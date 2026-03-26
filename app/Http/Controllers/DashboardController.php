<?php

namespace App\Http\Controllers;

use App\Models\Computadora;
use App\Models\Mantenimiento;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /* =========================
        COMPUTADORAS
        ========================= */

        $totalComputadoras = Computadora::count();

        // 🔵 Desktop (incluye Server)
        $desktopActivas = Computadora::whereIn('tipo', ['Desktop', 'Server'])
            ->where('estado', 'Activo')
            ->count();

        $desktopInactivas = Computadora::whereIn('tipo', ['Desktop', 'Server'])
            ->where('estado', '!=', 'Activo')
            ->count();

        // 🟢 Laptop
        $laptopActivas = Computadora::where('tipo', 'Laptop')
            ->where('estado', 'Activo')
            ->count();

        $laptopInactivas = Computadora::where('tipo', 'Laptop')
            ->where('estado', '!=', 'Activo')
            ->count();


        /* =========================
        MANTENIMIENTOS DEL MES
        ========================= */

        $mesActual = Carbon::now()->month;
        $anioActual = Carbon::now()->year;

        $mantenimientosPreventivos = Mantenimiento::where('tipo','Preventivo')
            ->where('estado','Pendiente')
            ->whereMonth('fecha_programada',$mesActual)
            ->whereYear('fecha_programada',$anioActual)
            ->count();

        $mantenimientosCorrectivos = Mantenimiento::where('tipo','Correctivo')
            ->where('estado','Pendiente')
            ->whereMonth('fecha_programada',$mesActual)
            ->whereYear('fecha_programada',$anioActual)
            ->count();


        /* =========================
        ENVIAR A LA VISTA
        ========================= */

        return view('dashboard.dashboard', compact(
            'totalComputadoras',
            'desktopActivas',
            'laptopActivas',
            'desktopInactivas',
            'laptopInactivas',
            'mantenimientosPreventivos',
            'mantenimientosCorrectivos'
        ));
    }
}