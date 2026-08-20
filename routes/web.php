<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $posts = collect([
        (object) ['titulo' => 'Cambio de horario en barandilla', 'contenido' => 'A partir del lunes el turno nocturno inicia a las 21:00 horas para todo el personal operativo.', 'categoria' => 'Aviso', 'fecha' => '11/08/2026'],
        (object) ['titulo' => 'Curso de primeros auxilios', 'contenido' => 'Inscripciones abiertas en la academia para el curso de primeros auxilios básicos. Cupo limitado.', 'categoria' => 'Capacitación', 'fecha' => '10/08/2026'],
        (object) ['titulo' => 'Mantenimiento de patrullas', 'contenido' => 'Las unidades del sector centro pasan a revisión mecánica esta semana según el rol publicado.', 'categoria' => 'Operativo', 'fecha' => '08/08/2026'],
    ]);

    return view('portada', ['posts' => $posts]);
});

Route::get('/contacto', fn () => view('contacto'));