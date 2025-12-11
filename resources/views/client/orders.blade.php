{{-- resources/views/client/orders.blade.php --}}
<x-app-layout>
    <section class="section">
        <div class="section-head">
            <h2 class="script">@lang('Historial de comandes')</h2>
            <p class="muted">
                @lang('Revisa què vas demanar i repeteix fàcilment.')
            </p>
        </div>

       

        @if($orders->isEmpty())
            <div class="card" style="max-width:1100px;margin:0 auto;">
                <p class="muted">@lang('Encara no tens comandes.')</p>
            </div>
        @else
            <div style="max-width:1100px;margin:0 auto;">
                @foreach($orders as $order)
                    <div class="card" style="margin-bottom:16px;">
                        {{-- Capçalera de la comanda --}}
                        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:6px;">
                            <div>
                                <h3 style="margin:0;">
                                    @lang('Comanda') #{{ $order->id }}
                                </h3>
                                <p class="muted" style="margin:2px 0 0;">
                                    {{ $order->fecha_creacion->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            {{-- Estat estil “badge” --}}
                            <span class="status-badge status-{{ $order->estado }}">
                                {{ __($order->estado) }}
                            </span>
                        </div>

                        {{-- Línies de productes --}}
                        @if($order->detalles && $order->detalles->count())
                            <ul class="menu-list" style="margin-top:10px;">
                                @foreach($order->detalles as $det)
                                    <li>
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

                                        @if(!empty($det->nota))
                                            <p class="desc">
                                                <em>@lang('Nota'):</em> {{ $det->nota }}
                                            </p>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        {{-- Total de la comanda --}}
                        <p style="margin-top:10px;">
                            <strong>@lang('Total'):</strong>
                            {{ number_format($order->total, 2, ',', '.') }}€
                        </p>
                    </div>
                @endforeach

                {{-- Paginació --}}
                <div style="margin-top:16px;">
                    {{ $orders->links() }}
                </div>
            </div>
        @endif
    </section>
</x-app-layout>
