<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutencao — <?= defined('APP_NAME') ? APP_NAME : 'Site' ?></title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: system-ui, sans-serif; background: #0a0a12; color: #e2e8f0; min-height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 24px; }
        h1 { font-size: 2rem; margin-bottom: 12px; }
        p { color: #7a7a8e; margin-bottom: 8px; }
        .countdown { font-size: 2.5rem; font-weight: 700; color: #7c3aed; margin: 24px 0; }
    </style>
</head>
<body>
    <div>
        <h1>Em Manutencao</h1>
        <p>Estamos realizando melhorias no site.</p>
        <p>Voltaremos em breve!</p>
        <div class="countdown" id="countdown">--:--:--</div>
        <p style="font-size:0.85rem;">Se precisar de ajuda urgente, envie email para contato@site.local</p>
    </div>
    <script>
        // Countdown for 1 hour from now
        const end = Date.now() + 3600000;
        setInterval(function() {
            const diff = Math.max(0, end - Date.now());
            const h = Math.floor(diff / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            const s = Math.floor((diff % 60000) / 1000);
            document.getElementById('countdown').textContent =
                String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
        }, 1000);
    </script>
</body>
</html>
