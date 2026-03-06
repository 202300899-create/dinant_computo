<?php

namespace App\Http\Controllers;

use App\Models\Computadora;
use App\Models\Usuario;
use App\Models\Ubicacion;
use Illuminate\Http\Request;

class ComputadoraController extends Controller
{

    /* =========================
        LISTADO + BUSCADOR
    ========================= */
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $computadoras = Computadora::with(['ubicacion','usuarioAsignado'])
            ->when($buscar, function($query) use ($buscar){
                $query->where('nombre_equipo','like',"%$buscar%")
                      ->orWhere('marca','like',"%$buscar%")
                      ->orWhere('modelo','like',"%$buscar%")
                      ->orWhere('numero_serie','like',"%$buscar%");
            })
            ->get();

        return view('computadoras.index', compact('computadoras','buscar'));
    }


    /* =========================
        FORM CREAR
    ========================= */
    public function create()
    {
        $usuarios = Usuario::all();
        $ubicaciones = Ubicacion::all();

        return view('computadoras.create', compact('usuarios','ubicaciones'));
    }


    /* =========================
        GUARDAR
    ========================= */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_equipo' => 'required',
            'tipo' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'numero_serie' => 'required',
            'procesador' => 'required',
            'ram' => 'required',
            'almacenamiento' => 'required',
            'sistema_operativo' => 'required',
            'fecha_compra' => 'required|date',
            'fecha_fin_garantia' => 'required|date',
            'vida_util' => 'required|numeric',   // CORREGIDO
            'estado' => 'required',
        ]);

        $datos = $request->all();

        /* SUBIDA IMAGEN */
        if ($request->hasFile('imagen')) {

            $nombre = time().'_'.$request->imagen->getClientOriginalName();
            $request->imagen->move(public_path('images'), $nombre);

            $datos['imagen'] = 'images/'.$nombre;
        }

        Computadora::create($datos);

        return redirect()->route('computadoras.index');
    }


    /* =========================
        FORM EDITAR
    ========================= */
    public function edit($id)
    {
        $computadora = Computadora::findOrFail($id);
        $usuarios = Usuario::all();
        $ubicaciones = Ubicacion::all();

        return view('computadoras.edit', compact('computadora','usuarios','ubicaciones'));
    }


    /* =========================
        ACTUALIZAR
    ========================= */
    public function update(Request $request, $id)
{
    $computadora = Computadora::findOrFail($id);

    $request->validate([
        'nombre_equipo' => 'required',
        'tipo' => 'required',
        'marca' => 'required',
        'modelo' => 'required',
        'numero_serie' => 'required',
        'procesador' => 'required',
        'ram' => 'required',
        'almacenamiento' => 'required',
        'sistema_operativo' => 'required',
        'fecha_compra' => 'required|date',
        'vida_util' => 'required|numeric',
        'estado' => 'required',
    ]);

    $computadora->nombre_equipo = $request->nombre_equipo;
    $computadora->tipo = $request->tipo;
    $computadora->marca = $request->marca;
    $computadora->modelo = $request->modelo;
    $computadora->numero_serie = $request->numero_serie;
    $computadora->procesador = $request->procesador;
    $computadora->ram = $request->ram;
    $computadora->almacenamiento = $request->almacenamiento;
    $computadora->sistema_operativo = $request->sistema_operativo;
    $computadora->fecha_compra = $request->fecha_compra;
    $computadora->vida_util = $request->vida_util;
    $computadora->estado = $request->estado;
    $computadora->id_usuario_asignado = $request->id_usuario_asignado;
    $computadora->id_ubicacion = $request->id_ubicacion;

    if ($request->hasFile('imagen')) {

        if ($computadora->imagen && file_exists(public_path($computadora->imagen))) {
            unlink(public_path($computadora->imagen));
        }

        $nombre = time().'_'.$request->imagen->getClientOriginalName();
        $request->imagen->move(public_path('images'), $nombre);

        $computadora->imagen = 'images/'.$nombre;
    }

    $computadora->save();

    return redirect()->route('computadoras.index');
}


    /* =========================
        ELIMINAR
    ========================= */
    public function destroy($id)
    {
        $computadora = Computadora::findOrFail($id);

        // eliminar mantenimientos relacionados
        $computadora->mantenimientos()->delete();

        // eliminar computadora
        $computadora->delete();

        return redirect()->route('computadoras.index');
    }


    /* =========================
        FICHA TECNICA
    ========================= */
    public function show($id)
{
    $computadora = Computadora::with(['mantenimientos' => function($query){
        $query->orderBy('fecha_programada','desc');
    }])->findOrFail($id);

    return view('computadoras.show', compact('computadora'));
}

}