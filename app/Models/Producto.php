<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'codigo',
        'nombre',
        'precio',
    ];

    // Relación muchos a muchos con Fianza
    public function fianzas()
    {
        return $this->belongsToMany(Fianza::class, 'fianza_producto', 'producto_id', 'fianza_nu_fianza')
                    ->withPivot('cantidad');
    }
}