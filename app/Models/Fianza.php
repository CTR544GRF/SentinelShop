<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fianza extends Model
{
    use HasFactory;

    protected $table = 'fianzas';
    protected $primaryKey = 'nu_fianza';

    protected $fillable = [
        'usuario_id',
        'fecha',
        'precio',
        'estado',
        'descripcion',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'fianza_producto', 'fianza_nu_fianza', 'producto_id')
                    ->withPivot('cantidad')
                    ->withTimestamps();
                    
    }

    public function factura()
{
    return $this->belongsToMany(Factura::class, 'factura_fianza', 'fianza_id', 'factura_id')
                ->withPivot('precio')
                ->withTimestamps();
}
}