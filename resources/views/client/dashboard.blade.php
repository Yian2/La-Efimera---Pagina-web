<x-app-layout>
</div>


<div class="card">
<h3>@lang('Estat de la meva comanda')</h3>
<p>@lang('Segueix la preparació i l’estat d’entrega.')</p>
<a class="cta ghost" href="{{ route('client.track') }}">@lang('Veure estat')</a>
</div>
</div>


@if($ultimaComanda)
<div class="card" style="max-width:1100px;margin:18px auto 0;">
<h3>@lang('Última comanda') #{{ $ultimaComanda->id }} ({{ __($ultimaComanda->estado) }})</h3>
<ul class="menu-list">
@foreach($ultimaComanda->detalles as $d)
<li>
<div class="menu-line">
<span class="menu-item">{{ $d->producto->nombre }} × {{ $d->cantidad }}</span>
<span class="dots"></span>
<span class="price">{{ number_format($d->subtotal,2,',','.') }}€</span>
</div>
</li>
@endforeach
</ul>
<p><strong>@lang('Total'):</strong> {{ number_format($ultimaComanda->total,2,',','.') }}€</p>
</div>
@endif


{{-- ======= DETALL DE PUNTS (integrat abaix del dashboard) ======= --}}
<div class="section-head" style="margin-top:28px;">
<h2 class="script">@lang('Punts i recompenses')</h2>
<p class="muted">@lang('Tiramisù, Panna cotta o Cheesecake')</p>
</div>


<div class="card" style="max-width:900px;margin:0 auto;">
<p>@lang('Total punts:') <strong>{{ number_format($gastat,2,',','.') }}</strong></p>
<div class="progress">
<div class="bar" style="width: {{ $progress }}%"></div>
</div>
<p class="muted small">{{ __('Progrés actual: :progress% cap a la propera recompensa.', ['progress' => $progress]) }}</p>
</div>
{{-- =============================================================== --}}
</section>
</x-app-layout>