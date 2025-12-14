
{{-- resources/views/takeaway/review.blade.php --}}
<x-app-layout :title="'Take Away · Revisa la comanda'">
    <section class="section">
        <div class="section-head">
            <h2 class="script">@lang('Revisa la teva comanda')</h2>
            <p class="muted">
                @lang('Comprova els productes abans de confirmar.')
            </p>
        </div>

        <div class="card" style="max-width:900px;margin:0 auto;">
            <p>
                <strong>@lang('Hora de recollida'):</strong> {{ $pickupTime }}
            </p>

            <ul class="menu-list">
                @foreach($detalls as $idx => $d)
                    <li>
                        <div class="menu-line">
                            <span class="menu-item">
                                {{ $d['nombre'] }} × {{ $d['cantidad'] }}
                            </span>
                            <span class="dots"></span>
                            <span class="price">
                                {{ number_format($d['subtotal'], 2, ',', '.') }}€
                            </span>
                        </div>

                        @if(!empty($d['nota']))
                            <p class="desc">
                                <em>@lang('Nota'):</em> {{ $d['nota'] }}
                            </p>
                        @endif
                    </li>
                @endforeach
            </ul>

            <p style="margin-top:12px;">
                <strong>@lang('Total'):</strong>
                {{ number_format($total, 2, ',', '.') }}€
            </p>

            {{-- Formulari ocult per CONFIRMAR (envia les mateixes dades a store) --}}
            <form method="POST" action="{{ route('takeaway.store') }}" id="confirm-form">
                @csrf
                <input type="hidden" name="pickup_time" value="{{ $pickupTime }}">

                @foreach($detalls as $i => $d)
                    <input type="hidden" name="lines[{{ $i }}][producto_id]" value="{{ $d['producto_id'] }}">
                    <input type="hidden" name="lines[{{ $i }}][cantidad]" value="{{ $d['cantidad'] }}">
                    <input type="hidden" name="lines[{{ $i }}][nota]" value="{{ $d['nota'] }}">
                @endforeach

                <div style="display:flex; flex-wrap:wrap; gap:10px; margin-top:18px;">
                    {{-- EDITAR: tornar al formulari (manté les dades al navegador) --}}
                    <button type="button" class="cta ghost" onclick="history.back()">
                        @lang('Editar comanda')
                    </button>

                    {{-- CONFIRMAR: crea el pedido i va a success --}}
                    <button type="submit" class="cta">
                        @lang('Confirmar comanda')
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>