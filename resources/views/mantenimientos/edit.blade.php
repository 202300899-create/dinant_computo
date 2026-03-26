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
    margin-bottom: 18px;
}

label{
    font-weight: 700;
    font-size: 13px;
    margin-bottom: 6px;
    display: block;
    color: #374151;
}

input, select, textarea{
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #d1d5db;
    border-radius: 12px;
    font-size: 14px;
    background: #f9fafb;
    transition: all 0.2s ease;
}

input:focus,
select:focus,
textarea:focus{
    border-color: #1d6fa5;
    background: white;
    box-shadow: 0 0 0 4px rgba(29,111,165,0.1);
    outline: none;
}

textarea{
    resize: none;
}

.mensaje{
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
    padding: 12px 14px;
    border-radius: 12px;
    margin-bottom: 18px;
    font-size: 13px;
}

.acciones{
    margin-top: 25px;
    display: flex;
    gap: 12px;
    justify-content: flex-start;
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
}

.btn:disabled{
    background: #9ca3af;
    cursor: not-allowed;
}
</style>

<div class="contenedor-form">

    <div class="encabezado">
        <h1>Cerrar ticket</h1>
    </div>

    <div class="cuerpo">

        @php
            $rutaVolver = $origen === 'calendario'
                ? route('calendario.index')
                : route('mantenimientos.show', [
                    'mantenimiento' => $mantenimiento->id,
                    'origen' => 'mantenimientos'
                ]);
        @endphp

        {{-- Mensaje si ya está completado --}}
        @if($mantenimiento->estado == 'Completado')
            <div class="mensaje">
                Este ticket ya está completado y no se puede modificar.
            </div>
        @endif

        <form method="POST" action="{{ route('mantenimientos.update', $mantenimiento->id) }}">
            @csrf
            @method('PUT')

            <input type="hidden" name="origen" value="{{ $origen }}">

            <div class="item">
                <label>Estado</label>
                <select name="estado" {{ $mantenimiento->estado == 'Completado' ? 'disabled' : '' }}>
                    <option value="Pendiente" {{ $mantenimiento->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="Completado" {{ $mantenimiento->estado == 'Completado' ? 'selected' : '' }}>Completado</option>
                </select>
            </div>

            <div class="item">
                <label>Observaciones</label>
                <textarea name="descripcion" rows="4" {{ $mantenimiento->estado == 'Completado' ? 'disabled' : '' }}>{{ $mantenimiento->descripcion }}</textarea>
            </div>

            <div class="acciones">

                @if($mantenimiento->estado != 'Completado')
                    <button type="submit" class="btn btn-guardar">
                        Guardar
                    </button>
                @endif

                <button
                    type="button"
                    class="btn btn-volver"
                    onclick="window.location.href='{{ $rutaVolver }}'">
                    Volver
                </button>

            </div>

        </form>

    </div>

</div>

@endsection