@extends('layouts.app')

@section('content')

<style>

/* ================= CONTENEDOR ================= */

.form-container{
    max-width:700px;
    margin:auto;
    background:white;
    padding:25px;
    border-radius:16px;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
}

.form-group{
    margin-bottom:15px;
}

.form-group label{
    display:block;
    margin-bottom:5px;
    font-size:14px;
}

.form-group input,
.form-group select,
.form-group textarea{
    width:100%;
    padding:10px;
    border-radius:8px;
    border:1px solid #ddd;
}

/* BOTONES */

.btn-primary{
    background:#0f4c81;
    color:white;
    padding:10px 16px;
    border:none;
    border-radius:10px;
    cursor:pointer;
}

.btn-select{
    background:#2c7be5;
    color:white;
    border:none;
    padding:10px 14px;
    border-radius:8px;
    cursor:pointer;
    margin-top:8px;
}

.btn-volver{
    background:#6b7280;
    color:white;
    border:none;
    padding:10px 14px;
    border-radius:8px;
    cursor:pointer;
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
    pointer-events:none;
}

.modal-bg.active{
    visibility:visible;
    opacity:1;
    pointer-events:auto;
}

.modal-box{
    margin-top:60px;
    background:white;
    padding:20px;
    border-radius:14px;
    width:520px;
    max-height:450px;
    display:flex;
    flex-direction:column;
    gap:10px;
    box-shadow:0 10px 30px rgba(0,0,0,0.15);
}

/* BUSCADOR */

.buscador-equipos{
    padding:8px;
    border-radius:8px;
    border:1px solid #ddd;
}

/* TABLA */

.tabla-equipos{
    max-height:230px;
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

.fila-activa{
    background:#e3f2fd !important;
}

.modal-actions{
    display:flex;
    gap:10px;
    justify-content:flex-end;
    margin-top:10px;
}

.error{
    color:#dc2626;
    font-size:12px;
    margin-top:5px;
}

</style>

<div class="form-container">

<h1>Nuevo Mantenimiento</h1>

<form action="/mantenimientos" method="POST" id="formMantenimiento">
@csrf

<div class="form-group">
<label>Computadora</label>

<input type="text" id="nombreComputadora" placeholder="Ninguna computadora seleccionada" readonly required>

<input type="hidden" name="id_computadora" id="computadoraSeleccionada" required>

<button type="button" class="btn-select" onclick="abrirModal()">Seleccionar computadora</button>
</div>

<div class="form-group">
<label>Tipo</label>

<select name="tipo" required>
<option value="">Seleccionar tipo</option>
<option value="Preventivo">Preventivo</option>
<option value="Correctivo">Correctivo</option>
</select>
</div>

<div class="form-group">
<label>Fecha programada</label>

<input 
    type="date" 
    name="fecha_programada" 
    id="fecha_programada"
    min="{{ date('Y-01-01') }}"
    required
>

<div id="errorFecha" class="error" style="display:none;"></div>
</div>

<div class="form-group">
<label>Estado</label>

<select name="estado" required>
<option value="">Seleccionar estado</option>
<option value="Pendiente">Pendiente</option>

</select>
</div>

<div class="form-group">
<label>Observaciones</label>
<textarea name="observaciones" required></textarea>
</div>

<button class="btn-primary" type="submit">
Guardar
</button>

</form>

</div>

<!-- ================= MODAL ================= -->

<div id="modalEquipos" class="modal-bg">
<div class="modal-box">

<h3>Seleccionar computadora</h3>

<input type="text" id="buscarEquipo" placeholder="Buscar computadora..." class="buscador-equipos" onkeyup="filtrarEquipos()">

<div class="tabla-equipos">
<table id="tablaEquipos">

<thead>
<tr>
<th></th>
<th>ID</th>
<th>Nombre</th>
<th>Marca</th>
<th>Modelo</th>
<th>Estado</th>
</tr>
</thead>

<tbody>

@foreach($computadoras as $pc)
<tr onclick="seleccionarEquipo(this)">
<td>
<input type="radio" name="equipoSeleccionado" value="{{ $pc->id }}" data-nombre="{{ $pc->nombre_equipo }}" onclick="event.stopPropagation()">
</td>
<td>{{ $pc->id }}</td>
<td>{{ $pc->nombre_equipo }}</td>
<td>{{ $pc->marca }}</td>
<td>{{ $pc->modelo }}</td>
<td>{{ $pc->estado }}</td>
</tr>
@endforeach

</tbody>

</table>
</div>

<div class="modal-actions">
<button class="btn-volver" onclick="cerrarModal()">Volver</button>
<button class="btn-primary" onclick="confirmarSeleccion()">Confirmar</button>
</div>

</div>
</div>

<script>

/* ================= MODAL ================= */

function abrirModal(){
    document.getElementById("modalEquipos").classList.add("active");
}

function cerrarModal(){
    document.getElementById("modalEquipos").classList.remove("active");
}

function seleccionarEquipo(fila){
    document.querySelectorAll("#tablaEquipos tbody tr")
    .forEach(f => f.classList.remove("fila-activa"));

    fila.classList.add("fila-activa");

    let radio = fila.querySelector("input");
    radio.checked = true;
}

function confirmarSeleccion(){
    let seleccionado = document.querySelector('input[name="equipoSeleccionado"]:checked');

    if(!seleccionado){
        alert("Selecciona una computadora");
        return;
    }

    document.getElementById("computadoraSeleccionada").value = seleccionado.value;
    document.getElementById("nombreComputadora").value = seleccionado.dataset.nombre;

    cerrarModal();
}

/* ================= BUSCADOR ================= */

function filtrarEquipos(){
    let input = document.getElementById("buscarEquipo").value.toLowerCase();
    let filas = document.querySelectorAll("#tablaEquipos tbody tr");

    filas.forEach(function(fila){
        let texto = fila.innerText.toLowerCase();
        fila.style.display = texto.includes(input) ? "" : "none";
    });
}

/* ================= VALIDACION FECHA ================= */

document.addEventListener('DOMContentLoaded', function () {

    const fecha = document.getElementById('fecha_programada');
    const error = document.getElementById('errorFecha');
    const form = document.getElementById('formMantenimiento');

    function validarFecha(){

        error.style.display = 'none';

        if(!fecha.value) return true;

        const seleccionada = new Date(fecha.value + 'T00:00:00');
        const inicioAnio = new Date(new Date().getFullYear(), 0, 1);

        if(seleccionada < inicioAnio){
            error.innerText = "No se permiten fechas de años pasados";
            error.style.display = 'block';
            fecha.focus();
            return false;
        }

        return true;
    }

    fecha.addEventListener('change', validarFecha);

    form.addEventListener('submit', function(e){
        if(!validarFecha()){
            e.preventDefault();
        }
    });

});

</script>

@endsection