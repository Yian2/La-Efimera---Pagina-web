<?php

use Illuminate\Support\Facades\Route;
use App\Models\Pedidos;
use App\Models\Producto;
use App\Models\Detalles_pedido;


Route::get('/', function () {
    return view('welcome');
});



Route::get('/productos', function(){

    $productos=Producto::All();
    foreach($productos as $p){
        echo $p->nombre;
    }
});