<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'usuarios';

    protected $fillable = ['nombre','correo','contrasena','rol'];

    // (sense casts: no calen de moment)
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'usuario_id');
    }
}
