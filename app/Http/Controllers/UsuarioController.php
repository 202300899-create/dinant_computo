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

        $usuarios = Usuario::with(['ubicacion','computadoras'])
        ->when($buscar, function($query) use ($buscar){
            $query->where('nombre','like',"%$buscar%");
        })
        ->get();

        return view('usuarios.index', compact('usuarios','buscar'));
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
        GUARDAR
    ========================= */

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required|email',
            'rol' => 'required',
            'estado' => 'required'
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'rol' => $request->rol,
            'estado' => $request->estado,
            'id_ubicacion' => $request->id_ubicacion
        ]);

        return redirect()->route('usuarios.index')
        ->with('success','Usuario creado correctamente');
    }


    /* =========================
        FICHA USUARIO
    ========================= */

    public function show($id)
    {
        $usuario = Usuario::with(['ubicacion','computadoras'])
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

        return view('usuarios.edit', compact('usuario','ubicaciones'));
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
            'estado' => 'required'
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;
        $usuario->rol = $request->rol;
        $usuario->estado = $request->estado;
        $usuario->id_ubicacion = $request->id_ubicacion;

        $usuario->save();

        return redirect()->route('usuarios.index')
        ->with('success','Usuario actualizado');
    }


    /* =========================
        ELIMINAR USUARIO
    ========================= */

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);

        $usuario->delete();

        return redirect()->route('usuarios.index')
        ->with('success','Usuario eliminado');
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

        /* ASIGNAR USUARIO */
        $computadora->id_usuario_asignado = $id;

        /* ACTIVAR EQUIPO */
        $computadora->estado = "Activo";

        $computadora->save();

        return redirect()->back()
        ->with('success','Equipo asignado correctamente');
    }


    /* =========================
        QUITAR EQUIPO ASIGNADO
    ========================= */

    public function quitarEquipo($usuarioId, $computadoraId)
    {

        $computadora = Computadora::findOrFail($computadoraId);

        /* verificar que pertenece a ese usuario */
        if($computadora->id_usuario_asignado != $usuarioId){
            return redirect()->back();
        }

        /* quitar asignación */
        $computadora->id_usuario_asignado = null;

        /* cambiar estado */
        $computadora->estado = "Inactivo";

        $computadora->save();

        return redirect()->back()
        ->with('success','Asignación eliminada correctamente');
    }

}