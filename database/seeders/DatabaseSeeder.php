<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


use App\Models\Producto;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1 users
       
        $adminId = DB::table('users')->insertGetId([
            'nombre'     => 'Admin',
            'email'     => 'admin@laefimera.test',
            'password' => Hash::make('123456'),
            'rol'        => 'admin',
        ]);

        $clienteId = DB::table('users')->insertGetId([
            'nombre'     => 'Cliente Demo',
            'email'     => 'cliente@laefimera.test',
            'password' => Hash::make('123456'),
            'rol'        => 'cliente',
        ]);

        //2 PRODUCTOS
        DB::table('productos')->insert([
            // LES VERMELLES
            [
                'nombre'      => 'La Margarida',
                'descripcion' => 'Tomàquet, mozzarella, alfàbrega',
                'precio'      => 9.00,
                'tipo'        => 'pizza_vermella',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La York',
                'descripcion' => 'Tomàquet, mozzarella, pernil dolç',
                'precio'      => 10.50,
                'tipo'        => 'pizza_vermella',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La York Xampi',
                'descripcion' => 'Tomàquet, mozzarella, pernil dolç, xampinyons',
                'precio'      => 11.00,
                'tipo'        => 'pizza_vermella',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Fresca',
                'descripcion' => 'Fulles verdes, encenalls de parmesà',
                'precio'      => 11.50,
                'tipo'        => 'pizza_vermella',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Carbonara',
                'descripcion' => 'Bacó, ou, parmesà, pebre',
                'precio'      => 12.50,
                'tipo'        => 'pizza_vermella',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Cabrita',
                'descripcion' => 'Formatge de cabra, ruca, tomàquet fresc, olives',
                'precio'      => 12.50,
                'tipo'        => 'pizza_vermella',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Parmigiani',
                'descripcion' => 'Albergínia rostida, parmesà',
                'precio'      => 12.00,
                'tipo'        => 'pizza_vermella',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Capritxosa',
                'descripcion' => 'Pernil dolç, carxofes, xampinyons, olives',
                'precio'      => 12.00,
                'tipo'        => 'pizza_vermella',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Golosa',
                'descripcion' => 'Gorgonzola, pernil serrà, olives',
                'precio'      => 12.50,
                'tipo'        => 'pizza_vermella',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Diàvola',
                'descripcion' => 'Ceba, salami picant i xili xipotle',
                'precio'      => 11.50,
                'tipo'        => 'pizza_vermella',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Pagessa',
                'descripcion' => 'Ceba, pebrot escalivat, sobrassada, olives',
                'precio'      => 12.50,
                'tipo'        => 'pizza_vermella',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Verda',
                'descripcion' => 'Burrata, tomàquet rostit, farigola, pesto, olives',
                'precio'      => 14.00,
                'tipo'        => 'pizza_vermella',
                'activo'      => true,
            ],
            [
                'nombre'      => 'L’Escalivada',
                'descripcion' => 'Verdures rostides, formatge de cabra, olives',
                'precio'      => 14.50,
                'tipo'        => 'pizza_vermella',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Veganà',
                'descripcion' => 'Sense mozza, verdures rostides, xampinyons, ceba',
                'precio'      => 11.50,
                'tipo'        => 'pizza_vermella',
                'activo'      => true,
            ],

            // LES BLANQUES
            [
                'nombre'      => 'La Black&White',
                'descripcion' => 'Gorgonzola, ceba, olives negres',
                'precio'      => 11.50,
                'tipo'        => 'pizza_blanca',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Anxoves',
                'descripcion' => 'Ceba, tàperes, anxoves, olives',
                'precio'      => 11.50,
                'tipo'        => 'pizza_blanca',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Tonna',
                'descripcion' => 'Tonyina, ceba, tàperes, olives',
                'precio'      => 12.50,
                'tipo'        => 'pizza_blanca',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Frida',
                'descripcion' => 'Ricotta, pesto, ruca, tomàquet fresc, parmesà',
                'precio'      => 15.00,
                'tipo'        => 'pizza_blanca',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La 4 Formatges',
                'descripcion' => 'Gorgonzola, taleggio, pecorino, escalunyes, sàlvia',
                'precio'      => 15.00,
                'tipo'        => 'pizza_blanca',
                'activo'      => true,
            ],

            // LES GOURMETS
            [
                'nombre'      => 'La Salmona',
                'descripcion' => 'Mozza, salmó fumat, ricotta, ceba, tàperes, ruca, mojo verd',
                'precio'      => 16.50,
                'tipo'        => 'pizza_gourmet',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Nostra',
                'descripcion' => 'Salsa de tòfona, mozza, carbassó rostit, xampinyó fresc, ou, parmesà',
                'precio'      => 16.00,
                'tipo'        => 'pizza_gourmet',
                'activo'      => true,
            ],
            [
                'nombre'      => 'L’Esparracada',
                'descripcion' => 'Tomàquet, mozza, botifarra, formatge de cabra, pebrot i ceba caramel·litzada',
                'precio'      => 16.00,
                'tipo'        => 'pizza_gourmet',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Roja',
                'descripcion' => 'Tomàquet, mozzarella, pernil serrà, scamorza, parmesà, ruca',
                'precio'      => 15.50,
                'tipo'        => 'pizza_gourmet',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Horney',
                'descripcion' => 'Tomàquet, mozza, albergínia rostida, tomàquet sec, parmesà, pipes, mel',
                'precio'      => 15.50,
                'tipo'        => 'pizza_gourmet',
                'activo'      => true,
            ],

            // FOCACCIA / LASANYA
            [
                'nombre'      => 'La Bonarda',
                'descripcion' => 'Taleggio, bacon, ceba caramel·litzada, ruca',
                'precio'      => 8.50,
                'tipo'        => 'focaccia',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Napolitana',
                'descripcion' => 'Mozza, tomàquet fresc, all i anxoves',
                'precio'      => 8.50,
                'tipo'        => 'focaccia',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Lasanha Vegetal',
                'descripcion' => 'Salsa de tomàquet, beixamel de porro, xampinyó, carbassó, pastanaga, formatge de cabra i parmesà',
                'precio'      => 10.50,
                'tipo'        => 'lasanya',
                'activo'      => true,
            ],

            // CALZONES
            [
                'nombre'      => 'El Scamorza',
                'descripcion' => 'Mozzarella, pernil dolç, scamorza, ou',
                'precio'      => 14.00,
                'tipo'        => 'calzone',
                'activo'      => true,
            ],
            [
                'nombre'      => 'El Ricotta',
                'descripcion' => 'Mozzarella, ricotta, tomàquet sec, pesto',
                'precio'      => 13.00,
                'tipo'        => 'calzone',
                'activo'      => true,
            ],

            // SUPLEMENTS
            [
                'nombre'      => 'Suplement Sense Gluten',
                'descripcion' => 'Base de pizza sense gluten',
                'precio'      => 2.50,
                'tipo'        => 'suplement',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Suplement Embotits i Formatges',
                'descripcion' => 'Afegir embotits i formatges',
                'precio'      => 1.50,
                'tipo'        => 'suplement',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Suplement Salmó',
                'descripcion' => 'Afegir salmó',
                'precio'      => 2.50,
                'tipo'        => 'suplement',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Suplement Xili Xipotle',
                'descripcion' => 'Afegir xili xipotle',
                'precio'      => 0.50,
                'tipo'        => 'suplement',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Suplement Vegetals',
                'descripcion' => 'Afegir verdures',
                'precio'      => 0.50,
                'tipo'        => 'suplement',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Suplement Pa de Focaccia',
                'descripcion' => 'Pa de focaccia extra',
                'precio'      => 2.50,
                'tipo'        => 'suplement',
                'activo'      => true,
            ],

            // AMANIDES
            [
                'nombre'      => 'La Burrata',
                'descripcion' => 'Fulles de ruca i canonges, burrata, olives, pipes i oli de pesto',
                'precio'      => 9.50,
                'tipo'        => 'amanida',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Rosita',
                'descripcion' => 'Fulles variades, salmó, alvocat, ceba, olives, pipes, salses de soja i llima',
                'precio'      => 10.50,
                'tipo'        => 'amanida',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Primavera',
                'descripcion' => 'Fulles variades, alvocat, maduixes, ceba, olives, pipes, vinagreta de coriandre i llima',
                'precio'      => 9.50,
                'tipo'        => 'amanida',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Caprese',
                'descripcion' => 'Tomàquet fresc, mozzarella de búfala, alfàbrega, pesto',
                'precio'      => 9.50,
                'tipo'        => 'amanida',
                'activo'      => true,
            ],
            [
                'nombre'      => 'La Tardor',
                'descripcion' => 'Fulles variades, formatge de cabra, moniato, ceba, olives, pipes, vinagreta de coriandre i llima',
                'precio'      => 9.50,
                'tipo'        => 'amanida',
                'activo'      => true,
            ],

            // PICA PICA
            [
                'nombre'      => 'Hummus',
                'descripcion' => 'Paté de cigrons amb tahin i llimona, amb pa de focaccia',
                'precio'      => 6.50,
                'tipo'        => 'pica_pica',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Trio de salses',
                'descripcion' => '3 dips: hummus, guacamole i tzatziki amb pa de focaccia',
                'precio'      => 8.50,
                'tipo'        => 'pica_pica',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Empanades argentines',
                'descripcion' => 'Varietat d’empanades argentines (pregunteu què tenim)',
                'precio'      => 2.80,
                'tipo'        => 'pica_pica',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Formatge al forn',
                'descripcion' => 'Taleggio al forn amb melmelada de ceba i pa de focaccia',
                'precio'      => 7.50,
                'tipo'        => 'pica_pica',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Olives',
                'descripcion' => 'Olives verdes i negres',
                'precio'      => 2.50,
                'tipo'        => 'pica_pica',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Patatilles',
                'descripcion' => 'Patates xips',
                'precio'      => 2.50,
                'tipo'        => 'pica_pica',
                'activo'      => true,
            ],

            // POSTRES
            [
                'nombre'      => 'Tiramisú',
                'descripcion' => 'Tiramisú casolà',
                'precio'      => 5.00,
                'tipo'        => 'postre',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Pizza Nutella i maduixa',
                'descripcion' => 'Pizza dolça amb Nutella i maduixa',
                'precio'      => 7.50,
                'tipo'        => 'postre',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Pastís Pastanaga',
                'descripcion' => 'Pastís de pastanaga casolà',
                'precio'      => 4.50,
                'tipo'        => 'postre',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Brownie amb gelat',
                'descripcion' => 'Brownie amb gelat',
                'precio'      => 6.50,
                'tipo'        => 'postre',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Panna cotta',
                'descripcion' => 'Panna cotta amb salsa',
                'precio'      => 4.50,
                'tipo'        => 'postre',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Copa gelat 1 bola (sense gluten)',
                'descripcion' => 'Gelat sense gluten, 1 bola',
                'precio'      => 2.50,
                'tipo'        => 'postre',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Copa gelat 2 boles (sense gluten)',
                'descripcion' => 'Gelat sense gluten, 2 boles',
                'precio'      => 4.50,
                'tipo'        => 'postre',
                'activo'      => true,
            ],

            // CAFÈS
            [
                'nombre'      => 'Cafè',
                'descripcion' => 'Cafè sol',
                'precio'      => 1.20,
                'tipo'        => 'cafe',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Tallat',
                'descripcion' => 'Cafè amb una mica de llet',
                'precio'      => 1.40,
                'tipo'        => 'cafe',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Cafè amb llet',
                'descripcion' => 'Cafè amb llet',
                'precio'      => 1.60,
                'tipo'        => 'cafe',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Cigaló',
                'descripcion' => 'Cafè amb licor',
                'precio'      => 2.20,
                'tipo'        => 'cafe',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Trifàsic',
                'descripcion' => 'Cafè, llet i licor',
                'precio'      => 2.50,
                'tipo'        => 'cafe',
                'activo'      => true,
            ],

            // INFUSIONS
            [
                'nombre'      => 'Roiboos digestiu',
                'descripcion' => 'Infusió roiboos digestiva',
                'precio'      => 2.10,
                'tipo'        => 'infusio',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Infusió Herbal chai',
                'descripcion' => 'Infusió chai',
                'precio'      => 2.10,
                'tipo'        => 'infusio',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Camamilla',
                'descripcion' => 'Infusió de camamilla',
                'precio'      => 2.10,
                'tipo'        => 'infusio',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Maria Lluïsa',
                'descripcion' => 'Infusió de maria lluïsa',
                'precio'      => 2.10,
                'tipo'        => 'infusio',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Menta poleo',
                'descripcion' => 'Infusió de menta poleo',
                'precio'      => 2.10,
                'tipo'        => 'infusio',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Te verd Moruno',
                'descripcion' => 'Te verd Moruno',
                'precio'      => 2.10,
                'tipo'        => 'infusio',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Te verd Sencha',
                'descripcion' => 'Te verd Sencha',
                'precio'      => 2.10,
                'tipo'        => 'infusio',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Te blanc Pai Mutan',
                'descripcion' => 'Te blanc Pai Mutan',
                'precio'      => 2.10,
                'tipo'        => 'infusio',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Te negre Chai pur',
                'descripcion' => 'Te negre Chai',
                'precio'      => 2.10,
                'tipo'        => 'infusio',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Te negre Ceilan',
                'descripcion' => 'Te negre Ceilan',
                'precio'      => 2.10,
                'tipo'        => 'infusio',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Te Kukitxa de 3 anys',
                'descripcion' => 'Te kukitxa de 3 anys',
                'precio'      => 2.10,
                'tipo'        => 'infusio',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Infusió Ayurveda gingebre',
                'descripcion' => 'Infusió Ayurveda de gingebre',
                'precio'      => 2.10,
                'tipo'        => 'infusio',
                'activo'      => true,
            ],

            // BEGUDES
            [
                'nombre'      => 'Canya',
                'descripcion' => 'Cervesa canya',
                'precio'      => 2.00,
                'tipo'        => 'beguda',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Copa',
                'descripcion' => 'Cervesa en copa',
                'precio'      => 2.50,
                'tipo'        => 'beguda',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Mitjana',
                'descripcion' => 'Cervesa mitjana',
                'precio'      => 2.50,
                'tipo'        => 'beguda',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Clara',
                'descripcion' => 'Cervesa amb llimonada',
                'precio'      => 2.70,
                'tipo'        => 'beguda',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Cervesa 0,0',
                'descripcion' => 'Cervesa sense alcohol',
                'precio'      => 2.70,
                'tipo'        => 'beguda',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Cervesa sense gluten',
                'descripcion' => 'Cervesa sense gluten',
                'precio'      => 2.70,
                'tipo'        => 'beguda',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Epidor',
                'descripcion' => 'Cervesa Epidor',
                'precio'      => 2.70,
                'tipo'        => 'beguda',
                'activo'      => true,
            ],
            [
                'nombre'      => '1906',
                'descripcion' => 'Cervesa 1906',
                'precio'      => 2.70,
                'tipo'        => 'beguda',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Birres artesanes',
                'descripcion' => 'Cerveses artesanes',
                'precio'      => 4,
                'tipo'        => 'beguda',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Sidra',
                'descripcion' => 'Sidra',
                'precio'      => 2.50,
                'tipo'        => 'beguda',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Cubates',
                'descripcion' => 'Combinats',
                'precio'      => 8.00,
                'tipo'        => 'beguda',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Chupito',
                'descripcion' => 'Xarrup de licor',
                'precio'      => 2.50,
                'tipo'        => 'beguda',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Refrescs',
                'descripcion' => 'Refrescs variats',
                'precio'      => 2.50,
                'tipo'        => 'beguda',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Vichy',
                'descripcion' => 'Aigua Vichy',
                'precio'      => 2.00,
                'tipo'        => 'beguda',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Aigua petita',
                'descripcion' => 'Aigua 0,5L aprox',
                'precio'      => 1.50,
                'tipo'        => 'beguda',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Aigua gran',
                'descripcion' => 'Aigua 1L aprox',
                'precio'      => 2.00,
                'tipo'        => 'beguda',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Refrescs Ecos',
                'descripcion' => 'Refresc eco gengibre',
                'precio'      => 3.50,
                'tipo'        => 'beguda',
                'activo'      => true,
            ],

            // VINS
            [
                'nombre'      => 'Blanc Verdejo Eco 1/2L',
                'descripcion' => 'Vi blanc Verdejo ecològic, 1/2L',
                'precio'      => 7.00,
                'tipo'        => 'vi',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Blanc Verdejo Eco (copa)',
                'descripcion' => 'Copa de vi blanc Verdejo ecològic',
                'precio'      => 2.50,
                'tipo'        => 'vi',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Negre Syrah Eco 1/2L',
                'descripcion' => 'Vi negre Syrah ecològic, 1/2L',
                'precio'      => 7.00,
                'tipo'        => 'vi',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Negre Syrah Eco (copa)',
                'descripcion' => 'Copa de vi negre Syrah ecològic',
                'precio'      => 2.50,
                'tipo'        => 'vi',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Vi de la setmana (copa)',
                'descripcion' => 'Copa de vi de la setmana',
                'precio'      => 4.50,
                'tipo'        => 'vi',
                'activo'      => true,
            ],
            [
                'nombre'      => 'Sangria',
                'descripcion' => 'Sangria de vi',
                'precio'      => 12.00,
                'tipo'        => 'vi',
                'activo'      => true,
            ],
        ]);

        // 3 EXEMPLE DE COMANDA

        // Creem el pedido i guardem l'id
        $pedidoId = DB::table('pedidos')->insertGetId([
            'user_id'     => $clienteId,    //aquí fem servir el id del client
            'estado'         => 'pendiente',
            'es_para_llevar' => true,
            'total'          => 20.50, //margarida 9 + diavola 11,5
            'fecha_creacion' => now(),
        ]);

        // busquem els ids por si acaso
        $margaridaId = DB::table('productos')
            ->where('nombre', 'La Margarida')
            ->value('id');

        $diavolaId = DB::table('productos')
            ->where('nombre', 'La Diàvola')
            ->value('id');

        // detalls de la comanda
        DB::table('detalles_pedido')->insert([
            'pedido_id'          => $pedidoId,
            'producto_id'        => $margaridaId,
            'cantidad'           => 1,
            'precio_unitario'    => 9.00,
            'subtotal'           => 9.00,
            'fecha_creacion'     => now(),
            'fecha_actualizacion'=> now(),
        ]);

        DB::table('detalles_pedido')->insert([
            'pedido_id'          => $pedidoId,
            'producto_id'        => $diavolaId,
            'cantidad'           => 1,
            'precio_unitario'    => 11.50,
            'subtotal'           => 11.50,
            'fecha_creacion'     => now(),
            'fecha_actualizacion'=> now(),
        ]);



        // --- FACTORIES 
    // alguns usuaris fake
    //Usuario::factory(3)->create();

    // alguns productes fake (encara que ja tens catàleg real)
   // Producto::factory(5)->create();

    // algunes comandes fake (cada una crearà el seu usuari si no l’hi passem)
    //Pedido::factory(3)->create();

    // alguns detalls de comanda fake (crea pedido i producte si cal)
    //DetallePedido::factory(5)->create();
    }

}
