@extends('layouts.app')

@section('content')

<style>

.ficha-container{
max-width:900px;
margin:auto;
background:white;
padding:30px;
border-radius:14px;
box-shadow:0 6px 18px rgba(0,0,0,0.08);
}

.ficha-header{
margin-bottom:20px;
}

.ficha-header h1{
font-size:26px;
font-weight:600;
}

.ficha-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:20px;
margin-top:15px;
}

.ficha-item label{
font-size:13px;
color:#6b7280;
display:block;
margin-bottom:4px;
}

.ficha-item input,
.ficha-item select{
width:100%;
padding:10px;
border:1px solid #ddd;
border-radius:8px;
font-size:14px;
}

.ficha-item input:required,
.ficha-item select:required{
border-color:#d1d5db;
}

.seccion{
margin-top:30px;
border-top:1px solid #e5e7eb;
padding-top:20px;
}

.btn-group{
margin-top:20px;
display:flex;
gap:10px;
flex-wrap:wrap;
}

.btn{
padding:10px 16px;
border:none;
border-radius:8px;
cursor:pointer;
font-size:14px;
}

.btn-primary{
background:#0f4c81;
color:white;
}

.btn-secondary{
background:#2c7be5;
color:white;
}

.btn-danger{
background:#e55353;
color:white;
}

.btn-volver{
background:#6b7280;
color:white;
}

.tabla{
width:100%;
border-collapse:collapse;
margin-top:10px;
}

.tabla th{
text-align:left;
font-size:13px;
padding:10px;
background:#f4f6f9;
border-bottom:1px solid #ddd;
}

.tabla td{
padding:10px;
font-size:14px;
border-bottom:1px solid #eee;
}

</style>



<div class="ficha-container">

<div class="ficha-header">
<h1>Crear Usuario</h1>
</div>

<form method="POST" action="{{ route('usuarios.store') }}">

@csrf

<!-- ================= DATOS USUARIO ================= -->

<div class="ficha-grid">

<div class="ficha-item">
<label>Nombre</label>
<input type="text" name="nombre" required>
</div>

<div class="ficha-item">
<label>Correo</label>
<input type="email" name="correo" required>
</div>

<div class="ficha-item">
<label>Área</label>

<select name="id_ubicacion" required>

<option value="">Seleccionar área</option>

@foreach($ubicaciones as $ubicacion)

<option value="{{ $ubicacion->id }}">
{{ $ubicacion->area_empresa }}
</option>

@endforeach

</select>

</div>

<div class="ficha-item">
<label>Rol</label>
<input type="text" name="rol" required>
</div>

<div class="ficha-item">
<label>Estado</label>

<select name="estado" required>

<option value="">Seleccionar estado</option>
<option value="Activo">Activo</option>
<option value="Inactivo">Inactivo</option>

</select>

</div>

</div>



<div class="btn-group">

<button class="btn btn-primary">
Guardar usuario
</button>

<button type="button" class="btn btn-volver"
onclick="window.location.href='/usuarios'">
Volver
</button>

</div>

</form>

</div>

@endsection