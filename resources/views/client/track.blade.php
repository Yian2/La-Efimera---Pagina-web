<x-app-layout>
<section class="section">
<div class="section-head">
<h2 class="script">@lang('Estat de la comanda')</h2>
<p class="muted">@lang('Segueix en temps real quan la teva comanda estigui llesta.')</p>
</div>


@if($order)
<div class="card" style="max-width:900px;margin:0 auto;">
<h3>@lang('Comanda') #{{ $order->id }}</h3>
<p><strong>@lang('Estat'):</strong> {{ __($order->estado) }}</p>


@php
$steps = ['pendiente','preparando','listo','entregado'];
$currentIndex = array_search($order->estado, $steps, true);
@endphp
<div class="stepper">
@foreach($steps as $i => $label)
<div class="step {{ $i <= $currentIndex ? 'done' : '' }}">
<span>{{ __($label) }}</span>
</div>
@endforeach
</div>
</div>
@else
<p class="muted" style="text-align:center;">@lang('No hem trobat cap comanda recent.')</p>
@endif
</section>
</x-app-layout>