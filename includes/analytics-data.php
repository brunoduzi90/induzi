<?php
/**
 * Dados analiticos do Painel — Funcao compartilhada
 * Usado por admin/pages/index.php (preload) e admin/api/painel/analytics.php
 */

function getAnalyticsData(PDO $db): array {
    // ── Overview (1 round-trip com subqueries) ──
    $overview = $db->query("SELECT
        (SELECT COUNT(*) FROM mensagens) AS mensagens_total,
        (SELECT COUNT(*) FROM mensagens WHERE lida = 0) AS mensagens_nao_lidas,
        (SELECT COUNT(*) FROM newsletter WHERE status = 'ativo') AS newsletter_ativos,
        (SELECT COUNT(*) FROM newsletter) AS newsletter_total,
        (SELECT COUNT(*) FROM leads) AS leads_total,
        (SELECT COUNT(*) FROM leads WHERE status = 'novo') AS leads_novos,
        (SELECT COUNT(*) FROM leads WHERE status = 'convertido') AS leads_convertidos,
        (SELECT COUNT(*) FROM users) AS users_total
    ")->fetch(PDO::FETCH_ASSOC);

    // Cast to int
    foreach ($overview as $k => $v) $overview[$k] = (int)$v;

    // ── Crescimento (este mes vs anterior) ──
    $thisMonth = date('Y-m-01');
    $lastMonth = date('Y-m-01', strtotime('-1 month'));
    $growth = [];
    foreach (['leads', 'newsletter', 'mensagens'] as $table) {
        $stmt = $db->prepare("SELECT
            SUM(created_at >= ?) AS atual,
            SUM(created_at >= ? AND created_at < ?) AS anterior
            FROM $table WHERE created_at >= ?");
        $stmt->execute([$thisMonth, $lastMonth, $thisMonth, $lastMonth]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $atual = (int)($row['atual'] ?? 0);
        $anterior = (int)($row['anterior'] ?? 0);
        $growth[$table] = [
            'atual' => $atual,
            'anterior' => $anterior,
            'percentual' => $anterior > 0 ? round((($atual - $anterior) / $anterior) * 100) : ($atual > 0 ? 100 : 0),
        ];
    }

    // ── Dados por mes (ultimos 6) — 3 queries ──
    $leadsPorMes = $db->query("SELECT DATE_FORMAT(created_at, '%Y-%m') AS mes, COUNT(*) AS total FROM leads WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) GROUP BY mes ORDER BY mes")->fetchAll(PDO::FETCH_ASSOC);
    $newsletterPorMes = $db->query("SELECT DATE_FORMAT(created_at, '%Y-%m') AS mes, COUNT(*) AS total FROM newsletter WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) GROUP BY mes ORDER BY mes")->fetchAll(PDO::FETCH_ASSOC);
    $mensagensPorMes = $db->query("SELECT DATE_FORMAT(created_at, '%Y-%m') AS mes, COUNT(*) AS total FROM mensagens WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) GROUP BY mes ORDER BY mes")->fetchAll(PDO::FETCH_ASSOC);

    // ── Leads por status e origem ──
    $leadsPorStatus = $db->query("SELECT status, COUNT(*) AS total FROM leads GROUP BY status ORDER BY total DESC")->fetchAll(PDO::FETCH_ASSOC);
    $leadsPorOrigem = $db->query("SELECT COALESCE(origem, 'Desconhecida') AS origem, COUNT(*) AS total FROM leads GROUP BY origem ORDER BY total DESC LIMIT 8")->fetchAll(PDO::FETCH_ASSOC);

    // ── Taxa de conversao ──
    $taxaConversao = $overview['leads_total'] > 0
        ? round(($overview['leads_convertidos'] / $overview['leads_total']) * 100, 1) : 0;

    // ── Recentes ──
    $leadsRecentes = $db->query("SELECT nome, email, origem, status, created_at FROM leads ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
    $atividadeRecente = $db->query("SELECT a.action, a.created_at, u.nome FROM activity_log a LEFT JOIN users u ON a.user_id = u.id ORDER BY a.created_at DESC LIMIT 8")->fetchAll(PDO::FETCH_ASSOC);

    return [
        'ok' => true,
        'overview' => $overview,
        'growth' => $growth,
        'taxa_conversao' => $taxaConversao,
        'leads_por_mes' => _fillMonths($leadsPorMes),
        'newsletter_por_mes' => _fillMonths($newsletterPorMes),
        'mensagens_por_mes' => _fillMonths($mensagensPorMes),
        'leads_por_status' => $leadsPorStatus,
        'leads_por_origem' => $leadsPorOrigem,
        'leads_recentes' => $leadsRecentes,
        'atividade_recente' => $atividadeRecente,
    ];
}

function _fillMonths(array $data): array {
    $meses = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
    $filled = [];
    for ($i = 5; $i >= 0; $i--) {
        $mes = date('Y-m', strtotime("-$i month"));
        $found = 0;
        foreach ($data as $row) {
            if ($row['mes'] === $mes) { $found = (int)$row['total']; break; }
        }
        $m = (int)substr($mes, 5, 2);
        $filled[] = ['mes' => $mes, 'label' => $meses[$m - 1], 'total' => $found];
    }
    return $filled;
}
