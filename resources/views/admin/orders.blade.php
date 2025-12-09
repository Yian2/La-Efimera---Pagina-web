<x-app-layout :title="__('Totes les comandes')">
    <section class="section">
        <div class="section-head">
            <h2 class="script">@lang('Totes les comandes')</h2>
            <p class="muted">
                @lang('Aquí veus totes les comandes del local, ordenades de la més recent a la més antiga.')
            </p>
        </div>

        <div class="card" style="max-width:1100px;margin:0 auto;overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:14px;">
                <thead>
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.1);">
                        <th style="text-align:left;padding:8px 4px;">ID</th>
                        <th style="text-align:left;padding:8px 4px;">@lang('Client')</th>
                        <th style="text-align:left;padding:8px 4px;">@lang('Total')</th>
                        <th style="text-align:left;padding:8px 4px;">@lang('Estat')</th>
                        <th style="text-align:left;padding:8px 4px;">@lang('Data')</th>
                        <th style="text-align:left;padding:8px 4px;">@lang('Línies')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr style="border-bottom:1px dashed rgba(255,255,255,0.06);">
                            <td style="padding:6px 4px;">#{{ $order->id }}</td>
                            <td style="padding:6px 4px;">
                                {{ optional($order->user)->name ?? '—' }}
                            </td>
                            <td style="padding:6px 4px;">
                                {{ number_format($order->total, 2, ',', '.') }} €
                            </td>
                            <td style="padding:6px 4px;">
                                {{ __($order->estado) }}
                            </td>
                            <td style="padding:6px 4px;">
                                {{ $order->created_at?->format('d/m/Y H:i') }}
                            </td>
                            <td style="padding:6px 4px;">
                                {{ $order->detalles_count ?? '—' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top:12px;">
                {{ $orders->links() }}
            </div>
        </div>
    </section>
</x-app-layout>
