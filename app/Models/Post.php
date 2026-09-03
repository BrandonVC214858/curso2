<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    use SoftDeletes;
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['publicado' => 'boolean'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['titulo', 'contenido', 'publicado', 'categoria_id', 'user_id'];

    protected function resumen(): Attribute
    {
        return Attribute::get(
            fn () => Str::limit($this->contenido, 90)
        );
    }

    protected function esNuevo(): Attribute
    {
        return Attribute::get(fn () =>
            $this->publicado
            && $this->created_at->gt(now()->subDays(7))
        );
    }

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

    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
