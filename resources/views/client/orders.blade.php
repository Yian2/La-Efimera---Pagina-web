<x-app-layout>
    <section class="section">
        <!-- Capçalera de la pàgina: títol i descripció -->
        <div class="section-head">
            <h2 class="script">@lang('Historial de comandes')</h2>
            <p class="muted">
                @lang('Revisa què vas demanar i repeteix fàcilment.')
            </p>
        </div>

        <!-- Si no hi ha comandes, mostrem missatge -->
        @if($orders->isEmpty())
            <div class="card" style="max-width:1100px;margin:0 auto;">
                <p class="muted">@lang('Encara no tens comandes.')</p>
            </div>
        @else
            <!-- Contenidor del llistat de comandes -->
            <div style="max-width:1100px;margin:0 auto;">
                @foreach($orders as $order)
                    <!-- Targeta d'una comanda -->
                    <div class="card" style="margin-bottom:16px;">
                        {{-- Capçalera de la comanda: id, data i estat --}}
                        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:6px;">
                            <div>
                                <h3 style="margin:0;">
                                    @lang('Comanda') #{{ $order->id }}
                                </h3>
                                <!-- Data de creació formatejada -->
                                <p class="muted" style="margin:2px 0 0;">
                                    {{ $order->fecha_creacion->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            {{-- Estat en format badge (classe segons estat) --}}
                            <span class="status-badge status-{{ $order->estado }}">
                                {{ __($order->estado) }}
                            </span>
                        </div>

                        {{-- Línies de productes de la comanda --}}
                        @if($order->detalles && $order->detalles->count())
                            <ul class="menu-list" style="margin-top:10px;">
                                @foreach($order->detalles as $det)
                                    <li>
                                        <!-- Línia: producte, quantitat i subtotal -->
                                        <div class="menu-line">
                                            <span class="menu-item">
                                                {{ $det->producto->nombre ?? 'Producte' }}
                                                × {{ $det->cantidad }}
                                            </span>
                                            <span class="dots"></span>
                                            <span class="price">
                                                {{ number_format($det->subtotal, 2, ',', '.') }}€
                                            </span>
                                        </div>

                                        <!-- Nota opcional del detall -->
                                        @if(!empty($det->nota))
                                            <p class="desc">
                                                <em>@lang('Nota'):</em> {{ $det->nota }}
                                            </p>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <!-- Total final de la comanda -->
                        <p style="margin-top:10px;">
                            <strong>@lang('Total'):</strong>
                            {{ number_format($order->total, 2, ',', '.') }}€
                        </p>
                    </div>
                @endforeach

                <!-- Paginació: enllaços de pàgina -->
                <div style="margin-top:16px;">
                    {{ $orders->links() }}
                </div>
            </div>
        @endif
    </section>
</x-app-layout>
