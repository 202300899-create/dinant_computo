<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Ubicacion;
use App\Models\Computadora;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $usuarios = Usuario::with(['ubicacion', 'computadoras'])
            ->when($buscar, function ($query) use ($buscar) {
                $query->where('nombre', 'like', "%$buscar%");
            })
            ->get();

        return view('usuarios.index', compact('usuarios', 'buscar'));
    }

    public function create()
    {
        $ubicaciones = Ubicacion::all();

        return view('usuarios.create', compact('ubicaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required|email',
            'rol' => 'required',
            'id_ubicacion' => 'required|exists:ubicaciones,id'
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'rol' => $request->rol,
            'estado' => 'Activo',
            'id_ubicacion' => $request->id_ubicacion
        ]);

        return redirect()->route('usuarios.show', $usuario->id)
            ->with('success', 'Usuario creado correctamente');
    }

    public function show($id)
    {
        $usuario = Usuario::with(['ubicacion', 'computadoras'])
            ->findOrFail($id);

        $computadorasDisponibles = Computadora::with('usuarios')->get();

        return view('usuarios.show', compact(
            'usuario',
            'computadorasDisponibles'
        ));
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $ubicaciones = Ubicacion::all();

        return view('usuarios.edit', compact('usuario', 'ubicaciones'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombre' => 'required',
            'correo' => 'required|email',
            'rol' => 'required',
            'estado' => 'required',
            'id_ubicacion' => 'required|exists:ubicaciones,id'
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;
        $usuario->rol = $request->rol;
        $usuario->estado = $request->estado;
        $usuario->id_ubicacion = $request->id_ubicacion;
        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado');
    }

    public function destroy($id)
    {
        $usuario = Usuario::with('computadoras')->findOrFail($id);

        $usuario->computadoras()->detach();
        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado');
    }

    public function asignarEquipo(Request $request, $id)
    {
        $request->validate([
            'computadora_id' => 'required|exists:computadoras,id'
        ]);

        $usuario = Usuario::findOrFail($id);
        $computadora = Computadora::findOrFail($request->computadora_id);

        $usuario->computadoras()->syncWithoutDetaching([$computadora->id]);

        if ($computadora->estado !== 'Activo') {
            $computadora->estado = 'Activo';
            $computadora->save();
        }

        return redirect()->back()
            ->with('success', 'Equipo asignado correctamente');
    }

    public function quitarEquipo($usuarioId, $computadoraId)
    {
        $usuario = Usuario::findOrFail($usuarioId);
        $computadora = Computadora::with('usuarios')->findOrFail($computadoraId);

        if (!$usuario->computadoras()->where('computadora_id', $computadoraId)->exists()) {
            return redirect()->back();
        }

        $usuario->computadoras()->detach($computadoraId);

        $computadora->load('usuarios');

        if ($computadora->usuarios->count() === 0) {
            $computadora->estado = 'Inactivo';
            $computadora->save();
        }

        return redirect()->back()
            ->with('success', 'Asignación eliminada correctamente');
    }
}