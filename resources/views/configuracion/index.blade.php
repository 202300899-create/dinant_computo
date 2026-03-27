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
    gap:18px;
    margin:18px 0 18px 0;
    flex-wrap:wrap;
    padding:14px;
    border:1px solid #e5e7eb;
    border-radius:16px;
    background:#f8fafc;
}

.preview-foto{
    width:92px;
    height:92px;
    border-radius:50%;
    object-fit:cover;
    display:block;
    border:3px solid #dbeafe;
    background:#f9fafb;
    box-shadow:0 6px 16px rgba(0,0,0,0.08);
}

.preview-info{
    display:flex;
    flex-direction:column;
    gap:6px;
}

.preview-usuario{
    color:#111827;
    font-size:15px;
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

.campo input[type="file"]{
    padding:10px 12px;
    background:white;
    border:1px dashed #cbd5e1;
}

.campo input[type="file"]:hover{
    border-color:#1d6fa5;
    background:#f8fbff;
}

.campo input:focus,
.campo select:focus{
    outline:none;
    border-color:#1d6fa5;
    box-shadow:0 0 0 4px rgba(29,111,165,0.10);
    background:white;
}

.input-error{
    border-color:#dc2626 !important;
    background:#fff7f7 !important;
    box-shadow:none !important;
}

.error-text{
    margin-top:6px;
    color:#b91c1c;
    font-size:12px;
    font-weight:500;
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
    line-height:1.5;
}

.texto-ayuda-foto{
    margin-top:8px;
    padding:10px 12px;
    background:#f8fafc;
    border:1px solid #e5e7eb;
    border-radius:10px;
    color:#6b7280;
    font-size:12px;
    line-height:1.5;
}

.form-separador{
    height:1px;
    background:#eef2f7;
    margin:20px 0 6px 0;
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

    .preview-wrap{
        align-items:flex-start;
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
                                <img src="{{ asset($admin->foto) }}" class="preview-foto" alt="Foto perfil" id="previewImagen">
                            @else
                                <img src="{{ asset('images/user.jpeg') }}" class="preview-foto" alt="Foto perfil" id="previewImagen">
                            @endif

                            <div class="preview-info">
                                <div class="preview-usuario">Usuario actual: <strong>{{ $admin->usuario }}</strong></div>
                                <div class="preview-texto">Puedes cambiar tu nombre de usuario y actualizar la imagen del perfil.</div>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="campo">
                                <label for="usuario">Usuario</label>
                                <input
                                    type="text"
                                    id="usuario"
                                    name="usuario"
                                    value="{{ old('usuario', $admin->usuario) }}"
                                    class="{{ $errors->has('usuario') ? 'input-error' : '' }}"
                                    required
                                >
                                @error('usuario')
                                    <div class="error-text">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="campo">
                                <label for="foto">Foto de perfil</label>
                                <input
                                    type="file"
                                    id="foto"
                                    name="foto"
                                    accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                                    class="{{ $errors->has('foto') ? 'input-error' : '' }}"
                                >
                                <div class="texto-ayuda-foto">
                                    Solo se permiten archivos JPG, JPEG y PNG. Tamaño máximo: 2 MB.
                                </div>
                                @error('foto')
                                    <div class="error-text">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="acciones">
                            <button type="submit" class="btn btn-primary">Guardar perfil</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
                                <label for="password_actual">Contraseña actual</label>
                                <input
                                    type="password"
                                    id="password_actual"
                                    name="password_actual"
                                    class="{{ $errors->has('password_actual') ? 'input-error' : '' }}"
                                    required
                                >
                                @error('password_actual')
                                    <div class="error-text">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="campo">
                                <label for="password_nueva">Nueva contraseña</label>
                                <input
                                    type="password"
                                    id="password_nueva"
                                    name="password_nueva"
                                    class="{{ $errors->has('password_nueva') ? 'input-error' : '' }}"
                                    required
                                >
                                @error('password_nueva')
                                    <div class="error-text">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="campo">
                                <label for="password_nueva_confirmation">Confirmar nueva contraseña</label>
                                <input
                                    type="password"
                                    id="password_nueva_confirmation"
                                    name="password_nueva_confirmation"
                                    required
                                >
                            </div>
                        </div>

                        <div class="texto-ayuda">
                            Usa una contraseña segura y fácil de recordar para ti.
                        </div>

                        <div class="acciones">
                            <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
                                <label for="nuevo_usuario">Usuario</label>
                                <input
                                    type="text"
                                    id="nuevo_usuario"
                                    name="nuevo_usuario"
                                    value="{{ old('nuevo_usuario') }}"
                                    class="{{ $errors->has('nuevo_usuario') ? 'input-error' : '' }}"
                                    required
                                >
                                @error('nuevo_usuario')
                                    <div class="error-text">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="campo">
                                <label for="nuevo_password">Contraseña</label>
                                <input
                                    type="password"
                                    id="nuevo_password"
                                    name="nuevo_password"
                                    class="{{ $errors->has('nuevo_password') ? 'input-error' : '' }}"
                                    required
                                >
                                @error('nuevo_password')
                                    <div class="error-text">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="campo">
                                <label for="nuevo_password_confirmation">Confirmar contraseña</label>
                                <input
                                    type="password"
                                    id="nuevo_password_confirmation"
                                    name="nuevo_password_confirmation"
                                    required
                                >
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

    const inputFoto = document.getElementById('foto');
    const previewImagen = document.getElementById('previewImagen');

    if (inputFoto && previewImagen) {
        inputFoto.addEventListener('change', function (e) {
            const archivo = e.target.files[0];

            if (!archivo) return;

            const tiposPermitidos = ['image/jpeg', 'image/png'];

            if (!tiposPermitidos.includes(archivo.type)) {
                alert('Solo se permiten imágenes JPG, JPEG o PNG.');
                inputFoto.value = '';
                return;
            }

            const lector = new FileReader();

            lector.onload = function (evento) {
                previewImagen.src = evento.target.result;
            };

            lector.readAsDataURL(archivo);
        });
    }
});
</script>

@endsection