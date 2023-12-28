<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthRequest;
use App\Http\Requests\UpdateAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('content.authentications.auth-login-basic', [
            'title' => 'login',
            'active' => 'dashboard/login'
        ]);
    }

    public function loginStore(Request $request)
    {

        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('loginError', 'Login Gagal!');

    }

    public function register()
    {
        return view('dashboard/register/index', [
            'title' => 'Daftar',
        ]);
    }

    public function registerStore(Request $request)
    {
        $validateData = $request->validate([
            'username' => ['required', 'min:3', 'max:255', 'unique:users'],
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:255',
            'role' => 'required|max:255',
            'developerName' => 'required|max:255',
        ]);

        // $validateData ['password'] = bcrypt($validateData['password']);
        $validateData['role'] = 'author';
        $validateData['developerName'] = 'Bukahuni';
        $validateData['password'] = Hash::make($validateData['password']);
        User::create($validateData);

        // $request->session()->flash('success', 'Akun Berhasil Di Daftarkan, Silah Masuk');

        return redirect('/login')->with('success', 'Akun Berhasil Di Daftarkan, Silah Masuk');

    }


    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    }

    public function loginIntegration()
    {
        return view('dashboard/loginIntegration/index', [
            'title' => 'loginIntegration',
            'active' => 'dashboard/loginIntegration'
        ]);
    }

    public function loginIntegrationStore(Request $request)
    {
        $credentials = $request->validate([
            'user_name' => ['required'],
            'password' => ['required']
        ]);

        $user = User::where('user_name', $request->user_name)->firstOrFail();
        $token = $user->createToken('auth-sanctum')->plainTextToken;

        if (Auth::attempt($credentials)) {
            // $request->session()->regenerate();
            // return redirect()->intended('/');
            return response()->json(['token' => $token]);
        }

        return back()->with('loginError', 'Login Gagal!');

        // return response(null, 404);

    }

}