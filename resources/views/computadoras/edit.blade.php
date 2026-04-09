@extends('layouts.app')

@section('content')

<style>
.contenedor-form{
    max-width: 1050px;
    margin: 30px auto;
    background: #ffffff;
    border-radius: 22px;
    box-shadow: 0 18px 45px rgba(15, 76, 129, 0.08);
    overflow: hidden;
    border: 1px solid #e5e7eb;
}

.encabezado-form{
    background: linear-gradient(135deg, #0f4c81, #1d6fa5);
    color: white;
    padding: 28px 32px;
}

.encabezado-form h1{
    margin: 0;
    font-size: 28px;
    font-weight: 700;
    letter-spacing: 0.5px;
}

.encabezado-form p{
    margin: 8px 0 0;
    font-size: 14px;
    opacity: 0.92;
}

.cuerpo-form{
    padding: 30px 32px 34px;
}

.errores{
    margin-bottom: 22px;
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
    border-radius: 14px;
    padding: 16px 18px;
}

.errores ul{
    margin: 0;
    padding-left: 18px;
}

.grid{
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 22px 20px;
}

.campo{
    display: flex;
    flex-direction: column;
}

.campo-completo{
    grid-column: 1 / -1;
}

label{
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 7px;
    color: #374151;
    letter-spacing: 0.2px;
}

input,
select{
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #d1d5db;
    border-radius: 12px;
    font-size: 14px;
    background: #f9fafb;
    color: #111827;
    outline: none;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

input:focus,
select:focus{
    border-color: #1d6fa5;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(29, 111, 165, 0.10);
}

input[type="file"]{
    padding: 10px;
    background: #ffffff;
}

.seccion{
    margin-top: 30px;
    padding-top: 24px;
    border-top: 1px solid #e5e7eb;
}

.seccion-titulo{
    font-size: 16px;
    font-weight: 700;
    color: #0f4c81;
    margin-bottom: 16px;
}

.imagen-box{
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.preview-imagen{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px;
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    width: fit-content;
}

.preview-imagen img{
    width: 240px;
    max-width: 100%;
    border-radius: 14px;
    display: block;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.acciones{
    margin-top: 32px;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    justify-content: flex-start;
    padding-top: 22px;
    border-top: 1px solid #e5e7eb;
}

.btn-guardar,
.btn-volver{
    padding: 12px 20px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-guardar{
    background: #0f4c81;
    color: white;
    box-shadow: 0 8px 18px rgba(15, 76, 129, 0.20);
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
    transform: translateY(-1px);
}

.btn-abrir-usuarios{
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #d1d5db;
    border-radius: 12px;
    font-size: 14px;
    background: #f9fafb;
    color: #111827;
    text-align: left;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-abrir-usuarios:hover{
    border-color: #1d6fa5;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(29, 111, 165, 0.10);
}

.usuarios-seleccionados-box{
    margin-top: 10px;
    min-height: 48px;
    border: 1px solid #d1d5db;
    border-radius: 12px;
    background: #f9fafb;
    padding: 10px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
}

.usuario-chip{
    background: #0f4c81;
    color: #ffffff;
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.texto-placeholder{
    color: #6b7280;
    font-size: 14px;
}

.modal-usuarios-overlay{
    position: fixed;
    inset: 0;
    background: rgba(17, 24, 39, 0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 20px;
}

.modal-usuarios{
    width: 100%;
    max-width: 560px;
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 20px 45px rgba(0,0,0,0.18);
    overflow: hidden;
}

.modal-usuarios-header{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 20px;
    border-bottom: 1px solid #e5e7eb;
}

.modal-usuarios-header h3{
    margin: 0;
    font-size: 18px;
    color: #111827;
}

.btn-cerrar-modal{
    border: none;
    background: transparent;
    font-size: 28px;
    line-height: 1;
    cursor: pointer;
    color: #6b7280;
}

.modal-usuarios-body{
    padding: 18px 20px;
}

.input-buscar-usuarios{
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #d1d5db;
    border-radius: 12px;
    font-size: 14px;
    margin-bottom: 14px;
    box-sizing: border-box;
}

.lista-usuarios-modal{
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 8px;
    background: #f9fafb;
}

.item-usuario-modal{
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.2s ease;
}

.item-usuario-modal:hover{
    background: #eef6ff;
}

.item-usuario-modal input[type="checkbox"]{
    width: auto;
    margin: 0;
}

.modal-usuarios-footer{
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 18px 20px;
    border-top: 1px solid #e5e7eb;
}

.btn-limpiar-usuarios,
.btn-aplicar-usuarios{
    padding: 10px 16px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
}

.btn-limpiar-usuarios{
    background: #e5e7eb;
    color: #111827;
}

.btn-aplicar-usuarios{
    background: #0f4c81;
    color: #ffffff;
}

@media (max-width: 768px){
    .contenedor-form{
        margin: 18px 12px;
        border-radius: 18px;
    }

    .encabezado-form{
        padding: 22px 20px;
    }

    .encabezado-form h1{
        font-size: 23px;
    }

    .cuerpo-form{
        padding: 22px 20px 26px;
    }

    .grid{
        grid-template-columns: 1fr;
    }

    .campo-completo{
        grid-column: auto;
    }

    .acciones{
        justify-content: stretch;
    }

    .btn-guardar,
    .btn-volver{
        width: 100%;
        text-align: center;
    }

    .preview-imagen{
        width: 100%;
    }

    .preview-imagen img{
        width: 100%;
        max-width: 300px;
    }

    .modal-usuarios{
        max-width: 100%;
    }
}
</style>

@php
    $usuariosSeleccionados = collect(
        old('id_usuarios_asignados', $computadora->usuarios->pluck('id')->toArray())
    )->map(fn($id) => (int) $id)->toArray();
@endphp

<div class="contenedor-form">

    <div class="encabezado-form">
        <h1>Editar Computadora</h1>
        <p>Actualiza la información técnica, estado, ubicación y Usuarios Asignados del equipo.</p>
    </div>

    <div class="cuerpo-form">

        @if(session('error'))
            <div class="errores">
                <ul>
                    <li>{{ session('error') }}</li>
                </ul>
            </div>
        @endif

        @if ($errors->any())
            <div class="errores">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('computadoras.update', $computadora->id) }}" method="POST" enctype="multipart/form-data" id="formComputadora">
            @csrf
            @method('PUT')

            <div class="grid">

                <div class="campo">
                    <label>Nombre del equipo</label>
                    <input type="text" name="nombre_equipo" value="{{ old('nombre_equipo', $computadora->nombre_equipo) }}" required>
                    @error('nombre_equipo')
                        <small style="color:#dc2626; margin-top:6px; font-size:12px; display:block;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="campo">
                    <label>Tipo</label>
                    <select name="tipo" required>
                        <option value="">Seleccione</option>
                        <option value="Desktop" {{ old('tipo', $computadora->tipo) == 'Desktop' ? 'selected' : '' }}>Desktop</option>
                        <option value="Laptop" {{ old('tipo', $computadora->tipo) == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                    </select>
                    @error('tipo')
                        <small style="color:#dc2626; margin-top:6px; font-size:12px; display:block;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="campo">
                    <label>Marca</label>
                    <input type="text" name="marca" value="{{ old('marca', $computadora->marca) }}" required>
                    @error('marca')
                        <small style="color:#dc2626; margin-top:6px; font-size:12px; display:block;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="campo">
                    <label>Modelo</label>
                    <input type="text" name="modelo" value="{{ old('modelo', $computadora->modelo) }}" required>
                    @error('modelo')
                        <small style="color:#dc2626; margin-top:6px; font-size:12px; display:block;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="campo">
                    <label>Número de serie</label>
                    <input type="text" name="numero_serie" value="{{ old('numero_serie', $computadora->numero_serie) }}" required>
                    @error('numero_serie')
                        <small style="color:#dc2626; margin-top:6px; font-size:12px; display:block;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="campo">
                    <label>Procesador</label>
                    <select name="procesador" required>
                        <option value="">Seleccione</option>
                        <option value="Intel i5" {{ old('procesador', $computadora->procesador) == 'Intel i5' ? 'selected' : '' }}>Intel i5</option>
                        <option value="Intel i7" {{ old('procesador', $computadora->procesador) == 'Intel i7' ? 'selected' : '' }}>Intel i7</option>
                        <option value="Ryzen 5" {{ old('procesador', $computadora->procesador) == 'Ryzen 5' ? 'selected' : '' }}>Ryzen 5</option>
                        <option value="Ryzen 7" {{ old('procesador', $computadora->procesador) == 'Ryzen 7' ? 'selected' : '' }}>Ryzen 7</option>
                    </select>
                    @error('procesador')
                        <small style="color:#dc2626; margin-top:6px; font-size:12px; display:block;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="campo">
                    <label>Memoria RAM</label>
                    <select name="ram" required>
                        <option value="">Seleccione</option>
                        <option value="8 GB" {{ old('ram', $computadora->ram) == '8 GB' ? 'selected' : '' }}>8 GB</option>
                        <option value="16 GB" {{ old('ram', $computadora->ram) == '16 GB' ? 'selected' : '' }}>16 GB</option>
                        <option value="32 GB" {{ old('ram', $computadora->ram) == '32 GB' ? 'selected' : '' }}>32 GB</option>
                    </select>
                    @error('ram')
                        <small style="color:#dc2626; margin-top:6px; font-size:12px; display:block;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="campo">
                    <label>Almacenamiento</label>
                    <select name="almacenamiento" required>
                        <option value="">Seleccione</option>
                        <option value="256 GB SSD" {{ old('almacenamiento', $computadora->almacenamiento) == '256 GB SSD' ? 'selected' : '' }}>256 GB SSD</option>
                        <option value="512 GB SSD" {{ old('almacenamiento', $computadora->almacenamiento) == '512 GB SSD' ? 'selected' : '' }}>512 GB SSD</option>
                        <option value="1 TB SSD" {{ old('almacenamiento', $computadora->almacenamiento) == '1 TB SSD' ? 'selected' : '' }}>1 TB SSD</option>
                    </select>
                    @error('almacenamiento')
                        <small style="color:#dc2626; margin-top:6px; font-size:12px; display:block;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="campo">
                    <label>Sistema operativo</label>
                    <select name="sistema_operativo" required>
                        <option value="">Seleccione</option>
                        <option value="Windows 11 Pro" {{ old('sistema_operativo', $computadora->sistema_operativo) == 'Windows 11 Pro' ? 'selected' : '' }}>Windows 11 Pro</option>
                        <option value="Windows 10 Pro" {{ old('sistema_operativo', $computadora->sistema_operativo) == 'Windows 10 Pro' ? 'selected' : '' }}>Windows 10 Pro</option>
                    </select>
                    @error('sistema_operativo')
                        <small style="color:#dc2626; margin-top:6px; font-size:12px; display:block;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="campo">
                    <label>Fecha compra</label>
                    <input
                        type="date"
                        name="fecha_compra"
                        id="fecha_compra"
                        value="{{ old('fecha_compra', $computadora->fecha_compra) }}"
                        max="{{ date('Y-m-d') }}"
                        required
                    >
                    @error('fecha_compra')
                        <small style="color:#dc2626; margin-top:6px; font-size:12px; display:block;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="campo">
                    <label>Fin de garantía</label>
                    <input
                        type="date"
                        name="fecha_fin_garantia"
                        id="fecha_fin_garantia"
                        value="{{ old('fecha_fin_garantia', $computadora->fecha_fin_garantia) }}"
                        required
                    >
                    @error('fecha_fin_garantia')
                        <small style="color:#dc2626; margin-top:6px; font-size:12px; display:block;">{{ $message }}</small>
                    @enderror
                    <small id="errorGarantia" style="color:#dc2626; margin-top:6px; font-size:12px; display:none;"></small>
                </div>

                <div class="campo">
                    <label>Vida útil (años)</label>
                    <input
                        type="number"
                        name="vida_util"
                        id="vida_util"
                        min="1"
                        value="{{ old('vida_util', $computadora->vida_util) }}"
                        required
                    >
                    @error('vida_util')
                        <small style="color:#dc2626; margin-top:6px; font-size:12px; display:block;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="campo">
                    <label>Estado</label>
                    <select name="estado" required>
                        <option value="">Seleccione</option>
                        <option value="Activo" {{ old('estado', $computadora->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                        <option value="Inactivo" {{ old('estado', $computadora->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estado')
                        <small style="color:#dc2626; margin-top:6px; font-size:12px; display:block;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="campo">
                    <label>Usuarios Asignados</label>

                    <button type="button" class="btn-abrir-usuarios" id="abrirModalUsuarios">
                        Asignar usuarios
                    </button>

                    <div id="usuariosSeleccionadosBox" class="usuarios-seleccionados-box">
                        @if(count($usuariosSeleccionados) > 0)
                            @foreach($usuarios as $u)
                                @if(in_array($u->id, $usuariosSeleccionados))
                                    <span class="usuario-chip">{{ $u->nombre }}</span>
                                @endif
                            @endforeach
                        @else
                            <span class="texto-placeholder">No hay usuarios seleccionados</span>
                        @endif
                    </div>

                    <div id="modalUsuarios" class="modal-usuarios-overlay" style="display:none;">
                        <div class="modal-usuarios">
                            <div class="modal-usuarios-header">
                                <h3>Seleccionar usuarios</h3>
                                <button type="button" class="btn-cerrar-modal" id="cerrarModalUsuarios">&times;</button>
                            </div>

                            <div class="modal-usuarios-body">
                                <input
                                    type="text"
                                    id="buscarUsuarioModal"
                                    class="input-buscar-usuarios"
                                    placeholder="Buscar usuario..."
                                >

                                <div class="lista-usuarios-modal" id="listaUsuariosModal">
                                    @foreach($usuarios as $u)
                                        <label class="item-usuario-modal" data-nombre="{{ strtolower($u->nombre) }}">
                                            <input
                                                type="checkbox"
                                                name="id_usuarios_asignados[]"
                                                value="{{ $u->id }}"
                                                {{ in_array($u->id, $usuariosSeleccionados) ? 'checked' : '' }}
                                            >
                                            <span>{{ $u->nombre }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="modal-usuarios-footer">
                                <button type="button" class="btn-limpiar-usuarios" id="limpiarUsuariosModal">
                                    Limpiar
                                </button>
                                <button type="button" class="btn-aplicar-usuarios" id="aplicarUsuariosModal">
                                    Aplicar
                                </button>
                            </div>
                        </div>
                    </div>

                    @error('id_usuarios_asignados')
                        <small style="color:#dc2626; margin-top:6px; font-size:12px; display:block;">{{ $message }}</small>
                    @enderror
                    @error('id_usuarios_asignados.*')
                        <small style="color:#dc2626; margin-top:6px; font-size:12px; display:block;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="campo campo-completo">
                    <label>Ubicación</label>
                    <select name="id_ubicacion">
                        <option value="">Seleccione</option>
                        @foreach($ubicaciones as $ub)
                            <option value="{{ $ub->id }}" {{ old('id_ubicacion', $computadora->id_ubicacion) == $ub->id ? 'selected' : '' }}>
                                {{ $ub->area_empresa }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_ubicacion')
                        <small style="color:#dc2626; margin-top:6px; font-size:12px; display:block;">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            <div class="seccion">
                <div class="seccion-titulo">Imagen del equipo</div>

                @if($computadora->imagen)
                    <div class="imagen-box">
                        <label>Imagen actual</label>
                        <div class="preview-imagen">
                            <img src="{{ asset($computadora->imagen) }}" alt="Imagen actual del equipo">
                        </div>
                    </div>
                @endif

                <div class="imagen-box" style="margin-top: 18px;">
                    <label>Cambiar imagen</label>
                    <input type="file" name="imagen">
                    @error('imagen')
                        <small style="color:#dc2626; margin-top:6px; font-size:12px; display:block;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="acciones">
                <button type="submit" class="btn-guardar">Actualizar</button>
                <a href="{{ route('computadoras.index') }}" class="btn-volver">Volver</a>
            </div>

        </form>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fechaCompra = document.getElementById('fecha_compra');
    const fechaGarantia = document.getElementById('fecha_fin_garantia');
    const form = document.getElementById('formComputadora');
    const errorGarantia = document.getElementById('errorGarantia');

    const abrirModalUsuarios = document.getElementById('abrirModalUsuarios');
    const cerrarModalUsuarios = document.getElementById('cerrarModalUsuarios');
    const modalUsuarios = document.getElementById('modalUsuarios');
    const aplicarUsuariosModal = document.getElementById('aplicarUsuariosModal');
    const limpiarUsuariosModal = document.getElementById('limpiarUsuariosModal');
    const buscarUsuarioModal = document.getElementById('buscarUsuarioModal');
    const listaUsuariosModal = document.getElementById('listaUsuariosModal');
    const usuariosSeleccionadosBox = document.getElementById('usuariosSeleccionadosBox');

    function limpiarErrorGarantia() {
        errorGarantia.style.display = 'none';
        errorGarantia.textContent = '';
        fechaGarantia.style.borderColor = '#d1d5db';
        fechaCompra.style.borderColor = '#d1d5db';
    }

    function mostrarErrorGarantia(mensaje) {
        errorGarantia.style.display = 'block';
        errorGarantia.textContent = mensaje;
        fechaGarantia.style.borderColor = '#dc2626';
        fechaCompra.style.borderColor = '#d1d5db';
    }

    function mostrarErrorCompra(mensaje) {
        errorGarantia.style.display = 'block';
        errorGarantia.textContent = mensaje;
        fechaCompra.style.borderColor = '#dc2626';
        fechaGarantia.style.borderColor = '#d1d5db';
    }

    function validarFormulario() {
        limpiarErrorGarantia();

        if (!fechaCompra.value || !fechaGarantia.value) {
            return true;
        }

        const compra = new Date(fechaCompra.value + 'T00:00:00');
        const garantia = new Date(fechaGarantia.value + 'T00:00:00');

        const hoy = new Date();
        hoy.setHours(0, 0, 0, 0);

        if (compra > hoy) {
            mostrarErrorCompra('La fecha de compra no puede ser mayor a la fecha actual.');
            fechaCompra.focus();
            return false;
        }

        if (garantia < compra) {
            mostrarErrorGarantia('La fecha de garantía no puede ser menor que la fecha de compra.');
            fechaGarantia.focus();
            return false;
        }

        const minimo = new Date(compra);
        minimo.setMonth(minimo.getMonth() + 1);

        if (garantia < minimo) {
            mostrarErrorGarantia('La fecha de garantía debe ser de al menos 1 mes después de la fecha de compra.');
            fechaGarantia.focus();
            return false;
        }

        return true;
    }

    function actualizarVistaUsuariosSeleccionados() {
        const checks = document.querySelectorAll('input[name="id_usuarios_asignados[]"]:checked');

        if (checks.length === 0) {
            usuariosSeleccionadosBox.innerHTML = '<span class="texto-placeholder">No hay usuarios seleccionados</span>';
            return;
        }

        let html = '';

        checks.forEach(check => {
            const nombre = check.closest('.item-usuario-modal').querySelector('span').textContent.trim();
            html += `<span class="usuario-chip">${nombre}</span>`;
        });

        usuariosSeleccionadosBox.innerHTML = html;
    }

    abrirModalUsuarios.addEventListener('click', function () {
        modalUsuarios.style.display = 'flex';
    });

    cerrarModalUsuarios.addEventListener('click', function () {
        modalUsuarios.style.display = 'none';
    });

    aplicarUsuariosModal.addEventListener('click', function () {
        actualizarVistaUsuariosSeleccionados();
        modalUsuarios.style.display = 'none';
    });

    limpiarUsuariosModal.addEventListener('click', function () {
        document.querySelectorAll('input[name="id_usuarios_asignados[]"]').forEach(check => {
            check.checked = false;
        });

        actualizarVistaUsuariosSeleccionados();
    });

    modalUsuarios.addEventListener('click', function (e) {
        if (e.target === modalUsuarios) {
            modalUsuarios.style.display = 'none';
        }
    });

    buscarUsuarioModal.addEventListener('input', function () {
        const texto = this.value.toLowerCase().trim();
        const items = listaUsuariosModal.querySelectorAll('.item-usuario-modal');

        items.forEach(item => {
            const nombre = item.getAttribute('data-nombre');
            item.style.display = nombre.includes(texto) ? 'flex' : 'none';
        });
    });

    fechaCompra.addEventListener('change', validarFormulario);
    fechaGarantia.addEventListener('change', validarFormulario);

    form.addEventListener('submit', function (e) {
        if (!validarFormulario()) {
            e.preventDefault();
            return;
        }

        actualizarVistaUsuariosSeleccionados();
    });

    actualizarVistaUsuariosSeleccionados();
});
</script>

@endsection