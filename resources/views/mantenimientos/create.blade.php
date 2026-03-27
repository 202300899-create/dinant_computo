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
    font-weight:600;
    color:#374151;
}

.form-group input,
.form-group select,
.form-group textarea{
    width:100%;
    padding:10px;
    border-radius:8px;
    border:1px solid #ddd;
    box-sizing:border-box;
}

.form-group textarea{
    min-height:110px;
    resize:vertical;
}

.input-error{
    border-color:#dc2626 !important;
}

.error-text{
    color:#dc2626;
    font-size:12px;
    margin-top:5px;
    display:block;
}

/* ALERTAS */

.alerta-error{
    background:#fee2e2;
    color:#991b1b;
    border:1px solid #fecaca;
    padding:12px 14px;
    border-radius:12px;
    margin-bottom:18px;
}

.alerta-error ul{
    margin:0;
    padding-left:18px;
}

.alerta-success{
    background:#dcfce7;
    color:#166534;
    border:1px solid #bbf7d0;
    padding:12px 14px;
    border-radius:12px;
    margin-bottom:18px;
}

/* BOTONES */

.btn-primary{
    background:#0f4c81;
    color:white;
    padding:10px 16px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    transition:.2s ease;
}

.btn-primary:hover{
    background:#0c3d68;
    transform:translateY(-1px);
}

.btn-select{
    background:#2c7be5;
    color:white;
    border:none;
    padding:10px 14px;
    border-radius:8px;
    cursor:pointer;
    margin-top:8px;
    transition:.2s ease;
}

.btn-select:hover{
    background:#1f68c7;
    transform:translateY(-1px);
}

.btn-volver{
    background:#6b7280;
    color:white;
    border:none;
    padding:10px 14px;
    border-radius:8px;
    cursor:pointer;
    transition:.2s ease;
}

.btn-volver:hover{
    background:#4b5563;
    transform:translateY(-1px);
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

</style>

<div class="form-container">

    <h1>Nuevo Mantenimiento</h1>

    @if(session('success'))
        <div class="alerta-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alerta-error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alerta-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mantenimientos.store') }}" method="POST" id="formMantenimiento">
        @csrf

        <div class="form-group">
            <label>Computadora</label>

            <input
                type="text"
                id="nombreComputadora"
                placeholder="Ninguna computadora seleccionada"
                value="{{ old('nombre_computadora') }}"
                readonly
                required
            >

            <input
                type="hidden"
                name="id_computadora"
                id="computadoraSeleccionada"
                value="{{ old('id_computadora') }}"
                required
            >

            <button type="button" class="btn-select" onclick="abrirModal()">
                Seleccionar computadora
            </button>

            @error('id_computadora')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Tipo</label>

            <select name="tipo" class="{{ $errors->has('tipo') ? 'input-error' : '' }}" required>
                <option value="">Seleccionar tipo</option>
                <option value="Preventivo" {{ old('tipo') == 'Preventivo' ? 'selected' : '' }}>Preventivo</option>
                <option value="Correctivo" {{ old('tipo') == 'Correctivo' ? 'selected' : '' }}>Correctivo</option>
            </select>

            @error('tipo')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Fecha programada</label>

            <input
                type="date"
                name="fecha_programada"
                id="fecha_programada"
                value="{{ old('fecha_programada') }}"
                min="{{ now()->startOfYear()->format('Y-m-d') }}"
                class="{{ $errors->has('fecha_programada') ? 'input-error' : '' }}"
                required
            >

            <span id="errorFecha" class="error-text" style="display:none;"></span>

            @error('fecha_programada')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Estado</label>

            <select name="estado" class="{{ $errors->has('estado') ? 'input-error' : '' }}" required>
                <option value="">Seleccionar estado</option>
                <option value="Pendiente" {{ old('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="En proceso" {{ old('estado') == 'En proceso' ? 'selected' : '' }}>En proceso</option>
            </select>

            @error('estado')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label>Observaciones</label>

            <textarea
                name="observaciones"
                id="observaciones"
                class="{{ $errors->has('observaciones') ? 'input-error' : '' }}"
                required
            >{{ old('observaciones') }}</textarea>

            <span id="errorObservaciones" class="error-text" style="display:none;"></span>

            @error('observaciones')
                <span class="error-text">{{ $message }}</span>
            @enderror
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

        <input
            type="text"
            id="buscarEquipo"
            placeholder="Buscar computadora..."
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
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($computadoras as $pc)
                        <tr onclick="seleccionarEquipo(this)">
                            <td>
                                <input
                                    type="radio"
                                    name="equipoSeleccionado"
                                    value="{{ $pc->id }}"
                                    data-nombre="{{ $pc->nombre_equipo }}"
                                    {{ old('id_computadora') == $pc->id ? 'checked' : '' }}
                                    onclick="event.stopPropagation()"
                                >
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
            <button type="button" class="btn-volver" onclick="cerrarModal()">
                Volver
            </button>

            <button type="button" class="btn-primary" onclick="confirmarSeleccion()">
                Confirmar
            </button>
        </div>

    </div>
</div>

<script>
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

function filtrarEquipos(){
    let input = document.getElementById("buscarEquipo").value.toLowerCase();
    let filas = document.querySelectorAll("#tablaEquipos tbody tr");

    filas.forEach(function(fila){
        let texto = fila.innerText.toLowerCase();
        fila.style.display = texto.includes(input) ? "" : "none";
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="equipoSeleccionado"]');
    const hidden = document.getElementById("computadoraSeleccionada");
    const nombre = document.getElementById("nombreComputadora");
    const fecha = document.getElementById("fecha_programada");
    const observaciones = document.getElementById("observaciones");
    const form = document.getElementById("formMantenimiento");
    const errorFecha = document.getElementById("errorFecha");
    const errorObservaciones = document.getElementById("errorObservaciones");

    radios.forEach(radio => {
        if (radio.checked) {
            hidden.value = radio.value;
            nombre.value = radio.dataset.nombre;
            radio.closest('tr')?.classList.add('fila-activa');
        }
    });

    function limpiarErrorFecha(){
        errorFecha.style.display = 'none';
        errorFecha.textContent = '';
        fecha.style.borderColor = '#ddd';
    }

    function mostrarErrorFecha(mensaje){
        errorFecha.style.display = 'block';
        errorFecha.textContent = mensaje;
        fecha.style.borderColor = '#dc2626';
    }

    function limpiarErrorObservaciones(){
        errorObservaciones.style.display = 'none';
        errorObservaciones.textContent = '';
        observaciones.style.borderColor = '#ddd';
    }

    function mostrarErrorObservaciones(mensaje){
        errorObservaciones.style.display = 'block';
        errorObservaciones.textContent = mensaje;
        observaciones.style.borderColor = '#dc2626';
    }

    function validarFecha(){
        limpiarErrorFecha();

        if(!fecha.value) return true;

        const seleccionada = new Date(fecha.value + 'T00:00:00');
        const inicioAnio = new Date(new Date().getFullYear(), 0, 1);

        if(seleccionada < inicioAnio){
            mostrarErrorFecha('No se permiten fechas de años pasados.');
            fecha.focus();
            return false;
        }

        return true;
    }

    function validarObservaciones(){
        limpiarErrorObservaciones();

        if(!observaciones.value.trim()) return true;

        if(/\d/.test(observaciones.value)){
            mostrarErrorObservaciones('Las observaciones no pueden contener números.');
            observaciones.focus();
            return false;
        }

        return true;
    }

    fecha.addEventListener('change', validarFecha);
    observaciones.addEventListener('input', validarObservaciones);

    form.addEventListener('submit', function(e){
        const fechaOk = validarFecha();
        const observacionesOk = validarObservaciones();

        if(!fechaOk || !observacionesOk){
            e.preventDefault();
        }
    });
});
</script>

@endsection