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

        $desktopActivas = Computadora::where('tipo','Desktop')
            ->where('estado','Activo')
            ->count();

        $laptopActivas = Computadora::where('tipo','Laptop')
            ->where('estado','Activo')
            ->count();

        $desktopInactivas = Computadora::where('tipo','Desktop')
            ->where('estado','Inactivo')
            ->count();

        $laptopInactivas = Computadora::where('tipo','Laptop')
            ->where('estado','Inactivo')
            ->count();


        /* =========================
        MANTENIMIENTOS PENDIENTES DEL MES
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