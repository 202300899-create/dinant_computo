@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="dashboard-container">

    <div class="dashboard-header">
        <h1 class="dashboard-title">Dashboard de Inventario</h1>
        <p class="dashboard-subtitle">Estado general de las computadoras del sistema</p>
    </div>


    <!-- TARJETAS PRINCIPALES -->
    <div class="dashboard-grid">

        <div class="dashboard-card">
            <p class="card-title">Total Computadoras</p>
            <h2 id="totalComputadoras" class="card-number card-blue">0</h2>

            <div class="image-box image-blue">
                <img src="{{ asset('images/lapcpu.png') }}" class="computer-image1">
            </div>
        </div>


        <div class="dashboard-card">
            <p class="card-title">Desktop Activas</p>
            <h2 id="desktopActivas" class="card-number card-green">0</h2>

            <div class="image-box image-green">
                <img src="{{ asset('images/cpudell.png') }}" class="computer-image">
            </div>
        </div>


        <div class="dashboard-card">
            <p class="card-title">Laptop Activas</p>
            <h2 id="laptopActivas" class="card-number card-green">0</h2>

            <div class="image-box image-green">
                <img src="{{ asset('images/laptopdell.png') }}" class="computer-image">
            </div>
        </div>


        <div class="dashboard-card">
            <p class="card-title">Desktop Inactivas</p>
            <h2 id="desktopInactivas" class="card-number card-red">0</h2>

            <div class="image-box image-red">
                <img src="{{ asset('images/cpudell.png') }}" class="computer-image">
            </div>
        </div>


        <div class="dashboard-card">
            <p class="card-title">Laptop Inactivas</p>
            <h2 id="laptopInactivas" class="card-number card-red">0</h2>

            <div class="image-box image-red">
                <img src="{{ asset('images/laptopdell.png') }}" class="computer-image">
            </div>
        </div>

    </div>



    <!-- TITULO MANTENIMIENTOS -->
    <div class="dashboard-header" style="margin-top:40px;">
        <h1 class="dashboard-title">Mantenimientos próximos de este mes</h1>
    </div>


    <!-- NUEVA GRID DE 2 TARJETAS -->
    <div class="dashboard-grid-mantenimientos">

        <!-- PREVENTIVO -->
        <div class="dashboard-card">
            <p class="card-title">Mantenimientos Preventivos</p>
           <h2 id="mantenimientosPreventivos" class="card-number card-blue">0</h2>
            <div class="image-box image-blue">
                <img src="{{ asset('images/preventivo.png') }}" class="computer-image2">
            </div>
        </div>


        <!-- CORRECTIVO -->
        <div class="dashboard-card">
            <p class="card-title">Mantenimientos Correctivos</p>
           <h2 id="mantenimientosCorrectivos" class="card-number card-yellow">0</h2>

            <div class="image-box image-yellow">
                <img src="{{ asset('images/correctivo.png') }}" class="computer-image2">
            </div>
        </div>

    </div>

</div>



<script>

let total = {{ $totalComputadoras }};
let desktopActivas = {{ $desktopActivas }};
let laptopActivas = {{ $laptopActivas }};
let desktopInactivas = {{ $desktopInactivas }};
let laptopInactivas = {{ $laptopInactivas }};

let mantenimientosPreventivos = {{ $mantenimientosPreventivos }};
let mantenimientosCorrectivos = {{ $mantenimientosCorrectivos }};

function animarContador(id, valorFinal){

    let elemento = document.getElementById(id);
    let contador = 0;

    let duracion = 4000; 
    let incremento = valorFinal / (duracion / 70);

    let intervalo = setInterval(function(){

        contador += incremento;

        if(contador >= valorFinal){
            contador = valorFinal;
            clearInterval(intervalo);
        }

        elemento.innerText = Math.floor(contador);

    },30);

}

document.addEventListener("DOMContentLoaded", function(){

    animarContador("totalComputadoras", total);
    animarContador("desktopActivas", desktopActivas);
    animarContador("laptopActivas", laptopActivas);
    animarContador("desktopInactivas", desktopInactivas);
    animarContador("laptopInactivas", laptopInactivas);

    animarContador("mantenimientosPreventivos", mantenimientosPreventivos);
    animarContador("mantenimientosCorrectivos", mantenimientosCorrectivos);

});

</script>



<style>

*{
font-family:'Inter',sans-serif;
}

.dashboard-container{
padding:35px;
background:#f3f4f6;
min-height:100vh;
animation:fadeIn .7s ease;
}

.dashboard-header{
margin-bottom:30px;
animation:slideDown .6s ease;
}

.dashboard-title{
font-size:28px;
font-weight:700;
color:#1f2937;
}

.dashboard-subtitle{
color:#6b7280;
}

/* GRID PRINCIPAL */

.dashboard-grid{
display:grid;
grid-template-columns:repeat(5,1fr);
gap:18px;
}

/* GRID MANTENIMIENTOS */

.dashboard-grid-mantenimientos{
display:grid;
grid-template-columns:repeat(2,1fr);
gap:18px;
}

/* TARJETAS */

.dashboard-card{
background:white;
border-radius:12px;
padding:14px;
text-align:center;
box-shadow:0 5px 14px rgba(0,0,0,0.07);
transition:all .25s ease;
animation:cardEntrada .6s ease;
}

.dashboard-card:hover{
transform:translateY(-5px);
box-shadow:0 10px 22px rgba(0,0,0,0.12);
}

.card-title{
font-size:13px;
color:#6b7280;
}

.card-number{
font-size:32px;
font-weight:700;
margin:6px 0 10px 0;
animation:numberPop .4s ease;
}

/* COLORES */

.card-blue{color:#1d4ed8;}
.card-green{color:#15803d;}
.card-red{color:#b91c1c;}
.card-yellow{color:#d97706;}

/* CAJA IMAGEN */

.image-box{
width:100%;
height:120px;
border-radius:10px;
display:flex;
align-items:center;
justify-content:center;
overflow:hidden;
}

.image-blue{background:#60a5fa;}
.image-green{background:#4ade80;}
.image-red{background:#f87171;}
.image-yellow{background:#facc15;}

/* IMAGEN */

.computer-image{
width:220px;
height:200px;
object-fit:contain;
transition:transform .3s ease;
}

.computer-image1{
width:260px;
height:260px;
object-fit:contain;
transition:transform .3s ease;
}

.computer-image2{
width:260px;
height:250px;
object-fit:contain;
transition:transform .3s ease;
}

.dashboard-card:hover .computer-image{
transform:scale(1.08);
}

/* ANIMACIONES */

@keyframes fadeIn{
from{opacity:0}
to{opacity:1}
}

@keyframes slideDown{
from{
opacity:0;
transform:translateY(-15px);
}
to{
opacity:1;
transform:translateY(0);
}
}

@keyframes cardEntrada{
from{
opacity:0;
transform:translateY(15px);
}
to{
opacity:1;
transform:translateY(0);
}
}

@keyframes numberPop{
from{
transform:scale(.7);
opacity:.6;
}
to{
transform:scale(1);
opacity:1;
}
}

</style>

@endsection