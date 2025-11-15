<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';

    public $timestamps = false;

    // Cada pedido pertany a un usuari
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Un pedido té molts detalls
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id');
    }
}
