<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $table = 'detalles_pedido';

    public $timestamps = false; // la taula té les seves pròpies dates

    // Cada detall pertany a un pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    // Cada detall està associat a un producte
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
