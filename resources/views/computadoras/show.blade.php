@extends('layouts.app')

@section('content')

<style>

/* ================= CONTENEDOR ================= */

.ficha{
max-width:950px;
margin:0 auto;
background:white;
padding:25px;
border-radius:16px;
box-shadow:0 6px 18px rgba(0,0,0,0.05);
margin-bottom:20px;
}

/* GRID */

.ficha-grid{
display:grid;
grid-template-columns:1fr 260px;
gap:25px;
align-items:start;
}

/* ITEMS */

.item{
margin-bottom:10px;
font-size:14px;
color:#374151;
}

/* ================= BADGES ================= */

.badge{
display:inline-block;
padding:6px 12px;
border-radius:6px;
font-size:12px;
font-weight:600;
}

/* ESTADOS */

.badge-pendiente{
background:#ef4444;
color:white;
}

.badge-completado{
background:#22c55e;
color:white;
}

/* TIPOS (COLORES CORREGIDOS) */

.badge-preventivo{
background:#3b82f6;
color:white;
}

.badge-correctivo{
background:#facc15;
color:#111827;
}


/* ================= IMAGEN ================= */

.imagen-box{
width:100%;
height:340px;
border-radius:16px;
background:#f4f6f9;
display:flex;
align-items:center;
justify-content:center;
overflow:hidden;
box-shadow: inset 0 0 0 1px #e5e7eb;
}

.imagen-box img{
width:100%;
height:100%;
object-fit:cover;
}


/* ================= BOTONES ================= */

.acciones{
margin-top:20px;
display:flex;
gap:10px;
flex-wrap:wrap;
}

.btn-editar{
background:#0f4c81;
color:white;
border:none;
padding:10px 18px;
border-radius:10px;
cursor:pointer;
transition:.2s;
}

.btn-editar:hover{
background:#0c3c66;
}

.btn-volver{
background:#6b7280;
color:white;
border:none;
padding:10px 18px;
border-radius:10px;
cursor:pointer;
transition:.2s;
}

.btn-volver:hover{
background:#4b5563;
}


/* ================= HISTORIAL ================= */

.historial{
max-width:950px;
margin:0 auto;
background:white;
padding:20px;
border-radius:16px;
box-shadow:0 6px 18px rgba(0,0,0,0.05);
}

.historial h2{
margin-bottom:15px;
font-size:18px;
font-weight:600;
color:#111827;
}


/* ================= TABLA ================= */

.tabla{
width:100%;
border-collapse:collapse;
}

.tabla th{
text-align:left;
padding:10px;
background:#f4f6f9;
font-size:13px;
color:#6b7280;
border-bottom:1px solid #e5e7eb;
}

.tabla td{
padding:10px;
border-top:1px solid #eee;
font-size:14px;
color:#374151;
}

.tabla tr:hover{
background:#f9fbfd;
}

</style>



<!-- ================= FICHA COMPUTADORA ================= -->

<div class="ficha">

<h1>{{ $computadora->nombre_equipo }}</h1>

<div class="ficha-grid">

<!-- DATOS -->

<div>

<div class="item">
<strong>Tipo:</strong> {{ $computadora->tipo }}
</div>

<div class="item">
<strong>Marca:</strong> {{ $computadora->marca }}
</div>

<div class="item">
<strong>Modelo:</strong> {{ $computadora->modelo }}
</div>

<div class="item">
<strong>Procesador:</strong> {{ $computadora->procesador }}
</div>

<div class="item">
<strong>RAM:</strong> {{ $computadora->ram }}
</div>

<div class="item">
<strong>Almacenamiento:</strong> {{ $computadora->almacenamiento }}
</div>

<div class="item">
<strong>Sistema operativo:</strong> {{ $computadora->sistema_operativo }}
</div>

<div class="item">
<strong>Usuario:</strong>
{{ $computadora->usuarioAsignado->nombre ?? 'Sin asignar' }}
</div>

<div class="item">
<strong>Ubicación:</strong>

@if($computadora->usuarioAsignado && $computadora->usuarioAsignado->ubicacion)
{{ $computadora->usuarioAsignado->ubicacion->area_empresa }}
@elseif($computadora->ubicacion)
{{ $computadora->ubicacion->area_empresa }}
@else
Sin área asignada
@endif

</div>

<div class="item">
<strong>Fecha compra:</strong>
{{ $computadora->fecha_compra }}
</div>

<div class="item">
<strong>Fin de Garantía:</strong>

@if($computadora->fecha_compra && $computadora->vida_util)
{{ \Carbon\Carbon::parse($computadora->fecha_compra)->addYears($computadora->vida_util)->format('Y-m-d') }}
@else
No registrada
@endif

</div>

<div class="item">
<strong>Vida útil:</strong>
{{ $computadora->vida_util }} años
</div>

<div class="item">
<strong>Estado:</strong>
<span class="badge">
{{ $computadora->estado }}
</span>
</div>

<div class="acciones">

<button class="btn-editar"
onclick="window.location.href='/computadoras/{{ $computadora->id }}/edit'">
Editar
</button>

<button class="btn-volver"
onclick="window.location.href='/computadoras'">
Volver
</button>

</div>

</div>


<!-- IMAGEN -->

<div>

<div class="imagen-box">

@if($computadora->imagen)

<img src="{{ asset($computadora->imagen) }}">

@else

<span style="color:#9ca3af;font-size:13px;">
Sin imagen
</span>

@endif

</div>

</div>

</div>

</div>



<!-- ================= HISTORIAL MANTENIMIENTOS ================= -->

<div class="historial">

<h2>Historial de mantenimientos</h2>

<table class="tabla">

<thead>

<tr>
<th>ID</th>
<th>Tipo</th>
<th>Fecha</th>
<th>Estado</th>
<th>Ver</th>
</tr>

</thead>

<tbody>

@forelse($computadora->mantenimientos as $m)

<tr>

<td>{{ $m->id }}</td>

<td>
<span class="badge badge-{{ strtolower($m->tipo) }}">
{{ $m->tipo }}
</span>
</td>

<td>{{ $m->fecha_programada }}</td>

<td>
<span class="badge badge-{{ strtolower($m->estado) }}">
{{ $m->estado }}
</span>
</td>

<td>
<a href="/mantenimientos/{{ $m->id }}">
Ver
</a>
</td>

</tr>

@empty

<tr>
<td colspan="5">
Sin mantenimientos registrados
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

@endsection