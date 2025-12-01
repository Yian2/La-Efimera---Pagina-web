{{-- resources/views/takeaway/success.blade.php --}}
<x-app-layout :title="'Take Away · Comanda confirmada'">
    <section class="section">
        <div class="section-head">
            <h2 class="script">@lang('Comanda confirmada')</h2>
            <p class="muted">
                @lang('Gràcies per fer la teva comanda. La prepararem al més aviat possible.')
            </p>
        </div>

        <div class="card" style="max-width:900px;margin:0 auto;">
            <h3 style="margin-top:0;">
                @lang('Detall de la comanda') #{{ $pedido->id }}
            </h3>

            <ul class="menu-list">
                @foreach($pedido->detalles as $det)
                    <li>
                        <div class="menu-line">
                            <span class="menu-item">
                                {{ $det->producto->nombre }} × {{ $det->cantidad }}
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

            <p style="margin-top:12px;">
                <strong>@lang('Total'):</strong>
                {{ number_format($pedido->total, 2, ',', '.') }}€
            </p>

            <div style="display:flex; flex-wrap:wrap; gap:10px; margin-top:18px;">
                <a href="{{ route('dashboard') }}" class="cta">
                    @lang('Anar al meu espai')
                </a>

                <a href="{{ route('takeaway.create') }}" class="cta ghost">
                    @lang('Fer una altra comanda')
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
