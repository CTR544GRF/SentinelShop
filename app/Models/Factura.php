<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $dates = ['fecha'];
    protected $fillable = ['user_id', 'fecha', 'descripcion', 'total'];
    protected $table = 'facturas';
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function fianzas()
    {
        return $this->belongsToMany(Fianza::class, 'factura_fianza', 'factura_id', 'fianza_id')
                    ->withPivot('precio')
                    ->withTimestamps();
    }
    public function facturas()
    {
        return $this->hasMany(Factura::class, 'user_id');
    }
}