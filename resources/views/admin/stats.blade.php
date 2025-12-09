<x-app-layout :title="__('Estadístiques de vendes')">
    <section class="section">
        <div class="section-head">
            <h2 class="script">@lang('Gràfics de vendes')</h2>
            <p class="muted">
                @lang('Resum de vendes totals i distribució per estat de les comandes.')
            </p>
        </div>

        {{-- Targetes resum --}}
        <div class="card-grid" style="max-width:900px;margin:0 auto 24px;">
            <div class="card">
                <h3>@lang('Total vendes acumulades')</h3>
                <p style="font-size:1.1rem;margin-top:8px;">
                    <strong>{{ number_format($totalSales, 2, ',', '.') }} €</strong>
                </p>
            </div>

            <div class="card">
                <h3>@lang('Nombre total de comandes')</h3>
                <p style="font-size:1.1rem;margin-top:8px;">
                    <strong>{{ $ordersCount }}</strong>
                </p>
            </div>
        </div>

        {{-- Distribució per estat --}}
        <div class="card" style="max-width:900px;margin:0 auto;">
            <h3 style="margin-top:0;">@lang('Vendes per estat de comanda')</h3>
            <p class="muted small">
                @lang('Cada barra representa el total de vendes per estat (pendent, en preparació, entregada, etc.).')
            </p>

            <div style="margin-top:12px;display:flex;flex-direction:column;gap:8px;">
                @forelse ($byStatus as $row)
                    <div>
                        <div style="display:flex;justify-content:space-between;font-size:13px;">
                            <span>{{ __($row->estado ?? '—') }}</span>
                            <span>
                                {{ $row->count }} · {{ number_format($row->total, 2, ',', '.') }} €
                            </span>
                        </div>
                        <div style="background:#1f2933;border-radius:999px;height:8px;overflow:hidden;margin-top:3px;">
                            <div style="
                                height:100%;
                                width: {{ $row->percent }}%;
                                background: linear-gradient(90deg,#d9a441,#facc6b);
                            "></div>
                        </div>
                    </div>
                @empty
                    <p class="muted">@lang('Encara no hi ha dades de vendes.')</p>
                @endforelse
            </div>
        </div>
    </section>
</x-app-layout>
