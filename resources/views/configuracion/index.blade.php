@extends('layouts.app')

@section('content')

<style>
.config-container{
    max-width: 980px;
    margin: 30px auto;
    padding: 0 12px 30px;
}

.config-header{
    margin-bottom: 22px;
}

.config-header h1{
    font-size: 28px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 6px;
}

.config-header p{
    color: #6b7280;
    font-size: 14px;
}

.alert-success{
    background:#d1fae5;
    color:#065f46;
    padding:12px 14px;
    border-radius:12px;
    margin-bottom:15px;
    border:1px solid #a7f3d0;
}

.alert-error{
    background:#fee2e2;
    color:#991b1b;
    padding:12px 14px;
    border-radius:12px;
    margin-bottom:15px;
    border:1px solid #fecaca;
}

.config-stack{
    display:flex;
    flex-direction:column;
    gap:14px;
}

.acordeon{
    background:#ffffff;
    border:1px solid #e5e7eb;
    border-radius:18px;
    box-shadow:0 10px 30px rgba(0,0,0,0.06);
    overflow:hidden;
}

.acordeon-header{
    width:100%;
    background:#ffffff;
    border:none;
    padding:18px 22px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    cursor:pointer;
    text-align:left;
    transition:background .2s ease;
}

.acordeon-header:hover{
    background:#f8fafc;
}

.acordeon-titulos h2{
    margin:0 0 4px 0;
    font-size:18px;
    font-weight:700;
    color:#0f4c81;
}

.acordeon-titulos p{
    margin:0;
    font-size:13px;
    color:#6b7280;
}

.acordeon-icono{
    font-size:22px;
    font-weight:700;
    color:#6b7280;
    transition:transform .25s ease;
    line-height:1;
}

.acordeon.activo .acordeon-icono{
    transform:rotate(45deg);
}

.acordeon-body{
    max-height:0;
    overflow:hidden;
    transition:max-height .35s ease;
    background:#ffffff;
}

.acordeon-body-contenido{
    padding:0 22px 22px 22px;
    border-top:1px solid #e5e7eb;
}

.preview-wrap{
    display:flex;
    align-items:center;
    gap:16px;
    margin:18px 0 18px 0;
    flex-wrap:wrap;
}

.preview-foto{
    width:90px;
    height:90px;
    border-radius:50%;
    object-fit:cover;
    display:block;
    border:3px solid #e5e7eb;
    background:#f9fafb;
}

.preview-texto{
    color:#6b7280;
    font-size:13px;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
}

.form-grid-3{
    display:grid;
    grid-template-columns:1fr 1fr 1fr;
    gap:16px;
}

.campo{
    margin-top:16px;
}

.campo label{
    display:block;
    margin-bottom:6px;
    font-size:13px;
    font-weight:600;
    color:#374151;
}

.campo input,
.campo select{
    width:100%;
    padding:12px 14px;
    border:1px solid #d1d5db;
    border-radius:12px;
    font-size:14px;
    background:#f9fafb;
    transition:all .2s ease;
    box-sizing:border-box;
}

.campo input:focus,
.campo select:focus{
    outline:none;
    border-color:#1d6fa5;
    box-shadow:0 0 0 4px rgba(29,111,165,0.10);
    background:white;
}

.acciones{
    margin-top:18px;
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.btn{
    border:none;
    padding:11px 18px;
    border-radius:12px;
    font-weight:600;
    font-size:14px;
    cursor:pointer;
    transition:all .2s ease;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
}

.btn-primary{
    background:#0f4c81;
    color:white;
}

.btn-primary:hover{
    background:#0c3d68;
    transform:translateY(-1px);
}

.btn-secondary{
    background:#2c7be5;
    color:white;
}

.btn-secondary:hover{
    background:#1f68c7;
    transform:translateY(-1px);
}

.btn-danger{
    background:#dc2626;
    color:white;
}

.btn-danger:hover{
    background:#b91c1c;
    transform:translateY(-1px);
}

.texto-ayuda{
    margin-top:8px;
    color:#6b7280;
    font-size:12px;
}

@media(max-width: 900px){
    .form-grid,
    .form-grid-3{
        grid-template-columns:1fr;
    }
}

@media(max-width: 600px){
    .config-container{
        margin:20px auto;
        padding:0 10px 24px;
    }

    .config-header h1{
        font-size:24px;
    }

    .acordeon-header{
        padding:16px 16px;
    }

    .acordeon-body-contenido{
        padding:0 16px 18px 16px;
    }

    .btn{
        width:100%;
    }
}
</style>

<div class="config-container">

    <div class="config-header">
        <h1>Configuración</h1>
        <p>Administra tu perfil, seguridad y usuarios del sistema.</p>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <ul style="margin:0; padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="config-stack">

        {{-- PERFIL --}}
        <div class="acordeon activo">
            <button type="button" class="acordeon-header">
                <div class="acordeon-titulos">
                    <h2>Perfil del usuario actual</h2>
                    <p>Actualiza tu nombre de usuario y tu foto de perfil.</p>
                </div>
                <span class="acordeon-icono">+</span>
            </button>

            <div class="acordeon-body">
                <div class="acordeon-body-contenido">
                    <form method="POST" action="{{ route('configuracion.perfil') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="preview-wrap">
                            @if($admin->foto)
                                <img src="{{ asset($admin->foto) }}" class="preview-foto" alt="Foto perfil">
                            @else
                                <img src="{{ asset('images/user.jpeg') }}" class="preview-foto" alt="Foto perfil">
                            @endif

                            <div class="preview-texto">
                                Usuario actual: <strong>{{ $admin->usuario }}</strong>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="campo">
                                <label>Usuario</label>
                                <input type="text" name="usuario" value="{{ old('usuario', $admin->usuario) }}" required>
                            </div>

                            <div class="campo">
                                <label>Foto de perfil</label>
                                <input type="file" name="foto">
                            </div>
                        </div>

                        <div class="acciones">
                            <button type="submit" class="btn btn-primary">Guardar perfil</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- CONTRASEÑA --}}
        <div class="acordeon">
            <button type="button" class="acordeon-header">
                <div class="acordeon-titulos">
                    <h2>Cambiar contraseña</h2>
                    <p>Actualiza la contraseña del usuario que ha iniciado sesión.</p>
                </div>
                <span class="acordeon-icono">+</span>
            </button>

            <div class="acordeon-body">
                <div class="acordeon-body-contenido">
                    <form method="POST" action="{{ route('configuracion.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-grid-3">
                            <div class="campo">
                                <label>Contraseña actual</label>
                                <input type="password" name="password_actual" required>
                            </div>

                            <div class="campo">
                                <label>Nueva contraseña</label>
                                <input type="password" name="password_nueva" required>
                            </div>

                            <div class="campo">
                                <label>Confirmar nueva contraseña</label>
                                <input type="password" name="password_nueva_confirmation" required>
                            </div>
                        </div>

                        <div class="acciones">
                            <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- CREAR USUARIO --}}
        <div class="acordeon">
            <button type="button" class="acordeon-header">
                <div class="acordeon-titulos">
                    <h2>Crear otro usuario del sistema</h2>
                    <p>Registra un nuevo usuario administrador para ingresar al sistema.</p>
                </div>
                <span class="acordeon-icono">+</span>
            </button>

            <div class="acordeon-body">
                <div class="acordeon-body-contenido">
                    <form method="POST" action="{{ route('configuracion.usuarios.store') }}">
                        @csrf

                        <div class="form-grid-3">
                            <div class="campo">
                                <label>Usuario</label>
                                <input type="text" name="nuevo_usuario" value="{{ old('nuevo_usuario') }}" required>
                            </div>

                            <div class="campo">
                                <label>Contraseña</label>
                                <input type="password" name="nuevo_password" required>
                            </div>

                            <div class="campo">
                                <label>Confirmar contraseña</label>
                                <input type="password" name="nuevo_password_confirmation" required>
                            </div>
                        </div>

                        <div class="acciones">
                            <button type="submit" class="btn btn-secondary">Crear usuario</button>
                        </div>

                        <div class="texto-ayuda">
                            Este usuario podrá iniciar sesión en el sistema con sus propias credenciales.
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- CERRAR SESIÓN --}}
        <div class="acordeon">
            <button type="button" class="acordeon-header">
                <div class="acordeon-titulos">
                    <h2>Cerrar sesión</h2>
                    <p>Finaliza la sesión actual de forma segura.</p>
                </div>
                <span class="acordeon-icono">+</span>
            </button>

            <div class="acordeon-body">
                <div class="acordeon-body-contenido">
                    <div class="texto-ayuda" style="margin-top:16px;">
                        Al cerrar sesión tendrás que volver a iniciar sesión para entrar al sistema.
                    </div>

                    <div class="acciones">
                        <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const acordeones = document.querySelectorAll('.acordeon');

    acordeones.forEach((acordeon) => {
        const header = acordeon.querySelector('.acordeon-header');
        const body = acordeon.querySelector('.acordeon-body');

        if (acordeon.classList.contains('activo')) {
            body.style.maxHeight = body.scrollHeight + 'px';
        }

        header.addEventListener('click', function () {
            const estaActivo = acordeon.classList.contains('activo');

            acordeones.forEach(item => {
                item.classList.remove('activo');
                item.querySelector('.acordeon-body').style.maxHeight = null;
            });

            if (!estaActivo) {
                acordeon.classList.add('activo');
                body.style.maxHeight = body.scrollHeight + 'px';
            }
        });
    });
});
</script>

@endsection