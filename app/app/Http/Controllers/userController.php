<?php

namespace App\Http\Controllers;

use App\Models\customCms;
use App\Models\event;
use App\Models\site_gate_parking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }


    public function account()
    {

        return view('dashboard/account/index', [
            'title' => 'account',
            'active' => 'dashboard/account'
        ]);
    }


    public function account_password()
    {

        return view('dashboard/account_password/index', [
            'title' => 'account',
            'active' => 'dashboard/account'
        ]);
    }


    public function index()
    {
        $user = User::where('role', '!=', 'admin')->with('site_gate_parking')->orderBy('id', "DESC")->get();
        // $user = User::with('site_gate_parking')->orderBy('id', "DESC")->get();
        return view('content.new.user.index', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->get();

        return view('content.new.user.create', [
            'site_gate_parking' => $site_gate_parking
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'role' => 'required|max:255',
            'email' => 'required|max:255',
            'timeZone' => 'required|max:255',
            'password' => 'required|max:255',
            'site_gate_parking_id' => 'required|max:255',
        ]);


        $user_email = User::where('email', $validatedData['email'])->first();
        $user_username = User::where('name', $validatedData['name'])->first();

        $validatedData['password'] = Hash::make($validatedData['password']);

        if (!$user_email) {
            if (!$user_username) {

                $userCreate = User::create($validatedData);

                return redirect('dashboard/auth')->with('success', 'data berhasil di tambahkan');
            } else {
                return redirect('dashboard/auth/create')->with('danger', 'username sudah tersedia');
            }

        } else {
            return redirect('dashboard/auth/create')->with('danger', 'email sudah tersedia');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::where('id', decrypt($id))->first();
        $site_gate_parking = site_gate_parking::where('is_deleted', 0)->orderBy('id', "DESC")->get();


        return view('content.new.user.edit', [
            'user' => $user,
            'site_gate_parking' => $site_gate_parking,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:255',
            'role' => 'required|max:255',
            'email' => 'required|max:255',
            'timeZone' => 'required|max:255',
            'password' => 'max:255',
            'site_gate_parking_id' => 'required|max:255',
        ];

        $validatedData = $request->validate($rules);
        $user_email = User::where('email', $validatedData['email'])->first();
        $user_username = User::where('name', $validatedData['name'])->first();


        if (!$user_email) {
            User::where('id', decrypt($id))->update(
                [
                    'role' => $validatedData["role"],
                    'email' => $validatedData["email"],
                ]
            );
        }


        if (!$user_username) {
            User::where('id', decrypt($id))->update(
                [
                    'role' => $validatedData["role"],
                    'name' => $validatedData["name"],
                ]

            );
        }



        if ($validatedData["password"]) {
            $validatedData["password"] = Hash::make($validatedData['password']);
            User::where('id', decrypt($id))->update(
                [
                    'role' => $validatedData["role"],
                    'password' => $validatedData["password"],
                ]
            );
        }

        User::where('id', decrypt($id))->update(
            [
                'site_gate_parking_id' => $validatedData["site_gate_parking_id"],
                'role' => $validatedData["role"],
                'timeZone' => $validatedData["timeZone"],
            ]
        );

        return redirect('dashboard/auth')->with('success', 'data berhasil di ubah');

    }

    public function updateAccount(Request $request)
    {
        $rules = [
            'photo_profile' => 'mimes:jpg,jpeg,png',
            'user_name' => 'required|max:255',
        ];

        $validatedData = $request->validate($rules);

        if ($request->has("photo_profile")) {

            if (file_exists(public_path('storage/allImages/') . $validatedData['photo_profile'])) {
                unlink(public_path('storage/allImages/') . $validatedData['photo_profile']);
            }

            $media_new_nameName = $validatedData['user_name'] . '-image-' . time() . rand(1, 1000) . '.' . $validatedData['photo_profile']->extension();
            $validatedData['photo_profile']->move(public_path('storage/allImages'), $media_new_nameName);

            User::where('user_player_id', auth()->user()->user_player_id)->update(
                [
                    'user_name' => $validatedData["user_name"],
                    'photo_profile' => $media_new_nameName,
                ]
            );
        } else {
            User::where('user_player_id', auth()->user()->user_player_id)->update(
                [
                    'user_name' => $validatedData["user_name"],
                ]
            );
        }



        return redirect('dashboard/account')->with('success', 'data berhasil di ubah');
    }


    public function updatePassword(Request $request)
    {

        $rules = [
            'old_password' => 'required|max:255',
            'new_password' => 'required|max:255',
            'confirm_password' => 'required|max:255',
        ];

        $validatedData = $request->validate($rules);

        //Select user data form database
        $user = User::where('user_name', auth()->user()->user_name)->first();

        //Check password hash
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect('dashboard/account_password')->with('danger', 'masukan password lama dengan benar');
        }

        if ($validatedData['new_password'] != $validatedData['confirm_password']) {
            return redirect('dashboard/account_password')->with('danger', 'konfirmasi password harus sama');
        } else {
            $validatedData['new_password'] = Hash::make($validatedData['new_password']);

            User::where('user_player_id', auth()->user()->user_player_id)->update(
                [
                    'password' => $validatedData["new_password"],
                ]
            );

            return redirect('dashboard/account')->with('success', 'data berhasil di ubah');
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', decrypt($id))->first();
        $user->delete();

        return decrypt($id);
    }
}