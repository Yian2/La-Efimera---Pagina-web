<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'productos';

    protected $fillable = ['nombre','descripcion','precio','tipo','activo'];

    protected $casts = [
        'activo' => 'boolean',
        'precio' => 'decimal:2',
    ];

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'producto_id');
    }
}
