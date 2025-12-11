<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $sort      = $request->input('sort', 'recent');
        $userId    = $request->input('user_id');
        $productId = $request->input('product_id');
        $email     = $request->input('email');
        $from      = $request->input('from');
        $to        = $request->input('to');

        // Modificació clau: Carreguem 'detalles' i 'detalles.producto' per a la vista d'índex (N+1)
        $query = Pedido::with(['user', 'detalles.producto'])
            ->withCount('detalles');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($email) {
            $query->whereHas('user', function ($q) use ($email) {
                $q->where('email', 'LIKE', '%' . $email . '%');
            });
        }

        if ($productId) {
            $query->whereHas('detalles', function ($q) use ($productId) {
                $q->where('producto_id', $productId);
            });
        }

        if ($from) {
            $query->whereDate('fecha_creacion', '>=', $from);
        }
        if ($to) {
            $query->whereDate('fecha_creacion', '<=', $to);
        }

        // Ordre
        if ($sort === 'oldest') {
            $query->orderBy('fecha_creacion', 'asc');
        } else {
            $query->orderBy('fecha_creacion', 'desc');
        }

        $orders = $query->paginate(20)->withQueryString();

        $users    = User::orderBy('email')->get();
        $products = Producto::orderBy('nombre')->get();

        // Productes més venuts: CORRECCIÓ DE LA COLUMNA SQL
        $topProducts = DB::table('detalles_pedido')
            ->select('producto_id')
            ->selectRaw('SUM(cantidad) as total_qty')
            // Ús correcte de 'precio_unitario'
            ->selectRaw('SUM(cantidad * precio_unitario) as total_importe')
            ->groupBy('producto_id')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->get();
        
        // Mapeamos los productos para obtener el nombre
        $topProducts = $topProducts->map(function ($row) {
            $row->producto = Producto::find($row->producto_id);
            return $row;
        });

        return view('admin.orders', compact(
            'orders',
            'users',
            'products',
            'topProducts',
            'sort'
        ));
    }

    public function show(Pedido $pedido)
    {
        // Ens assegurem de carregar les relacions per al detall
        $pedido->load([
            'user',
            'detalles.producto',
        ]);

        // ATENCIÓ: Assegura't que la vista es diu 'admin.orders.show' o 'admin.show'
        return view('admin.show', compact('pedido')); 
    }
}