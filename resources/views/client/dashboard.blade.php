<x-app-layout>
    <section class="section">
        <div class="section-head">
            <h2 class="script">El meu espai</h2>
            <p class="muted">Hola, {{ $user->nombre ?? $user->name }}. Gestiona les teves comandes i avantatges.</p>
        </div>

        {{-- Accions de pàgina (dreta) --}}
        <div class="page-actions">
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="cta ghost danger">Tancar sessió</button>
            </form>
        </div>

        <div class="card-grid">
            <div class="card">
                <h3>Demanar per emportar</h3>
                <p>Fes la teva comanda i vine a recollir-la.</p>
                <a class="cta" href="#carta">Inicia la comanda</a>
            </div>

            <div class="card">
                <h3>Historial de comandes</h3>
                <p>Revisa què vas demanar i repeteix fàcilment.</p>
                <a class="cta ghost" href="{{ route('client.orders') }}">Veure historial</a>
            </div>

            <div class="card">
                <h3>Estat de la meva comanda</h3>
                <p>Segueix la preparació i l’estat d’entrega.</p>
                <a class="cta ghost" href="{{ route('client.track') }}">Veure estat</a>
            </div>

            
        </div>

        @if($ultimaComanda)
            <div class="card" style="max-width:1100px;margin:18px auto 0;">
                <h3>Última comanda #{{ $ultimaComanda->id }} ({{ $ultimaComanda->estado }})</h3>
                <ul class="menu-list">
                    @foreach($ultimaComanda->detalles as $d)
                        <li>
                            <div class="menu-line">
                                <span class="menu-item">{{ $d->producto->nombre }} × {{ $d->cantidad }}</span>
                                <span class="dots"></span>
                                <span class="price">{{ number_format($d->subtotal,2,',','.') }}€</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <p><strong>Total:</strong> {{ number_format($ultimaComanda->total,2,',','.') }}€</p>
            </div>
        @endif

        {{-- ======= DETALL DE PUNTS (integrat abaix del dashboard) ======= --}}
        <div class="section-head" style="margin-top:28px;">
            <h2 class="script">Punts i recompenses</h2>
            <p class="muted"> Tiramisù, Panna cotta o Cheesecake </p>
        </div>

        <div class="card" style="max-width:900px;margin:0 auto;">
            <p>Total punts: <strong>{{ number_format($gastat,2,',','.') }}</strong></p>
            <div class="progress">
                <div class="bar" style="width: {{ $progress }}%"></div>
            </div>
            <p class="muted small">Progrés actual: {{ $progress }}% cap a la propera recompensa.</p>
        </div>
        {{-- =============================================================== --}}
    </section>
</x-app-layout>
