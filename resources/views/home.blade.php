{{-- resources/views/home.blade.php --}}
@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Quicksand:wght@400;600&family=Yellowtail&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

<x-app-layout :title="'Pizzeria Creativa · La Efímera'">
    {{-- NAVBAR --}}
    <header class="navbar">
        <div class="nav-inner">
            <a href="{{ route('home') }}" class="brand" aria-label="Inici">
                <span class="brand-script">La Efímera</span>
                <span class="brand-sub">pizzeria creativa</span>
            </a>
            <nav class="nav">
                <a href="#carta">Carta</a>
                <a href="#takeaway">Take Away</a>
                <a href="#contacte">Contacte</a>
                <a href="{{ route('acces') }}" target="_blank" rel="noopener">Accés</a>
            </nav>

        </div>
    </header>

    {{-- HERO --}}
    <section class="hero">
        <div class="hero-inner">
            <h1>Pizzes artesanes · Obra d’autor</h1>
            <p>Ingredients frescos, massa amb fermentació lenta i un toc artístic. Vine al nostre obrador o demana per emportar.</p>
            <a class="cta" href="#carta">Veure la carta</a>
        </div>
    </section>

    

    {{-- CARTA --}}
    <main id="carta" class="section">
        <div class="section-head">
            <h2 class="script">La nostra carta</h2>
            <p class="muted">Base de tomàquet o mozzarella, opcions gourmet, focaccies i més.</p>
        </div>

        <div class="menu-paper onecol">
            @php
                // Ordre de categories (tal com m'has demanat)
                $orden = [
                    'pica_pica',
                    'amanida',
                    'pizza_vermella',
                    'pizza_blanca',
                    'pizza_gourmet',
                    'calzone',
                    'focaccia',
                    'lasanya',
                    'postre',
                    'suplement',
                    'beguda',
                    'vi',
                    'infusio', // (l'he posat just abans de cafès; treu-la o mou-la si vols)
                    'cafe',
                ];

                // Labels bonics (si ja els tens, pots eliminar això)
                $labels = [
                    'pizza_vermella' => ['Les Vermelles', '(base de tomàquet + mozzarella)'],
                    'pizza_blanca'   => ['Les Blanques', '(base de mozzarella)'],
                    'suplement'      => ['Suplements',''],
                    'pizza_gourmet'  => ['Les Gourmets',''],
                    'calzone'        => ['Calzones',''],
                    'focaccia'       => ['Focaccies',''],
                    'lasanya'        => ['Lasanya',''],
                    'amanida'        => ['Amanides',''],
                    'pica_pica'      => ['Pica Pica',''],
                    'postre'         => ['Postres',''],
                    'cafe'           => ['Cafès',''],
                    'infusio'        => ['Infusions',''],
                    'beguda'         => ['Begudes',''],
                    'vi'             => ['Vins',''],
                ];

                // Categories que vols en 2 columnes
                $duesColumnes = ['pizza_vermella','pizza_blanca','pizza_gourmet','amanida','pica_pica','postre','beguda','infusio','vi'];
            @endphp

            @foreach ($orden as $tipus)
                @if(isset($productos[$tipus]) && $productos[$tipus]->count())
                    @php
                        [$titol, $sub] = $labels[$tipus] ?? [$tipus, ''];
                        $classeCols = in_array($tipus, $duesColumnes) ? 'columns-2' : '';
                    @endphp

                    <section class="menu-section">
                        <h3 class="menu-heading">
                            {{ $titol }} @if($sub) <span>{{ $sub }}</span> @endif
                        </h3>

                        @if(in_array($tipus, ['cafe','infusio']))
                            <ul class="menu-list simple {{ $classeCols }}">
                                @foreach($productos[$tipus] as $p)
                                    <li>
                                        <span>{{ $p->nombre }}</span>
                                        <span class="price">{{ number_format($p->precio, 2, ',', '') }}€</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <ul class="menu-list {{ $classeCols }}">
                                @foreach($productos[$tipus] as $p)
                                    <li>
                                        <div class="menu-line">
                                            <span class="menu-item">{{ $p->nombre }}</span>
                                            <span class="dots"></span>
                                            <span class="price">{{ number_format($p->precio, 2, ',', '') }}€</span>
                                        </div>
                                        @if($p->descripcion)
                                            <p class="desc">{{ $p->descripcion }}</p>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </section>
                @endif
            @endforeach

            <div class="note">
                 Avisa’ns d’al·lèrgies o intoleràncies. Productes locals i tots els formatges són pasturitzats
            </div>
        </div>
    </main>

    {{-- TAKE AWAY --}}
    <section id="takeaway" class="section alt">
        <div class="section-head">
            <h2 class="script">Take Away</h2>
            <p>Fes la comanda per telèfon i recull-la al nostre obrador.</p>
        </div>
        <div class="card-grid">
            <div class="card">
                <h3>Horari del forn</h3>
                <p>De <strong>dimecres a divendres</strong> 18:30–22:30 · <strong>i diumenge</strong> 13:00-22:30</p>
            </div>
            <div class="card">
                <h3>Telèfon</h3>
                <p><a class="tel" href="tel:+34934219089">+34934219089</a></p>
            </div>
            <div class="card">
                <h3>Adreça</h3>
                <p>Carretera del Montseny, 34 · 08461 Sant Esteve de Palautordera</p>
            </div>
        </div>
    </section>

    {{-- CONTACTE --}}
    <section id="contacte" class="section">
        <div class="section-head">
            <h2 class="script">Contacte</h2>
            <p>Reserves, esdeveniments i música en viu. Escriu-nos!</p>
        </div>

        <div class="contact-wrap">
            <form class="contact-form" action="#" method="post">
                {{-- @csrf si un dia envies el formulari --}}
                <label>Nom
                    <input type="text" name="name" required>
                </label>
                <label>Correu
                    <input type="email" name="email" required>
                </label>
                <label>Missatge
                    <textarea name="message" rows="5" required></textarea>
                </label>
                <button type="submit" disabled title="El JS el posaràs tu 😉">Enviar</button>
                <small class="muted">(* El botó queda deshabilitat, afegeix JS per gestionar l’enviament.)</small>
            </form>

            <aside class="mapcard">
                <h3>On som</h3>
                <p>Carretera del Montseny, 34<br>08461 Sant Esteve de Palautordera</p>
                <a class="cta ghost" target="_blank" rel="noopener" href="https://maps.google.com">Obrir al Maps</a>
            </aside>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="footer">
        <div class="footer-inner">
            <p>© <span id="y">2025</span> La Efímera · Pizzeria creativa</p>
            <p class="muted">IG: @laefimerapizzeria · All you knead is love.</p>
        </div>
    </footer>
</x-app-layout>
