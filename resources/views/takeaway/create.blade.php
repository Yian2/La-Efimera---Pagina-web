<x-app-layout :title="'Take Away · La Efímera'">
    <section class="section">
        <div class="section-head">
            <h2 class="script">@lang('Take Away')</h2>
            <p class="muted">@lang('Fes la comanda per telèfon i recull-la al nostre obrador.')</p>
        </div>

        <div class="card" style="max-width:1000px;margin:0 auto;">
            @if ($errors->any())
                <div class="auth-errors">
                    <ul>
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('takeaway.store') }}">
                @csrf

                <div style="display:grid; gap:12px; grid-template-columns: 1fr 1fr;">
                    <label>
                        <strong>@lang('Hora de recollida')</strong>
                        <select name="pickup_time" required
                                style="width:100%;background:#0f1115;border:1px solid #232733;color:#e9e9ea;padding:10px 12px;border-radius:12px;">
                            <option value="">{{ __('Selecciona una hora') }}</option>
                            @foreach($timeSlots as $t)
                                <option value="{{ $t }}" @selected(old('pickup_time')===$t)>{{ $t }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label>
                        <strong>@lang('Notes')</strong>
                        <input type="text" name="notes"
                               value="{{ old('notes') }}"
                               placeholder="{{ __('Sense olives, extra picant…') }}"
                               style="width:100%;background:#0f1115;border:1px solid #232733;color:#e9e9ea;padding:10px 12px;border-radius:12px;">
                    </label>
                </div>

                <hr style="border:none;border-top:1px dashed rgba(217,164,65,.25);margin:16px 0;">

                <h3 style="margin:0 0 10px;font-family:'Marcellus',serif;">@lang('Productes')</h3>

                @php $loc = app()->getLocale(); @endphp

                @for($i=0; $i<5; $i++)
                    <div class="card" style="background:#0f1115;border-color:#232733;margin-bottom:10px;">
                        <div style="display:grid; gap:12px; grid-template-columns: 1fr 120px;">
                            <label>
                                <span style="display:block;margin-bottom:6px;">@lang('Producte')</span>
                                <select name="lines[{{ $i }}][producto_id]"
                                        style="width:100%;background:#0f1115;border:1px solid #232733;color:#e9e9ea;padding:10px 12px;border-radius:12px;">
                                    <option value="">{{ __('(Opcional)') }}</option>
                                    @foreach($productos as $tipus => $list)
                                        <optgroup label="{{ $tipus }}">
                                            @foreach($list as $p)
                                                @php
                                                    $name = $p->{'nombre_'.$loc} ?? $p->nombre;
                                                @endphp
                                                <option value="{{ $p->id }}" @selected(old("lines.$i.producto_id")==$p->id)>
                                                    {{ $name }} — {{ number_format($p->precio,2,',','.') }}€
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </label>

                            <label>
                                <span style="display:block;margin-bottom:6px;">@lang('Quantitat')</span>
                                <input type="number" min="1" max="20" name="lines[{{ $i }}][cantidad]"
                                       value="{{ old("lines.$i.cantidad") }}"
                                       style="width:100%;background:#0f1115;border:1px solid #232733;color:#e9e9ea;padding:10px 12px;border-radius:12px;">
                            </label>
                        </div>
                    </div>
                @endfor

                <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:10px;">
                    <a href="{{ route('home') }}" class="cta ghost">@lang('Cancel·lar')</a>
                    <button type="submit" class="cta">@lang('Confirmar comanda')</button>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
