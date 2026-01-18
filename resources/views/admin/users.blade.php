<x-app-layout :title="__('Gestió d’usuaris')">
    <!-- Contenidor principal de la secció -->
    <section class="section">
        <!-- Capçalera: títol i descripció de la pantalla -->
        <div class="section-head">
            <h2 class="script">@lang('Gestió d’usuaris')</h2>
            <p class="muted">
                @lang('Cerca un usuari i canvia el seu rol (client, treballador, admin). Els canvis es guarden automàticament.')
            </p>
        </div>

        <!-- Missatge flash: mostra feedback quan es fa una acció (ex: rol actualitzat) -->
        @if (session('status'))
            <div class="auth-errors" style="margin-bottom:16px;">
                {{ session('status') }}
            </div>
        @endif

        <!-- BUSCADOR: formulari GET per filtrar usuaris per nom o correu -->
        <div style="max-width:1100px;margin:0 auto 14px;">
            <form method="GET" action="{{ route('admin.users.index') }}"
                  style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">

                <!-- Input de cerca: envia el paràmetre q a la URL (?q=...) -->
                <input
                    type="text"
                    name="q"
                    value="{{ $q ?? '' }}"
                    placeholder="@lang('Cerca per nom o correu...')"
                    style="flex:1 1 260px;background:#0f1115;border:1px solid #232733;color:#e9e9ea;
                           padding:8px 10px;border-radius:999px;font:inherit;"
                />

                <!-- Botó per netejar el filtre: només es mostra si hi ha cerca -->
                @if(!empty($q))
                    <a href="{{ route('admin.users.index') }}"
                       class="cta ghost"
                       style="padding:8px 14px;font-size:13px;">
                        @lang('Neteja filtre')
                    </a>
                @endif
            </form>
        </div>

        <!-- TAULA D’USUARIS: mostra la llista d'usuaris amb opció de canviar rol -->
        <div class="card" style="max-width:1100px;margin:0 auto;">
            <table style="width:100%;border-collapse:collapse;font-size:14px;">
                <thead>
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.1);">
                        <th style="text-align:left;padding:8px 4px;">@lang('ID')</th>
                        <th style="text-align:left;padding:8px 4px;">@lang('Nom')</th>
                        <th style="text-align:left;padding:8px 4px;">@lang('Correu')</th>
                        <th style="text-align:left;padding:8px 4px;">@lang('Rol')</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Itera els usuaris; si no n'hi ha, mostra missatge -->
                    @forelse ($users as $u)
                        <tr style="border-bottom:1px dashed rgba(255,255,255,0.06);">
                            <!-- ID usuari -->
                            <td style="padding:6px 4px;">{{ $u->id }}</td>

                            <!-- Nom usuari: intenta 'nombre', si no 'name', i si no '-' -->
                            <td style="padding:6px 4px;">
                                {{ $u->nombre ?? $u->name ?? '-' }}
                            </td>

                            <!-- Correu usuari -->
                            <td style="padding:6px 4px;">{{ $u->email }}</td>

                            <!-- Rol: select que fa submit automàtic quan es canvia -->
                            <td style="padding:6px 4px;">
                                <form method="POST" action="{{ route('admin.users.update', $u) }}">
                                    @csrf
                                    @method('PUT') <!-- Necessari perquè Laravel entengui que és una actualització -->

                                    <select
                                        name="rol"
                                        onchange="this.form.submit()" <!-- quan canvies el rol, s’envia el formulari -->
                                        style="background:#0f1115;border:1px solid #444;color:#f5f5f5;
                                               border-radius:8px;padding:4px 6px;"
                                    >
                                        <!-- Opcions de rol; marca com a seleccionada la que té l'usuari -->
                                        <option value="client" @selected($u->rol === 'client')>@lang('Client')</option>
                                        <option value="worker" @selected($u->rol === 'worker')>@lang('Treballador')</option>
                                        <option value="admin"  @selected($u->rol === 'admin')>@lang('Admin')</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <!-- Cas on no hi ha usuaris (per filtre o base de dades buida) -->
                        <tr>
                            <td colspan="4" style="padding:10px 4px;">
                                <span class="muted">@lang('No s’ha trobat cap usuari amb aquest filtre.')</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Paginació: enllaços a pàgines (1, 2, 3, següent, anterior...) -->
            <div style="margin-top:12px;">
                {{ $users->links() }}
            </div>
        </div>
    </section>
</x-app-layout>
