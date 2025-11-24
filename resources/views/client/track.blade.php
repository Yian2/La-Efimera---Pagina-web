<x-app-layout>
    <section class="section">
        <div class="section-head">
            <h2 class="script">Estat de la comanda</h2>
            <p class="muted">Segueix en temps real quan la teva comanda estigui llesta.</p>
        </div>

        @if($order)
            <div class="card" style="max-width:900px;margin:0 auto;">
                <h3>Comanda #{{ $order->id }}</h3>
                <p><strong>Estat:</strong> {{ ucfirst($order->estado) }}</p>

                {{-- Barra d’estats simple --}}
                @php
                    $steps = ['pendiente','preparando','listo','entregado'];
                    $currentIndex = array_search($order->estado, $steps);
                @endphp
                <div class="stepper">
                    @foreach($steps as $i => $label)
                        <div class="step {{ $i <= $currentIndex ? 'done' : '' }}">
                            <span>{{ ucfirst($label) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p class="muted" style="text-align:center;">No hem trobat cap comanda recent.</p>
        @endif
    </section>
</x-app-layout>
