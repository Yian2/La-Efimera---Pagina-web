<x-app-layout :title="'Take Away · La Efímera'">
    <section class="section">
        <!-- Capçalera de la pàgina -->
        <div class="section-head">
            <h2 class="script">@lang('Take Away')</h2>
            <p class="muted">@lang('Fes la comanda per telèfon o per la web i recull-la al nostre obrador.')</p>
        </div>

        <!-- Targeta principal amb el formulari -->
        <div class="card" style="max-width:1000px;margin:0 auto;">
            {{-- ERRORS: mostra errors de validació si el formulari falla --}}
            @if ($errors->any())
                <div class="auth-errors">
                    <ul>
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulari: envia dades per revisar/confirmar la comanda -->
            <form method="POST" action="{{ route('takeaway.review') }}">
                @csrf <!-- Token CSRF per seguretat -->

                {{-- HORA DE RECOLLIDA --}}
                <div style="display:grid; gap:12px; grid-template-columns: 1fr;">
                    <label>
                        <strong>@lang('Hora de recollida')</strong>
                        <!-- Selector d'hores disponibles -->
                        <select name="pickup_time" required
                                style="width:100%;background:#0f1115;border:1px solid #232733;color:#e9e9ea;padding:10px 12px;border-radius:12px;">
                            <option value="">{{ __('Selecciona una hora') }}</option>
                            @foreach($timeSlots as $t)
                                <!-- Manté el valor seleccionat si hi ha errors i torna amb old() -->
                                <option value="{{ $t }}" @selected(old('pickup_time')===$t)>{{ $t }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <!-- Separador visual -->
                <hr style="border:none;border-top:1px dashed rgba(217,164,65,.25);margin:16px 0;">

                <h3 style="margin:0 0 10px;font-family:'Marcellus',serif;">@lang('Productes')</h3>

                @php
                    $loc = app()->getLocale(); //idioma actual per mostrar el nom traduït si existeix

                    // Si torna amb errors, recupera les línies antigues; sinó crea 1 línia buida
                    $oldLines = old('lines', [
                        ['producto_id' => null, 'cantidad' => null, 'nota' => null],
                    ]);
                @endphp

                <!-- Contenidor de línies (productes) -->
                <div id="lines-container">
                    @foreach($oldLines as $idx => $line)
                        <!-- Targeta d'una línia de producte -->
                        <div class="card takeaway-line" data-index="{{ $idx }}" style="background:#0f1115;border-color:#232733;margin-bottom:10px;">
                            <div style="display:grid; gap:12px; grid-template-columns: 1.4fr 0.6fr;">
                                {{-- PRODUCTE --}}
                                <label>
                                    <span style="display:block;margin-bottom:6px;">@lang('Producte')</span>

                                    <!-- Select amb productes agrupats per tipus -->
                                    <select name="lines[{{ $idx }}][producto_id]"
                                            style="width:100%;background:#0f1115;border:1px solid #232733;color:#e9e9ea;padding:10px 12px;border-radius:12px;">
                                        <option value="">{{ __('(Opcional)') }}</option>

                                        @foreach($productos as $tipus => $list)
                                            <optgroup label="{{ $tipus }}">
                                                @foreach($list as $p)
                                                    @php
                                                        // Mostra el nom en l'idioma actual si existeix, si no el nom base
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
                                    <!-- Quantitat per producte (1 a 20) -->
                                    <input type="number" min="1" max="20" name="lines[{{ $idx }}][cantidad]"
                                           value="{{ old("lines.$idx.cantidad", $line['cantidad'] ?? '') }}"
                                           style="width:100%;background:#0f1115;border:1px solid #232733;color:#e9e9ea;padding:10px 12px;border-radius:12px;">
                                </label>
                            </div>

                            {{-- NOTA PER AQUEST PRODUCTE --}}
                            <label style="display:block;margin-top:10px;">
                                <span style="display:block;margin-bottom:6px;">@lang('Nota (opcional)')</span>
                                <!-- Nota especial per aquesta línia -->
                                <input type="text" name="lines[{{ $idx }}][nota]"
                                       value="{{ old("lines.$idx.nota", $line['nota'] ?? '') }}"
                                       placeholder="{{ __('Sense olives, extra picant…') }}"
                                       style="width:100%;background:#0f1115;border:1px solid #232733;color:#e9e9ea;padding:10px 12px;border-radius:12px;">
                            </label>
                        </div>
                    @endforeach
                </div>

                {{-- BOTÓ AFEGIR PRODUCTE: afegeix una línia nova amb JS --}}
                <button type="button" id="add-line-btn"
                        class="cta ghost"
                        style="margin-top:6px;margin-bottom:10px;">
                    + @lang('Afegir producte')
                </button>

                <!-- Botons finals: cancel·lar o confirmar -->
                <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:10px;">
                    <a href="{{ route('client.dashboard') }}" class="cta ghost">@lang('Cancel·lar')</a>
                    <button type="submit" class="cta">@lang('Confirmar comanda')</button>
                </div>
            </form>
        </div>
    </section>

    {{-- TEMPLATE JS: HTML base per crear noves línies sense recarregar --}}
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
            const container = document.getElementById('lines-container'); //on s'afegeixen les línies
            const btnAdd = document.getElementById('add-line-btn'); //botó d'afegir producte
            const tpl = document.getElementById('line-template').innerHTML; //template HTML

            // Últim índex utilitzat (per mantenir consistència amb les línies existents)
            let lineIndex = {{ count($oldLines) - 1 }};

            btnAdd.addEventListener('click', function () {
                lineIndex++; //nou index per la línia
                const html = tpl.replace(/__INDEX__/g, lineIndex); //substitueix __INDEX__ pel valor real

                const wrapper = document.createElement('div');
                wrapper.innerHTML = html.trim();

                container.appendChild(wrapper.firstElementChild); //afegeix la nova línia al formulari
            });
        });
    </script>
</x-app-layout>
