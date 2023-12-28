<?php

namespace App\Http\Controllers;

use App\Models\punishment;
use Illuminate\Http\Request;

class PunishmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();
        } else {
            $punishment = punishment::where('is_deleted', 0)->where('user_id', auth()->user()->id)->orderBy('id', "DESC")->get();
        }

        return view('content.new.punishment.index', [
            'punishment' => $punishment
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $punishment = punishment::where('is_deleted', 0)->orderBy('id', "DESC")->get();

        return view('content.new.punishment.create', [
            'punishment' => $punishment
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|max:255',
        ]);


        $punishment = punishment::create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'user_id' => auth()->user()->id,
        ]);

        return redirect('dashboard/punishment')->with('success', 'data berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\punishment  $punishment
     * @return \Illuminate\Http\Response
     */
    public function show(punishment $punishment)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\punishment  $punishment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $punishment = punishment::where('is_deleted', 0)->where('id', decrypt($id))->orderBy('id', "DESC")->first();

        return view('content.new.punishment.edit', [
            'punishment' => $punishment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\punishment  $punishment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:255',
            'price' => 'required|max:255',
        ];

        $validatedData = $request->validate($rules);

        punishment::where('id', decrypt($id))->update(
            [
                'name' => $validatedData["name"],
                'price' => $validatedData["price"],
            ]

        );

        return redirect('dashboard/punishment')->with('success', 'data berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\punishment  $punishment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $punishment = punishment::where('id', decrypt($id))->first();
        $punishment->delete();

        return decrypt($id);
    }
}
