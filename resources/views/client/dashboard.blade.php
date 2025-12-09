<x-app-layout>
    <section class="section">
        {{-- Títol + subtítol --}}
        <div class="section-head">
            <h2 class="script">
                @lang('El meu espai')
            </h2>

            <p class="muted">
                @lang('Hola, :name. Gestiona les teves comandes i avantatges.', [
                    'name' => $user->nombre ?? $user->name
                ])
            </p>

            {{-- Badge de rol perquè visualment es vegi clar --}}
            <p class="muted small" style="margin-top:8px;">
                @if($user->rol === 'admin')
                    <span style="padding:4px 10px;border-radius:999px;border:1px solid #f97373;color:#fecaca;background:rgba(248,113,113,0.08);font-weight:600;">
                        @lang('Administrador')
                    </span>
                @elseif($user->rol === 'worker')
                    <span style="padding:4px 10px;border-radius:999px;border:1px solid #38bdf8;color:#e0f2fe;background:rgba(56,189,248,0.08);font-weight:600;">
                        @lang('Treballador')
                    </span>
                @else
                    <span style="padding:4px 10px;border-radius:999px;border:1px solid #a3e635;color:#ecfccb;background:rgba(132,204,22,0.08);font-weight:600;">
                        @lang('Client')
                    </span>
                @endif
            </p>
        </div>

        {{-- Accions de pàgina (dreta) --}}
        <div class="page-actions">
            {{-- Botó "Tornar a l’inici" --}}
            <a href="{{ route('home') }}" class="cta ghost">
                @lang('Tornar a l’inici')
            </a>

            {{-- Formulari de logout --}}
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="cta ghost danger">
                    @lang('Tancar sessió')
                </button>
            </form>
        </div>

        {{-- Targetes principals comunes per a tots els rols --}}
        <div class="card-grid">
            <div class="card">
                <h3>@lang('Demanar per emportar')</h3>
                <p>@lang('Fes la teva comanda i vine a recollir-la.')</p>
                <a class="cta" href="{{ route('takeaway.create') }}">
                    @lang('Inicia la comanda per emportar')
                </a>
            </div>

            <div class="card">
                <h3>@lang('Historial de comandes')</h3>
                <p>@lang('Revisa què vas demanar i repeteix fàcilment.')</p>
                <a class="cta ghost" href="{{ route('client.orders') }}">
                    @lang('Veure historial')
                </a>
            </div>

            <div class="card">
                <h3>@lang('Estat de la meva comanda')</h3>
                <p>@lang('Segueix la preparació i l’estat d’entrega.')</p>
                <a class="cta ghost" href="{{ route('client.track') }}">
                    @lang('Veure estat')
                </a>
            </div>

            {{-- Bloc extra només per ADMIN --}}
            @if($user->rol === 'admin')
                <div class="card" style="border-color: rgba(248,113,113,0.6);">
                    <h3>@lang('Zona administrador')</h3>
                    <p class="muted">
                        @lang('Com a administrador podràs gestionar la carta, el personal i veure dades agregades de vendes. Ara mateix aquesta zona és només informativa.')
                    </p>
                    <ul class="link-list" style="margin-top:10px;">
                        <li>• @lang('En una següent fase aquí afegirem: gestió d’usuaris (rol i descompte).')</li>
                        <li>• @lang('Accés a totes les comandes del local.')</li>
                        <li>• @lang('Gràfics de vendes per dies, setmanes i productes.')</li>
                    </ul>
                </div>
            @endif

            {{-- Bloc extra per WORKER --}}
            @if($user->rol === 'worker')
                <div class="card" style="border-color: rgba(56,189,248,0.6);">
                    <h3>@lang('Avantatges de treballador')</h3>
                    <p class="muted">
                        @lang('El teu descompte s’aplica automàticament a les comandes que facis amb el teu usuari.')
                    </p>

                    <p style="margin-top:8px;">
                        <strong>@lang('Descompte actual'):</strong>
                        {{ number_format($user->descompte * 100, 0) }}%
                    </p>

                    <p class="small muted" style="margin-top:4px;">
                        @lang('Si el descompte no és correcte, parla amb el responsable perquè t’actualitzi el teu rol o percentatge.')
                    </p>
                </div>
            @endif
        </div>

        {{-- Última comanda (té sentit per tots els rols que fan comandes) --}}
        @if($ultimaComanda)
            <div class="card" style="max-width:1100px;margin:18px auto 0;">
                <h3>
                    @lang('Última comanda') #{{ $ultimaComanda->id }}
                    ({{ __($ultimaComanda->estado) }})
                </h3>

                @if($ultimaComanda->detalles && $ultimaComanda->detalles->count())
                    <ul class="menu-list">
                        @foreach($ultimaComanda->detalles as $d)
                            <li>
                                <div class="menu-line">
                                    <span class="menu-item">
                                        {{ $d->producto->nombre ?? 'Producte' }} × {{ $d->cantidad }}
                                    </span>
                                    <span class="dots"></span>
                                    <span class="price">
                                        {{ number_format($d->subtotal, 2, ',', '.') }}€
                                    </span>
                                </div>

                                @if(!empty($d->nota))
                                    <p class="desc">
                                        <em>@lang('Nota'):</em> {{ $d->nota }}
                                    </p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif

                <p style="margin-top:10px;">
                    <strong>@lang('Total'):</strong>
                    {{ number_format($ultimaComanda->total, 2, ',', '.') }}€
                </p>
            </div>
        @endif

        {{-- Punts i recompenses: això té més sentit per CLIENT i WORKER; si vols, pots excloure admin --}}
        @if(in_array($user->rol, ['client','worker']))
            <div class="section-head" style="margin-top:28px;">
                <h2 class="script">@lang('Punts i recompenses')</h2>
                <p class="muted">
                    @lang('Tiramisù, Panna cotta o Cheesecake')
                </p>
            </div>

            <div class="card" style="max-width:900px;margin:0 auto;">
                <p>
                    @lang('Total punts:') 
                    <strong>{{ number_format($gastat, 2, ',', '.') }}</strong>
                </p>

                <div class="progress">
                    <div class="bar" style="width: {{ $progress }}%"></div>
                </div>

                <p class="muted small">
                    @lang('Progrés actual: :progress% cap a la propera recompensa.', ['progress' => $progress])
                </p>
            </div>
        @endif
    </section>
</x-app-layout>
