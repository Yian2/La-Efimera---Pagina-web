<x-app-layout :title="'Take Away · Comanda confirmada'">
    <section class="section">
        <div class="section-head">
            <h2 class="script">@lang('Comanda confirmada')</h2>
            <p class="muted">
                @lang('Gràcies! Hem rebut la teva comanda per emportar.')
            </p>
        </div>

        <div class="card" style="max-width:700px;margin:0 auto;text-align:left;">
            <p>
                @lang('Número de comanda'):
                <strong>#{{ $pedido->id }}</strong>
            </p>

            @if(!empty($pedido->pickup_time))
                <p>
                    @lang('Hora de recollida prevista'):
                    <strong>{{ $pedido->pickup_time }}</strong>
                </p>
            @endif

            <p>
                @lang('Import total'):
                <strong>{{ number_format($pedido->total, 2, ',', '.') }}€</strong>
            </p>

            <p class="muted" style="margin-top:12px;">
                @lang('Si hi ha qualsevol incidència, el nostre equip es posarà en contacte amb tu.')
            </p>

            <div style="margin-top:20px;display:flex;flex-wrap:wrap;gap:10px;">
                <a href="{{ route('client.dashboard') }}" class="cta">
                    @lang('Anar al meu espai')
                </a>

                <a href="{{ route('home') }}" class="cta ghost">
                    @lang('Tornar a l’inici')
                </a>
            </div>
        </div>
    </section>
</x-app-layout>
