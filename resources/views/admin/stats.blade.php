<x-app-layout :title="__('Gràfics de vendes')">
    <section class="section">
        <div class="section-head">
            <h2 class="script">@lang('Gràfics de vendes')</h2>
            <p class="muted">
                @lang('Resum de vendes totals, distribució per estat i productes més venuts amb filtres de temps.')
            </p>
        </div>

        {{-- FILTRES AVANÇATS --}}
        <div class="card" style="max-width:1100px;margin:0 auto 24px auto;">
            <form method="GET" class="admin-filters">
                <div style="display:flex;flex-wrap:wrap;gap:16px;align-items:flex-end;">

                    {{-- Rang de dates --}}
                    <div style="flex:1 1 180px;min-width:180px;">
                        <label for="from" style="display:block;font-size:12px;margin-bottom:4px;">
                            @lang('Data Inici')
                        </label>
                        <input
                            type="date"
                            name="from"
                            id="from"
                            value="{{ $from }}"
                            style="width:100%;padding:6px 8px;border-radius:6px;border:1px solid rgba(255,255,255,0.15);background:rgba(0,0,0,0.25);color:#fff;"
                        >
                    </div>

                    <div style="flex:1 1 180px;min-width:180px;">
                        <label for="to" style="display:block;font-size:12px;margin-bottom:4px;">
                            @lang('Data Final')
                        </label>
                        <input
                            type="date"
                            name="to"
                            id="to"
                            value="{{ $to }}"
                            style="width:100%;padding:6px 8px;border-radius:6px;border:1px solid rgba(255,255,255,0.15);background:rgba(0,0,0,0.25);color:#fff;"
                        >
                    </div>

                    {{-- Producte per filtrar el rànquing --}}
                    <div style="flex:1 1 200px;min-width:200px;">
                        <label for="product_id" style="display:block;font-size:12px;margin-bottom:4px;">
                            @lang('Filtrar rànquing per producte')
                        </label>
                        <select
                            name="product_id"
                            id="product_id"
                            style="width:100%;padding:6px 8px;border-radius:6px;border:1px solid rgba(255,255,255,0.15);background:rgba(0,0,0,0.25);color:#fff;"
                        >
                            <option value="">@lang('-- Tots els productes --')</option>
                            @foreach($allProducts as $product)
                                <option value="{{ $product->id }}" @selected($productId == $product->id)>
                                    {{ $product->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Botons --}}
                    <div style="flex:0 0 auto;display:flex;gap:8px;margin-left:auto;">
                        <button type="submit" class="cta" style="padding:8px 14px;font-size:13px;">
                            @lang('Aplicar Filtres')
                        </button>
                        <a href="{{ route('admin.stats.index') }}"
                            class="cta ghost"
                            style="padding:8px 14px;font-size:13px;display:inline-flex;align-items:center;justify-content:center;">
                            @lang('Netejar')
                        </a>
                    </div>
                </div>
            </form>
        </div>


        {{-- RESUM GENERAL AMB FILTRES APLICATS --}}
        <div style="display:flex;gap:20px;max-width:1100px;margin:0 auto 32px auto;">
            <div class="card" style="flex:1;padding:16px;">
                <p class="muted" style="margin-bottom:4px;">@lang('Vendes Totals Acumulades')</p>
                <h3 style="font-size:2em;margin:0;">
                    {{ number_format($totalSales, 2, ',', '.') }} €
                </h3>
                <p class="muted" style="font-size:12px;margin-top:4px;">
                    @if($from || $to)
                        @lang('Segons els filtres de data aplicats.')
                    @else
                        @lang('Històric total.')
                    @endif
                </p>
            </div>
            <div class="card" style="flex:1;padding:16px;">
                <p class="muted" style="margin-bottom:4px;">@lang('Nombre Total de Comandes')</p>
                <h3 style="font-size:2em;margin:0;">
                    {{ $totalOrders }}
                </h3>
                 <p class="muted" style="font-size:12px;margin-top:4px;">
                    @lang('Comandes amb filtres aplicats.')
                </p>
            </div>
        </div>


        {{-- 3. RÀNQUING DE PRODUCTES MÉS VENUTS --}}
        <section style="max-width:1100px;margin:32px auto 0 auto;">
            <div class="section-head">
                <h3 class="script">@lang('Top 10 Productes Més Venuts')</h3>
                <p class="muted">
                    @lang('Ranking dels productes amb més unitats venudes dins el període filtrat.')
                </p>
            </div>

            <div class="card" style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:14px;">
                    <thead>
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.1);">
                            <th style="text-align:left;padding:8px 4px;width:50px;">#</th>
                            <th style="text-align:left;padding:8px 4px;">@lang('Producte')</th>
                            <th style="text-align:right;padding:8px 4px;">@lang('Unitats Venudes')</th>
                            <th style="text-align:right;padding:8px 4px;">@lang('Import Total')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $index => $row)
                            <tr style="border-bottom:1px dashed rgba(255,255,255,0.06);">
                                <td style="padding:6px 4px;font-weight:bold;">
                                    {{ $index + 1 }}
                                </td>
                                <td style="padding:6px 4px;">
                                    {{ optional($row->producto)->nombre ?? '— Producte Desconegut —' }}
                                </td>
                                <td style="padding:6px 4px;text-align:right;">
                                    {{ $row->total_qty }}
                                </td>
                                <td style="padding:6px 4px;text-align:right;">
                                    {{ number_format($row->total_importe, 2, ',', '.') }} €
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding:8px 4px;text-align:center;">
                                    @lang('No hi ha dades de vendes en aquest període/producte.')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>


        {{-- VENDES PER ESTAT (BARRES) --}}
        <section style="max-width:1100px;margin:32px auto 0 auto;">
            <div class="section-head">
                <h3 class="script">@lang('Vendes per estat de comanda')</h3>
                <p class="muted">
                    @lang('Cada barra representa el total de vendes per estat (pendent, en preparació, entregada, etc.) dins el període filtrat.')
                </p>
            </div>

            <div class="card" style="padding:24px;">
                @php
                    $maxTotal = $salesByStatus->max('total') ?: 1;
                @endphp
                @forelse($salesByStatus as $status)
                    <div style="margin-bottom:12px;">
                        <div style="display:flex;justify-content:space-between;font-size:14px;margin-bottom:4px;">
                            <strong>{{ __($status->estado) }}</strong>
                            <span>
                                {{ $status->count }} Comandes ·
                                <strong>{{ number_format($status->total, 2, ',', '.') }} €</strong>
                            </span>
                        </div>
                        <div style="background:rgba(255,255,255,0.1);border-radius:4px;height:10px;">
                            <div style="
                                background:#4CAF50; /* Un color més viu */
                                width:{{ ($status->total / $maxTotal) * 100 }}%;
                                height:100%;
                                border-radius:4px;
                            "></div>
                        </div>
                    </div>
                @empty
                    <p class="muted" style="text-align:center;">
                        @lang('No hi ha comandes amb estats en el període seleccionat.')
                    </p>
                @endforelse
            </div>
        </section>

    </section>
</x-app-layout>