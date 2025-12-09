<x-guest-layout>
    <section class="section">
        <div class="section-head" style="margin-bottom: 16px;">
            <h2 class="script">@lang('Restablir contrasenya')</h2>
            <p class="muted">
                @lang('Introdueix una nova contrasenya per al teu compte.')
            </p>
        </div>

        <div class="auth-wrap">
            <div class="auth-card">
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email -->
                    <label>
                        <span>@lang('Correu')</span>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', $request->email) }}"
                            required
                            autofocus
                            autocomplete="username"
                        />
                        @error('email')
                            <div class="auth-errors">{{ $message }}</div>
                        @enderror
                    </label>

                    <!-- Password -->
                    <label>
                        <span>@lang('Nova contrasenya')</span>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                        />
                        @error('password')
                            <div class="auth-errors">{{ $message }}</div>
                        @enderror
                    </label>

                    <!-- Confirm -->
                    <label>
                        <span>@lang('Repeteix la contrasenya')</span>
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                        />
                        @error('password_confirmation')
                            <div class="auth-errors">{{ $message }}</div>
                        @enderror
                    </label>

                    <div class="auth-actions">
                        <button class="cta" type="submit">
                            @lang('Restablir contrasenya')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>
