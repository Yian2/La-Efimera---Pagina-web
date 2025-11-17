<?php

use Illuminate\Support\Facades\Route;
use App/Models/Pedidos;
use App/Models/Productos;
use App/Models/Detalles_pedido;


Route::get('/', function () {
    return view('welcome');
});


Route::get("/Productos", function(){
    $productos=Productos::All();
    foreach($productos as $p){
        echo $p;
    }
});