<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\DetallePedido;

class Pedido extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'pedidos';

    protected $fillable = ['user_id', 'estado', 'es_para_llevar', 'total', 'fecha_creacion'];

    protected $casts = [
        'es_para_llevar' => 'boolean',
        'total'          => 'decimal:2',
        'fecha_creacion' => 'datetime',
    ];

    // Relació estàndard
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Alias antic si el feies servir en algun lloc
    public function usuario()
    {
        return $this->user();
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id');
    }
}
