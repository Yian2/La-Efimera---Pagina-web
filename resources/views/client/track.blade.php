<x-app-layout>
    <section class="section">
        <div class="section-head">
            <h2 class="script">@lang('Estat de la comanda')</h2>
            <p class="muted">
                @lang('Segueix en temps real quan la teva comanda estigui llesta.')
            </p>
        </div>


        <!-- Estils específics per al timeline tipus Jira -->
        <style>
            .status-wrapper {
                display: grid;
                grid-template-columns: minmax(0, 2.2fr) minmax(0, 1fr);
                gap: 24px;
                align-items: flex-start;
            }

            @media (max-width: 768px) {
                .status-wrapper {
                    grid-template-columns: 1fr;
                }
            }

            .status-column {
                border-left: 2px solid rgba(233, 233, 234, 0.12);
                padding-left: 16px;
            }

            .status-step {
                position: relative;
                padding: 6px 0 6px 8px;
                font-size: 0.9rem;
                color: #9ca3af;
            }

            .status-step::before {
                content: "";
                position: absolute;
                left: -19px;
                top: 8px;
                width: 10px;
                height: 10px;
                border-radius: 999px;
                background: #4b5563;
                border: 2px solid #111827;
            }

            .status-step--done {
                color: #d1fae5;
            }

            .status-step--done::before {
                background: #10b981;
                border-color: #065f46;
            }

            .status-step--current {
                color: #fde68a;
                font-weight: 600;
            }

            .status-step--current::before {
                background: #fbbf24;
                border-color: #92400e;
                box-shadow: 0 0 0 4px rgba(251, 191, 36, 0.25);
            }

            .status-pill {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 4px 10px;
                border-radius: 999px;
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            .status-pill--pendiente {
                background: rgba(251, 191, 36, 0.12);
                color: #fbbf24;
                border: 1px solid rgba(251, 191, 36, 0.35);
            }

            .status-pill--preparando {
                background: rgba(59, 130, 246, 0.12);
                color: #60a5fa;
                border: 1px solid rgba(59, 130, 246, 0.4);
            }

            .status-pill--listo {
                background: rgba(52, 211, 153, 0.12);
                color: #34d399;
                border: 1px solid rgba(16, 185, 129, 0.5);
            }

            .status-pill--entregado {
                background: rgba(156, 163, 175, 0.12);
                color: #d1d5db;
                border: 1px solid rgba(107, 114, 128, 0.6);
            }
        </style>

        @if($orders->isEmpty())
            <div class="card" style="max-width:900px;margin:0 auto;">
                <p>@lang('Encara no tens comandes.')</p>
            </div>
        @else
            @foreach($orders as $pedido)
                @php
                    // ordre dels estats
                    $steps = ['pendiente', 'preparando', 'listo', 'entregado'];
                    $currentIndex = array_search($pedido->estado, $steps);
                    if ($currentIndex === false) {
                        $currentIndex = 0;
                    }
                @endphp

                <div class="card" style="max-width:900px;margin:0 auto;margin-bottom:16px;">
                    <div class="status-wrapper">
                        {{-- COL ESQUERRA: info + línies --}}
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
                                <h3 style="margin:0;">
                                    @lang('Comanda') #{{ $pedido->id }}
                                </h3>

                                {{-- xip d’estat --}}
                                <span class="status-pill status-pill--{{ $pedido->estado }}">
                                    {{ strtoupper(__($pedido->estado)) }}
                                </span>
                            </div>

                            @if($pedido->fecha_creacion)
                                <p class="muted small" style="margin:6px 0 12px;">
                                    {{ \Carbon\Carbon::parse($pedido->fecha_creacion)->format('d/m/Y H:i') }}
                                </p>
                            @endif

                            <ul class="menu-list">
                                @foreach($pedido->detalles as $det)
                                    <li>
                                        <div class="menu-line">
                                            <span class="menu-item">
                                                {{ $det->producto->nombre }} × {{ $det->cantidad }}
                                            </span>
                                            <span class="dots"></span>
                                            <span class="price">
                                                {{ number_format($det->subtotal, 2, ',', '.') }}€
                                            </span>
                                        </div>

                                        @if(!empty($det->nota))
                                            <p class="desc">
                                                <em>@lang('Nota'):</em> {{ $det->nota }}
                                            </p>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>

                            <p style="margin-top:12px;">
                                <strong>@lang('Total'):</strong>
                                {{ number_format($pedido->total, 2, ',', '.') }}€
                            </p>
                        </div>

                        {{-- COL DRETA: timeline d’estat tipus Jira --}}
                        <aside class="status-column">
                            @foreach($steps as $index => $step)
                                @php
                                    $class = '';
                                    if ($index < $currentIndex) {
                                        $class = 'status-step--done';
                                    } elseif ($index === $currentIndex) {
                                        $class = 'status-step--current';
                                    }
                                @endphp

                                <div class="status-step {{ $class }}">
                                    @lang($step)
                                </div>
                            @endforeach
                        </aside>
                    </div>
                </div>
            @endforeach
        @endif
    </section>
</x-app-layout>
