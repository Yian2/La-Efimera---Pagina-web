<x-guest-layout>
    <section class="section">
        <div class="section-head" style="margin-bottom: 16px;">
            <h2 class="script">@lang('Crea un compte')</h2>
            <p class="muted">@lang('Registra’t per guardar i seguir les teves comandes.')</p>
        </div>

        <div class="auth-wrap">
            <div class="auth-card">
                {{-- LOGO/BRAND --}}
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                    <div>
                        <div class="brand-script" style="font-size:22px; line-height:1;">La Efímera</div>
                        <div class="brand-sub" style="transform:none;">@lang('pizzeria creativa')</div>
                    </div>
                </div>

                <!-- ERRORS VALIDACIÓ -->
                @if ($errors->any())
                    <div class="auth-errors">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- FORMULARI REGISTRE -->
                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf

                    <input type="hidden" name="lang" value="{{ app()->getLocale() }}">

                    <label>
                        <span>@lang('Nom')</span>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" required autofocus autocomplete="name" />
                    </label>


                    <label>
                        <span>@lang('Correu')</span>
                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" />
                    </label>

                    <label>
                        <span>@lang('Contrasenya')</span>
                        <input type="password" name="password" required autocomplete="new-password" />
                    </label>

                    <label>
                        <span>@lang('Confirmar contrasenya')</span>
                        <input type="password" name="password_confirmation" required autocomplete="new-password" />
                    </label>

                    <div class="auth-actions">
                        <button class="cta" type="submit">@lang('Registra’t')</button>

                        <a class="cta ghost" href="{{ route('login') }}">
                            @lang('Ja tens compte? Inicia sessió')
                        </a>

                        <a class="cta ghost" href="{{ route('home') }}">
                            @lang('Tornar a l’inici')
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>
