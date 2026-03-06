<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mantenimiento;
use Carbon\Carbon;

class CalendarioController extends Controller
{
    public function index(Request $request)
    {
        /* ================= PARAMETROS ================= */
        $mes  = $request->mes  ?? now()->month;
        $anio = $request->anio ?? now()->year;
        $tipo = $request->tipo;

        /* ================= FECHA BASE ================= */
        $fecha = Carbon::create($anio, $mes, 1);

        /* ================= QUERY BASE ================= */
        $query = Mantenimiento::with('computadora')
            ->whereYear('fecha_programada', $anio)
            ->whereMonth('fecha_programada', $mes)
            ->where('estado','Pendiente'); // 🔴 SOLO MOSTRAR PENDIENTES

        /* ================= FILTRO TIPO ================= */
        if($tipo){
            $query->where('tipo', $tipo);
        }

        /* ================= RESULTADO ================= */
        $mantenimientos = $query->orderBy('fecha_programada')->get();

        /* ================= RETURN ================= */
        return view('calendario.index', compact(
            'mantenimientos',
            'mes',
            'anio',
            'fecha'
        ));
    }
}