{{-- resources/views/home.blade.php --}}
@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Quicksand:wght@400;600&family=Yellowtail&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

<x-app-layout :title="'Pizzeria Creativa · La Efímera'">
    

    {{-- CARTA --}}
    <main id="carta" class="section">
        <div class="section-head">
            <h2 class="script">@lang('La nostra carta')</h2>
            <p class="muted">@lang('Base de tomàquet o mozzarella, opcions gourmet, focaccies i més.')</p>
        </div>

        <div class="menu-paper onecol">
            @php
                $orden = [
                    'pica_pica','amanida','pizza_vermella','pizza_blanca','pizza_gourmet',
                    'calzone','focaccia','lasanya','postre','suplement','beguda','vi','infusio','cafe',
                ];

                $labels = [
                    'pizza_vermella' => [__('Les Vermelles'), __('(base de tomàquet + mozzarella)')],
                    'pizza_blanca'   => [__('Les Blanques'), __('(base de mozzarella)')],
                    'suplement'      => [__('Suplements'), ''],
                    'pizza_gourmet'  => [__('Les Gourmets'), ''],
                    'calzone'        => [__('Calzones'), ''],
                    'focaccia'       => [__('Focaccies'), ''],
                    'lasanya'        => [__('Lasanya'), ''],
                    'amanida'        => [__('Amanides'), ''],
                    'pica_pica'      => [__('Pica Pica'), ''],
                    'postre'         => [__('Postres'), ''],
                    'cafe'           => [__('Cafès'), ''],
                    'infusio'        => [__('Infusions'), ''],
                    'beguda'         => [__('Begudes'), ''],
                    'vi'             => [__('Vins'), ''],
                ];

                $duesColumnes = ['pizza_vermella','pizza_blanca','pizza_gourmet','amanida','pica_pica','postre','beguda','infusio','vi'];
            @endphp

            @foreach ($orden as $tipus)
                @if(isset($productos[$tipus]) && $productos[$tipus]->count())
                    @php
                        [$titol, $sub] = $labels[$tipus] ?? [$tipus, ''];
                        $classeCols = in_array($tipus, $duesColumnes, true) ? 'columns-2' : '';
                    @endphp

                    <section class="menu-section">
                        <h3 class="menu-heading">
                            {{ $titol }} @if($sub) <span>{{ $sub }}</span> @endif
                        </h3>

                        @if(in_array($tipus, ['cafe','infusio'], true))
                            <ul class="menu-list simple {{ $classeCols }}">
                                @foreach($productos[$tipus] as $p)
                                    <li>
                                        <span>{{ __($p->nombre) }}</span>
                                        <span class="price">{{ number_format($p->precio, 2, ',', '') }}€</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <ul class="menu-list {{ $classeCols }}">
                                @foreach($productos[$tipus] as $p)
                                    <li>
                                        <div class="menu-line">
                                            <span class="menu-item">{{ __($p->nombre) }}</span>
                                            <span class="dots"></span>
                                            <span class="price">{{ number_format($p->precio, 2, ',', '') }}€</span>
                                        </div>
                                        @if($p->descripcion)
                                            <p class="desc">{{ __($p->descripcion) }}</p>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </section>
                @endif
            @endforeach

            <div class="note">
                @lang('Avisa’ns d’al·lèrgies o intoleràncies. Productes locals i tots els formatges són pasturitzats')
            </div>
        </div>
    </main>

    {{-- TAKE AWAY --}}
    <section id="takeaway" class="section alt">
        <div class="section-head">
            <h2 class="script">@lang('Take Away')</h2>
            <p>@lang('Fes la comanda per telèfon o per la web i recull-la al nostre obrador.')</p>
        </div>
        <div class="card-grid">
            <div class="card">
                <h3>@lang('Horari del forn')</h3>
                <p>@lang('De :d1 18:30–22:30 · i :d2 13:00-22:30', ['d1' => __('dimecres a divendres'), 'd2' => __('diumenge')])</p>
            </div>
            <div class="card">
                <h3>@lang('Telèfon')</h3>
                <p><a class="tel" href="tel:+34934219089">+34934219089</a></p>
            </div>
            <div class="card">
                <h3>@lang('Adreça')</h3>
                <p>@lang('Carretera del Montseny, 34 · 08461 Sant Esteve de Palautordera')</p>
            </div>
        </div>
    </section>

    {{-- CONTACTE --}}
    <section id="contacte" class="section">
        <div class="section-head">
            <h2 class="script">@lang('Contacte')</h2>
            <p>@lang('Reserves, esdeveniments i música en viu. Escriu-nos!')</p>
        </div>

        <div class="contact-wrap">
            <form class="contact-form" action="#" method="post">Gmail: admin@laefimera.test
                </form>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="footer">
        <div class="footer-inner">
            <p>© <span id="y">2025</span> La Efímera · @lang('Pizzeria creativa')</p>
            <p class="muted">IG: @laefimerapizzeria · @lang('All you knead is love.')</p>
        </div>
    </footer>
</x-app-layout>
