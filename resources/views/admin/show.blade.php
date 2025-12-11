<x-app-layout :title="__('Detall comanda #'.$pedido->id)">
    <section class="section">
        <div class="section-head">
            <h2 class="script">
                @lang('Comanda #'): {{ $pedido->id }}
            </h2>
            <p class="muted">
                {{ optional($pedido->user)->email ?? '—' }}
                · {{ $pedido->fecha_creacion?->format('d/m/Y H:i') }}
                · {{ __($pedido->estado) }}
            </p>
        </div>

        <div class="card" style="max-width:900px;margin:0 auto;">
            <table style="width:100%;border-collapse:collapse;font-size:14px;">
                <thead>
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.1);">
                        <th style="text-align:left;padding:8px 4px;">@lang('Producte')</th>
                        <th style="text-align:right;padding:8px 4px;">@lang('Quantitat')</th>
                        <th style="text-align:right;padding:8px 4px;">@lang('Preu unitari')</th>
                        <th style="text-align:right;padding:8px 4px;">@lang('Subtotal')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pedido->detalles as $linea)
                        <tr style="border-bottom:1px dashed rgba(255,255,255,0.06);">
                            <td style="padding:6px 4px;">
                                {{ optional($linea->producto)->nombre ?? '—' }}
                            </td>
                            <td style="padding:6px 4px;text-align:right;">
                                {{ $linea->cantidad }}
                            </td>
                            <td style="padding:6px 4px;text-align:right;">
                                {{ number_format($linea->precio_unitario, 2, ',', '.') }} €
                            </td>
                            <td style="padding:6px 4px;text-align:right;">
                                {{ number_format($linea->cantidad * $linea->precio_unitario, 2, ',', '.') }} €
                            </td>
                        </tr>
                    @empty
                         <tr>
                            <td colspan="4" style="padding:8px 4px; text-align:center;">
                                @lang('Aquesta comanda no conté productes.')
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top:16px;text-align:right;">
                <strong>@lang('Total'): </strong>
                {{ number_format($pedido->total, 2, ',', '.') }} €
            </div>

            <div style="margin-top:16px;">
                <a href="{{ route('admin.orders.index') }}" class="cta ghost">
                    @lang('Tornar a totes les comandes')
                </a>
            </div>
        </div>
    </section>
</x-app-layout>