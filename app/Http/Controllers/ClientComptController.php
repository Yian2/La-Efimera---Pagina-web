<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class ClientComptController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $gastat = Pedido::where('user_id', $user->id)->sum('total');
        $nextRewardAt = 500; // € per recompensa
        $progress = min(100, (int) round(($gastat % $nextRewardAt) / $nextRewardAt * 100));

        $ultimaComanda = Pedido::with('detalles.producto')
            ->where('user_id', $user->id)
            ->latest('id')
            ->first();

        return view('client.dashboard', compact('user','gastat','progress','ultimaComanda','nextRewardAt'));
    }

    public function orders()
    {
        $orders = Pedido::with('detalles.producto')
            ->where('user_id', auth()->id())
            ->orderByDesc('id')
            ->paginate(10);

        return view('client.orders', compact('orders'));
    }

    public function track()
    {
        // Agafem l’última comanda d’aquest usuari
        $order = \App\Models\Pedido::where('user_id', auth()->id())
            ->latest('id')
            ->first();

        return view('client.track', compact('order'));
    }

    public function loyalty()
    {
        $gastat = Pedido::where('user_id', auth()->id())->sum('total');
        $nextRewardAt = 500;
        $progress = min(100, (int) round(($gastat % $nextRewardAt) / $nextRewardAt * 100));

        return view('client.loyalty', compact('gastat','progress','nextRewardAt'));
    }
}
