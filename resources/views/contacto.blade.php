@extends('layouts.publico')

@section('titulo', 'Contacto · Blog de Avisos')

@section('contenido')
<div class="max-w-lg mx-auto p-8 bg-white rounded-lg shadow mt-8">
    <x-campo label="Nombre" placeholder="Nombre" type="text" />
    <x-campo label="Correo electrónico" placeholder="Correo electrónico" type="email" />
    <x-campo label="Mensaje" placeholder="Escribe tu mensaje aquí" type="textarea" />
    <button class="w-full bg-marca text-white font-semibold rounded-lg py-2 hover:bg-blue-800 transition">Enviar</button>
</div>
@endsection