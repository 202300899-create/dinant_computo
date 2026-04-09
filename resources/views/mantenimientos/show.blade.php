@extends('layouts.app')

@section('content')

<style>
.contenedor-form{
    max-width: 800px;
    margin: 30px auto;
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 18px 45px rgba(15, 76, 129, 0.08);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.encabezado{
    background: linear-gradient(135deg, #0f4c81, #1d6fa5);
    color: white;
    padding: 24px 28px;
}

.encabezado h1{
    margin: 0;
    font-size: 24px;
    font-weight: 700;
}

.cuerpo{
    padding: 26px 28px 30px;
}

.item{
    margin-bottom: 14px;
    font-size: 14px;
    color: #374151;
    line-height: 1.6;
}

.item strong{
    color: #111827;
}

.badge{
    display: inline-block;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-completado{
    background: #dcfce7;
    color: #166534;
}

.badge-pendiente{
    background: #fef3c7;
    color: #92400e;
}

.mensaje-ok{
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    color: #065f46;
    padding: 12px 14px;
    border-radius: 12px;
    margin-top: 15px;
    margin-bottom: 15px;
    font-size: 13px;
}

.acciones{
    margin-top: 25px;
    display: flex;
    gap: 12px;
    justify-content: flex-start;
    flex-wrap: wrap;
}

.btn{
    padding: 11px 18px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-guardar{
    background: #0f4c81;
    color: white;
}

.btn-guardar:hover{
    background: #0c3d68;
    transform: translateY(-1px);
}

.btn-volver{
    background: #6b7280;
    color: white;
}

.btn-volver:hover{
    background: #4b5563;
    transform: translateY(-1px);
}
</style>

<div class="contenedor-form">

    <div class="encabezado">
        <h1>Mantenimiento #{{ $mantenimiento->id }}</h1>
    </div>

    <div class="cuerpo">

        @if(session('success'))
            <div class="mensaje-ok">
                {{ session('success') }}
            </div>
        @endif

        @php
            $origenActual = $origen ?? request('origen') ?? 'mantenimientos';

            $rutaVolver = $origenActual === 'calendario'
                ? route('calendario.index')
                : route('mantenimientos.index');
        @endphp

        <div class="item">
            <strong>Equipo:</strong>
            {{ $mantenimiento->computadora->nombre_equipo ?? 'Sin equipo asignado' }}
        </div>

        <div class="item">
            <strong>Tipo:</strong>
            {{ $mantenimiento->tipo ?? 'No definido' }}
        </div>

        <div class="item">
            <strong>Fecha programada:</strong>
            {{ $mantenimiento->fecha_programada ?? 'No definida' }}
        </div>

        <div class="item">
            <strong>Estado:</strong>
            <span class="badge {{ $mantenimiento->estado == 'Completado' ? 'badge-completado' : 'badge-pendiente' }}">
                {{ $mantenimiento->estado ?? 'Pendiente' }}
            </span>
        </div>

        <div class="item">
            <strong>Fecha realizada:</strong>
            {{ $mantenimiento->fecha_realizada ?? 'Pendiente' }}
        </div>

        <div class="item">
            <strong>Observaciones:</strong>
            {{ $mantenimiento->descripcion ?? 'Sin observaciones' }}
        </div>

        @if($mantenimiento->estado == 'Completado')
            <div class="mensaje-ok">
                Este ticket ya fue completado.
            </div>
        @endif

        <div class="acciones">

            @if($mantenimiento->estado != 'Completado')
                <button
                    type="button"
                    class="btn btn-guardar"
                    onclick="window.location.href='{{ route('mantenimientos.edit', ['mantenimiento' => $mantenimiento->id, 'origen' => $origenActual]) }}'">
                    Cerrar ticket
                </button>
            @endif

            <button
                type="button"
                class="btn btn-volver"
                onclick="window.location.href='{{ $rutaVolver }}'">
                Volver
            </button>

        </div>

    </div>

</div>

@endsection