@extends('layouts.app')

@section('content')

<style>
.form-box{
    max-width:800px;
    margin:auto;
    background:white;
    padding:25px;
    border-radius:16px;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
}

.item{
    margin-bottom:15px;
}

label{
    font-weight:600;
    font-size:13px;
    display:block;
    margin-bottom:4px;
}

input, select, textarea{
    width:100%;
    padding:8px;
    border:1px solid #d1d5db;
    border-radius:8px;
}

.acciones{
    margin-top:20px;
    display:flex;
    gap:10px;
}

button{
    background:#0f4c81;
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:10px;
    cursor:pointer;
}

.btn-volver{
    background:#6b7280;
}
</style>

<div class="form-box">

    <h1>Cerrar ticket</h1>

    <form method="POST" action="/mantenimientos/{{ $mantenimiento->id }}">
        @csrf
        @method('PUT')

        <div class="item">
            <label>Estado</label>
            <select name="estado">
                <option value="Pendiente" {{ $mantenimiento->estado=='Pendiente'?'selected':'' }}>Pendiente</option>
                <option value="En proceso" {{ $mantenimiento->estado=='En proceso'?'selected':'' }}>En proceso</option>
                <option value="Completado" {{ $mantenimiento->estado=='Completado'?'selected':'' }}>Completado</option>
            </select>
        </div>

        <div class="item">
            <label>Observaciones</label>
            <textarea name="descripcion" rows="4">{{ $mantenimiento->descripcion }}</textarea>
        </div>

        <div class="acciones">
            <button type="submit">Guardar</button>
            <button type="button" class="btn-volver"
                onclick="window.location.href='/mantenimientos/{{ $mantenimiento->id }}'">
                Volver
            </button>
        </div>

    </form>

</div>

@endsection