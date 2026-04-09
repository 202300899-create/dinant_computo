@extends('layouts.app')

@section('content')

<style>
.form-container{
    max-width: 760px;
    margin: 30px auto;
    background: #ffffff;
    padding: 0;
    border-radius: 20px;
    box-shadow: 0 18px 45px rgba(15, 76, 129, 0.08);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.form-header{
    background: linear-gradient(135deg, #0f4c81, #1d6fa5);
    color: white;
    padding: 24px 28px;
}

.form-header h1{
    margin: 0;
    font-size: 24px;
    font-weight: 700;
}

.form-body{
    padding: 26px 28px 30px;
}

.form-group{
    margin-bottom: 18px;
}

.form-group label{
    display: block;
    margin-bottom: 6px;
    font-size: 13px;
    font-weight: 700;
    color: #374151;
}

.form-group input,
.form-group select,
.form-group textarea{
    width: 100%;
    padding: 12px 14px;
    border-radius: 12px;
    border: 1px solid #d1d5db;
    font-size: 14px;
    background: #f9fafb;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus{
    border-color: #1d6fa5;
    background: white;
    box-shadow: 0 0 0 4px rgba(29,111,165,0.10);
    outline: none;
}

.form-group textarea{
    min-height: 120px;
    resize: vertical;
}

.input-error{
    border-color: #dc2626 !important;
    background: #fff7f7 !important;
    box-shadow: none !important;
}

.error-text{
    color: #dc2626;
    font-size: 12px;
    margin-top: 6px;
    display: block;
}

.alerta-error{
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
    padding: 12px 14px;
    border-radius: 12px;
    margin-bottom: 18px;
    font-size: 13px;
}

.alerta-error ul{
    margin: 0;
    padding-left: 18px;
}

.alerta-success{
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
    padding: 12px 14px;
    border-radius: 12px;
    margin-bottom: 18px;
    font-size: 13px;
}

.estado-fijo{
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
    padding: 12px 14px;
    border-radius: 12px;
    font-size: 14px;
}

.acciones{
    margin-top: 25px;
    display: flex;
    gap: 12px;
    justify-content: flex-start;
    flex-wrap: wrap;
}

.btn{
    padding: 11px 18px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-primary{
    background: #0f4c81;
    color: white;
}

.btn-primary:hover{
    background: #0c3d68;
    transform: translateY(-1px);
}

.btn-select{
    background: #2c7be5;
    color: white;
    border: none;
    padding: 11px 16px;
    border-radius: 12px;
    cursor: pointer;
    margin-top: 8px;
    transition: .2s ease;
}

.btn-select:hover{
    background: #1f68c7;
    transform: translateY(-1px);
}

.btn-volver{
    background: #6b7280;
    color: white;
}

.btn-volver:hover{
    background: #4b5563;
    transform: translateY(-1px);
}

.alerta-sistema{
    position: fixed;
    top: 80px;
    left: 50%;
    transform: translateX(-50%) translateY(-20px);
    min-width: 280px;
    max-width: 420px;
    background: #fff4e5;
    color: #8a5300;
    padding: 14px 18px;
    border-radius: 12px;
    box-shadow: 0 12px 24px rgba(0,0,0,0.18);
    font-size: 14px;
    border-left: 5px solid #f59e0b;
    opacity: 0;
    pointer-events: none;
    transition: all .3s ease;
    z-index: 9999;
}

.alerta-sistema.mostrar{
    opacity: 1;
    pointer-events: auto;
    transform: translateX(-50%) translateY(0);
}

.alerta-sistema.error{
    background: #fef2f2;
    color: #991b1b;
    border-left-color: #dc2626;
}

.alerta-sistema.ok{
    background: #ecfdf5;
    color: #065f46;
    border-left-color: #22c55e;
}

.modal-bg{
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    visibility: hidden;
    opacity: 0;
    transition: .2s;
    z-index: 999;
    pointer-events: none;
}

.modal-bg.active{
    visibility: visible;
    opacity: 1;
    pointer-events: auto;
}

.modal-box{
    margin-top: 60px;
    background: white;
    padding: 20px;
    border-radius: 16px;
    width: 560px;
    max-width: 95%;
    max-height: 460px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.buscador-equipos{
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #ddd;
}

.tabla-equipos{
    max-height: 250px;
    overflow-y: auto;
    border: 1px solid #eee;
    border-radius: 10px;
}

#tablaEquipos{
    width: 100%;
    border-collapse: collapse;
}

#tablaEquipos th{
    background: #f4f6f9;
    padding: 8px;
    font-size: 12px;
    text-align: left;
}

#tablaEquipos td{
    padding: 8px;
    border-top: 1px solid #eee;
    font-size: 13px;
}

#tablaEquipos tr:hover{
    background: #f9fbfd;
    cursor: pointer;
}

.fila-activa{
    background: #e3f2fd !important;
}

.modal-actions{
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    margin-top: 10px;
}
</style>

<div id="alertaSistema" class="alerta-sistema"></div>

<div class="form-container">
    <div class="form-header">
        <h1>Nuevo Mantenimiento</h1>
    </div>

    <div class="form-body">

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
                    class="{{ $errors->has('id_computadora') ? 'input-error' : '' }}"
                >

                <input
                    type="hidden"
                    name="id_computadora"
                    id="computadoraSeleccionada"
                    value="{{ old('id_computadora') }}"
                >

                <button type="button" class="btn-select" onclick="abrirModal()">
                    Seleccionar computadora
                </button>

                <span id="errorComputadora" class="error-text" style="display:none;"></span>

                @error('id_computadora')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Tipo</label>

                <select name="tipo" id="tipo" class="{{ $errors->has('tipo') ? 'input-error' : '' }}" required>
                    <option value="">Seleccionar tipo</option>
                    <option value="Preventivo" {{ old('tipo') == 'Preventivo' ? 'selected' : '' }}>Preventivo</option>
                    <option value="Correctivo" {{ old('tipo') == 'Correctivo' ? 'selected' : '' }}>Correctivo</option>
                </select>

                <span id="errorTipo" class="error-text" style="display:none;"></span>

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
                <div class="estado-fijo">Pendiente</div>
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

            <div class="acciones">
                <button class="btn btn-primary" type="submit">
                    Guardar
                </button>

                <button
                    type="button"
                    class="btn btn-volver"
                    onclick="window.location.href='{{ route('mantenimientos.index') }}'">
                    Volver
                </button>
            </div>
        </form>

    </div>
</div>

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
                                    data-nombre="{{ $pc->nombre_equipo ?? 'Sin nombre' }}"
                                    {{ old('id_computadora') == $pc->id ? 'checked' : '' }}
                                    onclick="event.stopPropagation()"
                                >
                            </td>

                            <td>{{ $pc->id }}</td>
                            <td>{{ $pc->nombre_equipo ?? 'Sin nombre' }}</td>
                            <td>{{ $pc->marca ?? 'No definida' }}</td>
                            <td>{{ $pc->modelo ?? 'No definido' }}</td>
                            <td>{{ $pc->estado ?? 'Sin estado' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal-actions">
            <button type="button" class="btn btn-volver" onclick="cerrarModal()">
                Volver
            </button>

            <button type="button" class="btn btn-primary" onclick="confirmarSeleccion()">
                Confirmar
            </button>
        </div>
    </div>
</div>

<script>
function mostrarAlerta(mensaje, tipo = 'error') {
    const alertaSistema = document.getElementById('alertaSistema');
    alertaSistema.textContent = mensaje;
    alertaSistema.className = 'alerta-sistema mostrar ' + tipo;

    setTimeout(() => {
        alertaSistema.className = 'alerta-sistema';
    }, 3000);
}

function abrirModal(){
    document.getElementById("modalEquipos").classList.add("active");
}

function cerrarModal(){
    document.getElementById("modalEquipos").classList.remove("active");
}

function seleccionarEquipo(fila){
    document.querySelectorAll("#tablaEquipos tbody tr").forEach(f => {
        f.classList.remove("fila-activa");
    });

    fila.classList.add("fila-activa");

    let radio = fila.querySelector("input");
    radio.checked = true;
}

function confirmarSeleccion(){
    let seleccionado = document.querySelector('input[name="equipoSeleccionado"]:checked');

    if(!seleccionado){
        mostrarAlerta("Selecciona una computadora.");
        return;
    }

    document.getElementById("computadoraSeleccionada").value = seleccionado.value;
    document.getElementById("nombreComputadora").value = seleccionado.dataset.nombre;
    document.getElementById("errorComputadora").style.display = 'none';
    document.getElementById("nombreComputadora").classList.remove('input-error');

    cerrarModal();
    mostrarAlerta("Computadora seleccionada correctamente.", "ok");
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
    const tipo = document.getElementById("tipo");
    const fecha = document.getElementById("fecha_programada");
    const observaciones = document.getElementById("observaciones");
    const form = document.getElementById("formMantenimiento");
    const errorComputadora = document.getElementById("errorComputadora");
    const errorTipo = document.getElementById("errorTipo");
    const errorFecha = document.getElementById("errorFecha");
    const errorObservaciones = document.getElementById("errorObservaciones");

    radios.forEach(radio => {
        if (radio.checked) {
            hidden.value = radio.value;
            nombre.value = radio.dataset.nombre;
            radio.closest('tr')?.classList.add('fila-activa');
        }
    });

    function limpiarErrores() {
        errorComputadora.style.display = 'none';
        errorTipo.style.display = 'none';
        errorFecha.style.display = 'none';
        errorObservaciones.style.display = 'none';

        errorComputadora.textContent = '';
        errorTipo.textContent = '';
        errorFecha.textContent = '';
        errorObservaciones.textContent = '';

        nombre.classList.remove('input-error');
        tipo.classList.remove('input-error');
        fecha.classList.remove('input-error');
        observaciones.classList.remove('input-error');
    }

    function validarComputadora() {
        if (!hidden.value) {
            nombre.classList.add('input-error');
            errorComputadora.textContent = 'Debes seleccionar una computadora.';
            errorComputadora.style.display = 'block';
            mostrarAlerta('Debes seleccionar una computadora.');
            return false;
        }
        return true;
    }

    function validarTipo() {
        if (!tipo.value) {
            tipo.classList.add('input-error');
            errorTipo.textContent = 'Debes seleccionar el tipo de mantenimiento.';
            errorTipo.style.display = 'block';
            mostrarAlerta('Debes seleccionar el tipo de mantenimiento.');
            return false;
        }
        return true;
    }

    function validarFecha() {
        if (!fecha.value) {
            fecha.classList.add('input-error');
            errorFecha.textContent = 'Debes ingresar la fecha programada.';
            errorFecha.style.display = 'block';
            mostrarAlerta('Debes ingresar la fecha programada.');
            return false;
        }

        const seleccionada = new Date(fecha.value + 'T00:00:00');
        const inicioAnio = new Date(new Date().getFullYear(), 0, 1);

        if (seleccionada < inicioAnio) {
            fecha.classList.add('input-error');
            errorFecha.textContent = 'No se permiten fechas de años pasados.';
            errorFecha.style.display = 'block';
            mostrarAlerta('No se permiten fechas de años pasados.');
            return false;
        }

        return true;
    }

    function validarObservaciones() {
        const valor = observaciones.value.trim();

        if (valor === '') {
            observaciones.classList.add('input-error');
            errorObservaciones.textContent = 'Debes escribir las observaciones.';
            errorObservaciones.style.display = 'block';
            mostrarAlerta('Debes escribir las observaciones.');
            return false;
        }

        if (/\d/.test(valor)) {
            observaciones.classList.add('input-error');
            errorObservaciones.textContent = 'Las observaciones no pueden contener números.';
            errorObservaciones.style.display = 'block';
            mostrarAlerta('Las observaciones no pueden contener números.');
            return false;
        }

        if (valor.length > 500) {
            observaciones.classList.add('input-error');
            errorObservaciones.textContent = 'Las observaciones no pueden superar los 500 caracteres.';
            errorObservaciones.style.display = 'block';
            mostrarAlerta('Las observaciones no pueden superar los 500 caracteres.');
            return false;
        }

        return true;
    }

    fecha.addEventListener('change', function () {
        errorFecha.style.display = 'none';
        fecha.classList.remove('input-error');
    });

    tipo.addEventListener('change', function () {
        errorTipo.style.display = 'none';
        tipo.classList.remove('input-error');
    });

    observaciones.addEventListener('input', function () {
        if (/\d/.test(this.value)) {
            observaciones.classList.add('input-error');
            errorObservaciones.textContent = 'Las observaciones no pueden contener números.';
            errorObservaciones.style.display = 'block';
        } else {
            observaciones.classList.remove('input-error');
            errorObservaciones.style.display = 'none';
        }
    });

    form.addEventListener('submit', function(e){
        limpiarErrores();

        const computadoraOk = validarComputadora();
        const tipoOk = validarTipo();
        const fechaOk = validarFecha();
        const observacionesOk = validarObservaciones();

        if (!computadoraOk || !tipoOk || !fechaOk || !observacionesOk) {
            e.preventDefault();
        }
    });
});
</script>

@endsection