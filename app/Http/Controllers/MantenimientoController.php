<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Computadora;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MantenimientoController extends Controller
{
    /* ================= INDEX CON FILTROS ================= */
    public function index(Request $request)
    {
        $query = Mantenimiento::with('computadora');

        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        if ($request->tipo) {
            $query->where('tipo', $request->tipo);
        }

        $mantenimientos = $query->orderBy('fecha_programada', 'desc')->get();

        return view('mantenimientos.index', compact('mantenimientos'));
    }

    /* ================= CREATE ================= */
    public function create()
    {
        $computadoras = Computadora::all();

        return view('mantenimientos.create', compact('computadoras'));
    }

    /* ================= STORE ================= */
    public function store(Request $request)
    {
        $request->validate([
            'id_computadora'   => 'required',
            'tipo'             => 'required',
            'fecha_programada' => 'required|date|after_or_equal:' . now()->startOfYear()->format('Y-m-d'),
            'estado'           => 'required',
            'observaciones'    => ['required', 'regex:/^[^\d]+$/u']
        ], [
            'id_computadora.required'   => 'Debes seleccionar una computadora.',
            'tipo.required'             => 'Debes seleccionar el tipo de mantenimiento.',
            'fecha_programada.required' => 'Debes ingresar la fecha programada.',
            'fecha_programada.date'     => 'La fecha programada no es válida.',
            'fecha_programada.after_or_equal' => 'No se pueden crear tickets con fechas de años pasados.',
            'estado.required'           => 'Debes seleccionar el estado.',
            'observaciones.required'    => 'Debes escribir las observaciones.',
            'observaciones.regex'       => 'Las observaciones no pueden contener números.'
        ]);

        Mantenimiento::create([
            'id_computadora'   => $request->id_computadora,
            'tipo'             => $request->tipo,
            'descripcion'      => trim($request->observaciones),
            'fecha_programada' => $request->fecha_programada,
            'estado'           => $request->estado
        ]);

        return redirect()->route('mantenimientos.index')
            ->with('success', 'Mantenimiento creado');
    }

    /* ================= SHOW ================= */
    public function show(Request $request, $id)
    {
        $mantenimiento = Mantenimiento::with('computadora')->findOrFail($id);
        $origen = $request->origen;

        return view('mantenimientos.show', compact('mantenimiento', 'origen'));
    }

    /* ================= EDIT ================= */
    public function edit(Request $request, $id)
    {
        $mantenimiento = Mantenimiento::findOrFail($id);
        $computadoras = Computadora::all();
        $origen = $request->origen;

        return view('mantenimientos.edit', compact('mantenimiento', 'computadoras', 'origen'));
    }

    /* ================= UPDATE ================= */
    public function update(Request $request, $id)
    {
        $mantenimiento = Mantenimiento::findOrFail($id);

        $request->validate([
            'estado'      => 'required',
            'descripcion' => ['required', 'regex:/^[^\d]+$/u']
        ], [
            'estado.required'      => 'Debes seleccionar el estado.',
            'descripcion.required' => 'Debes escribir una observación.',
            'descripcion.regex'    => 'La observación no puede contener números.'
        ]);

        $mantenimiento->estado = $request->estado;
        $mantenimiento->descripcion = trim($request->descripcion);

        if ($request->estado == 'Completado' && !$mantenimiento->fecha_realizada) {
            $mantenimiento->fecha_realizada = Carbon::now();

            if ($mantenimiento->tipo == 'Preventivo') {
                Mantenimiento::create([
                    'id_computadora'   => $mantenimiento->id_computadora,
                    'tipo'             => 'Preventivo',
                    'descripcion'      => 'Mantenimiento preventivo generado automáticamente',
                    'fecha_programada' => Carbon::now()->addMonths(6),
                    'estado'           => 'Pendiente'
                ]);
            }
        }

        $mantenimiento->save();

        if ($request->origen === 'calendario') {
            return redirect()->route('calendario.index')
                ->with('success', 'Ticket cerrado correctamente');
        }

        return redirect()->route('mantenimientos.show', [
            'mantenimiento' => $mantenimiento->id,
            'origen' => 'mantenimientos'
        ])->with('success', 'Actualizado');
    }

    /* ================= DESTROY ================= */
    public function destroy($id)
    {
        $mantenimiento = Mantenimiento::findOrFail($id);
        $mantenimiento->delete();

        return redirect()->route('mantenimientos.index')
            ->with('success', 'Eliminado');
    }
}