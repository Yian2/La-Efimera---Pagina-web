<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;


class HomeController extends Controller
{
    public function index()
    {
        $productos = Producto::where('activo', true)
            ->orderBy('tipo')
            ->orderBy('nombre')
            ->get()
            ->groupBy('tipo');

        // labels per tipus → fem servir directament els textos que tens al JSON
        $labels = [
            'pizza_vermella' => [
                'title'    => __('Les Vermelles'),
                'subtitle' => __('(base de tomàquet + mozzarella)'),
            ],
            'pizza_blanca' => [
                'title'    => __('Les Blanques'),
                'subtitle' => __('(base de mozzarella)'),
            ],
            'pizza_gourmet' => [
                'title'    => __('Les Gourmets'),
                'subtitle' => '',
            ],
            'focaccia' => [
                'title'    => __('Focaccies'),
                'subtitle' => '',
            ],
            'lasanya' => [
                'title'    => __('Lasanya'),
                'subtitle' => '',
            ],
            'calzone' => [
                'title'    => __('Calzones'),
                'subtitle' => '',
            ],
            'suplement' => [
                'title'    => __('Suplements'),
                'subtitle' => '',
            ],
            'amanida' => [
                'title'    => __('Amanides'),
                'subtitle' => '',
            ],
            'pica_pica' => [
                'title'    => __('Pica Pica'),
                'subtitle' => '',
            ],
            'postre' => [
                'title'    => __('Postres'),
                'subtitle' => '',
            ],
            'cafe' => [
                'title'    => __('Cafès'),
                'subtitle' => '',
            ],
            'infusio' => [
                'title'    => __('Infusions'),
                'subtitle' => '',
            ],
            'beguda' => [
                'title'    => __('Begudes'),
                'subtitle' => '',
            ],
            'vi' => [
                'title'    => __('Vins'),
                'subtitle' => '',
            ],
        ];

        return view('home', compact('productos','labels'));
    }
}