<?php

namespace App\Http\Controllers;

use App\Models\Computadora;
use App\Models\Usuario;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ComputadoraController extends Controller
{
    /* =========================
        LISTADO + BUSCADOR
    ========================= */
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $computadoras = Computadora::with(['ubicacion', 'usuarioAsignado'])
            ->when($buscar, function ($query) use ($buscar) {
                $query->where('nombre_equipo', 'like', "%$buscar%")
                    ->orWhere('marca', 'like', "%$buscar%")
                    ->orWhere('modelo', 'like', "%$buscar%")
                    ->orWhere('numero_serie', 'like', "%$buscar%");
            })
            ->get();

        return view('computadoras.index', compact('computadoras', 'buscar'));
    }

    /* =========================
        FORM CREAR
    ========================= */
    public function create()
    {
        $usuarios = Usuario::all();
        $ubicaciones = Ubicacion::all();

        return view('computadoras.create', compact('usuarios', 'ubicaciones'));
    }

    /* =========================
        GUARDAR
    ========================= */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_equipo' => 'required|unique:computadoras,nombre_equipo',
            'tipo' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'numero_serie' => 'required|unique:computadoras,numero_serie',
            'procesador' => 'required',
            'ram' => 'required',
            'almacenamiento' => 'required',
            'sistema_operativo' => 'required',
            'fecha_compra' => 'required|date',
            'fecha_fin_garantia' => 'required|date',
            'vida_util' => 'required|numeric',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png'
        ], [
            'nombre_equipo.required' => 'El nombre del equipo es obligatorio.',
            'nombre_equipo.unique' => 'Ya existe una computadora con ese nombre.',
            'numero_serie.required' => 'El número de serie es obligatorio.',
            'numero_serie.unique' => 'Ya existe una computadora con ese número de serie.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'Solo se permiten archivos JPG, JPEG o PNG.'
        ]);

        try {
            $datos = $request->all();

            $datos['estado'] = 'Activo';

            if ($request->hasFile('imagen')) {
                $nombre = time() . '_' . $request->file('imagen')->getClientOriginalName();
                $request->file('imagen')->move(public_path('images'), $nombre);
                $datos['imagen'] = 'images/' . $nombre;
            }

            $computadora = Computadora::create($datos);

            return redirect()->route('computadoras.show', $computadora->id)
                ->with('success', 'Computadora creada correctamente');

        } catch (QueryException $e) {
            return back()
                ->withInput()
                ->with('error', 'Error: el nombre del equipo o el número de serie ya están registrados.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error inesperado al guardar la computadora.');
        }
    }

    /* =========================
        FORM EDITAR
    ========================= */
    public function edit($id)
    {
        $computadora = Computadora::findOrFail($id);
        $usuarios = Usuario::all();
        $ubicaciones = Ubicacion::all();

        return view('computadoras.edit', compact('computadora', 'usuarios', 'ubicaciones'));
    }

    /* =========================
        ACTUALIZAR
    ========================= */
    public function update(Request $request, $id)
    {
        $computadora = Computadora::findOrFail($id);

        $request->validate([
            'nombre_equipo' => 'required|unique:computadoras,nombre_equipo,' . $computadora->id,
            'tipo' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'numero_serie' => 'required|unique:computadoras,numero_serie,' . $computadora->id,
            'procesador' => 'required',
            'ram' => 'required',
            'almacenamiento' => 'required',
            'sistema_operativo' => 'required',
            'fecha_compra' => 'required|date',
            'fecha_fin_garantia' => 'required|date',
            'vida_util' => 'required|numeric',
            'estado' => 'required',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png'
        ], [
            'nombre_equipo.required' => 'El nombre del equipo es obligatorio.',
            'nombre_equipo.unique' => 'Ese nombre ya está siendo usado por otra computadora.',
            'numero_serie.required' => 'El número de serie es obligatorio.',
            'numero_serie.unique' => 'Ese número de serie ya pertenece a otra computadora.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'Solo se permiten archivos JPG, JPEG o PNG.'
        ]);

        try {
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
            $computadora->fecha_fin_garantia = $request->fecha_fin_garantia;
            $computadora->vida_util = $request->vida_util;
            $computadora->estado = $request->estado;
            $computadora->id_usuario_asignado = $request->id_usuario_asignado;
            $computadora->id_ubicacion = $request->id_ubicacion;

            if ($request->hasFile('imagen')) {
                if ($computadora->imagen && file_exists(public_path($computadora->imagen))) {
                    unlink(public_path($computadora->imagen));
                }

                $nombre = time() . '_' . $request->imagen->getClientOriginalName();
                $request->imagen->move(public_path('images'), $nombre);
                $computadora->imagen = 'images/' . $nombre;
            }

            $computadora->save();

            return redirect()->route('computadoras.show', $computadora->id)
                ->with('success', 'Computadora actualizada correctamente');

        } catch (QueryException $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar: el nombre del equipo o el número de serie ya existen.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error inesperado al actualizar la computadora.');
        }
    }

    /* =========================
        ELIMINAR
    ========================= */
    public function destroy($id)
    {
        $computadora = Computadora::findOrFail($id);

        if ($computadora->imagen && file_exists(public_path($computadora->imagen))) {
            unlink(public_path($computadora->imagen));
        }

        $computadora->mantenimientos()->delete();
        $computadora->delete();

        return redirect()->route('computadoras.index')
            ->with('success', 'Computadora eliminada correctamente');
    }

    /* =========================
        FICHA TECNICA
    ========================= */
    public function show($id)
    {
        $computadora = Computadora::with([
            'ubicacion',
            'usuarioAsignado',
            'mantenimientos' => function ($query) {
                $query->orderBy('fecha_programada', 'desc');
            }
        ])->findOrFail($id);

        return view('computadoras.show', compact('computadora'));
    }
}