<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class ClientComptController extends Controller
{
    public function index()
    {
        // Dashboard del client: dades d'usuari, total gastat, progrés de fidelització i última comanda
        $user = auth()->user();

        // Total gastat per l'usuari
        $gastat = Pedido::where('user_id', $user->id)->sum('total');

        // Llindar fix per obtenir una recompensa (p.ex. cada 500€)
        $nextRewardAt = 500;

        // Progrés dins del tram actual (gastat % llindar), expressat en percentatge (0-100)
        $progress = min(100, (int) round(($gastat % $nextRewardAt) / $nextRewardAt * 100));

        // Última comanda amb detalls i productes (per mostrar-la al dashboard)
        $ultimaComanda = Pedido::with('detalles.producto')
            ->where('user_id', $user->id)
            ->latest('id')
            ->first();

        return view('client.dashboard', compact('user','gastat','progress','ultimaComanda','nextRewardAt'));
    }

    public function orders()
    {
        // Llistat de comandes del client (paginat) amb detalls i productes
        $orders = Pedido::with('detalles.producto')
            ->where('user_id', auth()->id())
            ->orderByDesc('id')
            ->paginate(10);

        return view('client.orders', compact('orders'));
    }

    public function track()
    {
        // Vista de seguiment: recuperem només les últimes 5 comandes per mostrar estat / informació recent
        $orders = Pedido::with('detalles.producto')
            ->where('user_id', auth()->id())
            ->orderByDesc('id')
            ->take(5)
            ->get();

        return view('client.track', compact('orders'));
    }

    public function loyalty()
    {
        // Vista de fidelització: total gastat i progrés cap a la següent recompensa
        $gastat = Pedido::where('user_id', auth()->id())->sum('total');
        $nextRewardAt = 500;

        // Percentatge del tram actual fins a la recompensa (0-100)
        $progress = min(100, (int) round(($gastat % $nextRewardAt) / $nextRewardAt * 100));

        return view('client.loyalty', compact('gastat','progress','nextRewardAt'));
    }
}
