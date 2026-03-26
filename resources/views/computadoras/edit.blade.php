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
    opacity: 0.9;
}

.cuerpo-form{
    padding: 30px 32px 34px;
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
}
</style>

<div class="contenedor-form">

    <div class="encabezado-form">
        <h1>Propiedades del Equipo</h1>
        <p>Edita la información general, asignación y datos técnicos del equipo.</p>
    </div>

    <div class="cuerpo-form">
        <form action="/computadoras/{{ $computadora->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid">

                <div class="campo">
                    <label>Nombre del equipo</label>
                    <input type="text" name="nombre_equipo" value="{{ old('nombre_equipo', $computadora->nombre_equipo) }}">
                </div>

                <div class="campo">
                    <label>Tipo</label>
                    <select name="tipo">
                        <option value="Desktop" {{ old('tipo', $computadora->tipo) == 'Desktop' ? 'selected' : '' }}>Desktop</option>
                        <option value="Laptop" {{ old('tipo', $computadora->tipo) == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                    </select>
                </div>

                <div class="campo">
                    <label>Marca</label>
                    <input type="text" name="marca" value="{{ old('marca', $computadora->marca) }}">
                </div>

                <div class="campo">
                    <label>Modelo</label>
                    <input type="text" name="modelo" value="{{ old('modelo', $computadora->modelo) }}">
                </div>

                <div class="campo">
                    <label>Número de serie</label>
                    <input type="text" name="numero_serie" value="{{ old('numero_serie', $computadora->numero_serie) }}">
                </div>

                <div class="campo">
                    <label>Procesador</label>
                    <select name="procesador">
                        <option value="Intel i5" {{ old('procesador', $computadora->procesador) == 'Intel i5' ? 'selected' : '' }}>Intel i5</option>
                        <option value="Intel i7" {{ old('procesador', $computadora->procesador) == 'Intel i7' ? 'selected' : '' }}>Intel i7</option>
                        <option value="Ryzen 5" {{ old('procesador', $computadora->procesador) == 'Ryzen 5' ? 'selected' : '' }}>Ryzen 5</option>
                        <option value="Ryzen 7" {{ old('procesador', $computadora->procesador) == 'Ryzen 7' ? 'selected' : '' }}>Ryzen 7</option>
                    </select>
                </div>

                <div class="campo">
                    <label>Memoria RAM</label>
                    <select name="ram">
                        <option value="8 GB" {{ old('ram', $computadora->ram) == '8 GB' ? 'selected' : '' }}>8 GB</option>
                        <option value="16 GB" {{ old('ram', $computadora->ram) == '16 GB' ? 'selected' : '' }}>16 GB</option>
                        <option value="32 GB" {{ old('ram', $computadora->ram) == '32 GB' ? 'selected' : '' }}>32 GB</option>
                    </select>
                </div>

                <div class="campo">
                    <label>Almacenamiento</label>
                    <select name="almacenamiento">
                        <option value="256 GB SSD" {{ old('almacenamiento', $computadora->almacenamiento) == '256 GB SSD' ? 'selected' : '' }}>256 GB SSD</option>
                        <option value="512 GB SSD" {{ old('almacenamiento', $computadora->almacenamiento) == '512 GB SSD' ? 'selected' : '' }}>512 GB SSD</option>
                        <option value="1 TB SSD" {{ old('almacenamiento', $computadora->almacenamiento) == '1 TB SSD' ? 'selected' : '' }}>1 TB SSD</option>
                    </select>
                </div>

                <div class="campo">
                    <label>Sistema operativo</label>
                    <select name="sistema_operativo">
                        <option value="Windows 11 Pro" {{ old('sistema_operativo', $computadora->sistema_operativo) == 'Windows 11 Pro' ? 'selected' : '' }}>Windows 11 Pro</option>
                        <option value="Windows 10 Pro" {{ old('sistema_operativo', $computadora->sistema_operativo) == 'Windows 10 Pro' ? 'selected' : '' }}>Windows 10 Pro</option>
                    </select>
                </div>

                <div class="campo">
                    <label>Fecha compra</label>
                    <input type="date" name="fecha_compra" value="{{ old('fecha_compra', $computadora->fecha_compra) }}">
                </div>

                <div class="campo">
                    <label>Vida útil</label>
                    <input type="number" name="vida_util" value="{{ old('vida_util', $computadora->vida_util) }}">
                </div>

                <div class="campo">
                    <label>Estado</label>
                    <select name="estado">
                        <option value="Activo" {{ old('estado', $computadora->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                        <option value="En mantenimiento" {{ old('estado', $computadora->estado) == 'En mantenimiento' ? 'selected' : '' }}>En mantenimiento</option>
                        <option value="Dañado" {{ old('estado', $computadora->estado) == 'Dañado' ? 'selected' : '' }}>Dañado</option>
                        <option value="Inactivo" {{ old('estado', $computadora->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <div class="campo">
                    <label>Usuario asignado</label>
                    <select name="id_usuario_asignado">
                        <option value="">Seleccione</option>
                        @foreach($usuarios as $u)
                            <option value="{{ $u->id }}" {{ old('id_usuario_asignado', $computadora->id_usuario_asignado) == $u->id ? 'selected' : '' }}>
                                {{ $u->nombre }}
                            </option>
                        @endforeach
                    </select>
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
                    <input type="file" name="imagen" accept=".jpg,.jpeg,.png">
                </div>
            </div>

            <div class="acciones">
                <button type="submit" class="btn-guardar">Actualizar</button>
                <a href="/computadoras" class="btn-volver">Volver</a>
            </div>

        </form>
    </div>

</div>

@endsection