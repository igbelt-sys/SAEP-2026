<section class="card">
    <h2 style="margin-top: 0;">Bem-vindo, <?= htmlspecialchars((string)($usuarioNome ?? 'Operador'), ENT_QUOTES, 'UTF-8') ?>!</h2>
    <p class="muted">Painel principal da clínica.</p>
</section>

<section class="grid">
    <div class="metric">
        <span class="muted">Tutores</span>
        <strong><?= (int)($totalTutores ?? 0) ?></strong>
    </div>
    <div class="metric">
        <span class="muted">Pets</span>
        <strong><?= (int)($totalPets ?? 0) ?></strong>
    </div>
    <div class="metric">
        <span class="muted">Agendamentos</span>
        <strong><?= is_array($agendamentosRecentes ?? null) ? count($agendamentosRecentes) : 0 ?></strong>
    </div>
</section>

<section class="card">
    <div class="toolbar">
        <h3 style="margin: 0;">Próximos agendamentos</h3>
        <a href="/agendamentos">Ver todos</a>
    </div>

    <?php if (!empty($agendamentosRecentes)): ?>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Paciente</th>
                    <th>Responsável</th>
                    <th>Serviço</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agendamentosRecentes as $agendamento): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)($agendamento['data_agendamento'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string)($agendamento['pet_nome'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string)($agendamento['responsavel_nome'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string)($agendamento['servico'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="muted">Nenhum agendamento cadastrado.</p>
    <?php endif; ?>
</section>
