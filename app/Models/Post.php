<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['publicado' => 'boolean'];

    // Post.php: "pertenezco a una categoría"
    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }

    public function scopePublicados($query)
    {
        return $query->where('publicado', true);
    }

    public function scopeDeCategoria($query, $categoriaId)
    {
        return $query->where('categoria_id', $categoriaId);
    }

}
