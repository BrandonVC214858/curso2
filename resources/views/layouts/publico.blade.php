<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Blog de Avisos')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="bg-marca border-b px-6 py-2 text-sm flex justify-around items-center gap-4">
        <a href="{{ route('avisos.index') }}" class="text-white font-bold">Blog de Avisos</a>
        <p class="text-gray-200">Bienvenido a nuestro blog de avisos</p>
        @auth
            <span class="text-gray-200">Hola, {{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-white font-semibold hover:underline">Salir</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="text-white font-semibold hover:underline">Entrar</a>
        @endauth
    </div>
    @yield('contenido')
</body>
</html>
