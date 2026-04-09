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

.btn-cancelar,
.btn-confirmar{
    border:none;
    padding:10px 16px;
    border-radius:10px;
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
    font-weight:600;
    font-size:14px;
    position:relative;
    overflow:hidden;
    transition:all 0.25s ease;
    box-shadow:0 6px 14px rgba(15,76,129,0.12);
}

.btn-buscar:hover{
    transform:translateY(-2px) scale(1.02);
    box-shadow:0 12px 22px rgba(15,76,129,0.20);
    background:#0c3d68;
}

.btn-buscar:active{
    transform:scale(0.97);
}

.btn-buscar::before{
    content:"";
    position:absolute;
    top:0;
    left:-120%;
    width:120%;
    height:100%;
    background:linear-gradient(120deg, transparent, rgba(255,255,255,0.35), transparent);
    transition:left 0.6s ease;
}

.btn-buscar:hover::before{
    left:120%;
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
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.tabla-inventario tbody tr:hover{
    background:#f9fbfd;
    cursor:pointer;
}

.fila-activa{
    background:#e3f2fd !important;
}

/* Control ancho columnas */

.tabla-inventario th:nth-child(3),
.tabla-inventario td:nth-child(3){
    max-width:160px;
}

.tabla-inventario th:nth-child(5),
.tabla-inventario td:nth-child(5){
    max-width:120px;
}

.tabla-inventario th:nth-child(6),
.tabla-inventario td:nth-child(6){
    max-width:120px;
}

.tabla-inventario th:nth-child(8),
.tabla-inventario td:nth-child(8){
    max-width:240px;
}

/* Badge estado */

.badge-estado{
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

/* ================= BOTONES LATERALES ANIMADOS ================= */

.btn-primary,
.btn-secondary,
.btn-danger{
    border:none;
    padding:10px 16px;
    border-radius:10px;
    cursor:pointer;
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

.equipo-nombre{
    font-weight:600;
}

.usuarios-lista{
    display:flex;
    flex-wrap:wrap;
    gap:6px;
    max-width:220px;
    white-space:normal;
}

.usuario-badge{
    display:inline-block;
    padding:4px 8px;
    border-radius:999px;
    font-size:11px;
    font-weight:600;
    background:#0f4c81;
    color:white;
    line-height:1.2;
}

.texto-vacio{
    color:#6b7280;
    font-size:12px;
}

</style>

<div class="inventario-container">

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="inventario-header">
        <h1>Inventario Tecnológico</h1>
    </div>

    <form method="GET" action="/computadoras" class="buscador">
        <input type="text" name="buscar" placeholder="Buscar equipo..." value="{{ $buscar ?? '' }}">

        <button type="submit" class="btn-buscar">
            Buscar
        </button>
    </form>

    <div class="inventario-layout">

        <div class="tabla-scroll">

            <table id="tablaComputadoras" class="tabla-inventario">

                <thead>
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Estado</th>
                        <th>Usuarios Asignados</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($computadoras as $c)
                        <tr onclick="seleccionarFila(this)">

                            <td>
                                <input type="radio" name="filaSeleccionada" value="{{ $c->id }}" onclick="event.stopPropagation();">
                            </td>

                            <td>{{ $c->id }}</td>

                            <td class="equipo-nombre">{{ $c->nombre_equipo }}</td>

                            <td>{{ $c->tipo }}</td>

                            <td>{{ $c->marca }}</td>

                            <td>{{ $c->modelo }}</td>

                            <td>
                                <span class="badge-estado">{{ $c->estado }}</span>
                            </td>

                            <td>
                                @if($c->usuarios && $c->usuarios->count())
                                    <div class="usuarios-lista">
                                        @foreach($c->usuarios as $usuario)
                                            <span class="usuario-badge">{{ $usuario->nombre }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="texto-vacio">Sin usuarios</span>
                                @endif
                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="acciones-lado">

            <button class="btn-primary" onclick="window.location.href='/computadoras/create'">
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
    ⚠️ Selecciona una computadora primero
</div>

<div id="modalEliminar" class="modal-bg">

    <div class="modal-box">

        <h3>Eliminar computadora</h3>

        <p>¿Seguro que deseas eliminar este equipo?</p>

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
    document.querySelectorAll("#tablaComputadoras tbody tr")
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

    window.location.href = "/computadoras/" + seleccionado.value;
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
    form.action = "/computadoras/" + idEliminar;
    form.submit();
}
</script>

@endsection