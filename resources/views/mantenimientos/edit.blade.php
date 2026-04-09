@extends('layouts.app')

@section('content')

<style>
.contenedor-form{
    max-width: 800px;
    margin: 30px auto;
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 18px 45px rgba(15, 76, 129, 0.08);
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.encabezado{
    background: linear-gradient(135deg, #0f4c81, #1d6fa5);
    color: white;
    padding: 24px 28px;
}

.encabezado h1{
    margin: 0;
    font-size: 24px;
    font-weight: 700;
}

.cuerpo{
    padding: 26px 28px 30px;
}

.item{
    margin-bottom: 18px;
}

label{
    font-weight: 700;
    font-size: 13px;
    margin-bottom: 6px;
    display: block;
    color: #374151;
}

input, select, textarea{
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #d1d5db;
    border-radius: 12px;
    font-size: 14px;
    background: #f9fafb;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

input:focus,
select:focus,
textarea:focus{
    border-color: #1d6fa5;
    background: white;
    box-shadow: 0 0 0 4px rgba(29,111,165,0.1);
    outline: none;
}

textarea{
    resize: none;
}

.mensaje{
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
    padding: 12px 14px;
    border-radius: 12px;
    margin-bottom: 18px;
    font-size: 13px;
}

.mensaje-ok{
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    color: #065f46;
    padding: 12px 14px;
    border-radius: 12px;
    margin-bottom: 18px;
    font-size: 13px;
}

.error-texto{
    margin-top: 6px;
    color: #b91c1c;
    font-size: 12px;
    display: none;
}

.input-error{
    border-color: #dc2626 !important;
    background: #fff7f7 !important;
    box-shadow: none !important;
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

.btn-guardar{
    background: #0f4c81;
    color: white;
}

.btn-guardar:hover{
    background: #0c3d68;
    transform: translateY(-1px);
}

.btn-volver{
    background: #6b7280;
    color: white;
}

.btn-volver:hover{
    background: #4b5563;
}

.btn:disabled{
    background: #9ca3af;
    cursor: not-allowed;
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
</style>

<div id="alertaSistema" class="alerta-sistema"></div>

<div class="contenedor-form">

    <div class="encabezado">
        <h1>Cerrar ticket</h1>
    </div>

    <div class="cuerpo">

        @php
            $rutaVolver = $origen === 'calendario'
                ? route('calendario.index')
                : route('mantenimientos.show', [
                    'mantenimiento' => $mantenimiento->id,
                    'origen' => 'mantenimientos'
                ]);
        @endphp

        @if(session('error'))
            <div class="mensaje">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="mensaje-ok">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mensaje">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($mantenimiento->estado == 'Completado')
            <div class="mensaje">
                Este ticket ya está completado y no se puede modificar.
            </div>
        @endif

        <form method="POST" action="{{ route('mantenimientos.update', $mantenimiento->id) }}" id="formCerrarTicket">
            @csrf
            @method('PUT')

            <input type="hidden" name="origen" value="{{ $origen }}">

            <div class="item">
                <label>Estado</label>
                <select name="estado" id="estado" {{ $mantenimiento->estado == 'Completado' ? 'disabled' : '' }}>
                    <option value="Pendiente" {{ old('estado', $mantenimiento->estado) == 'Pendiente' ? 'selected' : '' }}>
                        Pendiente
                    </option>
                    <option value="Completado" {{ old('estado', $mantenimiento->estado) == 'Completado' ? 'selected' : '' }}>
                        Completado
                    </option>
                </select>
                <div class="error-texto" id="errorEstado">Para cerrar el ticket debes marcarlo como Completado.</div>
            </div>

            <div class="item">
                <label>Observaciones</label>
                <textarea
                    name="descripcion"
                    id="descripcion"
                    rows="4"
                    {{ $mantenimiento->estado == 'Completado' ? 'disabled' : '' }}
                >{{ old('descripcion', $mantenimiento->descripcion) }}</textarea>
                <div class="error-texto" id="errorDescripcion"></div>
            </div>

            <div class="acciones">

                @if($mantenimiento->estado != 'Completado')
                    <button type="submit" class="btn btn-guardar">
                        Guardar
                    </button>
                @endif

                <button
                    type="button"
                    class="btn btn-volver"
                    onclick="window.location.href='{{ $rutaVolver }}'">
                    Volver
                </button>

            </div>

        </form>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formCerrarTicket');
    const estado = document.getElementById('estado');
    const descripcion = document.getElementById('descripcion');
    const errorEstado = document.getElementById('errorEstado');
    const errorDescripcion = document.getElementById('errorDescripcion');
    const alertaSistema = document.getElementById('alertaSistema');

    function mostrarAlerta(mensaje, tipo = 'error') {
        alertaSistema.textContent = mensaje;
        alertaSistema.className = 'alerta-sistema mostrar ' + tipo;

        setTimeout(() => {
            alertaSistema.className = 'alerta-sistema';
        }, 3000);
    }

    function limpiarErrores() {
        errorEstado.style.display = 'none';
        errorDescripcion.style.display = 'none';
        errorDescripcion.textContent = '';
        estado.classList.remove('input-error');
        descripcion.classList.remove('input-error');
    }

    function validarDescripcion() {
        const valor = descripcion.value.trim();

        if (valor === '') {
            descripcion.classList.add('input-error');
            errorDescripcion.textContent = 'Debes escribir una observación.';
            errorDescripcion.style.display = 'block';
            mostrarAlerta('Debes escribir una observación.');
            return false;
        }

        if (/\d/.test(valor)) {
            descripcion.classList.add('input-error');
            errorDescripcion.textContent = 'La observación no puede contener números.';
            errorDescripcion.style.display = 'block';
            mostrarAlerta('La observación no puede contener números.');
            return false;
        }

        if (valor.length > 500) {
            descripcion.classList.add('input-error');
            errorDescripcion.textContent = 'La observación no puede superar los 500 caracteres.';
            errorDescripcion.style.display = 'block';
            mostrarAlerta('La observación no puede superar los 500 caracteres.');
            return false;
        }

        return true;
    }

    function validarEstado() {
        const valor = estado.value;

        if (valor === 'Pendiente') {
            estado.classList.add('input-error');
            errorEstado.style.display = 'block';
            mostrarAlerta('No puedes cerrar el ticket si sigue en Pendiente. Debes marcarlo como Completado.');
            return false;
        }

        if (valor !== 'Completado') {
            estado.classList.add('input-error');
            errorEstado.style.display = 'block';
            mostrarAlerta('Solo puedes cerrar el ticket como Completado.');
            return false;
        }

        return true;
    }

    if (descripcion) {
        descripcion.addEventListener('input', function () {
            if (/\d/.test(this.value)) {
                this.classList.add('input-error');
                errorDescripcion.textContent = 'La observación no puede contener números.';
                errorDescripcion.style.display = 'block';
            } else {
                this.classList.remove('input-error');
                errorDescripcion.style.display = 'none';
            }
        });
    }

    if (estado) {
        estado.addEventListener('change', function () {
            if (this.value === 'Pendiente') {
                this.classList.add('input-error');
                errorEstado.style.display = 'block';
            } else {
                this.classList.remove('input-error');
                errorEstado.style.display = 'none';
            }
        });
    }

    if (form) {
        form.addEventListener('submit', function (e) {
            limpiarErrores();

            const estadoValido = validarEstado();
            const descripcionValida = validarDescripcion();

            if (!estadoValido || !descripcionValida) {
                e.preventDefault();
            }
        });
    }
});
</script>

@endsection