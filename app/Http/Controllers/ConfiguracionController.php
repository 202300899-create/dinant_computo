<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrador;
use Illuminate\Support\Facades\Hash;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $admin = Administrador::findOrFail(session('admin_id'));

        return view('configuracion.index', compact('admin'));
    }

    public function actualizarPerfil(Request $request)
    {
        $admin = Administrador::findOrFail(session('admin_id'));

        $request->validate([
            'usuario' => 'required|string|max:255|unique:administradores,usuario,' . $admin->id,
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $admin->usuario = $request->usuario;

        if ($request->hasFile('foto')) {
            if ($admin->foto && file_exists(public_path($admin->foto))) {
                unlink(public_path($admin->foto));
            }

            $nombreFoto = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('images/perfiles'), $nombreFoto);
            $admin->foto = 'images/perfiles/' . $nombreFoto;
        }

        $admin->save();

        session([
            'admin_usuario' => $admin->usuario,
            'admin_foto' => $admin->foto,
            'tema' => $admin->tema ?? 'claro'
        ]);

        return redirect()->route('configuracion.index')
            ->with('success', 'Perfil actualizado correctamente');
    }

    public function actualizarPassword(Request $request)
    {
        $admin = Administrador::findOrFail(session('admin_id'));

        $request->validate([
            'password_actual' => 'required',
            'password_nueva' => 'required|min:6|confirmed'
        ]);

        if (!Hash::check($request->password_actual, $admin->password)) {
            return redirect()->route('configuracion.index')
                ->with('error', 'La contraseña actual no es correcta');
        }

        $admin->password = Hash::make($request->password_nueva);
        $admin->save();

        return redirect()->route('configuracion.index')
            ->with('success', 'Contraseña actualizada correctamente');
    }

    public function guardarNuevoUsuario(Request $request)
    {
        $request->validate([
            'nuevo_usuario' => 'required|string|max:255|unique:administradores,usuario',
            'nuevo_password' => 'required|min:6|confirmed'
        ]);

        Administrador::create([
            'usuario' => $request->nuevo_usuario,
            'password' => Hash::make($request->nuevo_password),
            'foto' => null,
            'tema' => 'claro'
        ]);

        return redirect()->route('configuracion.index')
            ->with('success', 'Nuevo usuario creado correctamente');
    }
}