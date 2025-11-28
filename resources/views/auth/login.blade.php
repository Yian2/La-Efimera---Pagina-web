<x-guest-layout>
    <section class="section">
        <div class="section-head" style="margin-bottom: 16px;">
            <h2 class="script">@lang('Accés')</h2>
            <p class="muted">@lang('Entra amb el teu correu i contrasenya.')</p>
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

                {{-- ERRORS VALIDACIÓ --}}
                @if ($errors->any())
                    <div class="auth-errors">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORMULARI LOGIN --}}
                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf

                    <input type="hidden" name="lang" value="{{ app()->getLocale() }}">

                    <label>
                        <span>@lang('Correu')</span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                    </label>

                    <label>
                        <span>@lang('Contrasenya')</span>
                        <input type="password" name="password" required autocomplete="current-password" />
                    </label>

                    <div class="remember">
                        <input id="remember_me" type="checkbox" name="remember">
                        <label for="remember_me" style="margin: 0;">@lang('Recorda’m')</label>
                    </div>

                    <div class="auth-actions">
                        <button class="cta" type="submit">@lang('Entrar')</button>

                        @if (Route::has('password.request'))
                            <a class="cta ghost" href="{{ route('password.request') }}">
                                @lang('Has oblidat la contrasenya?')
                            </a>
                        @endif

                        <a class="cta ghost" href="{{ route('home') }}">
                            @lang('Tornar a l’inici')
                        </a>

                        {{-- ENLLAÇ AL REGISTRE --}}
                        @if (Route::has('register'))
                            <p class="muted" style="margin-top: 12px; text-align:center;">
                                @lang('No tens compte?')
                                <a href="{{ route('register') }}" class="link">
                                    @lang('Crea un compte')
                                </a>
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>
