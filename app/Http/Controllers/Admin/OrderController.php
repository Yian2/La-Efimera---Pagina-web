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
        //Llegim paràmetres de consulta (filtres i ordenació) amb valors per defecte
        $sort      = $request->input('sort', 'recent');
        $userId    = $request->input('user_id');
        $productId = $request->input('product_id');
        $email     = $request->input('email');
        $from      = $request->input('from');
        $to        = $request->input('to');

        // Construïm la query base. Eager loading de 'user' i de 'detalles.producto' per evitar el problema N+1 a la vista
        // Comptem el nombre de detalls per comanda (detalles_count) per mostrar-ho fàcilment a l'índex
        $query = Pedido::with(['user', 'detalles.producto'])
            ->withCount('detalles');

        // Filtre per usuari (user_id)
        if ($userId) {
            $query->where('user_id', $userId);
        }

        // Filtre per email d'usuari (LIKE)
        if ($email) {
            $query->whereHas('user', function ($q) use ($email) {
                $q->where('email', 'LIKE', '%' . $email . '%');
            });
        }

        // Filtre per producte: només comandes que tinguin algun detall amb aquest producte
        if ($productId) {
            $query->whereHas('detalles', function ($q) use ($productId) {
                $q->where('producto_id', $productId);
            });
        }

        // Filtre de dates (rang) sobre la data de creació
        if ($from) {
            $query->whereDate('fecha_creacion', '>=', $from);
        }
        if ($to) {
            $query->whereDate('fecha_creacion', '<=', $to);
        }

        // Ordenació per data de creació:
        if ($sort === 'oldest') {
            $query->orderBy('fecha_creacion', 'asc');
        } else {
            $query->orderBy('fecha_creacion', 'desc');
        }

        // Paginació i conservació dels paràmetres (withQueryString) per mantenir filtres/ordenació en navegar
        $orders = $query->paginate(20)->withQueryString();

        // Llistes auxiliars per a filtres (selects) a la vista
        $users    = User::orderBy('email')->get();
        $products = Producto::orderBy('nombre')->get();

        // Top 10 productes més venuts: total_qty: suma de quantitats, total_importe: suma de quantitat * preu unitari
        // fem servir la taula 'detalles_pedido' directament per ser mes eficients
        $topProducts = DB::table('detalles_pedido')
            ->select('producto_id')
            ->selectRaw('SUM(cantidad) as total_qty')
            ->selectRaw('SUM(cantidad * precio_unitario) as total_importe')
            ->groupBy('producto_id')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->get();

        // Afegim el model Producte a cada fila (per mostrar nom, etc.)
        $topProducts = $topProducts->map(function ($row) {
            $row->producto = Producto::find($row->producto_id);
            return $row;
        });

        // Retornem la vista principal d'admin de comandes amb totes les dades necessàries
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
        // Carreguem les relacions necessàries per al detall, dades del client/usuari, detalles.producto: línies de la comanda i el producte de cada línia
        $pedido->load([
            'user',
            'detalles.producto',
        ]);

        return view('admin.show', compact('pedido'));
    }

    public function updateEstado(\Illuminate\Http\Request $request, \App\Models\Pedido $pedido)
    {
        // Com que ja estàs sota middleware can:admin, aquí no cal repetir checks d’admin.

        $estado = $request->input('estado');

        // Estats en català (els que guardarem a BD)
        $allowed = array('pendent', 'preparant', 'llest', 'entregat');

        if (!$estado || !in_array($estado, $allowed, true)) {
            return redirect()->back()->withErrors(['estado' => 'Estat no vàlid.']);
        }

        $pedido->estado = $estado;
        $pedido->save();

        return redirect()->back()->with('success', 'Estat de la comanda actualitzat.');
    }

}
