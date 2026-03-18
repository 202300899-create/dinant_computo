<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Ubicacion;
use App\Models\Computadora;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /* =========================
        LISTADO + BUSCADOR
    ========================= */

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

    /* =========================
        FORM CREAR
    ========================= */

    public function create()
    {
        $ubicaciones = Ubicacion::all();

        return view('usuarios.create', compact('ubicaciones'));
    }

    /* =========================
        GUARDAR (CORREGIDO 🔥)
    ========================= */

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
            'estado' => 'Activo', // 🔥 automático
            'id_ubicacion' => $request->id_ubicacion
        ]);

        // 🔥 REDIRECCIÓN A LA FICHA
        return redirect()->route('usuarios.show', $usuario->id)
            ->with('success', 'Usuario creado correctamente');
    }

    /* =========================
        FICHA USUARIO
    ========================= */

    public function show($id)
    {
        $usuario = Usuario::with(['ubicacion', 'computadoras'])
            ->findOrFail($id);

        $computadorasDisponibles = Computadora::whereNull('id_usuario_asignado')->get();

        return view('usuarios.show', compact(
            'usuario',
            'computadorasDisponibles'
        ));
    }

    /* =========================
        FORM EDITAR
    ========================= */

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $ubicaciones = Ubicacion::all();

        return view('usuarios.edit', compact('usuario', 'ubicaciones'));
    }

    /* =========================
        ACTUALIZAR
    ========================= */

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

    /* =========================
        ELIMINAR USUARIO
    ========================= */

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);

        $computadoras = Computadora::where('id_usuario_asignado', $usuario->id)->get();

        foreach ($computadoras as $computadora) {
            $computadora->id_usuario_asignado = null;
            $computadora->estado = 'Inactivo';
            $computadora->save();
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado');
    }

    /* =========================
        ASIGNAR EQUIPO
    ========================= */

    public function asignarEquipo(Request $request, $id)
    {
        $request->validate([
            'computadora_id' => 'required|exists:computadoras,id'
        ]);

        $computadora = Computadora::findOrFail($request->computadora_id);

        $computadora->id_usuario_asignado = $id;
        $computadora->estado = 'Activo';
        $computadora->save();

        return redirect()->back()
            ->with('success', 'Equipo asignado correctamente');
    }

    /* =========================
        QUITAR EQUIPO ASIGNADO
    ========================= */

    public function quitarEquipo($usuarioId, $computadoraId)
    {
        $computadora = Computadora::findOrFail($computadoraId);

        if ($computadora->id_usuario_asignado != $usuarioId) {
            return redirect()->back();
        }

        $computadora->id_usuario_asignado = null;
        $computadora->estado = 'Inactivo';
        $computadora->save();

        return redirect()->back()
            ->with('success', 'Asignación eliminada correctamente');
    }
}