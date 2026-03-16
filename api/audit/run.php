<?php
/**
 * Induzi — Site Audit API
 * POST { "url": "https://exemplo.com" }
 * Returns JSON with 60 checks across 6 categories and a 0-100 score.
 */
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/auth.php';

requireMethod('POST');
$session = requireProject();

$input = getJsonInput();
requireFields($input, ['url']);

$url = trim($input['url']);

// Ensure scheme
if (!preg_match('#^https?://#i', $url)) {
    $url = 'https://' . $url;
}

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    jsonResponse(['ok' => false, 'msg' => 'URL invalida.'], 400);
}

// SSRF protection — block private/reserved IPs
$host = parse_url($url, PHP_URL_HOST);
if (!$host) {
    jsonResponse(['ok' => false, 'msg' => 'URL invalida.'], 400);
}

$ip = gethostbyname($host);
if ($ip === $host) {
    // gethostbyname returns the input if DNS fails
    jsonResponse(['ok' => false, 'msg' => 'Nao foi possivel resolver o dominio.'], 400);
}

if (isPrivateIp($ip)) {
    jsonResponse(['ok' => false, 'msg' => 'URLs internas nao sao permitidas.'], 400);
}

// ─── Fetch page ─────────────────────────────────────────────
$startTime = microtime(true);
$pageResult = curlFetch($url, 15);
$responseTime = round(microtime(true) - $startTime, 3);

if ($pageResult['error']) {
    jsonResponse(['ok' => false, 'msg' => 'Erro ao acessar o site: ' . $pageResult['error']], 502);
}

$html       = $pageResult['body'];
$headers    = $pageResult['headers'];
$httpCode   = $pageResult['httpCode'];
$finalUrl   = $pageResult['finalUrl'];
$pageSize   = strlen($html);

// ─── Fetch robots.txt and sitemap.xml ───────────────────────
$parsedUrl  = parse_url($finalUrl);
$origin     = ($parsedUrl['scheme'] ?? 'https') . '://' . ($parsedUrl['host'] ?? $host);
if (!empty($parsedUrl['port'])) $origin .= ':' . $parsedUrl['port'];

$robotsResult  = curlFetch($origin . '/robots.txt', 3);
$robotsTxt     = (!$robotsResult['error'] && $robotsResult['httpCode'] === 200) ? $robotsResult['body'] : '';

$sitemapResult = curlFetch($origin . '/sitemap.xml', 3);
$sitemapOk     = (!$sitemapResult['error'] && $sitemapResult['httpCode'] === 200 && stripos($sitemapResult['body'], '<urlset') !== false);

// Also check robots.txt for sitemap reference
if (!$sitemapOk && $robotsTxt) {
    if (preg_match('/^Sitemap:\s*(.+)/mi', $robotsTxt, $m)) {
        $sitemapUrl = trim($m[1]);
        $sitemapCheck = curlFetch($sitemapUrl, 3);
        $sitemapOk = (!$sitemapCheck['error'] && $sitemapCheck['httpCode'] === 200);
    }
}

// ─── Parse HTML ─────────────────────────────────────────────
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_NOWARNING | LIBXML_NOERROR);
libxml_clear_errors();
$xpath = new DOMXPath($doc);

// Header helper
$headerMap = [];
foreach ($headers as $h) {
    $pos = strpos($h, ':');
    if ($pos !== false) {
        $key = strtolower(trim(substr($h, 0, $pos)));
        $val = trim(substr($h, $pos + 1));
        $headerMap[$key] = $val;
    }
}

// ─── Run checks ─────────────────────────────────────────────
$categories = [
    'seo' => [
        'label'  => 'SEO',
        'weight' => 0.20,
        'checks' => runSeoChecks($doc, $xpath, $html, $robotsTxt, $sitemapOk),
    ],
    'marketing' => [
        'label'  => 'Marketing e Rastreamento',
        'weight' => 0.20,
        'checks' => runMarketingChecks($doc, $xpath, $html),
    ],
    'seguranca' => [
        'label'  => 'Seguranca',
        'weight' => 0.20,
        'checks' => runSecurityChecks($finalUrl, $headerMap, $html, $xpath),
    ],
    'performance' => [
        'label'  => 'Performance',
        'weight' => 0.15,
        'checks' => runPerformanceChecks($responseTime, $pageSize, $headerMap, $doc, $xpath, $html),
    ],
    'acessibilidade' => [
        'label'  => 'Acessibilidade',
        'weight' => 0.10,
        'checks' => runAccessibilityChecks($doc, $xpath),
    ],
    'estrutura' => [
        'label'  => 'Estrutura',
        'weight' => 0.15,
        'checks' => runStructureChecks($doc, $xpath, $html),
    ],
];

// ─── Calculate scores ───────────────────────────────────────
$totalScore = 0;
foreach ($categories as &$cat) {
    $catSum = 0;
    $catCount = count($cat['checks']);
    foreach ($cat['checks'] as &$check) {
        $catSum += $check['score'];
    }
    unset($check);
    $cat['score'] = $catCount > 0 ? round(($catSum / $catCount) * 100) : 0;
    $totalScore += $cat['score'] * $cat['weight'];
}
unset($cat);

jsonResponse([
    'ok'           => true,
    'url'          => $input['url'],
    'finalUrl'     => $finalUrl,
    'httpCode'     => $httpCode,
    'responseTime' => $responseTime,
    'pageSize'     => $pageSize,
    'scannedAt'    => date('c'),
    'score'        => round($totalScore),
    'categories'   => $categories,
]);

// ═══════════════════════════════════════════════════════════════
// Helper functions
// ═══════════════════════════════════════════════════════════════

function isPrivateIp(string $ip): bool {
    return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
}

function curlFetch(string $url, int $timeout): array {
    $ch = curl_init();
    $responseHeaders = [];
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS      => 5,
        CURLOPT_TIMEOUT        => $timeout,
        CURLOPT_CONNECTTIMEOUT => $timeout,
        CURLOPT_USERAGENT      => 'InduziBot/1.0 (Site Audit)',
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_ENCODING       => '',
        CURLOPT_HEADERFUNCTION => function($ch, $header) use (&$responseHeaders) {
            $responseHeaders[] = $header;
            return strlen($header);
        },
    ]);
    $body = curl_exec($ch);
    $error = curl_error($ch);
    $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    return [
        'body'     => $body ?: '',
        'headers'  => $responseHeaders,
        'httpCode' => $httpCode,
        'finalUrl' => $finalUrl ?: $url,
        'error'    => $error ?: null,
    ];
}

// ─── SEO Checks (13) ────────────────────────────────────────

function runSeoChecks(DOMDocument $doc, DOMXPath $xpath, string $html, string $robotsTxt, bool $sitemapOk): array {
    $checks = [];

    // 1. Title tag
    $titles = $doc->getElementsByTagName('title');
    $titleText = $titles->length > 0 ? trim($titles->item(0)->textContent) : '';
    $titleLen = mb_strlen($titleText);
    if (!$titleText) {
        $checks[] = check('seo.title', 'Tag <title>', 'fail', 0, 'Nenhuma tag <title> encontrada.', 'Adicione uma tag <title> com 30-60 caracteres descrevendo a pagina.');
    } elseif ($titleLen < 30 || $titleLen > 60) {
        $checks[] = check('seo.title', 'Tag <title>', 'parcial', 0.5, 'Titulo: "' . esc($titleText) . '" (' . $titleLen . ' caracteres)', 'O titulo ideal tem entre 30 e 60 caracteres.');
    } else {
        $checks[] = check('seo.title', 'Tag <title>', 'pass', 1, 'Titulo: "' . esc($titleText) . '" (' . $titleLen . ' caracteres)', '');
    }

    // 2. Meta description
    $metaDesc = getMetaContent($xpath, 'description');
    $descLen = mb_strlen($metaDesc);
    if (!$metaDesc) {
        $checks[] = check('seo.meta_description', 'Meta description', 'fail', 0, 'Nenhuma meta description encontrada.', 'Adicione <meta name="description"> com 120-160 caracteres.');
    } elseif ($descLen < 120 || $descLen > 160) {
        $checks[] = check('seo.meta_description', 'Meta description', 'parcial', 0.5, 'Descricao com ' . $descLen . ' caracteres', 'O ideal e ter entre 120 e 160 caracteres.');
    } else {
        $checks[] = check('seo.meta_description', 'Meta description', 'pass', 1, 'Descricao com ' . $descLen . ' caracteres', '');
    }

    // 3. Single H1
    $h1s = $doc->getElementsByTagName('h1');
    $h1Count = $h1s->length;
    if ($h1Count === 0) {
        $checks[] = check('seo.h1', 'Tag <h1>', 'fail', 0, 'Nenhum <h1> encontrado.', 'Cada pagina deve ter exatamente um <h1> descrevendo o conteudo principal.');
    } elseif ($h1Count > 1) {
        $checks[] = check('seo.h1', 'Tag <h1>', 'parcial', 0.5, $h1Count . ' tags <h1> encontradas.', 'Use apenas um <h1> por pagina.');
    } else {
        $h1Text = trim($h1s->item(0)->textContent);
        $checks[] = check('seo.h1', 'Tag <h1>', 'pass', 1, 'H1: "' . esc(mb_substr($h1Text, 0, 80)) . '"', '');
    }

    // 4. Heading hierarchy
    $hierarchyOk = true;
    $lastLevel = 0;
    for ($i = 1; $i <= 6; $i++) {
        $tags = $doc->getElementsByTagName('h' . $i);
        if ($tags->length > 0) {
            if ($lastLevel > 0 && $i > $lastLevel + 1) {
                $hierarchyOk = false;
                break;
            }
            $lastLevel = $i;
        }
    }
    if ($h1Count === 0 && $lastLevel === 0) {
        $checks[] = check('seo.heading_hierarchy', 'Hierarquia de headings', 'fail', 0, 'Nenhum heading encontrado.', 'Use headings (h1-h6) para estruturar o conteudo.');
    } elseif (!$hierarchyOk) {
        $checks[] = check('seo.heading_hierarchy', 'Hierarquia de headings', 'parcial', 0.5, 'Headings pulam niveis (ex: h2 direto para h4).', 'Mantenha a hierarquia sequencial: h1 > h2 > h3, etc.');
    } else {
        $checks[] = check('seo.heading_hierarchy', 'Hierarquia de headings', 'pass', 1, 'Hierarquia de headings correta.', '');
    }

    // 5. Image alt attributes
    $images = $doc->getElementsByTagName('img');
    $imgTotal = $images->length;
    $imgWithAlt = 0;
    for ($i = 0; $i < $imgTotal; $i++) {
        if ($images->item($i)->hasAttribute('alt') && trim($images->item($i)->getAttribute('alt')) !== '') {
            $imgWithAlt++;
        }
    }
    if ($imgTotal === 0) {
        $checks[] = check('seo.img_alt', 'Alt em imagens', 'pass', 1, 'Nenhuma imagem encontrada.', '');
    } elseif ($imgWithAlt === $imgTotal) {
        $checks[] = check('seo.img_alt', 'Alt em imagens', 'pass', 1, 'Todas as ' . $imgTotal . ' imagens tem alt.', '');
    } elseif ($imgWithAlt / $imgTotal >= 0.5) {
        $checks[] = check('seo.img_alt', 'Alt em imagens', 'parcial', 0.5, $imgWithAlt . '/' . $imgTotal . ' imagens com alt.', 'Todas as imagens devem ter o atributo alt descritivo.');
    } else {
        $checks[] = check('seo.img_alt', 'Alt em imagens', 'fail', 0, $imgWithAlt . '/' . $imgTotal . ' imagens com alt.', 'Adicione alt descritivo em todas as imagens.');
    }

    // 6. Canonical
    $canonical = $xpath->query('//link[@rel="canonical"]');
    if ($canonical->length > 0) {
        $checks[] = check('seo.canonical', 'Link canonical', 'pass', 1, 'Canonical: ' . esc($canonical->item(0)->getAttribute('href')), '');
    } else {
        $checks[] = check('seo.canonical', 'Link canonical', 'fail', 0, 'Nenhum link canonical encontrado.', 'Adicione <link rel="canonical"> para evitar conteudo duplicado.');
    }

    // 7. Open Graph tags
    $ogTitle = getMetaProperty($xpath, 'og:title');
    $ogDesc  = getMetaProperty($xpath, 'og:description');
    $ogImage = getMetaProperty($xpath, 'og:image');
    $ogCount = ($ogTitle ? 1 : 0) + ($ogDesc ? 1 : 0) + ($ogImage ? 1 : 0);
    if ($ogCount === 3) {
        $checks[] = check('seo.og_tags', 'Open Graph tags', 'pass', 1, 'og:title, og:description e og:image presentes.', '');
    } elseif ($ogCount > 0) {
        $missing = [];
        if (!$ogTitle) $missing[] = 'og:title';
        if (!$ogDesc) $missing[] = 'og:description';
        if (!$ogImage) $missing[] = 'og:image';
        $checks[] = check('seo.og_tags', 'Open Graph tags', 'parcial', 0.5, 'Faltam: ' . implode(', ', $missing), 'Adicione todas as OG tags para melhor compartilhamento em redes sociais.');
    } else {
        $checks[] = check('seo.og_tags', 'Open Graph tags', 'fail', 0, 'Nenhuma Open Graph tag encontrada.', 'Adicione og:title, og:description e og:image.');
    }

    // 8. robots.txt
    if ($robotsTxt) {
        $checks[] = check('seo.robots_txt', 'robots.txt', 'pass', 1, 'robots.txt acessivel.', '');
    } else {
        $checks[] = check('seo.robots_txt', 'robots.txt', 'fail', 0, 'robots.txt nao encontrado.', 'Crie um arquivo robots.txt na raiz do site.');
    }

    // 9. Sitemap
    if ($sitemapOk) {
        $checks[] = check('seo.sitemap', 'Sitemap XML', 'pass', 1, 'sitemap.xml encontrado.', '');
    } else {
        $checks[] = check('seo.sitemap', 'Sitemap XML', 'fail', 0, 'sitemap.xml nao encontrado.', 'Crie um sitemap.xml e registre no robots.txt.');
    }

    // 10. Structured data (JSON-LD)
    $jsonLd = $xpath->query('//script[@type="application/ld+json"]');
    if ($jsonLd->length > 0) {
        $checks[] = check('seo.structured_data', 'Dados estruturados', 'pass', 1, $jsonLd->length . ' bloco(s) JSON-LD encontrado(s).', '');
    } else {
        $checks[] = check('seo.structured_data', 'Dados estruturados', 'fail', 0, 'Nenhum JSON-LD encontrado.', 'Adicione dados estruturados (Schema.org) para rich snippets.');
    }

    // 11. Favicon
    $favicon = $xpath->query('//link[contains(@rel,"icon")]');
    if ($favicon->length > 0) {
        $checks[] = check('seo.favicon', 'Favicon', 'pass', 1, 'Favicon encontrado.', '');
    } else {
        $checks[] = check('seo.favicon', 'Favicon', 'fail', 0, 'Nenhum favicon linkado.', 'Adicione <link rel="icon"> no <head>.');
    }

    // 12. Twitter/X Cards
    $twCard  = getMetaContent($xpath, 'twitter:card') ?: getMetaProperty($xpath, 'twitter:card');
    $twTitle = getMetaContent($xpath, 'twitter:title') ?: getMetaProperty($xpath, 'twitter:title');
    $twImage = getMetaContent($xpath, 'twitter:image') ?: getMetaProperty($xpath, 'twitter:image');
    $twCount = ($twCard ? 1 : 0) + ($twTitle ? 1 : 0) + ($twImage ? 1 : 0);
    if ($twCount >= 2) {
        $checks[] = check('seo.twitter_cards', 'Twitter/X Cards', 'pass', 1, 'Twitter Card tags presentes.', '');
    } elseif ($twCount > 0) {
        $checks[] = check('seo.twitter_cards', 'Twitter/X Cards', 'parcial', 0.5, 'Twitter Cards incompleto (' . $twCount . '/3 tags).', 'Adicione twitter:card, twitter:title e twitter:image para previews no X/Twitter.');
    } else {
        $checks[] = check('seo.twitter_cards', 'Twitter/X Cards', 'fail', 0, 'Nenhuma Twitter Card encontrada.', 'Adicione meta tags twitter:card, twitter:title e twitter:image.');
    }

    // 13. Meta robots — verificar se nao bloqueia indexacao
    $metaRobots = getMetaContent($xpath, 'robots');
    $hasNoindex = $metaRobots && (stripos($metaRobots, 'noindex') !== false);
    if ($hasNoindex) {
        $checks[] = check('seo.meta_robots', 'Meta robots', 'fail', 0, 'Pagina com noindex! robots: "' . esc($metaRobots) . '"', 'Remova noindex se quiser que a pagina apareca no Google.');
    } else {
        $checks[] = check('seo.meta_robots', 'Meta robots', 'pass', 1, $metaRobots ? 'robots: "' . esc($metaRobots) . '"' : 'Sem restricoes de indexacao.', '');
    }

    return $checks;
}

// ─── Security Checks (10) ───────────────────────────────────

function runSecurityChecks(string $finalUrl, array $headerMap, string $html, DOMXPath $xpath): array {
    $checks = [];

    // 1. HTTPS
    $isHttps = stripos($finalUrl, 'https://') === 0;
    if ($isHttps) {
        $checks[] = check('seguranca.https', 'HTTPS', 'pass', 1, 'Site usa HTTPS.', '');
    } else {
        $checks[] = check('seguranca.https', 'HTTPS', 'fail', 0, 'Site nao usa HTTPS.', 'Ative um certificado SSL/TLS para usar HTTPS.');
    }

    // 2. HSTS
    if (!empty($headerMap['strict-transport-security'])) {
        $checks[] = check('seguranca.hsts', 'HSTS', 'pass', 1, 'Strict-Transport-Security presente.', '');
    } else {
        $checks[] = check('seguranca.hsts', 'HSTS', 'fail', 0, 'Header HSTS ausente.', 'Adicione Strict-Transport-Security para forcar HTTPS.');
    }

    // 3. CSP
    if (!empty($headerMap['content-security-policy'])) {
        $checks[] = check('seguranca.csp', 'Content Security Policy', 'pass', 1, 'CSP presente.', '');
    } else {
        $checks[] = check('seguranca.csp', 'Content Security Policy', 'fail', 0, 'Header CSP ausente.', 'Adicione Content-Security-Policy para prevenir XSS e injecoes.');
    }

    // 4. X-Content-Type-Options
    $xcto = $headerMap['x-content-type-options'] ?? '';
    if (stripos($xcto, 'nosniff') !== false) {
        $checks[] = check('seguranca.x_content_type', 'X-Content-Type-Options', 'pass', 1, 'nosniff ativo.', '');
    } else {
        $checks[] = check('seguranca.x_content_type', 'X-Content-Type-Options', 'fail', 0, 'Header X-Content-Type-Options ausente.', 'Adicione X-Content-Type-Options: nosniff.');
    }

    // 5. X-Frame-Options
    if (!empty($headerMap['x-frame-options'])) {
        $checks[] = check('seguranca.x_frame', 'X-Frame-Options', 'pass', 1, 'X-Frame-Options: ' . esc($headerMap['x-frame-options']), '');
    } else {
        $checks[] = check('seguranca.x_frame', 'X-Frame-Options', 'fail', 0, 'Header X-Frame-Options ausente.', 'Adicione X-Frame-Options: DENY ou SAMEORIGIN para prevenir clickjacking.');
    }

    // 6. Referrer-Policy
    if (!empty($headerMap['referrer-policy'])) {
        $checks[] = check('seguranca.referrer_policy', 'Referrer-Policy', 'pass', 1, 'Referrer-Policy: ' . esc($headerMap['referrer-policy']), '');
    } else {
        $checks[] = check('seguranca.referrer_policy', 'Referrer-Policy', 'fail', 0, 'Header Referrer-Policy ausente.', 'Adicione Referrer-Policy para controlar informacoes de origem.');
    }

    // 7. Permissions-Policy
    if (!empty($headerMap['permissions-policy'])) {
        $checks[] = check('seguranca.permissions_policy', 'Permissions-Policy', 'pass', 1, 'Permissions-Policy presente.', '');
    } else {
        $checks[] = check('seguranca.permissions_policy', 'Permissions-Policy', 'fail', 0, 'Header Permissions-Policy ausente.', 'Adicione Permissions-Policy para restringir funcionalidades do navegador.');
    }

    // 8. Mixed content
    if ($isHttps) {
        $mixedCount = preg_match_all('/(?:src|href|action)\s*=\s*["\']http:\/\//i', $html);
        if ($mixedCount === 0) {
            $checks[] = check('seguranca.mixed_content', 'Mixed content', 'pass', 1, 'Nenhum conteudo misto encontrado.', '');
        } else {
            $checks[] = check('seguranca.mixed_content', 'Mixed content', 'fail', 0, $mixedCount . ' recurso(s) HTTP em pagina HTTPS.', 'Altere todos os recursos para HTTPS.');
        }
    } else {
        $checks[] = check('seguranca.mixed_content', 'Mixed content', 'parcial', 0.5, 'Site nao usa HTTPS, verificacao parcial.', 'Ative HTTPS primeiro.');
    }

    // 9. Server header exposure
    $serverHeader = $headerMap['server'] ?? '';
    if (!$serverHeader) {
        $checks[] = check('seguranca.server_expose', 'Header Server', 'pass', 1, 'Header Server nao exposto.', '');
    } elseif (preg_match('/\d+\.\d+/', $serverHeader)) {
        $checks[] = check('seguranca.server_expose', 'Header Server', 'fail', 0, 'Server expoe versao: ' . esc($serverHeader), 'Remova a versao do header Server para reduzir informacoes expostas.');
    } else {
        $checks[] = check('seguranca.server_expose', 'Header Server', 'pass', 1, 'Server: ' . esc($serverHeader) . ' (sem versao).', '');
    }

    // 10. Subresource Integrity (SRI) em scripts de CDN
    $cdnScripts = $xpath->query('//script[@src[contains(.,"cdn") or contains(.,"jsdelivr") or contains(.,"cloudflare") or contains(.,"unpkg") or contains(.,"googleapis")]]');
    $cdnTotal = $cdnScripts->length;
    $sriCount = 0;
    for ($i = 0; $i < $cdnTotal; $i++) {
        if ($cdnScripts->item($i)->hasAttribute('integrity')) $sriCount++;
    }
    if ($cdnTotal === 0) {
        $checks[] = check('seguranca.sri', 'Subresource Integrity', 'pass', 1, 'Nenhum script de CDN externo encontrado.', '');
    } elseif ($sriCount === $cdnTotal) {
        $checks[] = check('seguranca.sri', 'Subresource Integrity', 'pass', 1, 'Todos os ' . $cdnTotal . ' scripts CDN tem integrity.', '');
    } elseif ($sriCount > 0) {
        $checks[] = check('seguranca.sri', 'Subresource Integrity', 'parcial', 0.5, $sriCount . '/' . $cdnTotal . ' scripts CDN com integrity.', 'Adicione o atributo integrity em todos os scripts de CDN.');
    } else {
        $checks[] = check('seguranca.sri', 'Subresource Integrity', 'fail', 0, $cdnTotal . ' script(s) CDN sem integrity.', 'Adicione integrity="sha384-..." nos scripts de CDN para prevenir adulteracao.');
    }

    return $checks;
}

// ─── Performance Checks (10) ────────────────────────────────

function runPerformanceChecks(float $responseTime, int $pageSize, array $headerMap, DOMDocument $doc, DOMXPath $xpath, string $html): array {
    $checks = [];

    // 1. Response time
    if ($responseTime < 2) {
        $checks[] = check('performance.response_time', 'Tempo de resposta', 'pass', 1, $responseTime . 's', '');
    } elseif ($responseTime < 4) {
        $checks[] = check('performance.response_time', 'Tempo de resposta', 'parcial', 0.5, $responseTime . 's (lento)', 'O ideal e responder em menos de 2 segundos.');
    } else {
        $checks[] = check('performance.response_time', 'Tempo de resposta', 'fail', 0, $responseTime . 's (muito lento)', 'Otimize o servidor para responder em menos de 2 segundos.');
    }

    // 2. Page size
    $sizeKb = round($pageSize / 1024);
    $sizeMb = round($pageSize / 1048576, 2);
    if ($pageSize < 1048576) {
        $checks[] = check('performance.page_size', 'Tamanho da pagina', 'pass', 1, $sizeKb . ' KB', '');
    } elseif ($pageSize < 3145728) {
        $checks[] = check('performance.page_size', 'Tamanho da pagina', 'parcial', 0.5, $sizeMb . ' MB (pesado)', 'Mantenha abaixo de 1 MB para carregamento rapido.');
    } else {
        $checks[] = check('performance.page_size', 'Tamanho da pagina', 'fail', 0, $sizeMb . ' MB (muito pesado)', 'Reduza o tamanho para menos de 1 MB.');
    }

    // 3. Compression
    $encoding = $headerMap['content-encoding'] ?? '';
    if (preg_match('/gzip|br|deflate/i', $encoding)) {
        $checks[] = check('performance.compression', 'Compressao', 'pass', 1, 'Content-Encoding: ' . esc($encoding), '');
    } else {
        $checks[] = check('performance.compression', 'Compressao', 'fail', 0, 'Sem compressao (gzip/brotli).', 'Ative gzip ou brotli no servidor.');
    }

    // 4. Caching headers
    $hasCache = !empty($headerMap['cache-control']) || !empty($headerMap['etag']) || !empty($headerMap['expires']);
    if ($hasCache) {
        $checks[] = check('performance.caching', 'Cache HTTP', 'pass', 1, 'Headers de cache presentes.', '');
    } else {
        $checks[] = check('performance.caching', 'Cache HTTP', 'fail', 0, 'Nenhum header de cache encontrado.', 'Adicione Cache-Control e ETag para caching eficiente.');
    }

    // 5. Modern images
    $hasModernImg = (bool)preg_match('/\.(webp|avif)/i', $html);
    if ($hasModernImg) {
        $checks[] = check('performance.modern_images', 'Imagens modernas', 'pass', 1, 'Formato WebP/AVIF detectado.', '');
    } else {
        $images = $doc->getElementsByTagName('img');
        if ($images->length === 0) {
            $checks[] = check('performance.modern_images', 'Imagens modernas', 'pass', 1, 'Nenhuma imagem encontrada.', '');
        } else {
            $checks[] = check('performance.modern_images', 'Imagens modernas', 'fail', 0, 'Nenhum formato WebP/AVIF encontrado.', 'Use WebP ou AVIF para imagens menores e mais rapidas.');
        }
    }

    // 6. Minified assets
    $hasMin = (bool)preg_match('/\.min\.(css|js)/i', $html);
    $scripts = $doc->getElementsByTagName('script');
    $links   = $xpath->query('//link[@rel="stylesheet"]');
    $totalAssets = $scripts->length + $links->length;
    if ($totalAssets === 0) {
        $checks[] = check('performance.minified', 'Assets minificados', 'pass', 1, 'Nenhum asset externo encontrado.', '');
    } elseif ($hasMin) {
        $checks[] = check('performance.minified', 'Assets minificados', 'pass', 1, 'Assets .min.js/.min.css detectados.', '');
    } else {
        $checks[] = check('performance.minified', 'Assets minificados', 'fail', 0, 'Nenhum asset minificado detectado.', 'Use versoes .min.css e .min.js em producao.');
    }

    // 7. Preload/Prefetch
    $preload = $xpath->query('//link[@rel="preload" or @rel="prefetch" or @rel="preconnect"]');
    if ($preload->length > 0) {
        $checks[] = check('performance.preload', 'Preload/Prefetch', 'pass', 1, $preload->length . ' recurso(s) com preload/prefetch.', '');
    } else {
        $checks[] = check('performance.preload', 'Preload/Prefetch', 'fail', 0, 'Nenhum preload ou prefetch encontrado.', 'Use <link rel="preload"> para recursos criticos.');
    }

    // 8. Viewport meta
    $viewport = $xpath->query('//meta[@name="viewport"]');
    if ($viewport->length > 0) {
        $checks[] = check('performance.viewport', 'Meta viewport', 'pass', 1, 'Meta viewport presente.', '');
    } else {
        $checks[] = check('performance.viewport', 'Meta viewport', 'fail', 0, 'Meta viewport ausente.', 'Adicione <meta name="viewport"> para responsividade.');
    }

    // 9. Lazy loading em imagens
    $images = $doc->getElementsByTagName('img');
    $imgTotal = $images->length;
    $lazyCount = 0;
    for ($i = 0; $i < $imgTotal; $i++) {
        if ($images->item($i)->getAttribute('loading') === 'lazy') $lazyCount++;
    }
    if ($imgTotal <= 2) {
        $checks[] = check('performance.lazy_loading', 'Lazy loading', 'pass', 1, $imgTotal === 0 ? 'Nenhuma imagem.' : 'Poucas imagens, lazy loading opcional.', '');
    } elseif ($lazyCount > 0) {
        $pct = round($lazyCount / $imgTotal * 100);
        $checks[] = check('performance.lazy_loading', 'Lazy loading', $pct >= 50 ? 'pass' : 'parcial', $pct >= 50 ? 1 : 0.5, $lazyCount . '/' . $imgTotal . ' imagens com loading="lazy" (' . $pct . '%).', $pct < 50 ? 'Adicione loading="lazy" nas imagens abaixo da dobra.' : '');
    } else {
        $checks[] = check('performance.lazy_loading', 'Lazy loading', 'fail', 0, 'Nenhuma das ' . $imgTotal . ' imagens usa loading="lazy".', 'Adicione loading="lazy" nas imagens fora da area visivel inicial.');
    }

    // 10. Quantidade de requests externos (scripts + CSS)
    $extScripts = $xpath->query('//script[@src]');
    $extCss = $xpath->query('//link[@rel="stylesheet"]');
    $totalRequests = $extScripts->length + $extCss->length;
    if ($totalRequests <= 10) {
        $checks[] = check('performance.http_requests', 'Requests externos', 'pass', 1, $totalRequests . ' arquivo(s) externo(s) (JS + CSS).', '');
    } elseif ($totalRequests <= 20) {
        $checks[] = check('performance.http_requests', 'Requests externos', 'parcial', 0.5, $totalRequests . ' arquivos externos (JS + CSS).', 'Tente manter abaixo de 10 arquivos externos combinando ou removendo dependencias.');
    } else {
        $checks[] = check('performance.http_requests', 'Requests externos', 'fail', 0, $totalRequests . ' arquivos externos (JS + CSS) — excessivo.', 'Reduza a quantidade de arquivos combinando scripts e stylesheets.');
    }

    return $checks;
}

// ─── Accessibility Checks (8) ───────────────────────────────

function runAccessibilityChecks(DOMDocument $doc, DOMXPath $xpath): array {
    $checks = [];

    // 1. Lang attribute
    $htmlEl = $doc->getElementsByTagName('html');
    $lang = ($htmlEl->length > 0) ? $htmlEl->item(0)->getAttribute('lang') : '';
    if ($lang) {
        $checks[] = check('acessibilidade.lang', 'Atributo lang', 'pass', 1, 'lang="' . esc($lang) . '"', '');
    } else {
        $checks[] = check('acessibilidade.lang', 'Atributo lang', 'fail', 0, 'Atributo lang ausente no <html>.', 'Adicione lang="pt-BR" (ou idioma correto) no <html>.');
    }

    // 2. All images have alt
    $images = $doc->getElementsByTagName('img');
    $imgTotal = $images->length;
    $imgNoAlt = 0;
    for ($i = 0; $i < $imgTotal; $i++) {
        if (!$images->item($i)->hasAttribute('alt')) {
            $imgNoAlt++;
        }
    }
    if ($imgTotal === 0) {
        $checks[] = check('acessibilidade.img_alt', 'Alt em imagens', 'pass', 1, 'Nenhuma imagem encontrada.', '');
    } elseif ($imgNoAlt === 0) {
        $checks[] = check('acessibilidade.img_alt', 'Alt em imagens', 'pass', 1, 'Todas as ' . $imgTotal . ' imagens tem alt.', '');
    } else {
        $checks[] = check('acessibilidade.img_alt', 'Alt em imagens', 'fail', 0, $imgNoAlt . ' imagem(ns) sem atributo alt.', 'Adicione alt descritivo em todas as imagens.');
    }

    // 3. Form labels
    $inputs = $xpath->query('//input[not(@type="hidden") and not(@type="submit") and not(@type="button")]|//select|//textarea');
    $inputCount = $inputs->length;
    $noLabel = 0;
    for ($i = 0; $i < $inputCount; $i++) {
        $el = $inputs->item($i);
        $id = $el->getAttribute('id');
        $hasAriaLabel = $el->hasAttribute('aria-label') || $el->hasAttribute('aria-labelledby');
        $hasTitle = $el->hasAttribute('title');
        $hasLabel = false;
        if ($id) {
            $labels = $xpath->query('//label[@for="' . $id . '"]');
            $hasLabel = $labels->length > 0;
        }
        if (!$hasLabel && !$hasAriaLabel && !$hasTitle) {
            $noLabel++;
        }
    }
    if ($inputCount === 0) {
        $checks[] = check('acessibilidade.form_labels', 'Labels em formularios', 'pass', 1, 'Nenhum campo de formulario encontrado.', '');
    } elseif ($noLabel === 0) {
        $checks[] = check('acessibilidade.form_labels', 'Labels em formularios', 'pass', 1, 'Todos os ' . $inputCount . ' campos tem label.', '');
    } else {
        $checks[] = check('acessibilidade.form_labels', 'Labels em formularios', 'fail', 0, $noLabel . ' campo(s) sem label associada.', 'Associe labels a todos os campos de formulario.');
    }

    // 4. Semantic landmarks
    $landmarks = ['nav', 'main', 'header', 'footer'];
    $found = [];
    foreach ($landmarks as $tag) {
        if ($doc->getElementsByTagName($tag)->length > 0) {
            $found[] = $tag;
        }
    }
    if (count($found) >= 3) {
        $checks[] = check('acessibilidade.landmarks', 'Elementos semanticos', 'pass', 1, 'Encontrados: ' . implode(', ', $found), '');
    } elseif (count($found) > 0) {
        $checks[] = check('acessibilidade.landmarks', 'Elementos semanticos', 'parcial', 0.5, 'Encontrados: ' . implode(', ', $found), 'Use nav, main, header e footer para melhor acessibilidade.');
    } else {
        $checks[] = check('acessibilidade.landmarks', 'Elementos semanticos', 'fail', 0, 'Nenhum elemento semantico encontrado.', 'Use tags semanticas: <nav>, <main>, <header>, <footer>.');
    }

    // 5. Empty links/buttons
    $emptyLinks = $xpath->query('//a[not(normalize-space()) and not(.//img) and not(@aria-label)]|//button[not(normalize-space()) and not(.//img) and not(.//svg) and not(@aria-label)]');
    $emptyCount = $emptyLinks->length;
    if ($emptyCount === 0) {
        $checks[] = check('acessibilidade.empty_links', 'Links/botoes vazios', 'pass', 1, 'Nenhum link ou botao vazio.', '');
    } else {
        $checks[] = check('acessibilidade.empty_links', 'Links/botoes vazios', 'fail', 0, $emptyCount . ' link(s)/botao(s) sem texto.', 'Adicione texto ou aria-label em todos os links e botoes.');
    }

    // 6. Positive tabindex
    $posTabindex = $xpath->query('//*[@tabindex > 0]');
    if ($posTabindex->length === 0) {
        $checks[] = check('acessibilidade.tabindex', 'Tabindex positivo', 'pass', 1, 'Nenhum tabindex positivo encontrado.', '');
    } else {
        $checks[] = check('acessibilidade.tabindex', 'Tabindex positivo', 'fail', 0, $posTabindex->length . ' elemento(s) com tabindex positivo.', 'Evite tabindex positivo; use 0 ou -1.');
    }

    // 7. Skip navigation link
    $skipLink = $xpath->query('//a[contains(translate(@href,"MAINCONTENT","maincontent"),"#main") or contains(translate(@class,"SKIP","skip"),"skip")]');
    if ($skipLink->length > 0) {
        $checks[] = check('acessibilidade.skip_link', 'Skip navigation', 'pass', 1, 'Link "pular navegacao" encontrado.', '');
    } else {
        $checks[] = check('acessibilidade.skip_link', 'Skip navigation', 'parcial', 0.5, 'Nenhum link de pular navegacao.', 'Adicione um link "Pular para o conteudo" no inicio da pagina para leitores de tela.');
    }

    // 8. Botoes com type definido
    $buttons = $xpath->query('//button');
    $btnTotal = $buttons->length;
    $btnNoType = 0;
    for ($i = 0; $i < $btnTotal; $i++) {
        if (!$buttons->item($i)->hasAttribute('type')) $btnNoType++;
    }
    if ($btnTotal === 0) {
        $checks[] = check('acessibilidade.button_type', 'Botoes com type', 'pass', 1, 'Nenhum botao encontrado.', '');
    } elseif ($btnNoType === 0) {
        $checks[] = check('acessibilidade.button_type', 'Botoes com type', 'pass', 1, 'Todos os ' . $btnTotal . ' botoes tem type definido.', '');
    } else {
        $checks[] = check('acessibilidade.button_type', 'Botoes com type', 'parcial', 0.5, $btnNoType . '/' . $btnTotal . ' botao(s) sem type.', 'Defina type="button" ou type="submit" em todos os <button> para evitar submissoes acidentais.');
    }

    return $checks;
}

// ─── Structure Checks (9) ───────────────────────────────────

function runStructureChecks(DOMDocument $doc, DOMXPath $xpath, string $html): array {
    $checks = [];

    // 1. DOCTYPE
    if (stripos(trim($html), '<!doctype html>') === 0 || stripos(trim($html), '<!DOCTYPE html>') === 0) {
        $checks[] = check('estrutura.doctype', 'DOCTYPE', 'pass', 1, '<!DOCTYPE html> presente.', '');
    } else {
        $checks[] = check('estrutura.doctype', 'DOCTYPE', 'fail', 0, 'DOCTYPE ausente ou invalido.', 'Adicione <!DOCTYPE html> no inicio do documento.');
    }

    // 2. Charset
    $charset = $xpath->query('//meta[@charset]|//meta[contains(@content,"charset")]');
    if ($charset->length > 0) {
        $checks[] = check('estrutura.charset', 'Charset UTF-8', 'pass', 1, 'Meta charset encontrado.', '');
    } else {
        $checks[] = check('estrutura.charset', 'Charset UTF-8', 'fail', 0, 'Meta charset ausente.', 'Adicione <meta charset="UTF-8"> no <head>.');
    }

    // 3. Viewport
    $viewport = $xpath->query('//meta[@name="viewport"]');
    if ($viewport->length > 0) {
        $checks[] = check('estrutura.viewport', 'Meta viewport', 'pass', 1, 'Meta viewport presente.', '');
    } else {
        $checks[] = check('estrutura.viewport', 'Meta viewport', 'fail', 0, 'Meta viewport ausente.', 'Adicione <meta name="viewport" content="width=device-width, initial-scale=1.0">.');
    }

    // 4. Favicon
    $favicon = $xpath->query('//link[contains(@rel,"icon")]');
    if ($favicon->length > 0) {
        $checks[] = check('estrutura.favicon', 'Favicon', 'pass', 1, 'Favicon linkado.', '');
    } else {
        $checks[] = check('estrutura.favicon', 'Favicon', 'fail', 0, 'Nenhum favicon linkado.', 'Adicione <link rel="icon"> no <head>.');
    }

    // 5. External links with rel="noopener"
    $extLinks = $xpath->query('//a[@target="_blank"]');
    $extTotal = $extLinks->length;
    $noOpener = 0;
    for ($i = 0; $i < $extTotal; $i++) {
        $rel = $extLinks->item($i)->getAttribute('rel');
        if (stripos($rel, 'noopener') !== false || stripos($rel, 'noreferrer') !== false) {
            $noOpener++;
        }
    }
    if ($extTotal === 0) {
        $checks[] = check('estrutura.noopener', 'rel="noopener"', 'pass', 1, 'Nenhum link target="_blank" encontrado.', '');
    } elseif ($noOpener === $extTotal) {
        $checks[] = check('estrutura.noopener', 'rel="noopener"', 'pass', 1, 'Todos os ' . $extTotal . ' links externos tem noopener.', '');
    } elseif ($noOpener > 0) {
        $checks[] = check('estrutura.noopener', 'rel="noopener"', 'parcial', 0.5, $noOpener . '/' . $extTotal . ' com noopener.', 'Adicione rel="noopener" em todos os links com target="_blank".');
    } else {
        $checks[] = check('estrutura.noopener', 'rel="noopener"', 'fail', 0, 'Nenhum link externo tem rel="noopener".', 'Adicione rel="noopener" em links com target="_blank".');
    }

    // 6. Semantic HTML
    $semanticTags = ['header', 'nav', 'main', 'footer', 'article', 'section', 'aside'];
    $foundTags = [];
    foreach ($semanticTags as $tag) {
        if ($doc->getElementsByTagName($tag)->length > 0) {
            $foundTags[] = $tag;
        }
    }
    if (count($foundTags) >= 4) {
        $checks[] = check('estrutura.semantic_html', 'HTML semantico', 'pass', 1, 'Tags semanticas: ' . implode(', ', $foundTags), '');
    } elseif (count($foundTags) >= 2) {
        $checks[] = check('estrutura.semantic_html', 'HTML semantico', 'parcial', 0.5, 'Tags: ' . implode(', ', $foundTags), 'Use mais tags semanticas: header, nav, main, footer, article, section.');
    } else {
        $checks[] = check('estrutura.semantic_html', 'HTML semantico', 'fail', 0, count($foundTags) > 0 ? 'Apenas: ' . implode(', ', $foundTags) : 'Nenhuma tag semantica.', 'Estruture com header, nav, main, footer.');
    }

    // 7. Apple touch icon (mobile bookmark)
    $appleIcon = $xpath->query('//link[contains(@rel,"apple-touch-icon")]');
    if ($appleIcon->length > 0) {
        $checks[] = check('estrutura.apple_touch_icon', 'Apple Touch Icon', 'pass', 1, 'apple-touch-icon encontrado.', '');
    } else {
        $checks[] = check('estrutura.apple_touch_icon', 'Apple Touch Icon', 'parcial', 0.5, 'apple-touch-icon ausente.', 'Adicione <link rel="apple-touch-icon"> para icone ao salvar na tela inicial do iPhone.');
    }

    // 8. Theme color (barra do navegador mobile)
    $themeColor = $xpath->query('//meta[@name="theme-color"]');
    if ($themeColor->length > 0) {
        $val = $themeColor->item(0)->getAttribute('content');
        $checks[] = check('estrutura.theme_color', 'Theme color', 'pass', 1, 'theme-color: ' . esc($val), '');
    } else {
        $checks[] = check('estrutura.theme_color', 'Theme color', 'parcial', 0.5, 'Meta theme-color ausente.', 'Adicione <meta name="theme-color"> para personalizar a barra do navegador mobile.');
    }

    // 9. Logo
    $logo = $xpath->query(
        '//img[contains(translate(@class,"LOGO","logo"),"logo") or contains(translate(@id,"LOGO","logo"),"logo") or contains(translate(@alt,"LOGO","logo"),"logo")]' .
        '|//*[contains(translate(@class,"LOGO","logo"),"logo")]//img' .
        '|//*[contains(translate(@class,"LOGO","logo"),"logo")]//svg' .
        '|//a[contains(translate(@class,"LOGO","logo"),"logo")]'
    );
    if ($logo->length > 0) {
        $checks[] = check('estrutura.logo', 'Logo', 'pass', 1, 'Logo encontrado na pagina.', '');
    } else {
        $checks[] = check('estrutura.logo', 'Logo', 'fail', 0, 'Nenhum logo identificado.', 'Adicione um logo com class, id ou alt contendo "logo".');
    }

    return $checks;
}

// ─── Marketing & Tracking Checks (10) ───────────────────────

function runMarketingChecks(DOMDocument $doc, DOMXPath $xpath, string $html): array {
    $checks = [];

    // 1. Google Analytics (GA4 / gtag)
    $hasGA = (bool)preg_match('/gtag\s*\(|google-analytics\.com|googletagmanager\.com\/gtag|G-[A-Z0-9]{4,}/i', $html);
    if ($hasGA) {
        $checks[] = check('marketing.analytics', 'Google Analytics', 'pass', 1, 'Google Analytics detectado.', '');
    } else {
        $checks[] = check('marketing.analytics', 'Google Analytics', 'fail', 0, 'Google Analytics nao encontrado.', 'Adicione o Google Analytics (GA4) para rastrear visitantes e conversoes.');
    }

    // 2. Google Tag Manager
    $hasGTM = (bool)preg_match('/googletagmanager\.com.*GTM-|GTM-[A-Z0-9]{4,}/i', $html);
    if ($hasGTM) {
        $checks[] = check('marketing.gtm', 'Google Tag Manager', 'pass', 1, 'GTM detectado.', '');
    } else {
        $checks[] = check('marketing.gtm', 'Google Tag Manager', 'parcial', 0.5, 'Google Tag Manager nao encontrado.', 'O GTM facilita o gerenciamento de tags e pixels sem alterar o codigo.');
    }

    // 3. Meta/Facebook Pixel
    $hasPixel = (bool)preg_match('/fbq\s*\(|facebook\.com\/tr|connect\.facebook\.net/i', $html);
    if ($hasPixel) {
        $checks[] = check('marketing.meta_pixel', 'Meta Pixel (Facebook)', 'pass', 1, 'Meta Pixel detectado.', '');
    } else {
        $checks[] = check('marketing.meta_pixel', 'Meta Pixel (Facebook)', 'fail', 0, 'Meta Pixel nao encontrado.', 'Instale o Meta Pixel para rastrear conversoes e criar publicos para anuncios.');
    }

    // 4. og:image — thumbnail para WhatsApp, Facebook, LinkedIn
    $ogImage = getMetaProperty($xpath, 'og:image');
    if ($ogImage) {
        $isAbsolute = (bool)preg_match('#^https?://#i', $ogImage);
        if ($isAbsolute) {
            $checks[] = check('marketing.og_image', 'Thumbnail de compartilhamento', 'pass', 1, 'og:image presente com URL absoluta.', '');
        } else {
            $checks[] = check('marketing.og_image', 'Thumbnail de compartilhamento', 'parcial', 0.5, 'og:image com URL relativa.', 'Use URL absoluta (https://...) na og:image para compatibilidade com WhatsApp e redes sociais.');
        }
    } else {
        $checks[] = check('marketing.og_image', 'Thumbnail de compartilhamento', 'fail', 0, 'og:image nao encontrada.', 'Adicione og:image para exibir imagem ao compartilhar no WhatsApp, Facebook e LinkedIn.');
    }

    // 5. Links de redes sociais
    $socialMap = [
        'instagram.com' => 'Instagram',
        'facebook.com'  => 'Facebook',
        'linkedin.com'  => 'LinkedIn',
        'twitter.com'   => 'Twitter/X',
        'x.com'         => 'X',
        'youtube.com'   => 'YouTube',
        'tiktok.com'    => 'TikTok',
    ];
    $foundSocials = [];
    foreach ($socialMap as $domain => $name) {
        if (stripos($html, $domain) !== false && !in_array($name, $foundSocials)) {
            $foundSocials[] = $name;
        }
    }
    if (count($foundSocials) >= 2) {
        $checks[] = check('marketing.social_links', 'Links de redes sociais', 'pass', 1, 'Encontrados: ' . implode(', ', $foundSocials), '');
    } elseif (count($foundSocials) === 1) {
        $checks[] = check('marketing.social_links', 'Links de redes sociais', 'parcial', 0.5, 'Apenas: ' . $foundSocials[0], 'Adicione links para pelo menos 2 redes sociais.');
    } else {
        $checks[] = check('marketing.social_links', 'Links de redes sociais', 'fail', 0, 'Nenhum link de rede social encontrado.', 'Adicione links para suas redes sociais (Instagram, Facebook, etc.).');
    }

    // 6. WhatsApp link/botao
    $hasWhatsApp = (bool)preg_match('/wa\.me|api\.whatsapp\.com|whatsapp/i', $html);
    if ($hasWhatsApp) {
        $checks[] = check('marketing.whatsapp', 'Link/botao WhatsApp', 'pass', 1, 'Link ou botao de WhatsApp detectado.', '');
    } else {
        $checks[] = check('marketing.whatsapp', 'Link/botao WhatsApp', 'parcial', 0.5, 'Nenhum link de WhatsApp encontrado.', 'Adicione um botao ou link de WhatsApp para facilitar o contato com clientes.');
    }

    // 7. Google Ads conversion/remarketing tag
    $hasGAds = (bool)preg_match('/googleads\.g\.doubleclick\.net|AW-[A-Z0-9]{6,}|google_tag_params|gtag\s*\(\s*[\'"]event[\'"]/i', $html);
    if ($hasGAds) {
        $checks[] = check('marketing.google_ads', 'Google Ads Tag', 'pass', 1, 'Tag do Google Ads detectada.', '');
    } else {
        $checks[] = check('marketing.google_ads', 'Google Ads Tag', 'parcial', 0.5, 'Tag do Google Ads nao encontrada.', 'Instale a tag de conversao do Google Ads se usar campanhas pagas no Google.');
    }

    // 8. TikTok Pixel
    $hasTikTok = (bool)preg_match('/analytics\.tiktok\.com|ttq\.track|ttq\.load/i', $html);
    if ($hasTikTok) {
        $checks[] = check('marketing.tiktok_pixel', 'TikTok Pixel', 'pass', 1, 'TikTok Pixel detectado.', '');
    } else {
        $checks[] = check('marketing.tiktok_pixel', 'TikTok Pixel', 'parcial', 0.5, 'TikTok Pixel nao encontrado.', 'Instale o TikTok Pixel se anunciar na plataforma.');
    }

    // 9. Hotjar / Microsoft Clarity (mapas de calor)
    $hasHotjar = (bool)preg_match('/hotjar\.com|static\.hotjar\.com|hj\s*\(\s*[\'"]identify/i', $html);
    $hasClarity = (bool)preg_match('/clarity\.ms|clarity\.microsoft\.com/i', $html);
    if ($hasHotjar || $hasClarity) {
        $tool = $hasHotjar ? 'Hotjar' : 'Microsoft Clarity';
        $checks[] = check('marketing.heatmap', 'Mapa de calor', 'pass', 1, $tool . ' detectado.', '');
    } else {
        $checks[] = check('marketing.heatmap', 'Mapa de calor', 'parcial', 0.5, 'Nenhum Hotjar ou Clarity encontrado.', 'Instale Hotjar ou Microsoft Clarity (gratis) para ver como usuarios navegam no site.');
    }

    // 10. Aviso de cookies / LGPD
    $hasCookieBanner = (bool)preg_match('/cookie.?consent|cookie.?banner|cookie.?notice|lgpd|gdpr|cookieyes|onetrust|termly|complianz|cookie.?law|cookie.?policy/i', $html);
    if ($hasCookieBanner) {
        $checks[] = check('marketing.cookie_consent', 'Aviso de cookies (LGPD)', 'pass', 1, 'Banner de cookies/LGPD detectado.', '');
    } else {
        $checks[] = check('marketing.cookie_consent', 'Aviso de cookies (LGPD)', 'fail', 0, 'Nenhum aviso de cookies encontrado.', 'Adicione um banner de consentimento de cookies para conformidade com a LGPD.');
    }

    return $checks;
}

// ─── Utility ─────────────────────────────────────────────────

function check(string $id, string $name, string $status, float $score, string $detail, string $tip): array {
    return compact('id', 'name', 'status', 'score', 'detail', 'tip');
}

function esc(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function getMetaContent(DOMXPath $xpath, string $name): string {
    $nodes = $xpath->query('//meta[@name="' . $name . '"]');
    return $nodes->length > 0 ? trim($nodes->item(0)->getAttribute('content')) : '';
}

function getMetaProperty(DOMXPath $xpath, string $property): string {
    $nodes = $xpath->query('//meta[@property="' . $property . '"]');
    return $nodes->length > 0 ? trim($nodes->item(0)->getAttribute('content')) : '';
}
