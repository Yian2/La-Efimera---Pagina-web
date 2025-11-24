<x-app-layout>
    <section class="section">
        <div class="section-head">
            <h2 class="script">Historial de comandes</h2>
            <p class="muted">Repesca comandes anteriors i repeteix el que t’agrada.</p>
        </div>

        @forelse($orders as $o)
            <div class="card" style="max-width:1100px;margin:0 auto 12px;">
                <h3>Comanda #{{ $o->id }} — {{ ucfirst($o->estado) }}</h3>
                <ul class="menu-list">
                    @foreach($o->detalles as $d)
                        <li>
                            <div class="menu-line">
                                <span class="menu-item">{{ $d->producto->nombre }} × {{ $d->cantidad }}</span>
                                <span class="dots"></span>
                                <span class="price">{{ number_format($d->subtotal,2,',','.') }}€</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <p><strong>Total:</strong> {{ number_format($o->total,2,',','.') }}€</p>
            </div>
        @empty
            <p class="muted" style="text-align:center;">Encara no tens comandes.</p>
        @endforelse

        <div style="max-width:1100px;margin:12px auto;">{{ $orders->links() }}</div>
    </section>
</x-app-layout>
