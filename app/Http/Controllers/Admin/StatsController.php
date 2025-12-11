<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $productId = $request->input('product_id');
        $from      = $request->input('from');
        $to        = $request->input('to');

        // 1. Dades per a la taula de Top Productes i Vendes Totals (Filtres)
        $detallesQuery = DB::table('detalles_pedido');

        // Aplicar filtre de producte a la consulta dels detalls
        if ($productId) {
            $detallesQuery->where('producto_id', $productId);
        }

        // Aplicar filtres de data (requereix JOIN amb la taula de comandes)
        if ($from || $to) {
            $detallesQuery->join('pedidos', 'detalles_pedido.pedido_id', '=', 'pedidos.id');

            if ($from) {
                $detallesQuery->whereDate('pedidos.fecha_creacion', '>=', $from);
            }
            if ($to) {
                $detallesQuery->whereDate('pedidos.fecha_creacion', '<=', $to);
            }
        }

        // Càlcul de Top Productes (amb filtres aplicats)
        $topProducts = $detallesQuery
            ->select('producto_id')
            ->selectRaw('SUM(cantidad) as total_qty')
            ->selectRaw('SUM(cantidad * precio_unitario) as total_importe')
            ->groupBy('producto_id')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->get();
        
        // Mapejar els productes per obtenir el nom
        $topProducts = $topProducts->map(function ($row) {
            $row->producto = Producto::find($row->producto_id);
            return $row;
        });


        // 2. Dades per a les estadístiques generals (sense filtres específics de detall)
        // Creem una nova consulta per a les estadístiques generals que només filtren per data
        $ordersQuery = Pedido::query();
        
        if ($from) {
            $ordersQuery->whereDate('fecha_creacion', '>=', $from);
        }
        if ($to) {
            $ordersQuery->whereDate('fecha_creacion', '<=', $to);
        }

        // Càlcul d'Estadístiques Generals
        $totalOrders = $ordersQuery->count();
        $totalSales  = $ordersQuery->sum('total');

        // Vendes per estat (amb filtres de data aplicats)
        $salesByStatus = $ordersQuery
            ->select('estado', DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->groupBy('estado')
            ->orderBy('estado')
            ->get();
        
        // Productes per al filtre
        $allProducts = Producto::orderBy('nombre')->get();

        return view('admin.stats', compact(
            'totalOrders',
            'totalSales',
            'salesByStatus',
            'topProducts',
            'allProducts',
            'productId',
            'from',
            'to'
        ));
    }
    
    // El mètode 'show' no és necessari en el StatsController
}