<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrador;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function mostrarLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        $admin = Administrador::where('usuario', $request->usuario)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {

            session([
                'admin_id' => $admin->id,
                'admin_usuario' => $admin->usuario
            ]);

            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Usuario o contraseña incorrectos');
    }


    public function logout()
    {
        session()->flush();

        return redirect('/');
    }

}