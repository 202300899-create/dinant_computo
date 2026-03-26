<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Sistema Inventario Dinant</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>

/* ================= BASE ================= */

[x-cloak]{
display:none !important;
}

body{
margin:0;
font-family:'Inter',sans-serif;
background:#f5f6f8;
color:#1d1d1f;
}

/* ================= HEADER ================= */

.header{
position:fixed;
top:0;
left:0;
width:100%;
height:80px;
background:#0f4c81;
display:flex;
align-items:center;
justify-content:center;
box-shadow:0 3px 10px rgba(0,0,0,0.15);
z-index:9999;
}

/* CONTENEDOR */

.header-inner{
width:100%;
max-width:1400px;
display:flex;
align-items:center;
padding:0 10px;
}

/* ================= LOGO ================= */

.logo{
flex:0 0 260px;
display:flex;
align-items:center;
}

.logo img{
height:240px;
width:380px;
margin-left:-50px;
margin-top:10px;
transition:0.3s;
}

.logo img:hover{
transform:scale(1.03);
}

/* ================= MENU ================= */

.menu{
flex:1;
display:flex;
justify-content:center;
gap:40px;
}

.menu a{
text-decoration:none;
color:#e3eef9;
font-size:15px;
font-weight:500;
position:relative;
}

.menu a::after{
content:"";
position:absolute;
left:0;
bottom:-6px;
width:0;
height:2px;
background:white;
transition:0.3s;
}

.menu a:hover::after{
width:100%;
}

.menu a.activo::after{
width:100%;
}

/* ================= PERFIL ================= */

.perfil-container{
position:relative;
margin-left:auto;
}

.perfil-btn{
width:42px;
height:42px;
border-radius:50%;
overflow:hidden;
cursor:pointer;
border:2px solid white;
transition:0.2s;
background:none;
padding:0;
display:flex;
align-items:center;
justify-content:center;
}

.perfil-btn:hover{
transform:scale(1.08);
}

.perfil-btn img{
width:100%;
height:100%;
object-fit:cover;
}

/* ===== DROPDOWN PERFIL ===== */

.dropdown-perfil{
position:absolute;
top:55px;
right:0;
background:white;
border-radius:12px;
box-shadow:0 10px 30px rgba(0,0,0,0.25);
width:275px;
overflow:hidden;
z-index:10050;
transform-origin:top right;
}

/* HEADER PERFIL */

.perfil-header{
display:flex;
align-items:center;
gap:12px;
padding:15px;
border-bottom:1px solid #eee;
}

.perfil-header img{
width:40px;
height:40px;
border-radius:50%;
object-fit:cover;
}

.nombre{
font-size:14px;
font-weight:600;
}

.rol{
font-size:12px;
color:#666;
}

/* OPCIONES */

.perfil-opciones a{
display:block;
padding:12px 15px;
text-decoration:none;
font-size:14px;
color:#333;
transition:0.2s;
}

.perfil-opciones a:hover{
background:#f5f6f8;
}

.logout{
color:#e74c3c;
}

/* ================= HAMBURGUESA ================= */

.hamburguesa{
display:none;
font-size:26px;
color:white;
cursor:pointer;
margin-left:15px;
}

/* ================= CONTENIDO ================= */

.contenido{
margin-top:80px;
padding:30px;
}

/* ================= RESPONSIVE ================= */

@media(max-width:900px){

.menu{
position:fixed;
top:80px;
left:0;
width:100%;
background:#0f4c81;
flex-direction:column;
align-items:center;
gap:20px;
padding:25px 0;
transform:translateY(-120%);
opacity:0;
transition:0.3s;
z-index:9998;
}

.menu.active{
transform:translateY(0);
opacity:1;
}

.hamburguesa{
display:block;
}

.logo{
flex:1;
}

.logo img{
width:240px;
margin-left:0;
margin-top:6px;
}

.dropdown-perfil{
right:0;
width:250px;
}
}

</style>
</head>

<body class="{{ session('tema') == 'oscuro' ? 'modo-oscuro' : '' }}">

<div class="header">
    <div class="header-inner">

        <!-- LOGO -->
        <div class="logo">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Dinant">
            </a>
        </div>

        <!-- MENU -->
        <div class="menu" id="menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'activo' : '' }}">
                Dashboard
            </a>

            <a href="/computadoras" class="{{ request()->is('computadoras*') ? 'activo' : '' }}">
                Inventario
            </a>

            <a href="/mantenimientos" class="{{ request()->is('mantenimientos*') ? 'activo' : '' }}">
                Mantenimientos
            </a>

            <a href="/calendario" class="{{ request()->is('calendario*') ? 'activo' : '' }}">
                Calendario
            </a>

            <a href="/usuarios" class="{{ request()->is('usuarios*') ? 'activo' : '' }}">
                Usuarios
            </a>
        </div>

        <!-- PERFIL -->
        <div class="perfil-container" x-data="{ open: false }">
            <button type="button" class="perfil-btn" @click.stop="open = !open">
               <img src="{{ session('admin_foto') ? asset(session('admin_foto')) : asset('images/user.jpeg') }}" alt="Usuario">
            </button>

            <div
                class="dropdown-perfil"
                x-cloak
                x-show="open"
                @click.outside="open = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
            >
                <div class="perfil-header">
                    <img src="{{ session('admin_foto') ? asset(session('admin_foto')) : asset('images/user.jpeg') }}" alt="Usuario">

                    <div>
                        <div class="nombre">
                            {{ session('admin_usuario') ?? 'Administrador' }}
                        </div>

                        <div class="rol">
                            Administrador
                        </div>
                    </div>
                </div>

                <div class="perfil-opciones">
                    <a href="{{ route('configuracion.index') }}">
                        Configuración
                    </a>

                    <a href="{{ route('logout') }}" class="logout">
                        Cerrar sesión
                    </a>
                </div>
            </div>
        </div>

        <!-- HAMBURGUESA -->
        <div class="hamburguesa" onclick="toggleMenu()">☰</div>

    </div>
</div>

<div class="contenido">
    @yield('content')
</div>

<script>
function toggleMenu(){
    document.getElementById("menu").classList.toggle("active");
}
</script>

</body>
</html>