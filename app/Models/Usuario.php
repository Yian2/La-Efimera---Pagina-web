<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    // Taula de la BD
    protected $table = 'usuarios';

    // Com que la taula NO té created_at / updated_at
    public $timestamps = false;

    // Relació: un usuari té molts pedidos
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'usuario_id');
    }
}
