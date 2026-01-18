<x-app-layout :title="'Pàgina no trobada · La Efímera'">
    <section class="section">
        <div class="section-head" style="margin-bottom: 24px; text-align:center;">
            <p class="muted" style="letter-spacing:0.2em; text-transform:uppercase; margin-bottom:8px;">
                404
            </p>
            <h2 class="script" style="font-size:34px;">
                @lang('Pàgina no trobada')
            </h2>
            <p class="muted" style="max-width:480px;margin:8px auto 0;">
                @lang("Ups… aquesta adreça no existeix o ja no és disponible. Potser la pizza s’ha menjat la pàgina.")
            </p>
        </div>

        <div class="card" style="max-width:560px;margin:0 auto;text-align:center;">
            <p style="margin-bottom:18px;">
                @lang("Torna a l’inici o dona un cop d’ull a la carta i al Take Away.")
            </p>

            <div style="display:flex; flex-wrap:wrap; gap:10px; justify-content:center;">
                <a href="{{ route('home') }}" class="cta">
                    @lang("Tornar a l’inici")
                </a>

                <a href="{{ route('home') }}#carta" class="cta ghost">
                    @lang("Veure la carta")
                </a>

              
            </div>
        </div>
    </section>
</x-app-layout>
