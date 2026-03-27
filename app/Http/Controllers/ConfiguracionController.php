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
            'foto' => [
                'nullable',
                'file',
                'image',
                'mimes:jpeg,jpg,png',
                'mimetypes:image/jpeg,image/png',
                'max:2048'
            ]
        ], [
            'usuario.required' => 'Debes ingresar el nombre de usuario.',
            'usuario.string' => 'El nombre de usuario no es válido.',
            'usuario.max' => 'El nombre de usuario no puede superar los 255 caracteres.',
            'usuario.unique' => 'Ese nombre de usuario ya está en uso.',

            'foto.file' => 'El archivo seleccionado no es válido.',
            'foto.image' => 'Solo se permite subir una imagen.',
            'foto.mimes' => 'Solo se permiten archivos JPG, JPEG o PNG.',
            'foto.mimetypes' => 'El archivo no corresponde a una imagen válida.',
            'foto.max' => 'La imagen no puede superar los 2 MB.'
        ]);

        $admin->usuario = $request->usuario;

        if ($request->hasFile('foto')) {
            if ($admin->foto && file_exists(public_path($admin->foto))) {
                unlink(public_path($admin->foto));
            }

            $archivo = $request->file('foto');
            $extension = $archivo->getClientOriginalExtension();
            $nombreBase = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
            $nombreLimpio = preg_replace('/[^A-Za-z0-9_\-]/', '_', $nombreBase);
            $nombreFoto = time() . '_' . $nombreLimpio . '.' . $extension;

            $archivo->move(public_path('images/perfiles'), $nombreFoto);
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
        ], [
            'password_actual.required' => 'Debes escribir la contraseña actual.',
            'password_nueva.required' => 'Debes escribir la nueva contraseña.',
            'password_nueva.min' => 'La nueva contraseña debe tener al menos 6 caracteres.',
            'password_nueva.confirmed' => 'La confirmación de la nueva contraseña no coincide.'
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
        ], [
            'nuevo_usuario.required' => 'Debes ingresar el nombre del nuevo usuario.',
            'nuevo_usuario.string' => 'El nombre del usuario no es válido.',
            'nuevo_usuario.max' => 'El nombre del usuario no puede superar los 255 caracteres.',
            'nuevo_usuario.unique' => 'Ese usuario ya existe.',
            'nuevo_password.required' => 'Debes ingresar la contraseña del nuevo usuario.',
            'nuevo_password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'nuevo_password.confirmed' => 'La confirmación de la contraseña no coincide.'
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