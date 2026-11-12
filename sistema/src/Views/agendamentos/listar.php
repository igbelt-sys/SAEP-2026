<section class="card">
    <div class="toolbar">
        <h2 style="margin: 0;">Agendamentos</h2>
        <a href="/agendamentos/novo" class="btn">Novo agendamento</a>
    </div>
</section>

<section class="card">
    <?php if (!empty($agendamentos)): ?>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Dados do tutor</th>
                    <th>Dados do pet</th>
                    <th>Serviço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agendamentos as $agendamento): ?>
                    <tr>
                        <td><?= htmlspecialchars(date('d/m/Y', strtotime((string)($agendamento['data_agendamento'] ?? ''))), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string)($agendamento['hora_agendamento'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <strong><?= htmlspecialchars((string)($agendamento['tutor_nome'] ?? ''), ENT_QUOTES, 'UTF-8') ?></strong><br>
                            <small><?= htmlspecialchars((string)($agendamento['tutor_telefone'] ?? ''), ENT_QUOTES, 'UTF-8') ?><br><?= htmlspecialchars((string)($agendamento['tutor_email'] ?? ''), ENT_QUOTES, 'UTF-8') ?></small>
                        </td>
                        <td>
                            <strong><?= htmlspecialchars((string)($agendamento['pet_nome'] ?? ''), ENT_QUOTES, 'UTF-8') ?></strong><br>
                            <small><?= htmlspecialchars((string)($agendamento['pet_especie'] ?? ''), ENT_QUOTES, 'UTF-8') ?> · <?= htmlspecialchars((string)($agendamento['pet_raca'] ?? ''), ENT_QUOTES, 'UTF-8') ?></small>
                        </td>
                        <td><?= htmlspecialchars((string)($agendamento['servico'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><a href="/agendamentos/editar-data?id=<?= (int)($agendamento['id'] ?? 0) ?>">Atualizar data</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="muted">Nenhum agendamento cadastrado.</p>
     
    <?php endif; ?>
</section>
