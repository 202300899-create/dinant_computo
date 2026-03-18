<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dinant Computo</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
}

body{
font-family:'Inter',sans-serif;
height:100vh;
overflow:hidden;
}

/* VIDEO DE FONDO */

.video-bg{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
object-fit:cover;
z-index:-1;
}

/* OVERLAY */

.overlay{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.35);
z-index:-1;
}

/* CONTENEDOR */

.main-container{
display:flex;
justify-content:center;
align-items:center;
height:100vh;
padding:40px;
}

/* TARJETA LOGIN */

.login-card{

background:white;
width:900px;
border-radius:20px;
box-shadow:0 25px 60px rgba(0,0,0,0.35);
display:flex;
overflow:hidden;

animation:fadeIn 0.8s ease;

transition:transform 0.7s ease, opacity 0.7s ease;

}

/* ANIMACION AL ENTRAR */

@keyframes fadeIn{
from{
opacity:0;
transform:translateY(30px);
}
to{
opacity:1;
transform:translateY(0);
}
}

/* ANIMACION AL SALIR */

.login-card.slide-up{
transform:translateY(-120vh);
opacity:0;
}

/* LADO IZQUIERDO */

.left-side{

background:#f5f6f8;
width:50%;
display:flex;
flex-direction:column;
justify-content:center;
align-items:center;
padding:40px;

}

.left-side img{
width:260px;
margin-bottom:20px;
filter:drop-shadow(0 10px 20px rgba(0,0,0,0.2));
}

.left-side h2{
color:#1d1d1f;
font-weight:600;
text-align:center;
}

/* LADO DERECHO */

.right-side{

width:50%;
padding:50px;
display:flex;
flex-direction:column;
justify-content:center;

}

/* LOGO */

.logo{
width:200px;
height:140px;
}

/* TITULO */

.title{
font-size:22px;
font-weight:600;
margin-bottom:30px;
color:#1d1d1f;
}

/* INPUTS */

.input-group{
margin-bottom:20px;
}

.input-group input{

width:100%;
padding:14px;
border-radius:10px;
border:1px solid #ddd;
font-size:14px;
outline:none;
transition:0.2s;

}

.input-group input:focus{

border-color:#1f5582;
box-shadow:0 0 0 3px rgba(31,85,130,0.15);

}

/* BOTON */

button{

width:100%;
padding:14px;
border:none;
border-radius:10px;
background:#1f5582;
color:white;
font-size:15px;
font-weight:500;
cursor:pointer;

transition:0.3s;

box-shadow:0 0 10px rgba(31,85,130,0.6);

}

button:hover{

transform:translateY(-2px);

box-shadow:
0 0 10px rgba(31,85,130,0.8),
0 0 20px rgba(31,85,130,0.6),
0 0 35px rgba(31,85,130,0.4);

}

/* ERROR */

.error{
color:#e74c3c;
margin-bottom:15px;
}

/* FOOTER */

.footer{
margin-top:20px;
font-size:13px;
color:#777;
}

/* RESPONSIVE */

@media(max-width:900px){

.login-card{
flex-direction:column;
width:90%;
}

.left-side{
width:100%;
padding:30px;
}

.right-side{
width:100%;
padding:40px;
}

.left-side img{
width:200px;
}

}

</style>

</head>

<body>

<!-- VIDEO -->

<video class="video-bg" autoplay muted loop>
<source src="{{ asset('images/back.mp4') }}" type="video/mp4">
</video>

<div class="overlay"></div>

<div class="main-container">

<div class="login-card" id="loginCard">

<div class="left-side">

<img class="logo" src="{{ asset('images/logo2.png') }}" alt="Dinant">

<h2>Sistema de Inventario Tecnológico</h2>

</div>

<div class="right-side">

<div class="title">
Iniciar Sesión
</div>

@if(session('error'))
<p class="error">{{ session('error') }}</p>
@endif

<form id="loginForm" method="POST" action="{{ route('login.procesar') }}">

@csrf

<div class="input-group">
<input type="text" name="usuario" placeholder="Usuario" required>
</div>

<div class="input-group">
<input type="password" name="password" placeholder="Contraseña" required>
</div>

<button type="submit">Ingresar</button>

</form>

<div class="footer">
© {{ date('Y') }} Dinant
</div>

</div>

</div>

</div>

<script>

/* ANIMACION AL LOGIN */

const form = document.getElementById('loginForm');
const card = document.getElementById('loginCard');

form.addEventListener('submit', function(e){

e.preventDefault();

card.classList.add('slide-up');

setTimeout(()=>{
form.submit();
},600);

});

</script>

</body>
</html>