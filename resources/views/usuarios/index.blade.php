@extends('layouts.app')

@section('content')

<style>

/* ================= MENSAJE SUCCESS ================= */

.alert-success{
background:#d1fae5;
color:#065f46;
padding:12px;
border-radius:10px;
margin-bottom:15px;
}

/* ================= ALERTA SISTEMA ================= */

.alerta-sistema{

position:fixed;

top:70px;

left:50%;

transform:translateX(-50%) translateY(-30px);

background:#fff4e5;
color:#8a5300;

padding:12px 22px;

border-radius:10px;

box-shadow:0 8px 20px rgba(0,0,0,0.15);

font-size:14px;

border-left:4px solid #f59e0b;

opacity:0;

pointer-events:none;

transition:all .35s ease;

z-index:200;

}

.alerta-sistema.mostrar{

opacity:1;

transform:translateX(-50%) translateY(0);

}

/* ================= MODAL ================= */

.modal-bg{
position:fixed;
inset:0;
background:rgba(0,0,0,0.35);
display:flex;
align-items:center;
justify-content:center;
visibility:hidden;
opacity:0;
transition:0.2s;
z-index:999;
}

.modal-bg.active{
visibility:visible;
opacity:1;
}

.modal-box{
background:white;
padding:25px;
border-radius:14px;
width:320px;
text-align:center;
box-shadow:0 10px 30px rgba(0,0,0,0.15);
}

.modal-actions{
margin-top:20px;
display:flex;
gap:10px;
justify-content:center;
}

.btn-cancelar{
background:#e5e7eb;
border:none;
padding:8px 14px;
border-radius:8px;
cursor:pointer;
}

.btn-confirmar{
background:#e55353;
color:white;
border:none;
padding:8px 14px;
border-radius:8px;
cursor:pointer;
}

/* ================= INVENTARIO ================= */

.inventario-container{
padding:25px;
width:100%;
}

.inventario-header{
margin-bottom:15px;
}

.inventario-header h1{
font-size:26px;
font-weight:600;
}

.buscador{
margin-bottom:20px;
display:flex;
gap:10px;
}

.buscador input{
padding:10px;
border-radius:10px;
border:1px solid #d1d5db;
width:260px;
}

.btn-buscar{
background:#0f4c81;
color:white;
border:none;
padding:10px 16px;
border-radius:10px;
cursor:pointer;
}

.inventario-layout{
display:flex;
gap:14px;
width:100%;
align-items:flex-start;
}

.tabla-scroll{
flex:1;
background:white;
border-radius:16px;
box-shadow:0 6px 18px rgba(0,0,0,0.05);
max-height:600px;
overflow-y:auto;
}

.tabla-inventario{
width:100%;
border-collapse:collapse;
}

.tabla-inventario thead{
position:sticky;
top:0;
z-index:5;
}

.tabla-inventario th{
background:#f4f6f9;
text-align:left;
padding:10px 12px;
font-size:12.5px;
color:#6c757d;
border-bottom:1px solid #ddd;
}

.tabla-inventario td{
padding:10px 12px;
font-size:13px;
border-top:1px solid #eee;
}

.tabla-inventario tbody tr:hover{
background:#f9fbfd;
cursor:pointer;
}

.fila-activa{
background:#e3f2fd !important;
}

.badge-rol{
background:#e3f2fd;
color:#0f4c81;
padding:4px 8px;
border-radius:20px;
font-size:11px;
}

html, body{
overflow-x:hidden;
}

.acciones-lado{
display:flex;
flex-direction:column;
gap:10px;
min-width:130px;
}

.btn-primary{
background:#0f4c81;
color:white;
border:none;
padding:10px 16px;
border-radius:10px;
cursor:pointer;
}

.btn-secondary{
background:#2c7be5;
color:white;
border:none;
padding:10px 16px;
border-radius:10px;
cursor:pointer;
}

.btn-danger{
background:#e55353;
color:white;
border:none;
padding:10px 16px;
border-radius:10px;
cursor:pointer;
}

.usuario-nombre{
font-weight:600;
}

</style>


<div class="inventario-container">

@if(session('success'))
<div class="alert-success">
{{ session('success') }}
</div>
@endif

<div class="inventario-header">
<h1>Usuarios</h1>
</div>

<form method="GET" action="/usuarios" class="buscador">

<input type="text" name="buscar" placeholder="Buscar usuario..." value="{{ $buscar ?? '' }}">

<button type="submit" class="btn-buscar">
Buscar
</button>

</form>


<div class="inventario-layout">

<div class="tabla-scroll">

<table id="tablaUsuarios" class="tabla-inventario">

<thead>
<tr>
<th></th>
<th>ID</th>
<th>Nombre</th>
<th>Área</th>
<th>Rol</th>
<th>Computadoras</th>
</tr>
</thead>

<tbody>

@foreach($usuarios as $u)

<tr onclick="seleccionarFila(this)">

<td>
<input type="radio" name="filaSeleccionada" value="{{ $u->id }}" onclick="event.stopPropagation();">
</td>

<td>{{ $u->id }}</td>

<td class="usuario-nombre">
{{ $u->nombre }}
</td>

<td>
{{ optional($u->ubicacion)->area_empresa ?? 'Sin área' }}
</td>

<td>
<span class="badge-rol">
{{ $u->rol ?? 'Sin rol' }}
</span>
</td>

<td>
{{ $u->computadoras()->count() }}
</td>

</tr>

@endforeach

</tbody>

</table>

</div>


<div class="acciones-lado">

<button class="btn-primary" onclick="window.location.href='/usuarios/create'">
Nuevo
</button>

<button class="btn-secondary" onclick="editarSeleccion()">
Propiedades
</button>

<button class="btn-danger" onclick="eliminarSeleccion()">
Eliminar
</button>

</div>

</div>

</div>


<div id="alertaSistema" class="alerta-sistema">
⚠️ Selecciona un usuario primero
</div>


<div id="modalEliminar" class="modal-bg">

<div class="modal-box">

<h3>Eliminar usuario</h3>

<p>¿Seguro que deseas eliminar este usuario?</p>

<div class="modal-actions">

<button class="btn-cancelar" onclick="cerrarModal()">
Cancelar
</button>

<button class="btn-confirmar" onclick="confirmarEliminar()">
Eliminar
</button>

</div>

</div>

</div>


<form id="formEliminar" method="POST" style="display:none;">
@csrf
@method('DELETE')
</form>


<script>

let idEliminar = null;

function mostrarAlerta(){

let alerta = document.getElementById("alertaSistema");

alerta.classList.add("mostrar");

setTimeout(function(){

alerta.classList.remove("mostrar");

},2500);

}

function seleccionarFila(fila){

document.querySelectorAll("#tablaUsuarios tbody tr")
.forEach(f => f.classList.remove("fila-activa"));

fila.classList.add("fila-activa");

fila.querySelector("input").checked = true;

}

function editarSeleccion(){

let seleccionado = document.querySelector('input[name="filaSeleccionada"]:checked');

if(!seleccionado){

mostrarAlerta();
return;

}

window.location.href = "/usuarios/" + seleccionado.value;

}

function eliminarSeleccion(){

let seleccionado = document.querySelector('input[name="filaSeleccionada"]:checked');

if(!seleccionado){

mostrarAlerta();
return;

}

idEliminar = seleccionado.value;

document.getElementById("modalEliminar").classList.add("active");

}

function cerrarModal(){

document.getElementById("modalEliminar").classList.remove("active");

}

function confirmarEliminar(){

let form = document.getElementById("formEliminar");

form.action = "/usuarios/" + idEliminar;

form.submit();

}

</script>

@endsection