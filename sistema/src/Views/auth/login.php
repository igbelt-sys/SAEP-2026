<div class="card" style="max-width: 400px; margin: 50px auto;">
    <div style="text-align:center; margin-bottom: 24px;">
        <img src="/assets/logo-vet-bem-estar.png" alt="Vet Bem Estar — Clínica Veterinária" style="display:block; width:100%; max-width:360px; height:auto; margin:0 auto;">
    </div>
    <h2 style="text-align:center; color:#16734a; margin: 0 0 8px;">Login</h2>
    <p style="text-align:center; color:#6b8a7a; font-size:0.88rem; margin: 0 0 24px;">Entre para continuar</p>

    <?php if (!empty($erro)): ?>
        <div class="alerta-erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form action="/login" method="POST">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken ?? '') ?>">
        <div class="form-group">
            <label for="email">E-mail Corporativo</label>
        <input type="email" id="email" name="email" required placeholder="seu.email@vetbemestar.com">
        </div>
        <div class="form-group">
            <label for="senha">Senha de Acesso</label>
            <input type="password" id="senha" name="senha" required placeholder="••••••••">
        </div>
        <button type="submit" class="btn" style="width:100%; margin-top:10px;">Entrar</button>
    </form>
    <div style="margin-top:20px; font-size:0.8rem; color:#64748b; text-align:center;">
        Sessão com expiração automática por inatividade após 15 minutos.
    </div>
</div>
