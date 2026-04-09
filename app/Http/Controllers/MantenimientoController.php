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

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $hoy = Carbon::today()->toDateString();

        if ($request->filled('orden')) {
            switch ($request->orden) {
                case 'recientes':
                    $query->orderByRaw("
                        CASE
                            WHEN COALESCE(fecha_realizada, fecha_programada) >= ? THEN 0
                            ELSE 1
                        END ASC
                    ", [$hoy])
                    ->orderByRaw("
                        CASE
                            WHEN COALESCE(fecha_realizada, fecha_programada) >= ? THEN COALESCE(fecha_realizada, fecha_programada)
                        END ASC
                    ", [$hoy])
                    ->orderByRaw("
                        CASE
                            WHEN COALESCE(fecha_realizada, fecha_programada) < ? THEN COALESCE(fecha_realizada, fecha_programada)
                        END DESC
                    ", [$hoy]);
                    break;

                case 'antiguos':
                    $query->orderByRaw('COALESCE(fecha_realizada, fecha_programada) ASC');
                    break;

                case 'modificados':
                    $query->orderBy('updated_at', 'desc');
                    break;

                default:
                    $query->orderBy('id', 'desc');
                    break;
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        $mantenimientos = $query->get();

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
            'id_computadora'   => 'required|exists:computadoras,id',
            'tipo'             => 'required|in:Preventivo,Correctivo',
            'fecha_programada' => 'required|date|after_or_equal:' . now()->startOfYear()->format('Y-m-d'),
            'observaciones'    => ['required', 'string', 'max:500', 'regex:/^[^\d]+$/u']
        ], [
            'id_computadora.required'         => 'Debes seleccionar una computadora.',
            'id_computadora.exists'           => 'La computadora seleccionada no es válida.',
            'tipo.required'                   => 'Debes seleccionar el tipo de mantenimiento.',
            'tipo.in'                         => 'El tipo seleccionado no es válido.',
            'fecha_programada.required'       => 'Debes ingresar la fecha programada.',
            'fecha_programada.date'           => 'La fecha programada no es válida.',
            'fecha_programada.after_or_equal' => 'No se permiten fechas de años pasados.',
            'observaciones.required'          => 'Debes escribir las observaciones.',
            'observaciones.string'            => 'Las observaciones deben ser texto.',
            'observaciones.max'               => 'Las observaciones no pueden superar los 500 caracteres.',
            'observaciones.regex'             => 'Las observaciones no pueden contener números.'
        ]);

        Mantenimiento::create([
            'id_computadora'   => $request->id_computadora,
            'tipo'             => $request->tipo,
            'descripcion'      => trim($request->observaciones),
            'fecha_programada' => $request->fecha_programada,
            'estado'           => 'Pendiente'
        ]);

        return redirect()->route('mantenimientos.index')
            ->with('success', 'Mantenimiento creado correctamente.');
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
        $origen = $request->origen ?? 'mantenimientos';

        return view('mantenimientos.edit', compact('mantenimiento', 'computadoras', 'origen'));
    }

    /* ================= UPDATE ================= */
    public function update(Request $request, $id)
    {
        $mantenimiento = Mantenimiento::findOrFail($id);

        if ($mantenimiento->estado === 'Completado') {
            return back()
                ->with('error', 'Este ticket ya está completado y no se puede modificar.');
        }

        $request->validate([
            'estado'      => 'required|in:Pendiente,Completado',
            'descripcion' => ['required', 'string', 'max:500', 'regex:/^[^\d]+$/u']
        ], [
            'estado.required'      => 'Debes seleccionar el estado.',
            'estado.in'            => 'Solo puedes dejar el ticket como Pendiente o Completado.',
            'descripcion.required' => 'Debes escribir una observación.',
            'descripcion.string'   => 'La observación debe ser texto.',
            'descripcion.max'      => 'La observación no puede superar los 500 caracteres.',
            'descripcion.regex'    => 'La observación no puede contener números.'
        ]);

        if ($request->estado !== 'Completado') {
            return back()
                ->withInput()
                ->with('error', 'No puedes cerrar el ticket si sigue en Pendiente. Debes marcarlo como Completado.');
        }

        $mantenimiento->estado = 'Completado';
        $mantenimiento->descripcion = trim($request->descripcion);
        $mantenimiento->fecha_realizada = Carbon::now();

        $mantenimiento->save();

        if ($mantenimiento->tipo === 'Preventivo') {
            Mantenimiento::create([
                'id_computadora'   => $mantenimiento->id_computadora,
                'tipo'             => 'Preventivo',
                'descripcion'      => 'Mantenimiento preventivo generado automáticamente',
                'fecha_programada' => Carbon::now()->addMonths(6)->toDateString(),
                'estado'           => 'Pendiente'
            ]);
        }

        if ($request->origen === 'calendario') {
            return redirect()->route('calendario.index')
                ->with('success', 'Ticket cerrado correctamente.');
        }

        return redirect()->route('mantenimientos.show', [
            'mantenimiento' => $mantenimiento->id,
            'origen' => 'mantenimientos'
        ])->with('success', 'Ticket cerrado correctamente.');
    }

    /* ================= DESTROY ================= */
    public function destroy($id)
    {
        $mantenimiento = Mantenimiento::findOrFail($id);
        $mantenimiento->delete();

        return redirect()->route('mantenimientos.index')
            ->with('success', 'Mantenimiento eliminado correctamente.');
    }
}