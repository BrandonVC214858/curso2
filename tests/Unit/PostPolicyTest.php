<?php

use App\Models\Post;
use App\Models\User;
use App\Policies\PostPolicy;

beforeEach(function () {
    $this->policy = new PostPolicy();
});

test('el dueno puede editar su aviso', function () {
    $yo = (new User)->forceFill(['id' => 1, 'rol' => 'editor']);
    $mio = (new Post)->forceFill(['user_id' => 1]);

    expect($this->policy->update($yo, $mio))->toBeTrue();
});

test('un editor no puede editar el aviso de otro', function () {
    $yo = (new User)->forceFill(['id' => 1, 'rol' => 'editor']);
    $ajeno = (new Post)->forceFill(['user_id' => 2]);

    expect($this->policy->update($yo, $ajeno))->toBeFalse();
});

test('before() deja pasar al admin', function () {
    $admin = (new User)->forceFill(['id' => 1, 'rol' => 'admin']);

    expect($this->policy->before($admin, 'update'))->toBeTrue();
});

test('before() no opina sobre un editor', function () {
    $editor = (new User)->forceFill(['id' => 1, 'rol' => 'editor']);

    expect($this->policy->before($editor, 'update'))->toBeNull();
});

test('un lector no puede crear avisos', function () {
    $lector = (new User)->forceFill(['id' => 1, 'rol' => 'lector']);

    expect($this->policy->create($lector))->toBeFalse();
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
