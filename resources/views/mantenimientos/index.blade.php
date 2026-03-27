@extends('layouts.app')

@section('content')

<style>

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

/* ================= FILTROS ================= */

.filtros{
display:flex;
gap:10px;
margin-bottom:15px;
flex-wrap:wrap;
}

.filtros select{
padding:7px 10px;
border-radius:8px;
border:1px solid #ddd;
font-size:13px;
}

.btn-filtrar,
.btn-limpiar{
border:none;
padding:7px 14px;
border-radius:8px;
font-size:13px;
cursor:pointer;
text-decoration:none;
display:inline-flex;
align-items:center;
justify-content:center;
font-weight:600;
position:relative;
overflow:hidden;
transition:all 0.25s ease;
box-shadow:0 6px 14px rgba(0,0,0,0.10);
}

.btn-filtrar{
background:#0f4c81;
color:white;
}

.btn-limpiar{
background:#e55353;
color:white;
}

.btn-filtrar:hover,
.btn-limpiar:hover{
transform:translateY(-2px) scale(1.02);
box-shadow:0 12px 22px rgba(0,0,0,0.16);
}

.btn-filtrar:active,
.btn-limpiar:active{
transform:scale(0.97);
}

.btn-filtrar::before,
.btn-limpiar::before{
content:"";
position:absolute;
top:0;
left:-120%;
width:120%;
height:100%;
background:linear-gradient(120deg, transparent, rgba(255,255,255,0.35), transparent);
transition:left 0.6s ease;
}

.btn-filtrar:hover::before,
.btn-limpiar:hover::before{
left:120%;
}

/* ================= CONTENEDOR ================= */

.mant-container{
padding:25px;
}

.mant-header{
margin-bottom:15px;
}

.mant-header h1{
font-size:24px;
font-weight:600;
}

.mant-grid{
display:grid;
grid-template-columns: 1fr 150px;
gap:16px;
}

.mant-actions{
display:flex;
flex-direction:column;
gap:10px;
}

/* ================= BOTONES ================= */

.btn-primary,
.btn-secondary,
.btn-danger{
border:none;
padding:10px;
border-radius:10px;
cursor:pointer;
width:100%;
font-weight:600;
font-size:14px;
position:relative;
overflow:hidden;
transition:all 0.25s ease;
box-shadow:0 6px 14px rgba(0,0,0,0.10);
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

.btn-primary:hover,
.btn-secondary:hover,
.btn-danger:hover{
transform:translateY(-2px) scale(1.02);
box-shadow:0 12px 22px rgba(0,0,0,0.16);
}

.btn-primary:active,
.btn-secondary:active,
.btn-danger:active{
transform:scale(0.97);
}

.btn-primary::before,
.btn-secondary::before,
.btn-danger::before{
content:"";
position:absolute;
top:0;
left:-120%;
width:120%;
height:100%;
background:linear-gradient(120deg, transparent, rgba(255,255,255,0.35), transparent);
transition:left 0.6s ease;
}

.btn-primary:hover::before,
.btn-secondary:hover::before,
.btn-danger:hover::before{
left:120%;
}

/* ================= TABLA ================= */

.tabla-wrapper{
background:white;
border-radius:16px;
box-shadow:0 6px 18px rgba(0,0,0,0.05);
max-height:520px;
overflow-y:auto;
}

.tabla-mant{
width:100%;
border-collapse:collapse;
table-layout:fixed;
}

.tabla-mant thead{
position:sticky;
top:0;
background:#f4f6f9;
}

.tabla-mant th{
padding:9px;
font-size:12px;
color:#6c757d;
}

.tabla-mant td{
padding:9px;
font-size:13px;
border-top:1px solid #eee;
white-space:nowrap;
overflow:hidden;
text-overflow:ellipsis;
}

.tabla-mant tbody tr:hover{
background:#f9fbfd;
cursor:pointer;
}

.fila-activa{
background:#e3f2fd !important;
}

/* ================= BADGES COLORES ================= */

.badge{
padding:4px 10px;
border-radius:6px;
font-size:11px;
font-weight:600;
display:inline-block;
}

.badge-pendiente{
background:#ef4444;
color:white;
}

.badge-completado{
background:#22c55e;
color:white;
}

.badge-en{
background:#f59e0b;
color:white;
}

.badge-preventivo{
background:#3b82f6;
color:white;
}

.badge-correctivo{
background:#facc15;
color:#111827;
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

.btn-cancelar,
.btn-confirmar{
border:none;
padding:8px 14px;
border-radius:8px;
cursor:pointer;
font-weight:600;
font-size:14px;
position:relative;
overflow:hidden;
transition:all 0.25s ease;
box-shadow:0 6px 14px rgba(0,0,0,0.10);
}

.btn-cancelar{
background:#e5e7eb;
color:#374151;
}

.btn-confirmar{
background:#e55353;
color:white;
}

.btn-cancelar:hover,
.btn-confirmar:hover{
transform:translateY(-2px) scale(1.02);
box-shadow:0 12px 22px rgba(0,0,0,0.16);
}

.btn-cancelar:active,
.btn-confirmar:active{
transform:scale(0.97);
}

.btn-cancelar::before,
.btn-confirmar::before{
content:"";
position:absolute;
top:0;
left:-120%;
width:120%;
height:100%;
background:linear-gradient(120deg, transparent, rgba(255,255,255,0.35), transparent);
transition:left 0.6s ease;
}

.btn-cancelar:hover::before,
.btn-confirmar:hover::before{
left:120%;
}

</style>

<div class="mant-container">

<div class="mant-header">
<h1>Mantenimientos</h1>
</div>

<form method="GET" class="filtros">

<select name="estado">
<option value="">Estado</option>
<option value="Pendiente" {{ request('estado')=='Pendiente'?'selected':'' }}>Pendiente</option>
<option value="Completado" {{ request('estado')=='Completado'?'selected':'' }}>Completado</option>
<option value="En proceso" {{ request('estado')=='En proceso'?'selected':'' }}>En proceso</option>
</select>

<select name="tipo">
<option value="">Tipo</option>
<option value="Preventivo" {{ request('tipo')=='Preventivo'?'selected':'' }}>Preventivo</option>
<option value="Correctivo" {{ request('tipo')=='Correctivo'?'selected':'' }}>Correctivo</option>
</select>

<select name="orden">
<option value="recientes" {{ request('orden')=='recientes'?'selected':'' }}>Más recientes</option>
<option value="antiguos" {{ request('orden')=='antiguos'?'selected':'' }}>Más antiguos</option>
<option value="modificados" {{ request('orden')=='modificados'?'selected':'' }}>Modificados recientemente</option>
</select>

<button type="submit" class="btn-filtrar">Filtrar</button>

<a href="/mantenimientos" class="btn-limpiar">Limpiar</a>

</form>

<div class="mant-grid">

<div class="tabla-wrapper">

<table id="tablaMant" class="tabla-mant">

<thead>
<tr>
<th style="width:35px"></th>
<th style="width:55px">ID</th>
<th style="width:180px">Equipo</th>
<th style="width:110px">Tipo</th>
<th style="width:120px">Fecha</th>
<th style="width:130px">Estado</th>
</tr>
</thead>

<tbody>

@foreach($mantenimientos as $m)

<tr onclick="seleccionarFila(this)">

<td>
<input type="radio" name="filaSeleccionada" value="{{ $m->id }}" onclick="event.stopPropagation();">
</td>

<td>{{ $m->id }}</td>

<td>{{ $m->computadora->nombre_equipo ?? 'Sin equipo' }}</td>

<td>
<span class="badge badge-{{ strtolower($m->tipo) }}">
{{ $m->tipo }}
</span>
</td>

<td>{{ $m->fecha_programada }}</td>

<td>
@if($m->estado == 'En proceso')
<span class="badge badge-en">{{ $m->estado }}</span>
@else
<span class="badge badge-{{ strtolower($m->estado) }}">
{{ $m->estado }}
</span>
@endif
</td>

</tr>

@endforeach

</tbody>

</table>

</div>

<div class="mant-actions">

<button type="button" class="btn-primary" onclick="window.location.href='/mantenimientos/create'">
Nuevo
</button>

<button type="button" class="btn-secondary" onclick="editarSeleccion()">
Propiedades
</button>

<button type="button" class="btn-danger" onclick="eliminarSeleccion()">
Eliminar
</button>

</div>

</div>

</div>

<div id="alertaSistema" class="alerta-sistema">
⚠️ Selecciona un mantenimiento primero
</div>

<div id="modalEliminar" class="modal-bg">

<div class="modal-box">

<h3>Eliminar mantenimiento</h3>

<p>¿Seguro que deseas eliminar este registro?</p>

<div class="modal-actions">

<button type="button" class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>

<button type="button" class="btn-confirmar" onclick="confirmarEliminar()">Eliminar</button>

</div>

</div>

</div>

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

document.querySelectorAll("#tablaMant tbody tr")
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

window.location.href = "/mantenimientos/" + seleccionado.value;

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

fetch("/mantenimientos/" + idEliminar,{
method:"DELETE",
headers:{
"X-CSRF-TOKEN":"{{ csrf_token() }}",
"Accept":"application/json"
}
}).then(()=>location.reload());

}

</script>

@endsection