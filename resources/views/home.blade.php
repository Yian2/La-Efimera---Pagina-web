{{-- resources/views/home.blade.php --}}
@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Quicksand:wght@400;600&family=Yellowtail&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

<x-app-layout :title="'Pizzeria Creativa · La Efímera'">
    {{-- Si vols capçalera Breeze, descomenta:
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Inici
        </h2>
    </x-slot>
    --}}

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
            <p class="muted">Inspirada en la teva segona imatge: base de tomàquet o mozzarella, opcions gourmet i focaccies. (Afegeix/edita plats i preus al teu gust.)</p>
        </div>

        <div class="menu-paper">
            {{-- Columna 1 --}}
            <article class="menu-col">
                <h3 class="menu-heading">Les Vermelles <span>(base de tomàquet + mozzarella)</span></h3>
                <ul class="menu-list">
                    <li>
                        <div class="menu-line">
                            <span class="menu-item">La Margarita</span>
                            <span class="dots"></span>
                            <span class="price">9,0€</span>
                        </div>
                        <p class="desc">tomàquet, mozzarella, alfàbrega</p>
                    </li>
                    <li>
                        <div class="menu-line"><span class="menu-item">La York</span><span class="dots"></span><span class="price">10,5€</span></div>
                        <p class="desc">pernil dolç</p>
                    </li>
                    <li>
                        <div class="menu-line"><span class="menu-item">La Carbonara</span><span class="dots"></span><span class="price">12,5€</span></div>
                        <p class="desc">bacó, ou, parmesà, pebre</p>
                    </li>
                    <li>
                        <div class="menu-line"><span class="menu-item">La Diàvola</span><span class="dots"></span><span class="price">12,0€</span></div>
                        <p class="desc">tomàquet, mozzarella, salami picant i xili chipotle</p>
                    </li>
                </ul>

                <h3 class="menu-heading">Les Blanques <span>(base de mozzarella)</span></h3>
                <ul class="menu-list">
                    <li>
                        <div class="menu-line"><span class="menu-item">La Black &amp; White</span><span class="dots"></span><span class="price">11,5€</span></div>
                        <p class="desc">gorgonzola, ceba, olives negres</p>
                    </li>
                    <li>
                        <div class="menu-line"><span class="menu-item">La Quatre Formaggi</span><span class="dots"></span><span class="price">13,0€</span></div>
                        <p class="desc">mozza, gorgonzola, taleggio, pecorino</p>
                    </li>
                </ul>

                <h3 class="menu-heading">Suplements</h3>
                <ul class="menu-tags">
                    <li>Sense gluten +2,5€</li>
                    <li>Ou +1,0€</li>
                    <li>Chipotle +0,5€</li>
                    <li>Pa de focaccia +2,5€</li>
                </ul>
            </article>

            {{-- Columna 2 --}}
            <article class="menu-col">
                <h3 class="menu-heading">Les Gourmets</h3>
                <ul class="menu-list">
                    <li>
                        <div class="menu-line"><span class="menu-item">La Nostra</span><span class="dots"></span><span class="price">16,0€</span></div>
                        <p class="desc">salsa de tomàquet rostit, mozza, carbassó rostit, xampinyó fresc, ou, parmesà</p>
                    </li>
                    <li>
                        <div class="menu-line"><span class="menu-item">L’Asparragada</span><span class="dots"></span><span class="price">15,5€</span></div>
                        <p class="desc">tomàquet, prosc. bufarra, ricotta, carbassó, ceba caramel·litzada</p>
                    </li>
                    <li>
                        <div class="menu-line"><span class="menu-item">Horney</span><span class="dots"></span><span class="price">15,5€</span></div>
                        <p class="desc">mozza, albergínia rostida, tomàquet sec, parmesà, pesto</p>
                    </li>
                </ul>

                <h3 class="menu-heading">Calzones</h3>
                <ul class="menu-list">
                    <li>
                        <div class="menu-line"><span class="menu-item">El Scamorza</span><span class="dots"></span><span class="price">14,0€</span></div>
                        <p class="desc">mozzarella, pernil dolç, scamorza, ou</p>
                    </li>
                    <li>
                        <div class="menu-line"><span class="menu-item">El Ricotta</span><span class="dots"></span><span class="price">13,0€</span></div>
                        <p class="desc">mozza, ricotta, tomàquet sec, pesto</p>
                    </li>
                </ul>
            </article>

            {{-- Columna 3 --}}
            <article class="menu-col">
                <h3 class="menu-heading">Postres</h3>
                <ul class="menu-list">
                    <li><div class="menu-line"><span class="menu-item">Tiramisù</span><span class="dots"></span><span class="price">5,0€</span></div></li>
                    <li><div class="menu-line"><span class="menu-item">Brownie amb gelat</span><span class="dots"></span><span class="price">6,5€</span></div></li>
                    <li><div class="menu-line"><span class="menu-item">Panna cotta</span><span class="dots"></span><span class="price">4,5€</span></div></li>
                </ul>

                <h3 class="menu-heading">Cafès</h3>
                <ul class="menu-list simple">
                    <li><span>Cafè</span> <span class="price">1,2€</span></li>
                    <li><span>Tallat</span> <span class="price">1,4€</span></li>
                    <li><span>Trifàsic</span> <span class="price">2,5€</span></li>
                </ul>

                <h3 class="menu-heading">Infusions</h3>
                <ul class="menu-tags">
                    <li>Rooibos</li><li>Camamilla</li><li>Menta</li>
                    <li>Te verd</li><li>Te negre Ceilan</li><li>Te Kukicha</li>
                </ul>

                <div class="note">
                    * Avisa’ns d’al·lèrgies o intoleràncies. Productes locals i massa de fermentació lenta.
                </div>
            </article>
        </div>
    </main>

    {{-- TAKE AWAY --}}
    <section id="takeaway" class="section alt">
        <div class="section-head">
            <h2 class="script">Take Away</h2>
            <p>Fes la comanda per telèfon i recull-la al nostre obrador. Descomptes en comandes grans.</p>
        </div>

        <div class="card-grid">
            <div class="card">
                <h3>Horari</h3>
                <p>De <strong>dc a dv</strong> 19:30–22:30 · <strong>ds i dg</strong> 13:00–15:30 / 19:30–23:00</p>
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
