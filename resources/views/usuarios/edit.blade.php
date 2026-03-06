@extends('layouts.app')

@section('content')

<style>

/* ================= CONTENEDOR ================= */

.ficha{
max-width:950px;
margin:auto;
background:white;
padding:25px;
border-radius:16px;
box-shadow:0 6px 18px rgba(0,0,0,0.05);
}

/* ================= CAMPOS ================= */

.campo{
margin-bottom:15px;
display:flex;
flex-direction:column;
}

.campo label{
font-weight:600;
margin-bottom:5px;
font-size:14px;
}

.campo input,
.campo select{
padding:8px 10px;
border-radius:8px;
border:1px solid #ddd;
font-size:14px;
}

/* ================= BADGE ================= */

.badge{
background:#e3f2fd;
color:#0f4c81;
padding:5px 10px;
border-radius:20px;
font-size:12px;
display:inline-block;
}

/* ================= BOTONES ================= */

.acciones{
margin-top:20px;
display:flex;
gap:10px;
}

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
border:none;
padding:10px 18px;
border-radius:10px;
cursor:pointer;
}

</style>


<div class="ficha">

<h1>Editar usuario</h1>

<form method="POST" action="/usuarios/{{ $usuario->id }}">

@csrf
@method('PUT')


<div class="campo">

<label>Nombre</label>

<input
type="text"
name="nombre"
value="{{ $usuario->nombre }}"
required>

</div>



<div class="campo">

<label>Correo</label>

<input
type="email"
name="correo"
value="{{ $usuario->correo }}"
required>

</div>



<div class="campo">

<label>Rol</label>

<input
type="text"
name="rol"
value="{{ $usuario->rol }}"
required>

</div>



<div class="campo">

<label>Área / Ubicación</label>

<select name="id_ubicacion">

<option value="">Seleccionar área</option>

@foreach($ubicaciones as $u)

<option
value="{{ $u->id }}"
{{ $usuario->id_ubicacion == $u->id ? 'selected' : '' }}>

{{ $u->area_empresa }}

</option>

@endforeach

</select>

</div>



<div class="campo">

<label>Estado</label>

<select name="estado">

<option value="Activo"
{{ $usuario->estado == 'Activo' ? 'selected' : '' }}>
Activo
</option>

<option value="Inactivo"
{{ $usuario->estado == 'Inactivo' ? 'selected' : '' }}>
Inactivo
</option>

</select>

</div>



<div class="acciones">

<button class="btn-guardar">
Guardar cambios
</button>

<button
type="button"
class="btn-volver"
onclick="window.location.href='/usuarios'">

Cancelar

</button>

</div>

</form>

</div>

@endsection