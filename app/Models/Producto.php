<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    public $timestamps = false;

    // Un producte surt a molts detalls de pedido
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'producto_id');
    }
}
