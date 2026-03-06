@extends('layouts.app')

@section('content')

<div class="contenedor-form">

<h1>Nueva Computadora</h1>

@if ($errors->any())
<div class="errores">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif


<form action="/computadoras" method="POST" enctype="multipart/form-data">
@csrf

<div class="grid">

<div>
<label>Nombre del equipo</label>
<input type="text" name="nombre_equipo" required>
</div>

<div>
<label>Tipo</label>
<select name="tipo" required>
<option value="">Seleccione</option>
<option value="Desktop">Desktop</option>
<option value="Laptop">Laptop</option>
</select>
</div>

<div>
<label>Marca</label>
<input type="text" name="marca" required>
</div>

<div>
<label>Modelo</label>
<input type="text" name="modelo" required>
</div>

<div>
<label>Número de serie</label>
<input type="text" name="numero_serie" required>
</div>

<div>
<label>Procesador</label>
<select name="procesador" required>
<option value="">Seleccione</option>
<option value="Intel i5">Intel i5</option>
<option value="Intel i7">Intel i7</option>
<option value="Ryzen 5">Ryzen 5</option>
<option value="Ryzen 7">Ryzen 7</option>
</select>
</div>

<div>
<label>Memoria RAM</label>
<select name="ram" required>
<option value="">Seleccione</option>
<option value="8 GB">8 GB</option>
<option value="16 GB">16 GB</option>
<option value="32 GB">32 GB</option>
</select>
</div>

<div>
<label>Almacenamiento</label>
<select name="almacenamiento" required>
<option value="">Seleccione</option>
<option value="256 GB SSD">256 GB SSD</option>
<option value="512 GB SSD">512 GB SSD</option>
<option value="1 TB SSD">1 TB SSD</option>
</select>
</div>

<div>
<label>Sistema operativo</label>
<select name="sistema_operativo" required>
<option value="">Seleccione</option>
<option value="Windows 11 Pro">Windows 11 Pro</option>
<option value="Windows 10 Pro">Windows 10 Pro</option>
</select>
</div>

<div>
<label>Fecha compra</label>
<input type="date" name="fecha_compra" required>
</div>

<div>
<label>Fin de garantía</label>
<input type="date" name="fecha_fin_garantia" id="fecha_fin_garantia" required>
</div>

<div>
<label>Vida útil (años)</label>
<input type="number" name="vida_util" id="vida_util" min="1" required>
</div>

<div>
<label>Estado</label>
<select name="estado" required>
<option value="">Seleccione</option>
<option value="Activo">Activo</option>
<option value="En mantenimiento">En mantenimiento</option>
<option value="Dañado">Dañado</option>
<option value="Inactivo">Inactivo</option>
</select>
</div>

<div>
<label>Usuario asignado</label>
<select name="id_usuario_asignado">
<option value="">Seleccione</option>
@foreach($usuarios as $u)
<option value="{{ $u->id }}">
{{ $u->nombre }}
</option>
@endforeach
</select>
</div>

<div>
<label>Fotografía del equipo</label>
<input type="file" name="imagen">
</div>

</div>

<div class="acciones">
<button type="submit">Guardar</button>
<a href="/computadoras" class="btn-volver">Volver</a>
</div>

</form>

</div>

@endsection

<script>

document.getElementById('fecha_fin_garantia').addEventListener('change', function(){

    let garantia = new Date(this.value);

    if(!isNaN(garantia)){

        garantia.setFullYear(garantia.getFullYear() + 5);

        let year = garantia.getFullYear();
        let month = String(garantia.getMonth() + 1).padStart(2,'0');
        let day = String(garantia.getDate()).padStart(2,'0');

        document.getElementById('vida_util').value = year + '-' + month + '-' + day;

    }

});

</script>


<style>

.contenedor-form{
max-width:900px;
margin:auto;
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

.grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:15px;
}

label{
font-size:13px;
font-weight:600;
display:block;
margin-bottom:3px;
}

input, select{
width:100%;
padding:7px;
border:1px solid #d1d5db;
border-radius:6px;
}

.acciones{
margin-top:20px;
display:flex;
gap:10px;
}

button{
background:#2563eb;
color:white;
border:none;
padding:8px 15px;
border-radius:6px;
cursor:pointer;
}

.btn-volver{
background:#6b7280;
color:white;
padding:8px 15px;
border-radius:6px;
text-decoration:none;
}

</style>