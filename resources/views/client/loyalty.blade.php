<x-app-layout>
    <section class="section">
        <div class="section-head">
            <h2 class="script">Punts i recompenses</h2>
            <p class="muted">Cada 500€ gastats: Tiramisù, Panna cotta o Cheesecake 🎉</p>
        </div>

        <div class="card" style="max-width:900px;margin:0 auto;">
            <p>Total gastat: <strong>{{ number_format($gastat,2,',','.') }}€</strong></p>
            <div class="progress">
                <div class="bar" style="width: {{ $progress }}%"></div>
            </div>
            <p class="muted small">Progrés actual: {{ $progress }}% cap a la propera recompensa.</p>
        </div>
    </section>
</x-app-layout>
