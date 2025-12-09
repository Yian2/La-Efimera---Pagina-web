<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        // Total vendes global
        $totalSales = Pedido::sum('total');

        // Nombre total de comandes
        $ordersCount = Pedido::count();

        // Vendes agrupades per estat
        $byStatus = Pedido::select(
                'estado',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('estado')
            ->get();

        $maxTotal = $byStatus->max('total') ?: 1;
        foreach ($byStatus as $row) {
            $row->percent = round($row->total / $maxTotal * 100);
        }

        // IMPORTANT: admin.stats (NO .index)
        return view('admin.stats', compact('totalSales', 'ordersCount', 'byStatus'));
    }
}
