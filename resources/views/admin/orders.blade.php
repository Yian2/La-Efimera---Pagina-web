<x-app-layout :title="__('Totes les comandes')">
    <section class="section">
        <div class="section-head">
            <h2 class="script">@lang('Totes les comandes')</h2>
            <p class="muted">
                @lang('Aquí veus totes les comandes del local. Pots filtrar per client, dates, productes i ordenar per data.')
            </p>
        </div>

        {{-- FILTRES --}}
        <div class="card" style="max-width:1100px;margin:0 auto 24px auto;">
            <form method="GET" class="admin-filters">
                <div style="display:flex;flex-wrap:wrap;gap:16px;align-items:flex-end;">

                    {{-- Usuari (select) --}}
                    <div style="flex:1 1 180px;min-width:180px;">
                        <label for="user_id" style="display:block;font-size:12px;margin-bottom:4px;">
                            @lang('Usuari (id)')
                        </label>
                        <select name="user_id" id="user_id" style="width:100%;padding:6px 8px;border-radius:6px;border:1px solid rgba(255,255,255,0.15);background:rgba(0,0,0,0.25);color:#fff;">
                            <option value="">@lang('-- Tots --')</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @selected(request('user_id') == $user->id)>
                                    {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Email (text) --}}
                    <div style="flex:1 1 180px;min-width:180px;">
                        <label for="email" style="display:block;font-size:12px;margin-bottom:4px;">
                            @lang('Correu conté')
                        </label>
                        <input
                            type="text"
                            name="email"
                            id="email"
                            value="{{ request('email') }}"
                            placeholder="client@exemple.com"
                            style="width:100%;padding:6px 8px;border-radius:6px;border:1px solid rgba(255,255,255,0.15);background:rgba(0,0,0,0.25);color:#fff;"
                        >
                    </div>

                    {{-- Rang de dates --}}
                    <div style="flex:1 1 140px;min-width:140px;">
                        <label for="from" style="display:block;font-size:12px;margin-bottom:4px;">
                            @lang('Des de')
                        </label>
                        <input
                            type="date"
                            name="from"
                            id="from"
                            value="{{ request('from') }}"
                            style="width:100%;padding:6px 8px;border-radius:6px;border:1px solid rgba(255,255,255,0.15);background:rgba(0,0,0,0.25);color:#fff;"
                        >
                    </div>

                    <div style="flex:1 1 140px;min-width:140px;">
                        <label for="to" style="display:block;font-size:12px;margin-bottom:4px;">
                            @lang('Fins a')
                        </label>
                        <input
                            type="date"
                            name="to"
                            id="to"
                            value="{{ request('to') }}"
                            style="width:100%;padding:6px 8px;border-radius:6px;border:1px solid rgba(255,255,255,0.15);background:rgba(0,0,0,0.25);color:#fff;"
                        >
                    </div>

                    {{-- Producte --}}
                    <div style="flex:1 1 180px;min-width:180px;">
                        <label for="product_id" style="display:block;font-size:12px;margin-bottom:4px;">
                            @lang('Producte')
                        </label>
                        <select
                            name="product_id"
                            id="product_id"
                            style="width:100%;padding:6px 8px;border-radius:6px;border:1px solid rgba(255,255,255,0.15);background:rgba(0,0,0,0.25);color:#fff;"
                        >
                            <option value="">@lang('-- Tots --')</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" @selected(request('product_id') == $product->id)>
                                    {{ $product->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Ordenació --}}
                    <div style="flex:1 1 160px;min-width:160px;">
                        <label for="sort" style="display:block;font-size:12px;margin-bottom:4px;">
                            @lang('Ordenar per data')
                        </label>
                        <select
                            name="sort"
                            id="sort"
                            style="width:100%;padding:6px 8px;border-radius:6px;border:1px solid rgba(255,255,255,0.15);background:rgba(0,0,0,0.25);color:#fff;"
                        >
                            <option value="recent" @selected(($sort ?? request('sort')) === 'recent')>
                                @lang('Més recent primer')
                            </option>
                            <option value="oldest" @selected(($sort ?? request('sort')) === 'oldest')>
                                @lang('Més antic primer')
                            </option>
                        </select>
                    </div>

                    {{-- Botons --}}
                    <div style="flex:0 0 auto;display:flex;gap:8px;margin-left:auto;">
                        <button type="submit" class="cta" style="padding:8px 14px;font-size:13px;">
                            @lang('Filtrar')
                        </button>
                        <a href="{{ route('admin.orders.index') }}"
                            class="cta ghost"
                            style="padding:8px 14px;font-size:13px;display:inline-flex;align-items:center;justify-content:center;">
                            @lang('Netejar')
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- TAULA DE COMANDES --}}
        <div class="card" style="max-width:1100px;margin:0 auto;overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:14px;">
                <thead>
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.1);">
                        <th style="text-align:left;padding:8px 4px;">ID</th>
                        <th style="text-align:left;padding:8px 4px;">@lang('Correu client')</th>
                        <th style="text-align:left;padding:8px 4px;">@lang('Productes')</th> {{-- NOVA CAPÇALERA --}}
                        <th style="text-align:left;padding:8px 4px;">@lang('Total')</th>
                        <th style="text-align:left;padding:8px 4px;">@lang('Estat')</th>
                        <th style="text-align:left;padding:8px 4px;">@lang('Data')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr style="border-bottom:1px dashed rgba(255,255,255,0.06);">
                            <td style="padding:6px 4px;">#{{ $order->id }}</td>
                            <td style="padding:6px 4px;">
                                {{ optional($order->user)->email ?? '—' }}
                            </td>
                            
                            {{-- NOVA CEL·LA AMB ELS PRODUCTES --}}
                            <td style="padding:6px 4px; font-size: 12px; color: #aaa;">
                                @forelse($order->detalles as $detalle)
                                    {{ optional($detalle->producto)->nombre }} (x{{ $detalle->cantidad }})@if(!$loop->last), @endif
                                @empty
                                    <span style="color: red;">@lang('Buit')</span>
                                @endforelse
                            </td>
                            {{-- FI NOVA CEL·LA --}}

                            <td style="padding:6px 4px;">
                                {{ number_format($order->total, 2, ',', '.') }} €
                            </td>
                            <td style="padding:6px 4px;">
                                {{ __($order->estado) }}
                            </td>
                            <td style="padding:6px 4px;">
                                {{ optional($order->fecha_creacion)->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:8px 4px;">
                                @lang('No hi ha comandes amb aquests filtres.')
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top:12px;">
                {{ $orders->links() }}
            </div>
        </div>

        {{-- TOP PRODUCTES MÉS VENGUTS --}}
        <section class="section" style="max-width:1100px;margin:32px auto 0 auto;">
            <div class="section-head">
                <h3 class="script">@lang('Top productes més venuts')</h3>
                <p class="muted">
                    @lang('Ranking dels productes amb més unitats venudes.')
                </p>
            </div>

            <div class="card" style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:14px;">
                    <thead>
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.1);">
                            <th style="text-align:left;padding:8px 4px;">@lang('Producte')</th>
                            <th style="text-align:left;padding:8px 4px;">@lang('Unitats venudes')</th>
                            <th style="text-align:left;padding:8px 4px;">@lang('Import total')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $row)
                            <tr style="border-bottom:1px dashed rgba(255,255,255,0.06);">
                                <td style="padding:6px 4px;">
                                    {{ optional($row->producto)->nombre ?? '—' }}
                                </td>
                                <td style="padding:6px 4px;">
                                    {{ $row->total_qty }}
                                </td>
                                <td style="padding:6px 4px;">
                                    {{ number_format($row->total_importe, 2, ',', '.') }} €
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="padding:8px 4px;">
                                    @lang('Encara no hi ha dades de vendes.')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.order-row').forEach(function (row) {
                    row.addEventListener('click', function () {
                        const href = this.dataset.href;
                        if (href) {
                            window.location.href = href;
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>