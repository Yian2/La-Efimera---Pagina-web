<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Pedido::with('user')
            ->withCount('detalles')
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }
}
