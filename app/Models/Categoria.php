<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // Categoria.php: "tengo muchos posts"
    public function posts() {
        return $this->hasMany(Post::class);
    }
}
