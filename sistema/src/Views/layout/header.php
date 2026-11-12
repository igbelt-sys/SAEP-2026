<?php
$usuarioLogado = $_SESSION['usuario_nome'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo ?? 'Vet Bem Estar — Clínica Veterinária') ?></title>
    <style>
        body { font-family: Inter, ui-sans-serif, system-ui, sans-serif; background: #f3faf6; margin: 0; color: #17352b; }
        header { background: #ffffff; padding: 16px 28px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #d9eee1; box-shadow: 0 2px 12px rgba(22, 101, 52, .06); }
        header h1 { font-size: 1.15rem; color: #16734a; margin: 0; }
        nav { display: flex; align-items: center; gap: 15px; }
        nav a { color: #47715e; text-decoration: none; font-weight: 600; font-size: 0.9rem; }
        nav a:hover { color: #16734a; }
        .user-tag { background: #edf8f0; padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; border: 1px solid #c9e8d2; color: #16734a; }
        .container { max-width: 1050px; margin: 30px auto; padding: 0 20px; }
        .card { background: #ffffff; border-radius: 14px; padding: 25px; border: 1px solid #d9eee1; box-shadow: 0 8px 24px rgba(22, 101, 52, .07); }
        .grid-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px; margin-top: 20px; }
        .stat-box { background: #f5fbf7; padding: 18px; border-radius: 10px; text-align: center; border: 1px solid #d9eee1; }
        .stat-box span { font-size: 0.8rem; color: #5b806d; text-transform: uppercase; font-weight: bold; }
        .stat-box strong { display: block; font-size: 1.8rem; color: #16734a; margin-top: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 0.88rem; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e1f0e5; }
        th { color: #47715e; font-weight: 600; background: #f5fbf7; }
        .btn { display: inline-block; background: #198754; color: white; padding: 8px 14px; border-radius: 7px; text-decoration: none; font-weight: bold; font-size: 0.85rem; border: none; cursor: pointer; }
        .btn:hover { background: #146c43; }
        .btn-success { background: #198754; }
        .btn-success:hover { background: #146c43; }
        .btn-danger { background: #dc2626; }
        .btn-danger:hover { background: #b91c1c; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 0.85rem; margin-bottom: 6px; color: #cbd5e1; font-weight: 600; }
        input, select, textarea { width: 100%; padding: 10px; border-radius: 7px; border: 1px solid #b9dac4; background: #ffffff; color: #17352b; box-sizing: border-box; }
        .alerta-erro { background: #7f1d1d; border: 1px solid #dc2626; color: #fecaca; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.85rem; }
    </style>
</head>
<body>
<header>
    <h1>Vet Bem Estar · Gestão Veterinária</h1>
    <nav>
        <?php if ($usuarioLogado): ?>
            <a href="/">Painel</a>
            <a href="/tutores">Tutores</a>
            <a href="/pets">Pets</a>
            <a href="/agendamentos">Agendamentos</a>
            <span class="user-tag">👤 <?= htmlspecialchars($usuarioLogado) ?></span>
            <form action="/logout" method="POST" style="display:inline;margin:0;">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <button type="submit" class="btn btn-danger" style="padding:5px 10px;font-size:0.8rem;">Sair</button>
            </form>
        <?php else: ?>
            <a href="/login" class="btn">Entrar</a>
        <?php endif; ?>
    </nav>
</header>
<div class="container">
