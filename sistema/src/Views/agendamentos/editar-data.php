<section class="card" style="max-width: 700px; margin: 0 auto;">
    <h2 style="margin-top: 0;">Atualizar Data do Agendamento</h2>

    <form method="POST" action="/agendamentos/atualizar-data">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string)($csrfToken ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="id" value="<?= (int)($agendamento['id'] ?? 0) ?>">

        <label>
            Data
            <input type="date" name="data_agendamento" value="<?= htmlspecialchars((string)($agendamento['data_agendamento'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required>
        </label>

        <label>
            Hora
            <input type="time" name="hora_agendamento" value="<?= htmlspecialchars((string)($agendamento['hora_agendamento'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        </label>

        <div style="display:flex; gap:12px;">
            <button type="submit">Atualizar</button>
            <a href="/agendamentos" class="btn-secondary" style="display:inline-flex; align-items:center; justify-content:center; padding: 10px 14px; border-radius: 8px; background:#334155;">Voltar</a>
        </div>
    </form>
</section>
