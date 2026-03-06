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
margin-bottom:20px;
}

.item{
margin-bottom:10px;
font-size:15px;
}

.badge{
background:#e3f2fd;
color:#0f4c81;
padding:5px 10px;
border-radius:20px;
font-size:12px;
}

.acciones{
margin-top:20px;
display:flex;
gap:10px;
flex-wrap:wrap;
}

.btn-editar{
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

.btn-asignar{
background:#2c7be5;
color:white;
border:none;
padding:10px 18px;
border-radius:10px;
cursor:pointer;
}

.btn-eliminar{
background:#e55353;
color:white;
border:none;
padding:10px 18px;
border-radius:10px;
cursor:pointer;
}

/* ================= TABLA ================= */

.historial{
max-width:950px;
margin:auto;
background:white;
padding:20px;
border-radius:16px;
box-shadow:0 6px 18px rgba(0,0,0,0.05);
}

.tabla{
width:100%;
border-collapse:collapse;
}

.tabla th{
text-align:left;
padding:10px;
background:#f4f6f9;
font-size:13px;
}

.tabla td{
padding:10px;
border-top:1px solid #eee;
}

.tabla tr:hover{
background:#f9fbfd;
cursor:pointer;
}

.fila-activa{
background:#e3f2fd !important;
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
transition:.2s;
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
width:800px;
max-height:600px;
display:flex;
flex-direction:column;
gap:10px;
box-shadow:0 10px 30px rgba(0,0,0,0.15);
}

.modal-box-small{
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

/* ================= BUSCADOR ================= */

.buscador-equipos{
padding:8px;
border-radius:8px;
border:1px solid #ddd;
}

/* ================= TABLA MODAL ================= */

.tabla-equipos{
max-height:350px;
overflow-y:auto;
border:1px solid #eee;
border-radius:10px;
}

#tablaEquipos{
width:100%;
border-collapse:collapse;
}

#tablaEquipos th{
background:#f4f6f9;
padding:8px;
font-size:12px;
}

#tablaEquipos td{
padding:8px;
border-top:1px solid #eee;
font-size:13px;
}

#tablaEquipos tr:hover{
background:#f9fbfd;
cursor:pointer;
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
.titulo{
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 20px;
    letter-spacing: 1px;
    text-transform: uppercase;
}

</style>

<div id="alertaSistema" class="alerta-sistema">
⚠️ Selecciona una computadora primero
</div>


<!-- ================= FICHA USUARIO ================= -->

<div class="ficha">

<h1 class="titulo">{{ $usuario->nombre }}</h1>

<div class="item"><strong>Correo:</strong> {{ $usuario->correo }}</div>
<div class="item"><strong>Área:</strong> {{ $usuario->ubicacion->area_empresa ?? 'Sin área asignada' }}</div>
<div class="item"><strong>Rol:</strong> {{ $usuario->rol ?? 'Sin rol' }}</div>

<div class="item">
<strong>Estado:</strong>
<span class="badge">{{ $usuario->estado }}</span>
</div>

<div class="acciones">

<button class="btn-editar"
onclick="window.location.href='/usuarios/{{ $usuario->id }}/edit'">
Editar
</button>

<button class="btn-volver"
onclick="window.location.href='/usuarios'">
Volver
</button>

</div>

</div>



<!-- ================= EQUIPOS ================= -->

<div class="historial">

<h2>Equipos asignados</h2>

<table class="tabla">

<thead>
<tr>
<th></th>
<th>ID</th>
<th>Nombre</th>
<th>Marca</th>
<th>Modelo</th>
<th>Estado</th>
<th>Ver</th>
</tr>
</thead>

<tbody>

@forelse($usuario->computadoras as $pc)

<tr onclick="seleccionarPC(this)">

<td>
<input type="radio" name="pcSeleccionada" value="{{ $pc->id }}" onclick="event.stopPropagation();">
</td>

<td>{{ $pc->id }}</td>
<td>{{ $pc->nombre_equipo }}</td>
<td>{{ $pc->marca }}</td>
<td>{{ $pc->modelo }}</td>

<td>
<span class="badge">{{ $pc->estado }}</span>
</td>

<td>
<a href="/computadoras/{{ $pc->id }}">Ver</a>
</td>

</tr>

@empty

<tr>
<td colspan="7">Este usuario no tiene computadoras asignadas</td>
</tr>

@endforelse

</tbody>

</table>


<div class="acciones">

<button class="btn-asignar" onclick="abrirAsignar()">
Asignar equipo
</button>

<button class="btn-eliminar" onclick="abrirEliminar()">
Eliminar asignación
</button>

</div>

</div>



<!-- ================= MODAL ASIGNAR ================= -->

<div id="modalAsignar" class="modal-bg">

<div class="modal-box">

<h3>Asignar equipo</h3>

<input
type="text"
id="buscarEquipo"
placeholder="Buscar equipo..."
class="buscador-equipos"
onkeyup="filtrarEquipos()"
>

<div class="tabla-equipos">

<table id="tablaEquipos">

<thead>
<tr>
<th></th>
<th>ID</th>
<th>Nombre</th>
<th>Tipo</th>
<th>Marca</th>
<th>Modelo</th>
<th>Estado</th>
</tr>
</thead>

<tbody>

@foreach($computadorasDisponibles as $pc)

<tr onclick="seleccionarEquipo(this)">

<td>
<input type="radio"
name="equipoSeleccionado"
value="{{ $pc->id }}"
onclick="event.stopPropagation()">
</td>

<td>{{ $pc->id }}</td>
<td>{{ $pc->nombre_equipo }}</td>
<td>{{ $pc->tipo }}</td>
<td>{{ $pc->marca }}</td>
<td>{{ $pc->modelo }}</td>
<td>{{ $pc->estado }}</td>

</tr>

@endforeach

</tbody>

</table>

</div>


<form method="POST" action="/usuarios/{{ $usuario->id }}/asignar-equipo">

@csrf

<input type="hidden" name="computadora_id" id="computadoraSeleccionada">

<div class="acciones">

<button type="button" class="btn-volver" onclick="cerrarAsignar()">
Volver
</button>

<button type="submit" class="btn-asignar">
Asignar
</button>

</div>

</form>

</div>

</div>



<!-- ================= MODAL ELIMINAR ================= -->

<div id="modalEliminar" class="modal-bg">

<div class="modal-box-small">

<h3>Eliminar asignación</h3>

<p>¿Seguro que deseas quitar este equipo del usuario?</p>

<div class="modal-actions">

<button class="btn-cancelar" onclick="cerrarEliminar()">
Cancelar
</button>

<button class="btn-confirmar" onclick="confirmarEliminar()">
Eliminar
</button>

</div>

</div>

</div>



<form id="formEliminarAsignacion" method="POST" style="display:none;">
@csrf
@method('PUT')
</form>



<script>

/* ================= ALERTA ================= */

function mostrarAlerta(){

let alerta = document.getElementById("alertaSistema");

alerta.classList.add("mostrar");

setTimeout(function(){
alerta.classList.remove("mostrar");
},2500);

}


/* ================= MODAL ASIGNAR ================= */

function abrirAsignar(){
document.getElementById("modalAsignar").classList.add("active");
}

function cerrarAsignar(){
document.getElementById("modalAsignar").classList.remove("active");
}


/* ================= SELECCION EQUIPO MODAL ================= */

function seleccionarEquipo(fila){

document.querySelectorAll("#tablaEquipos tbody tr")
.forEach(f => f.classList.remove("fila-activa"));

fila.classList.add("fila-activa");

let radio = fila.querySelector("input");

radio.checked = true;

document.getElementById("computadoraSeleccionada").value = radio.value;

}


/* ================= BUSCAR EQUIPOS ================= */

function filtrarEquipos(){

let input = document.getElementById("buscarEquipo").value.toLowerCase();

let filas = document.querySelectorAll("#tablaEquipos tbody tr");

filas.forEach(function(fila){

let texto = fila.innerText.toLowerCase();

fila.style.display = texto.includes(input) ? "" : "none";

});

}


/* ================= SELECCION PC ================= */

function seleccionarPC(fila){

document.querySelectorAll(".tabla tbody tr")
.forEach(f => f.classList.remove("fila-activa"));

fila.classList.add("fila-activa");

fila.querySelector("input").checked = true;

}


/* ================= ELIMINAR ================= */

function abrirEliminar(){

let seleccionado = document.querySelector('input[name="pcSeleccionada"]:checked');

if(!seleccionado){

mostrarAlerta();

return;

}

document.getElementById("modalEliminar").classList.add("active");

}


function cerrarEliminar(){
document.getElementById("modalEliminar").classList.remove("active");
}


function confirmarEliminar(){

let seleccionado = document.querySelector('input[name="pcSeleccionada"]:checked');

if(!seleccionado){

mostrarAlerta();

return;

}

let pcID = seleccionado.value;

let form = document.getElementById("formEliminarAsignacion");

form.action="/usuarios/{{ $usuario->id }}/quitar-equipo/" + pcID;

form.submit();

}

</script>

@endsection