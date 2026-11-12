<div class="card">
    <?php if (!empty($erro)): ?>
        <div class="alerta-erro"><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2><?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?></h2>
        <a href="/tutores/novo" class="btn btn-success">+ Cadastrar Tutor</a>
    </div>

    <form action="/tutores" method="GET" style="margin-top:20px; display:flex; gap:10px;">
        <input type="text" name="q" value="<?= htmlspecialchars($busca ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Pesquise por nome, e-mail ou telefone..." style="flex:1;">
        <button type="submit" class="btn">Buscar</button>
        <?php if (!empty($busca)): ?>
            <a href="/tutores" class="btn btn-danger" style="text-decoration:none;">Limpar</a>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Tutor</th>
                <th>CPF (Protegido LGPD)</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th style="text-align:right;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($tutores)): ?>
                <tr><td colspan="6" style="text-align:center; color:#94a3b8;">Nenhum tutor encontrado para o termo pesquisado.</td></tr>
            <?php else: ?>
                <?php foreach ($tutores as $t): ?>
                    <tr>
                        <td>#<?= (int)$t['id'] ?></td>
                        <td><strong><?= htmlspecialchars($t['nome'], ENT_QUOTES, 'UTF-8') ?></strong></td>
                        <td><code><?= htmlspecialchars($t['cpf_criptografado'], ENT_QUOTES, 'UTF-8') ?></code></td>
                        <td><?= htmlspecialchars($t['telefone'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($t['email'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td style="text-align:right;">
                            <a href="/tutores/editar?id=<?= (int)$t['id'] ?>" class="btn" style="padding:4px 8px; font-size:0.75rem;">Editar</a>
                            <form action="/tutores/excluir" method="POST" style="display:inline;" onsubmit="return confirm('Deseja excluir este tutor?');">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
                                <button type="submit" class="btn btn-danger" style="padding:4px 8px; font-size:0.75rem;">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>