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
overflow:hidden;
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
height:200px;
width:300px;
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
transition:0.25s ease;
background:none;
padding:0;
display:flex;
align-items:center;
justify-content:center;
text-decoration:none;
box-shadow:0 4px 10px rgba(0,0,0,0.18);
}

.perfil-btn:hover{
transform:scale(1.08);
box-shadow:0 8px 18px rgba(0,0,0,0.24);
}

.perfil-btn:active{
transform:scale(0.96);
}

.perfil-btn img{
width:100%;
height:100%;
object-fit:cover;
display:block;
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
padding:80px 30px 30px;
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

}

</style>

</head>

<body class="{{ session('tema') == 'oscuro' ? 'modo-oscuro' : '' }}">

<div class="header">
    <div class="header-inner">

        <!-- LOGO -->
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Dinant">
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
        <div class="perfil-container">
            <a href="{{ route('configuracion.index') }}" class="perfil-btn" title="Configuración">
                <img src="{{ session('admin_foto') ? asset(session('admin_foto')) : asset('images/user.jpeg') }}" alt="Usuario">
            </a>
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