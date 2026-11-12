<section class="card" style="max-width: 700px; margin: 0 auto;">
    <h2 style="margin-top: 0;">Novo Agendamento</h2>

    <form method="POST" action="/agendamentos/salvar">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string)($csrfToken ?? ''), ENT_QUOTES, 'UTF-8') ?>">

        <label>
            Tutor
            <select name="tutor_id" required>
                <option value="">Selecione</option>
                <?php foreach ($tutores as $tutor): ?>
                    <option value="<?= (int)($tutor['id'] ?? 0) ?>"><?= htmlspecialchars((string)($tutor['nome'] ?? ''), ENT_QUOTES, 'UTF-8') ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            Pet
            <select name="pet_id" required>
                <option value="">Selecione</option>
                <?php foreach ($pets as $pet): ?>
                    <option value="<?= (int)($pet['id'] ?? 0) ?>"><?= htmlspecialchars((string)($pet['nome'] ?? ''), ENT_QUOTES, 'UTF-8') ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            Data do agendamento
            <input type="date" name="data_agendamento" required>
        </label>

        <label>
            Hora do agendamento
            <input type="time" name="hora_agendamento" required>
        </label>

        <label>
            Serviço
            <input type="text" name="servico" required>
        </label>

        <div style="display:flex; gap:12px;">
            <button type="submit">Salvar</button>
            <a href="/agendamentos" class="btn-secondary" style="display:inline-flex; align-items:center; justify-content:center; padding: 10px 14px; border-radius: 8px; background:#334155;">Cancelar</a>
        </div>
    </form>
</section>

