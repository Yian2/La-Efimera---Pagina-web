<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetallePedido extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'detalles_pedido';

    protected $fillable = [
        'pedido_id','producto_id','cantidad',
        'precio_unitario','subtotal','fecha_creacion','fecha_actualizacion'
    ];

    protected $casts = [
        'cantidad'            => 'integer',
        'precio_unitario'     => 'decimal:2',
        'subtotal'            => 'decimal:2',
        'fecha_creacion'      => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
