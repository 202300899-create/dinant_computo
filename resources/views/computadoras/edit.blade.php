@extends('layouts.app')

@section('content')

<style>

/* CONTENEDOR */
.contenedor-form{
    max-width:1000px;
    margin:auto;
    background:white;
    padding:25px;
    border-radius:16px;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
}

/* TITULO */
.contenedor-form h1{
    margin-bottom:20px;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
}

/* LABEL */
label{
    font-size:13px;
    font-weight:600;
    display:block;
    margin-bottom:4px;
    color:#374151;
}

/* INPUTS */
input, select{
    width:100%;
    padding:9px;
    border:1px solid #d1d5db;
    border-radius:8px;
    font-size:14px;
}

/* IMAGEN */
.imagen-box{
    margin-top:20px;
}

.imagen-box img{
    width:220px;
    border-radius:12px;
    margin-top:6px;
}

/* ACCIONES */
.acciones{
    margin-top:25px;
    display:flex;
    gap:10px;
}

/* BOTONES */
.btn-guardar{
    background:#0f4c81;
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:10px;
    cursor:pointer;
}

.btn-volver{
    background:#6b7280;
    color:white;
    padding:10px 18px;
    border-radius:10px;
    text-decoration:none;
}

</style>

<div class="contenedor-form">

<h1>Propiedades del Equipo</h1>

<form action="/computadoras/{{ $computadora->id }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="grid">

<div>
<label>Nombre del equipo</label>
<input type="text" name="nombre_equipo" value="{{ $computadora->nombre_equipo }}">
</div>

<div>
<label>Tipo</label>
<select name="tipo">
<option value="Desktop" {{ $computadora->tipo == 'Desktop' ? 'selected' : '' }}>Desktop</option>
<option value="Laptop" {{ $computadora->tipo == 'Laptop' ? 'selected' : '' }}>Laptop</option>
</select>
</div>

<div>
<label>Marca</label>
<input type="text" name="marca" value="{{ $computadora->marca }}">
</div>

<div>
<label>Modelo</label>
<input type="text" name="modelo" value="{{ $computadora->modelo }}">
</div>

<div>
<label>Número de serie</label>
<input type="text" name="numero_serie" value="{{ $computadora->numero_serie }}">
</div>

<div>
<label>Procesador</label>
<select name="procesador">
<option value="Intel i5" {{ $computadora->procesador == 'Intel i5' ? 'selected' : '' }}>Intel i5</option>
<option value="Intel i7" {{ $computadora->procesador == 'Intel i7' ? 'selected' : '' }}>Intel i7</option>
<option value="Ryzen 5" {{ $computadora->procesador == 'Ryzen 5' ? 'selected' : '' }}>Ryzen 5</option>
<option value="Ryzen 7" {{ $computadora->procesador == 'Ryzen 7' ? 'selected' : '' }}>Ryzen 7</option>
</select>
</div>

<div>
<label>Memoria RAM</label>
<select name="ram">
<option value="8 GB" {{ $computadora->ram == '8 GB' ? 'selected' : '' }}>8 GB</option>
<option value="16 GB" {{ $computadora->ram == '16 GB' ? 'selected' : '' }}>16 GB</option>
<option value="32 GB" {{ $computadora->ram == '32 GB' ? 'selected' : '' }}>32 GB</option>
</select>
</div>

<div>
<label>Almacenamiento</label>
<select name="almacenamiento">
<option value="256 GB SSD" {{ $computadora->almacenamiento == '256 GB SSD' ? 'selected' : '' }}>256 GB SSD</option>
<option value="512 GB SSD" {{ $computadora->almacenamiento == '512 GB SSD' ? 'selected' : '' }}>512 GB SSD</option>
<option value="1 TB SSD" {{ $computadora->almacenamiento == '1 TB SSD' ? 'selected' : '' }}>1 TB SSD</option>
</select>
</div>

<div>
<label>Sistema operativo</label>
<select name="sistema_operativo">
<option value="Windows 11 Pro" {{ $computadora->sistema_operativo == 'Windows 11 Pro' ? 'selected' : '' }}>Windows 11 Pro</option>
<option value="Windows 10 Pro" {{ $computadora->sistema_operativo == 'Windows 10 Pro' ? 'selected' : '' }}>Windows 10 Pro</option>
</select>
</div>

<div>
<label>Fecha compra</label>
<input type="date" name="fecha_compra" value="{{ $computadora->fecha_compra }}">
</div>

<div>
<label>Vida útil</label>
<input type="number" name="vida_util" value="{{ $computadora->vida_util }}">
</div>

<div>
<label>Estado</label>
<select name="estado">
<option value="Activo" {{ $computadora->estado == 'Activo' ? 'selected' : '' }}>Activo</option>
<option value="En mantenimiento" {{ $computadora->estado == 'En mantenimiento' ? 'selected' : '' }}>En mantenimiento</option>
<option value="Dañado" {{ $computadora->estado == 'Dañado' ? 'selected' : '' }}>Dañado</option>
<option value="Inactivo" {{ $computadora->estado == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
</select>
</div>

<div>
<label>Usuario asignado</label>
<select name="id_usuario_asignado">
<option value="">Seleccione</option>
@foreach($usuarios as $u)
<option value="{{ $u->id }}" {{ $computadora->id_usuario_asignado == $u->id ? 'selected' : '' }}>
{{ $u->nombre }}
</option>
@endforeach
</select>
</div>

<div>
<label>Ubicación</label>
<select name="id_ubicacion">
<option value="">Seleccione</option>
@foreach($ubicaciones as $ub)
<option value="{{ $ub->id }}" {{ $computadora->id_ubicacion == $ub->id ? 'selected' : '' }}>
{{ $ub->area_empresa }}
</option>
@endforeach
</select>
</div>

</div>

@if($computadora->imagen)
<div class="imagen-box">
<label>Imagen actual</label>
<img src="{{ asset($computadora->imagen) }}">
</div>
@endif

<div class="imagen-box">
<label>Cambiar imagen</label>
<input type="file" name="imagen">
</div>

<div class="acciones">
<button type="submit" class="btn-guardar">Actualizar</button>
<a href="/computadoras" class="btn-volver">Volver</a>
</div>

</form>

</div>

@endsection