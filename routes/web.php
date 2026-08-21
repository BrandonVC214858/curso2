<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;

Route::get('/', function () {
    $posts = Post::publicados()->with('categoria')->latest()->get();

    return view('portada', ['posts' => $posts]);
});

Route::get('/contacto', fn () => view('contacto'));