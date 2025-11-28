<x-app-layout :title="'Take Away · La Efímera'">
    <section class="section">
        <div class="section-head">
            <h2 class="script">@lang('Take Away')</h2>
            <p class="muted">@lang('Fes la comanda per telèfon o per la web i recull-la al nostre obrador.')</p>
        </div>

        <div class="card" style="max-width:1000px;margin:0 auto;">
            {{-- ERRORS --}}
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

                {{-- HORA DE RECOLLIDA --}}
                <div style="display:grid; gap:12px; grid-template-columns: 1fr;">
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
                </div>

                <hr style="border:none;border-top:1px dashed rgba(217,164,65,.25);margin:16px 0;">

                <h3 style="margin:0 0 10px;font-family:'Marcellus',serif;">@lang('Productes')</h3>

                @php
                    $loc = app()->getLocale();
                    // Si ve de validació amb errors, recuperem les línies antigues.
                    $oldLines = old('lines', [
                        ['producto_id' => null, 'cantidad' => null, 'nota' => null],
                    ]);
                @endphp

                <div id="lines-container">
                    @foreach($oldLines as $idx => $line)
                        <div class="card takeaway-line" data-index="{{ $idx }}" style="background:#0f1115;border-color:#232733;margin-bottom:10px;">
                            <div style="display:grid; gap:12px; grid-template-columns: 1.4fr 0.6fr;">
                                {{-- PRODUCTE --}}
                                <label>
                                    <span style="display:block;margin-bottom:6px;">@lang('Producte')</span>
                                    <select name="lines[{{ $idx }}][producto_id]"
                                            style="width:100%;background:#0f1115;border:1px solid #232733;color:#e9e9ea;padding:10px 12px;border-radius:12px;">
                                        <option value="">{{ __('(Opcional)') }}</option>
                                        @foreach($productos as $tipus => $list)
                                            <optgroup label="{{ $tipus }}">
                                                @foreach($list as $p)
                                                    @php
                                                        $name = $p->{'nombre_'.$loc} ?? $p->nombre;
                                                    @endphp
                                                    <option value="{{ $p->id }}"
                                                        @selected(old("lines.$idx.producto_id", $line['producto_id'] ?? null)==$p->id)>
                                                        {{ $name }} — {{ number_format($p->precio,2,',','.') }}€
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </label>

                                {{-- QUANTITAT --}}
                                <label>
                                    <span style="display:block;margin-bottom:6px;">@lang('Quantitat')</span>
                                    <input type="number" min="1" max="20" name="lines[{{ $idx }}][cantidad]"
                                           value="{{ old("lines.$idx.cantidad", $line['cantidad'] ?? '') }}"
                                           style="width:100%;background:#0f1115;border:1px solid #232733;color:#e9e9ea;padding:10px 12px;border-radius:12px;">
                                </label>
                            </div>

                            {{-- NOTA PER AQUEST PRODUCTE --}}
                            <label style="display:block;margin-top:10px;">
                                <span style="display:block;margin-bottom:6px;">@lang('Nota (opcional)')</span>
                                <input type="text" name="lines[{{ $idx }}][nota]"
                                       value="{{ old("lines.$idx.nota", $line['nota'] ?? '') }}"
                                       placeholder="{{ __('Sense olives, extra picant…') }}"
                                       style="width:100%;background:#0f1115;border:1px solid #232733;color:#e9e9ea;padding:10px 12px;border-radius:12px;">
                            </label>
                        </div>
                    @endforeach
                </div>

                {{-- BOTÓ AFEGIR PRODUCTE --}}
                <button type="button" id="add-line-btn"
                        class="cta ghost"
                        style="margin-top:6px;margin-bottom:10px;">
                    + @lang('Afegir producte')
                </button>

                <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:10px;">
                    <a href="{{ route('home') }}" class="cta ghost">@lang('Cancel·lar')</a>
                    <button type="submit" class="cta">@lang('Confirmar comanda')</button>
                </div>
            </form>
        </div>
    </section>

    {{-- TEMPLATE JS per afegir noves línies --}}
    <template id="line-template">
        <div class="card takeaway-line" data-index="__INDEX__" style="background:#0f1115;border-color:#232733;margin-bottom:10px;">
            <div style="display:grid; gap:12px; grid-template-columns: 1.4fr 0.6fr;">
                <label>
                    <span style="display:block;margin-bottom:6px;">@lang('Producte')</span>
                    <select name="lines[__INDEX__][producto_id]"
                            style="width:100%;background:#0f1115;border:1px solid #232733;color:#e9e9ea;padding:10px 12px;border-radius:12px;">
                        <option value="">{{ __('(Opcional)') }}</option>
                        @foreach($productos as $tipus => $list)
                            <optgroup label="{{ $tipus }}">
                                @foreach($list as $p)
                                    @php
                                        $name = $p->{'nombre_'.$loc} ?? $p->nombre;
                                    @endphp
                                    <option value="{{ $p->id }}">
                                        {{ $name }} — {{ number_format($p->precio,2,',','.') }}€
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </label>

                <label>
                    <span style="display:block;margin-bottom:6px;">@lang('Quantitat')</span>
                    <input type="number" min="1" max="20" name="lines[__INDEX__][cantidad]"
                           style="width:100%;background:#0f1115;border:1px solid #232733;color:#e9e9ea;padding:10px 12px;border-radius:12px;">
                </label>
            </div>

            <label style="display:block;margin-top:10px;">
                <span style="display:block;margin-bottom:6px;">@lang('Nota (opcional)')</span>
                <input type="text" name="lines[__INDEX__][nota]"
                       placeholder="{{ __('Sense olives, extra picant…') }}"
                       style="width:100%;background:#0f1115;border:1px solid #232733;color:#e9e9ea;padding:10px 12px;border-radius:12px;">
            </label>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('lines-container');
            const btnAdd = document.getElementById('add-line-btn');
            const tpl = document.getElementById('line-template').innerHTML;

            // Últim índex utilitzat (per si ve d'un old())
            let lineIndex = {{ count($oldLines) - 1 }};

            btnAdd.addEventListener('click', function () {
                lineIndex++;
                const html = tpl.replace(/__INDEX__/g, lineIndex);
                const wrapper = document.createElement('div');
                wrapper.innerHTML = html.trim();
                container.appendChild(wrapper.firstElementChild);
            });
        });
    </script>
</x-app-layout>
