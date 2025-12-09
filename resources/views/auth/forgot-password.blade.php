<x-guest-layout>
    <section class="section">
        <div class="section-head" style="margin-bottom: 16px;">
            <h2 class="script">@lang('Has oblidat la contrasenya?')</h2>
            <p class="muted">
                @lang('Introdueix el teu correu i t’enviarem un enllaç per restablir-la.')
            </p>
        </div>

        <div class="auth-wrap">
            <div class="auth-card">
                {{-- MISSATGE D’ÈXIT --}}
                @if (session('status'))
                    <div class="auth-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <label>
                        <span>@lang('Correu')</span>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required autofocus autocomplete="email" />
                    </label>

                    @error('email')
                        <div class="auth-errors">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="auth-actions">
                        <button class="cta" type="submit">
                            @lang('Enviar enllaç de restabliment')
                        </button>

                        <a class="cta ghost" href="{{ route('login') }}">
                            @lang('Tornar a l’accés')
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>
