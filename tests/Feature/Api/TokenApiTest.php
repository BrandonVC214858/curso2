<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->editor = User::factory()->create(['rol' => 'editor']);
});

describe('tokens', function () {

    test('credenciales correctas devuelven un token', function () {
        $this->postJson('/api/token', [
            'email' => $this->editor->email,
            'password' => 'password',
            'dispositivo' => 'pruebas',
        ])->assertStatus(200)->assertJsonStructure(['token', 'usuario', 'rol']);

        $this->assertDatabaseHas('personal_access_tokens', ['name' => 'pruebas']);
    });

    test('credenciales incorrectas responden 422 y no dejan token', function () {
        $this->postJson('/api/token', [
            'email' => $this->editor->email,
            'password' => 'la-que-no-es',
            'dispositivo' => 'pruebas',
        ])->assertStatus(422);

        $this->assertDatabaseCount('personal_access_tokens', 0);
    });
});
