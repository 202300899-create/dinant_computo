<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Sistema Inventario Dinant</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.6.2/countUp.min.js"></script>
<style>

/* ================= BASE ================= */
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

/* CONTENEDOR INTERNO */
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
    height:auto;
    width:330px;
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

/* Hover animado */
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

/* ACTIVO PERSISTENTE */
.menu a.activo::after{
    width:100%;
}

/* ================= HAMBURGUESA ================= */
.hamburguesa{
    display:none;
    font-size:26px;
    color:white;
    cursor:pointer;
}

/* ================= CONTENIDO ================= */
.contenido{
    margin-top:50px;
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

}

</style>
</head>

<body>

<div class="header">
<div class="header-inner">

<!-- LOGO CLICKEABLE -->
<div class="logo">
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