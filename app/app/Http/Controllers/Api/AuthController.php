<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\printer;
use App\Models\site_gate_parking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function loginStore(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required']
        ]);


        $user = User::where('name', $request->name)->with('site_gate_parking')->firstOrFail();
        $token = $user->createToken('auth-sanctum')->plainTextToken;

        if (Auth::attempt($credentials)) {
            return response()->json(
                [
                    'token' => $token,
                    'type_payment' => $user->site_gate_parking->type_payment,
                ]
            );
        }

        return response(null, 404);

    }

}
