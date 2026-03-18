@extends('layouts.app')

@section('content')

<style>
.contenedor-form{
    max-width: 850px;
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
    font-size: 25px;
    font-weight: 700;
    letter-spacing: 0.3px;
}

.encabezado p{
    margin: 8px 0 0;
    font-size: 14px;
    opacity: 0.92;
}

.cuerpo{
    padding: 28px 30px 32px;
}

.grid{
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.campo{
    display: flex;
    flex-direction: column;
}

.campo-completo{
    grid-column: 1 / -1;
}

.campo label{
    font-size: 13px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 7px;
    letter-spacing: 0.2px;
}

.campo input,
.campo select{
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #d1d5db;
    border-radius: 12px;
    background: #f9fafb;
    font-size: 14px;
    color: #111827;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.campo input:focus,
.campo select:focus{
    border-color: #1d6fa5;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(29, 111, 165, 0.10);
    outline: none;
}

.acciones{
    margin-top: 30px;
    padding-top: 22px;
    border-top: 1px solid #e5e7eb;
    display: flex;
    gap: 12px;
    justify-content: flex-start;
    flex-wrap: wrap;
}

.btn-guardar,
.btn-volver{
    padding: 12px 20px;
    border-radius: 12px;
    border: none;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
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

    .encabezado{
        padding: 22px 20px;
    }

    .encabezado h1{
        font-size: 22px;
    }

    .cuerpo{
        padding: 22px 20px 26px;
    }

    .grid{
        grid-template-columns: 1fr;
    }

    .campo-completo{
        grid-column: auto;
    }

    .btn-guardar,
    .btn-volver{
        width: 100%;
        text-align: center;
    }
}
</style>

<div class="contenedor-form">

    <div class="encabezado">
        <h1>Editar usuario</h1>
        <p>Actualiza la información general, ubicación y estado del usuario.</p>
    </div>

    <div class="cuerpo">
        <form method="POST" action="/usuarios/{{ $usuario->id }}">
            @csrf
            @method('PUT')

            <div class="grid">

                <div class="campo">
                    <label>Nombre</label>
                    <input
                        type="text"
                        name="nombre"
                        value="{{ old('nombre', $usuario->nombre) }}"
                        required>
                </div>

                <div class="campo">
                    <label>Correo</label>
                    <input
                        type="email"
                        name="correo"
                        value="{{ old('correo', $usuario->correo) }}"
                        required>
                </div>

                <div class="campo">
                    <label>Rol</label>
                    <input
                        type="text"
                        name="rol"
                        value="{{ old('rol', $usuario->rol) }}"
                        required>
                </div>

                <div class="campo">
                    <label>Área / Ubicación</label>
                    <select name="id_ubicacion" required>
                        <option value="">Seleccionar área</option>
                        @foreach($ubicaciones as $u)
                            <option
                                value="{{ $u->id }}"
                                {{ old('id_ubicacion', $usuario->id_ubicacion) == $u->id ? 'selected' : '' }}>
                                {{ $u->area_empresa }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="campo campo-completo">
                    <label>Estado</label>
                    <select name="estado" required>
                        <option value="Activo" {{ old('estado', $usuario->estado) == 'Activo' ? 'selected' : '' }}>
                            Activo
                        </option>
                        <option value="Inactivo" {{ old('estado', $usuario->estado) == 'Inactivo' ? 'selected' : '' }}>
                            Inactivo
                        </option>
                    </select>
                </div>

            </div>

            <div class="acciones">
                <button type="submit" class="btn-guardar">Guardar cambios</button>

                <button
                    type="button"
                    class="btn-volver"
                    onclick="window.location.href='/usuarios/{{ $usuario->id }}'">
                    Cancelar
                </button>
            </div>

        </form>
    </div>

</div>

@endsection