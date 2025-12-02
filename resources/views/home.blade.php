{{-- resources/views/home.blade.php --}}
@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Quicksand:wght@400;600&family=Yellowtail&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

<x-app-layout :title="'Pizzeria Creativa · La Efímera'">
    {{-- NAVBAR --}}
    <header class="navbar">
        <div class="nav-inner">
            <a href="{{ route('home') }}" class="brand" aria-label="@lang('Inici')">
                <span class="brand-script">La Efímera</span>
                <span class="brand-sub">@lang('pizzeria creativa')</span>
            </a>

            <nav class="nav">
                <a href="#carta">@lang('Carta')</a>
                <a href="{{ route('takeaway.create') }}">@lang('Take Away')</a>
                <a href="#contacte">@lang('Contacte')</a>
                <a href="{{ route('acces') }}" target="_blank" rel="noopener">@lang('Accés')</a>

                {{--  Desplegable d'idioma --}}
                <div class="lang-dropdown">
                    <button class="lang-btn" aria-haspopup="true" aria-expanded="false">
                        {{ strtoupper(app()->getLocale()) }}
                        <svg width="12" height="12" viewBox="0 0 20 20" aria-hidden="true"><path d="M5 7l5 6 5-6H5z" fill="currentColor"/></svg>
                    </button>
                    <div class="lang-menu">
                        <a href="{{ route('lang.switch','ca') }}">Català</a>
                        <a href="{{ route('lang.switch','es') }}">Español</a>
                        <a href="{{ route('lang.switch','en') }}">English</a>
                        <a href="{{ route('lang.switch','fr') }}">Français</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    {{-- HERO --}}
    <section class="hero">
        <div class="hero-inner">
            <h1>@lang("Pizzes artesanes · Obra d'autor")</h1>
            <p>@lang('Ingredients frescos, massa amb fermentació lenta i un toc artístic. Vine al nostre obrador o demana per emportar.')</p>
            <a class="cta" href="#carta">@lang('Veure la carta')</a>
        </div>
    </section>

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
            <form class="contact-form" action="#" method="post">
                <label>@lang('Nom')
                    <input type="text" name="name" required>
                </label>
                <label>@lang('Correu')
                    <input type="email" name="email" required>
                </label>
                <label>@lang('Missatge')
                    <textarea name="message" rows="5" required></textarea>
                </label>
                <button type="submit" disabled title="@lang('El JS el posaràs tu')">@lang('Enviar')</button>
                <small class="muted">@lang('(* El botó queda deshabilitat, afegeix JS per gestionar l’enviament.)')</small>
            </form>

            <aside class="mapcard">
                <h3>@lang('On som')</h3>
                <p>@lang('Carretera del Montseny, 34')<br>08461 Sant Esteve de Palautordera</p>
                <a class="cta ghost" target="_blank" rel="noopener" href="https://www.google.com/maps/place/La+Ef%C3%ADmera+-+Pizzer%C3%ADa+Bar+Obrador/@41.7035991,2.4353139,17z/data=!3m1!4b1!4m6!3m5!1s0x12a4cdbb7782ec9b:0x7c2ba1f695fb84c3!8m2!3d41.7035991!4d2.4353139!16s%2Fg%2F11fm9tfl9d?entry=ttu&g_ep=EgoyMDI1MTEyMy4xIKXMDSoASAFQAw%3D%3D">@lang('Obrir al Maps')</a>
            </aside>
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
