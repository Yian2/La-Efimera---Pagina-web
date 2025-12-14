{{-- resources/views/dashboard/index.blade.php --}}
<x-app-layout :title="__('El meu espai')">
    <section class="section">
        <div class="section-head" style="margin-bottom: 16px;">
            <h1 class="script">
                @lang('Hola'), {{ $user->name }} 👋
            </h1>
            <p class="muted">
                @lang('Aquest és el teu espai personal a La Efímera.')
            </p>
        </div>

        <div class="dashboard-grid">
            {{-- Targeta amb info bàsica --}}
            <div class="card">
                <h2 class="card-title">@lang('Perfil')</h2>
                <p><strong>@lang('Correu'):</strong> {{ $user->email }}</p>
                <p><strong>@lang('Rol'):</strong> {{ ucfirst($user->rol) }}</p>
            </div>

            {{--  ZONA ADMIN --}}
            @if ($user->rol === 'admin')
                <div class="card">
                    <h2 class="card-title">@lang('Administració')</h2>
                    <p class="muted">
                        @lang('Com a administrador pots gestionar la carta, les comandes i el personal.')
                    </p>

                    <ul class="link-list">
                        <li>
                            <a href="{{ route('admin.orders.index') }}">
                                @lang('Veure totes les comandes')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.stats.index') }}">
                                @lang('Veure gràfics de vendes')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}">
                                @lang('Gestió d’usuaris (rol i descompte)')
                            </a>
                        </li>
                        {{-- Aquí en un futur: enllaç a gestionar carta, productes, etc. --}}
                    </ul>
                </div>
            @endif

            {{--ZONA WORKER --}}
            @if ($user->rol === 'worker')
                <div class="card">
                    <h2 class="card-title">@lang('Espai de treballador')</h2>
                    <p class="muted">
                        @lang('Aquí tens la teva informació com a membre de l’equip.')
                    </p>

                    <p>
                        <strong>@lang('Descompte de treballador'):</strong>
                        {{ $user->descompte * 100 }}%
                    </p>

                    <ul class="link-list">
                        <li>
                            <a href="{{ route('takeaway.create') }}">
                                @lang('Fer una comanda amb el teu descompte')
                            </a>
                        </li>
                        {{-- més endavant: enllaç a "Carregar comanda habitual", torns, etc. --}}
                    </ul>
                </div>
            @endif

            {{-- ZONA CLIENT --}}
            @if ($user->rol === 'client')
                <div class="card">
                    <h2 class="card-title">@lang('Espai de client')</h2>
                    <p class="muted">
                        @lang('Des d’aquí pots fer comandes i, si vols, veure les teves comandes recents.')
                    </p>

                    <ul class="link-list">
                        <li>
                            <a href="{{ route('takeaway.create') }}">
                                @lang('Fer una nova comanda')
                            </a>
                        </li>
                        {{-- si més endavant tens historial: --}}
                        {{-- <li><a href="{{ route('orders.my') }}">@lang('Les meves comandes')</a></li> --}}
                    </ul>
                </div>
            @endif
        </div>
    </section>

    {{-- Estils mínims inline (pots passar-ho a CSS) --}}
    @push('styles')
        <style>
            .dashboard-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
                gap: 1.5rem;
            }
            .card {
                background: rgba(255, 255, 255, 0.03);
                border-radius: 16px;
                padding: 1.5rem;
                border: 1px solid rgba(255,255,255,0.05);
            }
            .card-title {
                font-size: 1.2rem;
                margin-bottom: 0.75rem;
            }
            .link-list {
                list-style: none;
                padding: 0;
                margin: 0.75rem 0 0;
            }
            .link-list li + li {
                margin-top: 0.35rem;
            }
            .link-list a {
                text-decoration: underline;
                text-underline-offset: 2px;
            }
        </style>
    @endpush
</x-app-layout>
