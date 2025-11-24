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
                <a class="cta ghost" href="{{ route('client.orders') }}" target="_blank" rel="noopener">Veure historial</a>
            </div>

            <div class="card">
                <h3>Estat de la meva comanda</h3>
                <p>Segueix la preparació i l’estat d’entrega.</p>
                <a class="cta ghost" href="{{ route('client.track') }}" target="_blank" rel="noopener">Veure estat</a>
            </div>

            <div class="card">
                <h3>Punts & Recompenses</h3>
                <p>Acumules 1 punt per 10€ gastat: Tiramisù/Panna cotta/Cheesecake.</p>
                <div class="progress">
                    <div class="bar" style="width: {{ $progress }}%"></div>
                </div>
                <p class="muted small">Total gastat: {{ number_format($gastat,2,',','.') }}€ · Progrés: {{ $progress }}%</p>
                <a class="cta ghost" href="{{ route('client.loyalty') }}" target="_blank" rel="noopener">Detall de punts</a>
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
    </section>
</x-app-layout>
