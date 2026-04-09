@extends('layouts.app')

@section('content')

@php
    use Carbon\Carbon;

    Carbon::setLocale('es');

    $diasMes = $fecha->daysInMonth;
    $primerDia = $fecha->copy()->startOfMonth()->dayOfWeekIso;

    $mantenimientosPendientes = $mantenimientos
        ->filter(fn($m) => strtolower(trim($m->estado)) === 'pendiente')
        ->sortBy('fecha_programada');

    $nombreMeses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre',
    ];
@endphp

<div class="pagina">

    <h1 class="titulo-seccion">Calendario de mantenimientos</h1>

    <form method="GET" action="{{ route('calendario.index') }}" class="filtro">

        <select name="mes">
            @foreach(range(1,12) as $m)
                <option value="{{ $m }}" {{ $m == $mes ? 'selected' : '' }}>
                    {{ $nombreMeses[$m] }}
                </option>
            @endforeach
        </select>

        <select name="anio">
            @foreach(range(now()->year - 2, now()->year + 2) as $a)
                <option value="{{ $a }}" {{ $a == $anio ? 'selected' : '' }}>
                    {{ $a }}
                </option>
            @endforeach
        </select>

        <select name="tipo">
            <option value="">Todos</option>
            <option value="Preventivo" {{ request('tipo') == 'Preventivo' ? 'selected' : '' }}>Preventivo</option>
            <option value="Correctivo" {{ request('tipo') == 'Correctivo' ? 'selected' : '' }}>Correctivo</option>
        </select>

        <button type="submit" class="btn-filtrar">Filtrar</button>
        <a href="{{ route('calendario.index') }}" class="btn-limpiar">Limpiar</a>

    </form>

    <div class="contenedor">

        <div class="calendario">
            <table>
                <thead>
                    <tr>
                        @foreach(['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'] as $d)
                            <th>{{ $d }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    <tr>

                        @for($i = 1; $i < $primerDia; $i++)
                            <td></td>
                        @endfor

                        @for($dia = 1; $dia <= $diasMes; $dia++)
                            <td>
                                <div class="numero">{{ $dia }}</div>

                                @foreach($mantenimientos as $m)
                                    @php
                                        $f = Carbon::parse($m->fecha_programada);
                                        $estado = strtolower(trim($m->estado));
                                        $tipoEvento = strtolower(trim($m->tipo));

                                        $claseTipo = $tipoEvento === 'preventivo' ? 'preventivo' : 'correctivo';
                                        $claseEstado = $estado === 'completado' ? 'estado-completado' : 'estado-pendiente';
                                        $textoEstado = $estado === 'completado' ? 'Completado' : 'Pendiente';
                                    @endphp

                                    @if($f->day == $dia && $f->month == $fecha->month && $f->year == $fecha->year)
                                        <a href="{{ route('mantenimientos.show', ['mantenimiento' => $m->id, 'origen' => 'calendario']) }}"
                                           class="evento"
                                           title="{{ $m->computadora->nombre_equipo }} - {{ $m->tipo }} - {{ $m->estado }}">

                                            <span class="evento-nombre {{ $claseTipo }}">
                                                {{ $m->computadora->nombre_equipo }}
                                            </span>

                                            <span class="evento-estado {{ $claseEstado }}">
                                                {{ $textoEstado }}
                                            </span>
                                        </a>
                                    @endif
                                @endforeach
                            </td>

                            @if(($dia + $primerDia - 1) % 7 == 0)
                                </tr><tr>
                            @endif
                        @endfor

                    </tr>
                </tbody>
            </table>
        </div>

        <div class="panel">
            <h3>Pendientes</h3>

            <div class="panel-scroll">
                @forelse($mantenimientosPendientes as $m)
                    <div class="item">

                        <div class="fila-top">
                            <a href="{{ route('mantenimientos.show', ['mantenimiento' => $m->id, 'origen' => 'calendario']) }}" class="link-equipo">
                                {{ $m->computadora->nombre_equipo }}
                            </a>

                            <div class="fecha">
                                {{ \Carbon\Carbon::parse($m->fecha_programada)->translatedFormat('d M Y') }}
                            </div>
                        </div>

                        <div class="badges">
                            <span class="badge estado-pendiente">Pendiente</span>
                            <span class="badge {{ strtolower($m->tipo) }}">{{ $m->tipo }}</span>
                        </div>

                    </div>
                @empty
                    <div class="sin-pendientes">
                        No hay mantenimientos pendientes en este período.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>

@endsection

<style>

.pagina{
    padding: 10px;
    margin-top: 30px;
}

.titulo-seccion{
    font-size: 22px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 15px;
}

.filtro{
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 12px;
}

.filtro select{
    padding: 7px 10px;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 13px;
}

.btn-filtrar,
.btn-limpiar{
    border: none;
    padding: 7px 14px;
    border-radius: 8px;
    font-size: 13px;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    position: relative;
    overflow: hidden;
    transition: all 0.25s ease;
    box-shadow: 0 6px 14px rgba(0,0,0,0.10);
}

.btn-filtrar{
    background: #0f4c81;
    color: white;
}

.btn-limpiar{
    background: #e55353;
    color: white;
}

.btn-filtrar:hover,
.btn-limpiar:hover{
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 12px 22px rgba(0,0,0,0.16);
}

.btn-filtrar:active,
.btn-limpiar:active{
    transform: scale(0.97);
}

.btn-filtrar::before,
.btn-limpiar::before{
    content: "";
    position: absolute;
    top: 0;
    left: -120%;
    width: 120%;
    height: 100%;
    background: linear-gradient(120deg, transparent, rgba(255,255,255,0.35), transparent);
    transition: left 0.6s ease;
}

.btn-filtrar:hover::before,
.btn-limpiar:hover::before{
    left: 120%;
}

.contenedor{
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 12px;
    align-items: stretch;
}

.calendario{
    width: 100%;
    background: white;
    border-radius: 12px;
    padding: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.calendario table{
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

.calendario th{
    background: #f3f4f6;
    padding: 8px;
    font-size: 13px;
}

.calendario td{
    border: 1px solid #e5e7eb;
    height: 95px;
    vertical-align: top;
    padding: 4px;
    overflow: hidden;
}

.numero{
    font-size: 11px;
    font-weight: bold;
}

.evento{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 3px;
    margin-top: 3px;
    text-decoration: none;
    overflow: hidden;
}

.evento-nombre,
.evento-estado{
    display: inline-block;
    max-width: 100%;
    font-size: 10px;
    padding: 2px 5px;
    border-radius: 4px;
    font-weight: 600;
    line-height: 1.15;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    box-sizing: border-box;
}

.evento-nombre.preventivo{
    background: #2563eb;
    color: white;
}

.evento-nombre.correctivo{
    background: #facc15;
    color: #000;
}

.evento-estado.estado-completado{
    background: #22c55e;
    color: white;
}

.evento-estado.estado-pendiente{
    background: #ef4444;
    color: white;
}

.panel{
    width: 100%;
    background: white;
    padding: 12px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.panel h3{
    margin: 0 0 10px 0;
    font-size: 18px;
    font-weight: 600;
    color: #111827;
}

.panel-scroll{
    max-height: 420px;
    overflow-y: auto;
}

.item{
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.fila-top{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}

.link-equipo{
    text-decoration: none;
    color: #111;
    font-weight: 500;
    font-size: 14px;
}

.link-equipo:hover{
    color: #2563eb;
}

.fecha{
    font-size: 12px;
    color: #6b7280;
    white-space: nowrap;
    text-align: right;
}

.badges{
    margin-top: 6px;
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
}

.badge{
    font-size: 11px;
    padding: 3px 6px;
    border-radius: 5px;
    color: white;
}

.badge.estado-pendiente{
    background: #ef4444;
}

.badge.preventivo{
    background: #2563eb;
    color: white;
}

.badge.correctivo{
    background: #facc15;
    color: #000;
}

.sin-pendientes{
    font-size: 13px;
    color: #6b7280;
    padding: 10px 0;
}

body{
    overflow-x: hidden;
}

@media(max-width: 900px){
    .contenedor{
        grid-template-columns: 1fr;
    }

    .panel{
        margin-top: 10px;
    }

    .fila-top{
        flex-direction: column;
        align-items: flex-start;
    }

    .fecha{
        text-align: left;
    }
}

</style>