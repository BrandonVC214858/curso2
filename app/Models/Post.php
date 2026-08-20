<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Post.php: "pertenezco a una categoría"
    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }
}
