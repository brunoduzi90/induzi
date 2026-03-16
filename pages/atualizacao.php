<?php require_once __DIR__ . '/../includes/fragment.php'; spaFragmentStart(); ?>
<?php require_once __DIR__ . '/../includes/db.php'; ?>
<?php require_once __DIR__ . '/../includes/helpers.php'; ?>
<?php require_once __DIR__ . '/../includes/auth.php'; ?>
<?php require_once __DIR__ . '/../version.php'; ?>
<?php $sbInPages = true; $sbPrefix = ''; $sbRoot = '../'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Atualizacao do Sistema — Induzi</title>
<link rel="stylesheet" href="../css/style.css?v=<?= INDUZI_VERSION ?>">
<style>
/* ─── Layout ─── */
.update-page {
    max-width: 960px;
    margin: 0 auto;
    padding: 20px 20px 60px;
}
.update-page > h2 {
    font-size: 1.35rem;
    font-weight: 700;
    color: var(--color-black);
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.update-page > h2 svg {
    width: 22px;
    height: 22px;
    stroke: var(--color-accent);
}
.update-page > .update-subtitle {
    font-size: 0.82rem;
    color: var(--color-gray);
    margin-bottom: 24px;
}

/* ─── Tabs ─── */
.update-tabs {
    display: flex;
    gap: 0;
    border-bottom: 2px solid var(--color-border);
    margin-bottom: 28px;
}
.update-tab {
    padding: 10px 20px;
    font-size: 0.88rem;
    font-weight: 500;
    color: var(--color-gray);
    background: none;
    border: none;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    cursor: pointer;
    transition: color 0.15s, border-color 0.15s;
    font-family: inherit;
    display: flex;
    align-items: center;
    gap: 6px;
}
.update-tab:hover {
    color: var(--color-black);
}
.update-tab.active {
    color: var(--color-accent);
    border-bottom-color: var(--color-accent);
    font-weight: 600;
}
.update-tab svg {
    width: 16px;
    height: 16px;
}
.update-tab-panel {
    display: none;
}
.update-tab-panel.active {
    display: block;
}

/* ─── Cards ─── */
.upd-card {
    background: var(--color-white);
    border: 1px solid var(--color-border);
    border-radius: 12px;
    padding: 20px 24px;
    margin-bottom: 20px;
    transition: box-shadow 0.15s;
}
.upd-card:hover {
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}
.upd-card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 14px;
}
.upd-card-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.upd-card-icon svg {
    width: 20px;
    height: 20px;
}
.upd-card-icon.purple {
    background: rgba(139,92,246,0.1);
    color: var(--color-accent);
}
.upd-card-icon.green {
    background: var(--color-success-bg);
    color: var(--color-success);
}
.upd-card-icon.orange {
    background: var(--color-warning-bg);
    color: #f59e0b;
}
.upd-card-icon.red {
    background: var(--color-danger-bg);
    color: #ef4444;
}
.upd-card-icon.blue {
    background: rgba(59,130,246,0.1);
    color: #3b82f6;
}
.upd-card-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--color-black);
}
.upd-card-desc {
    font-size: 0.82rem;
    color: var(--color-gray);
    margin-top: 2px;
}

/* ─── Version card ─── */
.version-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.version-item {
    padding: 14px 16px;
    background: var(--color-bg);
    border-radius: 8px;
    border: 1px solid var(--color-border);
}
.version-label {
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--color-gray);
    text-transform: uppercase;
    letter-spacing: 0.3px;
    margin-bottom: 4px;
}
.version-value {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--color-black);
}
.version-value.accent {
    color: var(--color-accent);
}

/* ─── Update check result ─── */
.update-result {
    margin-top: 16px;
    padding: 16px;
    border-radius: 10px;
    font-size: 0.88rem;
    display: none;
}
.update-result.show {
    display: block;
}
.update-result.up-to-date {
    background: var(--color-success-bg);
    color: var(--color-success);
    border: 1px solid var(--color-success);
}
.update-result.has-update {
    background: var(--color-warning-bg);
    color: #92400e;
    border: 1px solid #f59e0b;
}
.update-result.error {
    background: var(--color-danger-bg);
    color: #991b1b;
    border: 1px solid #ef4444;
}
.update-result-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    margin-bottom: 6px;
}
.update-result-header svg {
    width: 18px;
    height: 18px;
}
.update-result-body {
    font-size: 0.82rem;
    line-height: 1.5;
}
.update-result-actions {
    margin-top: 12px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

/* ─── Backups table ─── */
.backup-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 12px;
    font-size: 0.85rem;
}
.backup-table th {
    text-align: left;
    padding: 10px 12px;
    font-weight: 600;
    color: var(--color-gray);
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    border-bottom: 2px solid var(--color-border);
    background: var(--color-bg);
}
.backup-table td {
    padding: 10px 12px;
    border-bottom: 1px solid var(--color-border);
    color: var(--color-black);
    vertical-align: middle;
}
.backup-table tr:last-child td {
    border-bottom: none;
}
.backup-table tr:hover td {
    background: var(--color-bg);
}
.backup-empty {
    padding: 30px 16px;
    text-align: center;
    color: var(--color-gray);
    font-size: 0.85rem;
}
.backup-actions {
    display: flex;
    gap: 6px;
}

/* ─── Buttons ─── */
.btn-update {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 18px;
    border: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: opacity 0.15s, transform 0.1s;
    white-space: nowrap;
}
.btn-update:hover {
    opacity: 0.9;
}
.btn-update:active {
    transform: scale(0.98);
}
.btn-update:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}
.btn-update svg {
    width: 16px;
    height: 16px;
}
.btn-primary {
    background: var(--color-accent);
    color: #fff;
}
.btn-secondary {
    background: var(--color-bg);
    color: var(--color-black);
    border: 1px solid var(--color-border);
}
.btn-danger {
    background: #ef4444;
    color: #fff;
}
.btn-success {
    background: var(--color-success);
    color: #fff;
}
.btn-warning {
    background: #f59e0b;
    color: #fff;
}
.btn-sm {
    padding: 6px 12px;
    font-size: 0.78rem;
    border-radius: 6px;
}
.btn-sm svg {
    width: 14px;
    height: 14px;
}

/* ─── Manual update toggle ─── */
.manual-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 16px;
    background: var(--color-bg);
    border: 1px solid var(--color-border);
    border-radius: 8px;
    cursor: pointer;
    margin-bottom: 20px;
    font-size: 0.85rem;
    color: var(--color-gray);
    transition: color 0.15s, border-color 0.15s;
    user-select: none;
}
.manual-toggle:hover {
    color: var(--color-black);
    border-color: var(--color-gray-light);
}
.manual-toggle svg {
    width: 16px;
    height: 16px;
    transition: transform 0.2s;
}
.manual-toggle.open svg {
    transform: rotate(90deg);
}
.manual-section {
    display: none;
}
.manual-section.show {
    display: block;
}

/* ─── File upload ─── */
.file-upload-zone {
    border: 2px dashed var(--color-border);
    border-radius: 10px;
    padding: 30px;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
    margin-top: 12px;
}
.file-upload-zone:hover,
.file-upload-zone.dragover {
    border-color: var(--color-accent);
    background: rgba(139,92,246,0.03);
}
.file-upload-zone svg {
    width: 36px;
    height: 36px;
    stroke: var(--color-gray-light);
    margin-bottom: 8px;
}
.file-upload-zone p {
    font-size: 0.85rem;
    color: var(--color-gray);
    margin: 0 0 4px;
}
.file-upload-zone .hint {
    font-size: 0.75rem;
    color: var(--color-gray-light);
}
.file-selected {
    margin-top: 10px;
    padding: 10px 14px;
    background: var(--color-bg);
    border: 1px solid var(--color-border);
    border-radius: 8px;
    display: none;
    align-items: center;
    gap: 10px;
    font-size: 0.85rem;
    color: var(--color-black);
}
.file-selected.show {
    display: flex;
}
.file-selected svg {
    width: 18px;
    height: 18px;
    color: var(--color-accent);
    flex-shrink: 0;
}
.file-selected .file-name {
    flex: 1;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.file-selected .file-size {
    font-size: 0.78rem;
    color: var(--color-gray);
    flex-shrink: 0;
}

/* ─── Progress bar ─── */
.progress-bar-wrap {
    width: 100%;
    height: 6px;
    background: var(--color-border);
    border-radius: 3px;
    margin-top: 12px;
    overflow: hidden;
    display: none;
}
.progress-bar-wrap.show {
    display: block;
}
.progress-bar-fill {
    height: 100%;
    border-radius: 3px;
    background: var(--color-accent);
    transition: width 0.3s ease;
    width: 0%;
}
.progress-text {
    font-size: 0.78rem;
    color: var(--color-gray);
    margin-top: 6px;
    display: none;
}
.progress-text.show {
    display: block;
}

/* ─── Timeline (Historico) ─── */
.timeline {
    position: relative;
    padding-left: 28px;
}
.timeline::before {
    content: '';
    position: absolute;
    left: 9px;
    top: 4px;
    bottom: 4px;
    width: 2px;
    background: var(--color-border);
    border-radius: 1px;
}
.timeline-item {
    position: relative;
    margin-bottom: 28px;
    padding-bottom: 0;
}
.timeline-item:last-child {
    margin-bottom: 0;
}
.timeline-dot {
    position: absolute;
    left: -28px;
    top: 4px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: var(--color-white);
    border: 2px solid var(--color-border);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1;
}
.timeline-dot svg {
    width: 10px;
    height: 10px;
}
.timeline-dot.current {
    border-color: var(--color-accent);
    background: var(--color-accent);
}
.timeline-dot.current svg {
    color: #fff;
}
.timeline-dot.past {
    border-color: var(--color-gray-light);
}
.timeline-dot.past svg {
    color: var(--color-gray-light);
}
.timeline-version {
    font-size: 1rem;
    font-weight: 700;
    color: var(--color-black);
    margin-bottom: 2px;
}
.timeline-date {
    font-size: 0.78rem;
    color: var(--color-gray);
    margin-bottom: 10px;
}
.timeline-changes {
    list-style: none;
    padding: 0;
    margin: 0;
}
.timeline-changes li {
    font-size: 0.84rem;
    color: var(--color-gray-dark, var(--color-black));
    padding: 4px 0;
    display: flex;
    align-items: flex-start;
    gap: 8px;
}
.timeline-changes li::before {
    content: '';
    display: none;
}
.change-badge {
    display: inline-flex;
    align-items: center;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    flex-shrink: 0;
    margin-top: 1px;
}
.change-badge.new {
    background: var(--color-success-bg);
    color: var(--color-success);
}
.change-badge.fix {
    background: var(--color-danger-bg);
    color: #ef4444;
}
.change-badge.improve {
    background: var(--color-warning-bg);
    color: #92400e;
}
.change-badge.change {
    background: rgba(59,130,246,0.1);
    color: #3b82f6;
}
.change-badge.security {
    background: rgba(139,92,246,0.1);
    color: var(--color-accent);
}

/* ─── Maintenance cards ─── */
.maint-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 28px;
}
.maint-card {
    background: var(--color-white);
    border: 1px solid var(--color-border);
    border-radius: 10px;
    padding: 18px 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.maint-card-top {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}
.maint-card-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.maint-card-icon svg {
    width: 18px;
    height: 18px;
}
.maint-card-icon.purple {
    background: rgba(139,92,246,0.1);
    color: var(--color-accent);
}
.maint-card-icon.blue {
    background: rgba(59,130,246,0.1);
    color: #3b82f6;
}
.maint-card-icon.orange {
    background: var(--color-warning-bg);
    color: #f59e0b;
}
.maint-card-icon.green {
    background: var(--color-success-bg);
    color: var(--color-success);
}
.maint-card-info {
    flex: 1;
    min-width: 0;
}
.maint-card-title {
    font-size: 0.92rem;
    font-weight: 600;
    color: var(--color-black);
    margin-bottom: 2px;
}
.maint-card-desc {
    font-size: 0.78rem;
    color: var(--color-gray);
    line-height: 1.4;
}
.maint-card-bottom {
    display: flex;
    justify-content: flex-end;
}

/* ─── System Status ─── */
.status-section-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--color-black);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.status-section-title svg {
    width: 18px;
    height: 18px;
    color: var(--color-accent);
}
.status-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.status-card {
    background: var(--color-white);
    border: 1px solid var(--color-border);
    border-radius: 10px;
    padding: 18px 20px;
}
.status-card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
}
.status-card-header svg {
    width: 18px;
    height: 18px;
    color: var(--color-accent);
}
.status-card-header span {
    font-size: 0.92rem;
    font-weight: 600;
    color: var(--color-black);
}
.status-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.status-list li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 7px 0;
    border-bottom: 1px solid var(--color-border);
    font-size: 0.82rem;
}
.status-list li:last-child {
    border-bottom: none;
}
.status-list .s-label {
    color: var(--color-gray);
}
.status-list .s-value {
    color: var(--color-black);
    font-weight: 500;
    text-align: right;
    word-break: break-all;
}
.status-list .s-value.ok {
    color: var(--color-success);
}
.status-list .s-value.warn {
    color: #f59e0b;
}
.status-list .s-value.err {
    color: #ef4444;
}

/* ─── Spinner ─── */
.spinner-inline {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
    vertical-align: middle;
}
@keyframes spin {
    to { transform: rotate(360deg); }
}

/* ─── Loading skeleton ─── */
.skel-line {
    height: 14px;
    background: var(--color-border);
    border-radius: 4px;
    margin-bottom: 8px;
    animation: skel-pulse 1.2s infinite ease-in-out;
}
.skel-line.w60 { width: 60%; }
.skel-line.w40 { width: 40%; }
.skel-line.w80 { width: 80%; }
@keyframes skel-pulse {
    0%, 100% { opacity: 0.4; }
    50% { opacity: 1; }
}

/* ─── Responsive ─── */
@media (max-width: 768px) {
    .update-page {
        padding: 16px 14px 48px;
    }
    .update-page > h2 {
        font-size: 1.15rem;
    }
    .version-grid {
        grid-template-columns: 1fr;
    }
    .maint-grid {
        grid-template-columns: 1fr;
    }
    .status-grid {
        grid-template-columns: 1fr;
    }
    .update-tabs {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .update-tab {
        padding: 10px 14px;
        font-size: 0.82rem;
    }
    .backup-table {
        font-size: 0.78rem;
    }
    .backup-table th,
    .backup-table td {
        padding: 8px;
    }
    .upd-card {
        padding: 16px 18px;
    }
    .file-upload-zone {
        padding: 20px;
    }
}
@media (max-width: 480px) {
    .update-page {
        padding: 12px 10px 40px;
    }
    .update-page > h2 {
        font-size: 1.05rem;
        gap: 8px;
    }
    .update-page > h2 svg {
        width: 18px;
        height: 18px;
    }
    .update-tab {
        padding: 8px 10px;
        font-size: 0.78rem;
        gap: 4px;
    }
    .update-tab svg {
        width: 14px;
        height: 14px;
    }
    .upd-card {
        padding: 14px 14px;
        border-radius: 10px;
    }
    .upd-card-header {
        gap: 10px;
        margin-bottom: 12px;
    }
    .upd-card-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
    }
    .upd-card-icon svg {
        width: 16px;
        height: 16px;
    }
    .upd-card-title {
        font-size: 0.92rem;
    }
    .upd-card-desc {
        font-size: 0.78rem;
    }
    .version-item {
        padding: 12px 14px;
    }
    .version-label {
        font-size: 0.7rem;
    }
    .version-value {
        font-size: 1rem;
    }
    .btn-update {
        padding: 8px 14px;
        font-size: 0.8rem;
    }
    .maint-card {
        padding: 14px 16px;
    }
    .maint-card-title {
        font-size: 0.85rem;
    }
    .maint-card-desc {
        font-size: 0.75rem;
    }
    .status-card {
        padding: 14px 16px;
    }
    .status-card-header span {
        font-size: 0.85rem;
    }
    .status-list li {
        font-size: 0.78rem;
        flex-direction: column;
        align-items: flex-start;
        gap: 2px;
    }
    .status-list .s-value {
        text-align: left;
    }
    .timeline {
        padding-left: 24px;
    }
    .timeline-dot {
        left: -24px;
        width: 16px;
        height: 16px;
    }
    .timeline-dot svg {
        width: 8px;
        height: 8px;
    }
    .timeline-version {
        font-size: 0.92rem;
    }
    .timeline-changes li {
        font-size: 0.8rem;
        flex-direction: column;
        gap: 4px;
    }
    .backup-table thead {
        display: none;
    }
    .backup-table tr {
        display: flex;
        flex-direction: column;
        padding: 10px 0;
        border-bottom: 1px solid var(--color-border);
    }
    .backup-table td {
        border-bottom: none;
        padding: 3px 0;
    }
    .backup-actions {
        margin-top: 6px;
    }
    .update-result-actions {
        flex-direction: column;
    }
    .update-result-actions .btn-update {
        width: 100%;
        justify-content: center;
    }
}

/* ─── Print ─── */
@media print {
    .update-tabs,
    .btn-update,
    .manual-toggle,
    .manual-section,
    .file-upload-zone,
    .maint-card-bottom {
        display: none !important;
    }
    .update-tab-panel {
        display: block !important;
    }
    .upd-card,
    .maint-card,
    .status-card {
        break-inside: avoid;
        box-shadow: none;
    }
}
</style>
</head>
<body>

<?php if (!isset($_GET['fragment'])): ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>
<?php endif; ?>
<div class="main-content">

<div class="update-page">
    <h2>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"></polyline><polyline points="23 20 23 14 17 14"></polyline><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path></svg>
        Atualizacao do Sistema
    </h2>
    <div class="update-subtitle">Gerencie versoes, atualizacoes e manutencao do sistema Induzi.</div>

    <!-- ─── Tabs ─── -->
    <div class="update-tabs">
        <button class="update-tab active" data-tab="atualizacao" onclick="switchUpdateTab('atualizacao')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
            Atualizacao
        </button>
        <button class="update-tab" data-tab="historico" onclick="switchUpdateTab('historico')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            Historico
        </button>
        <button class="update-tab" data-tab="manutencao" onclick="switchUpdateTab('manutencao')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
            Manutencao
        </button>
    </div>

    <!-- ════════════════════════════════════════ -->
    <!-- TAB 1: ATUALIZACAO                       -->
    <!-- ════════════════════════════════════════ -->
    <div class="update-tab-panel active" id="panelAtualizacao">

        <!-- Version Card -->
        <div class="upd-card">
            <div class="upd-card-header">
                <div class="upd-card-icon purple">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"></path><line x1="16" y1="8" x2="2" y2="22"></line><line x1="17.5" y1="15" x2="9" y2="15"></line></svg>
                </div>
                <div>
                    <div class="upd-card-title">Versao Atual</div>
                    <div class="upd-card-desc">Informacoes sobre a versao instalada do sistema</div>
                </div>
            </div>
            <div class="version-grid">
                <div class="version-item">
                    <div class="version-label">Versao</div>
                    <div class="version-value accent" id="currentVersion">
                        <div class="skel-line w40"></div>
                    </div>
                </div>
                <div class="version-item">
                    <div class="version-label">Data da Versao</div>
                    <div class="version-value" id="currentVersionDate">
                        <div class="skel-line w60"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Remote Update Card -->
        <div class="upd-card">
            <div class="upd-card-header">
                <div class="upd-card-icon green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 16 12 12 8 16"></polyline><line x1="12" y1="12" x2="12" y2="21"></line><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path><polyline points="16 16 12 12 8 16"></polyline></svg>
                </div>
                <div>
                    <div class="upd-card-title">Atualizacao Remota</div>
                    <div class="upd-card-desc">Verifique e instale atualizacoes automaticamente do repositorio</div>
                </div>
            </div>
            <button class="btn-update btn-primary" id="btnVerificar" onclick="verificarAtualizacoes()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                Verificar Atualizacoes
            </button>
            <div class="update-result" id="updateResult"></div>
            <div class="progress-bar-wrap" id="updateProgress">
                <div class="progress-bar-fill" id="updateProgressFill"></div>
            </div>
            <div class="progress-text" id="updateProgressText"></div>
        </div>

        <!-- Backups Card -->
        <div class="upd-card">
            <div class="upd-card-header">
                <div class="upd-card-icon blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                </div>
                <div>
                    <div class="upd-card-title">Backups</div>
                    <div class="upd-card-desc">Backups automaticos criados antes de cada atualizacao</div>
                </div>
            </div>
            <div id="backupContent">
                <div class="backup-empty">
                    <span class="spinner-inline"></span> Carregando backups...
                </div>
            </div>
        </div>

        <!-- Manual Update Toggle -->
        <div class="manual-toggle" id="manualToggle" onclick="toggleManual()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            Atualizacao Manual (Avancado)
        </div>

        <!-- Manual Update Section -->
        <div class="manual-section" id="manualSection">

            <!-- Generate Package -->
            <div class="upd-card">
                <div class="upd-card-header">
                    <div class="upd-card-icon orange">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <div>
                        <div class="upd-card-title">Gerar Pacote de Atualizacao</div>
                        <div class="upd-card-desc">Cria um arquivo ZIP com a versao atual para distribuicao</div>
                    </div>
                </div>
                <button class="btn-update btn-warning" id="btnGerarPacote" onclick="gerarPacote()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                    Gerar Pacote
                </button>
                <div class="progress-bar-wrap" id="packageProgress">
                    <div class="progress-bar-fill" id="packageProgressFill"></div>
                </div>
                <div class="progress-text" id="packageProgressText"></div>
            </div>

            <!-- Apply Update -->
            <div class="upd-card">
                <div class="upd-card-header">
                    <div class="upd-card-icon red">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    </div>
                    <div>
                        <div class="upd-card-title">Aplicar Atualizacao Manual</div>
                        <div class="upd-card-desc">Envie um arquivo ZIP de atualizacao para instalar manualmente</div>
                    </div>
                </div>

                <div class="file-upload-zone" id="fileUploadZone" onclick="document.getElementById('fileInput').click()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    <p>Clique ou arraste o arquivo ZIP aqui</p>
                    <span class="hint">Somente arquivos .zip ate 50MB</span>
                </div>
                <input type="file" id="fileInput" accept=".zip" style="display:none" onchange="setSelectedFile(this.files[0])">

                <div class="file-selected" id="fileSelected">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                    <span class="file-name" id="fileName"></span>
                    <span class="file-size" id="fileSize"></span>
                </div>

                <div style="margin-top: 14px;">
                    <button class="btn-update btn-danger" id="btnAplicar" onclick="aplicarAtualizacao()" disabled>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Aplicar Atualizacao
                    </button>
                </div>
                <div class="progress-bar-wrap" id="applyProgress">
                    <div class="progress-bar-fill" id="applyProgressFill"></div>
                </div>
                <div class="progress-text" id="applyProgressText"></div>
            </div>

        </div><!-- /manual-section -->
    </div><!-- /panelAtualizacao -->

    <!-- ════════════════════════════════════════ -->
    <!-- TAB 2: HISTORICO                         -->
    <!-- ════════════════════════════════════════ -->
    <div class="update-tab-panel" id="panelHistorico">
        <div class="upd-card">
            <div class="upd-card-header">
                <div class="upd-card-icon purple">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                <div>
                    <div class="upd-card-title">Historico de Versoes</div>
                    <div class="upd-card-desc">Registro de todas as versoes e alteracoes do sistema</div>
                </div>
            </div>
            <div id="historicoContent">
                <div class="backup-empty">
                    <span class="spinner-inline"></span> Carregando historico...
                </div>
            </div>
        </div>
    </div><!-- /panelHistorico -->

    <!-- ════════════════════════════════════════ -->
    <!-- TAB 3: MANUTENCAO                        -->
    <!-- ════════════════════════════════════════ -->
    <div class="update-tab-panel" id="panelManutencao">

        <!-- Cleanup Cards -->
        <div style="margin-bottom: 8px;">
            <div class="status-section-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                Limpeza
            </div>
        </div>
        <div class="maint-grid">

            <!-- SW Cache -->
            <div class="maint-card">
                <div class="maint-card-top">
                    <div class="maint-card-icon purple">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </div>
                    <div class="maint-card-info">
                        <div class="maint-card-title">Cache Service Worker</div>
                        <div class="maint-card-desc">Remove caches armazenados pelo service worker do navegador</div>
                    </div>
                </div>
                <div class="maint-card-bottom">
                    <button class="btn-update btn-secondary btn-sm" onclick="limparCacheSW()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        Limpar
                    </button>
                </div>
            </div>

            <!-- SPA Cache -->
            <div class="maint-card">
                <div class="maint-card-top">
                    <div class="maint-card-icon blue">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
                    </div>
                    <div class="maint-card-info">
                        <div class="maint-card-title">Cache SPA</div>
                        <div class="maint-card-desc">Limpa fragmentos de pagina em cache do roteador SPA</div>
                    </div>
                </div>
                <div class="maint-card-bottom">
                    <button class="btn-update btn-secondary btn-sm" onclick="limparCacheSPA()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        Limpar
                    </button>
                </div>
            </div>

            <!-- localStorage -->
            <div class="maint-card">
                <div class="maint-card-top">
                    <div class="maint-card-icon orange">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                    </div>
                    <div class="maint-card-info">
                        <div class="maint-card-title">localStorage</div>
                        <div class="maint-card-desc">Remove dados locais do Induzi (preferencias, cache de sessao)</div>
                    </div>
                </div>
                <div class="maint-card-bottom">
                    <button class="btn-update btn-secondary btn-sm" onclick="limparLocalStorage()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        Limpar
                    </button>
                </div>
            </div>

            <!-- OPcache -->
            <div class="maint-card">
                <div class="maint-card-top">
                    <div class="maint-card-icon green">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polyline></svg>
                    </div>
                    <div class="maint-card-info">
                        <div class="maint-card-title">OPcache</div>
                        <div class="maint-card-desc">Limpa o cache de opcodes PHP do servidor (se disponivel)</div>
                    </div>
                </div>
                <div class="maint-card-bottom">
                    <button class="btn-update btn-secondary btn-sm" onclick="limparOPcache()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        Limpar
                    </button>
                </div>
            </div>

        </div><!-- /maint-grid -->

        <!-- System Status -->
        <div class="status-section-title" style="margin-top: 12px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
            Status do Sistema
        </div>
        <div class="status-grid" id="statusGrid">
            <!-- Server -->
            <div class="status-card">
                <div class="status-card-header">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
                    <span>Servidor</span>
                </div>
                <ul class="status-list" id="statusServer">
                    <li><span class="s-label">Carregando...</span><span class="s-value"><span class="spinner-inline"></span></span></li>
                </ul>
            </div>

            <!-- Database -->
            <div class="status-card">
                <div class="status-card-header">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                    <span>Banco de Dados</span>
                </div>
                <ul class="status-list" id="statusDatabase">
                    <li><span class="s-label">Carregando...</span><span class="s-value"><span class="spinner-inline"></span></span></li>
                </ul>
            </div>

            <!-- Storage -->
            <div class="status-card">
                <div class="status-card-header">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                    <span>Armazenamento</span>
                </div>
                <ul class="status-list" id="statusStorage">
                    <li><span class="s-label">Carregando...</span><span class="s-value"><span class="spinner-inline"></span></span></li>
                </ul>
            </div>

            <!-- Application -->
            <div class="status-card">
                <div class="status-card-header">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                    <span>Aplicacao</span>
                </div>
                <ul class="status-list" id="statusApp">
                    <li><span class="s-label">Carregando...</span><span class="s-value"><span class="spinner-inline"></span></span></li>
                </ul>
            </div>
        </div>

    </div><!-- /panelManutencao -->

</div><!-- /update-page -->

</div><!-- /main-content -->

<script>
/* ═══════════════════════════════════════════════════════════════
   Atualizacao do Sistema — Induzi
   ═══════════════════════════════════════════════════════════════ */

let _selectedFile = null;
let _remoteUpdateData = null;

/* ─── Init ─── */
(async function() {
    try {
        const resp = await fetch('api/atualizacao/versao.php');
        const data = await resp.json();
        if (data.ok) {
            document.getElementById('currentVersion').textContent = data.data.version;
            document.getElementById('currentVersionDate').textContent = data.data.date;
        } else {
            document.getElementById('currentVersion').textContent = '?';
            document.getElementById('currentVersionDate').textContent = '-';
        }
    } catch (e) {
        document.getElementById('currentVersion').textContent = '?';
        document.getElementById('currentVersionDate').textContent = '-';
    }
    carregarBackups();
    verificarAtualizacoes();
})();


/* ─── Tab Switching ─── */
function switchUpdateTab(tab) {
    document.querySelectorAll('.update-tab').forEach(function(t) {
        t.classList.toggle('active', t.dataset.tab === tab);
    });
    document.querySelectorAll('.update-tab-panel').forEach(function(p) {
        p.classList.remove('active');
    });
    var panel = document.getElementById('panel' + tab.charAt(0).toUpperCase() + tab.slice(1));
    if (panel) panel.classList.add('active');

    if (tab === 'historico') {
        carregarHistorico();
    } else if (tab === 'manutencao') {
        carregarStatus();
    }
}


/* ─── Manual Toggle ─── */
function toggleManual() {
    var toggle = document.getElementById('manualToggle');
    var section = document.getElementById('manualSection');
    toggle.classList.toggle('open');
    section.classList.toggle('show');
}


/* ─── Verificar Atualizacoes ─── */
async function verificarAtualizacoes() {
    var btn = document.getElementById('btnVerificar');
    var result = document.getElementById('updateResult');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-inline"></span> Verificando...';
    result.className = 'update-result';
    result.style.display = '';

    try {
        var resp = await fetch('api/atualizacao/verificar.php', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        var data = await resp.json();

        if (!data.ok) {
            throw new Error(data.msg || 'Erro ao verificar atualizacoes');
        }

        if (data.data.configured === false) {
            result.className = 'update-result show has-update';
            result.innerHTML =
                '<div class="update-result-header">' +
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>' +
                    'URL de atualizacao nao configurada' +
                '</div>' +
                '<div class="update-result-body">' +
                    escapeHtml(data.data.msg || 'Configure a URL do servidor de atualizacoes nas Configuracoes.') +
                '</div>';

            btn.disabled = false;
            btn.innerHTML =
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>' +
                'Verificar Atualizacoes';
            return;
        }

        if (data.data.hasUpdate) {
            _remoteUpdateData = data.data;
            result.className = 'update-result show has-update';
            result.innerHTML =
                '<div class="update-result-header">' +
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>' +
                    'Nova versao disponivel: ' + escapeHtml(data.data.remoteVersion) +
                '</div>' +
                '<div class="update-result-body">' +
                    (function() {
                        var cl = data.data.changelog;
                        if (!cl || !Array.isArray(cl) || cl.length === 0) return 'Uma nova versao esta disponivel para download.';
                        var h = '';
                        cl.forEach(function(entry) {
                            h += '<strong>v' + escapeHtml(entry.version) + '</strong>';
                            if (entry.changes && entry.changes.length > 0) {
                                h += '<ul style="margin:4px 0 10px;padding-left:18px;">';
                                entry.changes.forEach(function(c) { h += '<li>' + escapeHtml(c) + '</li>'; });
                                h += '</ul>';
                            }
                        });
                        return h;
                    })() +
                '</div>' +
                '<div class="update-result-actions">' +
                    '<button class="btn-update btn-success" onclick="atualizarRemoto()">' +
                        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>' +
                        'Atualizar Agora' +
                    '</button>' +
                    '<button class="btn-update btn-secondary" onclick="switchUpdateTab(\'historico\')">' +
                        'Ver Changelog' +
                    '</button>' +
                '</div>';
        } else {
            _remoteUpdateData = null;
            result.className = 'update-result show up-to-date';
            result.innerHTML =
                '<div class="update-result-header">' +
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>' +
                    'Sistema atualizado!' +
                '</div>' +
                '<div class="update-result-body">' +
                    'Voce esta usando a versao mais recente do Induzi.' +
                '</div>';
        }
    } catch (e) {
        result.className = 'update-result show error';
        result.innerHTML =
            '<div class="update-result-header">' +
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>' +
                'Erro ao verificar' +
            '</div>' +
            '<div class="update-result-body">' +
                escapeHtml(e.message) +
            '</div>';
    }

    btn.disabled = false;
    btn.innerHTML =
        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>' +
        'Verificar Atualizacoes';
}


/* ─── Atualizar Remoto ─── */
async function atualizarRemoto() {
    if (!_remoteUpdateData) {
        if (typeof Igris !== 'undefined') Igris.toast('Nenhuma atualizacao disponivel.', 'warning');
        return;
    }

    var confirmed = true;
    if (typeof Igris !== 'undefined' && Igris.confirm) {
        confirmed = await Igris.confirm(
            'Atualizar para a versao ' + _remoteUpdateData.remoteVersion + '?',
            'Um backup sera criado automaticamente antes da atualizacao.'
        );
    }
    if (!confirmed) return;

    var progressWrap = document.getElementById('updateProgress');
    var progressFill = document.getElementById('updateProgressFill');
    var progressText = document.getElementById('updateProgressText');
    var result = document.getElementById('updateResult');

    progressWrap.classList.add('show');
    progressText.classList.add('show');
    progressFill.style.width = '10%';
    progressText.textContent = 'Preparando atualizacao...';

    try {
        progressFill.style.width = '20%';
        progressText.textContent = 'Baixando atualizacao...';

        var resp = await fetch('api/atualizacao/baixar-remoto.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                download_url: _remoteUpdateData.downloadUrl || '',
                sha256: _remoteUpdateData.sha256 || '',
                remote_version: _remoteUpdateData.remoteVersion
            })
        });

        progressFill.style.width = '60%';
        progressText.textContent = 'Aplicando atualizacao...';

        var data = await resp.json();

        if (!data.ok) {
            throw new Error(data.msg || 'Falha na atualizacao');
        }

        progressFill.style.width = '100%';
        progressText.textContent = 'Atualizacao concluida!';

        result.className = 'update-result show up-to-date';
        result.innerHTML =
            '<div class="update-result-header">' +
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>' +
                'Atualizado com sucesso!' +
            '</div>' +
            '<div class="update-result-body">' +
                'O sistema foi atualizado para a versao ' + escapeHtml(data.data.newVersion || _remoteUpdateData.remoteVersion) + '.' +
                '<br>Recarregue a pagina para aplicar as mudancas.' +
            '</div>' +
            '<div class="update-result-actions">' +
                '<button class="btn-update btn-primary" onclick="location.reload()">' +
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>' +
                    'Recarregar Pagina' +
                '</button>' +
            '</div>';

        _remoteUpdateData = null;
        carregarBackups();

        if (typeof Igris !== 'undefined') Igris.toast('Atualizacao concluida!', 'success');

    } catch (e) {
        progressFill.style.width = '100%';
        progressFill.style.background = '#ef4444';
        progressText.textContent = 'Falha na atualizacao';

        result.className = 'update-result show error';
        result.innerHTML =
            '<div class="update-result-header">' +
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>' +
                'Falha na atualizacao' +
            '</div>' +
            '<div class="update-result-body">' +
                escapeHtml(e.message) +
            '</div>';

        if (typeof Igris !== 'undefined') Igris.toast('Erro: ' + e.message, 'error');
    }

    setTimeout(function() {
        progressWrap.classList.remove('show');
        progressText.classList.remove('show');
        progressFill.style.width = '0%';
        progressFill.style.background = '';
    }, 5000);
}


/* ─── Carregar Backups ─── */
async function carregarBackups() {
    var container = document.getElementById('backupContent');
    container.innerHTML = '<div class="backup-empty"><span class="spinner-inline"></span> Carregando backups...</div>';

    try {
        var resp = await fetch('api/atualizacao/backups.php', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        var data = await resp.json();

        if (!data.ok) {
            container.innerHTML = '<div class="backup-empty">Erro ao carregar backups</div>';
            return;
        }

        var backups = Array.isArray(data.data) ? data.data : (data.data.backups || []);
        if (backups.length === 0) {
            container.innerHTML = '<div class="backup-empty">Nenhum backup encontrado</div>';
            return;
        }

        var html = '<table class="backup-table"><thead><tr>' +
            '<th>Arquivo</th><th>Tamanho</th><th>Data</th><th>Acoes</th>' +
            '</tr></thead><tbody>';

        for (var i = 0; i < backups.length; i++) {
            var b = backups[i];
            var bName = b.file || b.name || '';
            html += '<tr>' +
                '<td>' + escapeHtml(bName) + '</td>' +
                '<td>' + formatBytes(b.size) + '</td>' +
                '<td>' + escapeHtml(b.date || '-') + '</td>' +
                '<td><div class="backup-actions">' +
                    '<button class="btn-update btn-secondary btn-sm" onclick="restaurarBackup(\'' + escapeHtml(bName) + '\')" title="Restaurar">' +
                        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>' +
                    '</button>' +
                    '<button class="btn-update btn-danger btn-sm" onclick="excluirBackup(\'' + escapeHtml(bName) + '\')" title="Excluir">' +
                        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>' +
                    '</button>' +
                '</div></td></tr>';
        }

        html += '</tbody></table>';
        container.innerHTML = html;

    } catch (e) {
        container.innerHTML = '<div class="backup-empty">Erro ao carregar backups: ' + escapeHtml(e.message) + '</div>';
    }
}


/* ─── Restaurar Backup ─── */
async function restaurarBackup(filename) {
    var confirmed = true;
    if (typeof Igris !== 'undefined' && Igris.confirm) {
        confirmed = await Igris.confirm(
            'Restaurar backup?',
            'O sistema sera revertido para o estado do backup "' + filename + '". Esta acao nao pode ser desfeita.'
        );
    }
    if (!confirmed) return;

    try {
        var resp = await fetch('api/atualizacao/restaurar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ file: filename })
        });
        var data = await resp.json();

        if (!data.ok) {
            throw new Error(data.msg || 'Falha ao restaurar backup');
        }

        if (typeof Igris !== 'undefined') Igris.toast('Backup restaurado com sucesso! Recarregue a pagina.', 'success');
        carregarBackups();

    } catch (e) {
        if (typeof Igris !== 'undefined') Igris.toast('Erro: ' + e.message, 'error');
    }
}


/* ─── Excluir Backup ─── */
async function excluirBackup(filename) {
    var confirmed = true;
    if (typeof Igris !== 'undefined' && Igris.confirm) {
        confirmed = await Igris.confirm(
            'Excluir backup?',
            'O arquivo "' + filename + '" sera removido permanentemente.'
        );
    }
    if (!confirmed) return;

    try {
        var resp = await fetch('api/atualizacao/backups.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ file: filename })
        });
        var data = await resp.json();

        if (!data.ok) {
            throw new Error(data.msg || 'Falha ao excluir backup');
        }

        if (typeof Igris !== 'undefined') Igris.toast('Backup excluido.', 'success');
        carregarBackups();

    } catch (e) {
        if (typeof Igris !== 'undefined') Igris.toast('Erro: ' + e.message, 'error');
    }
}


/* ─── File Selection (Manual Upload) ─── */
function selecionarArquivo() {
    document.getElementById('fileInput').click();
}

function setSelectedFile(file) {
    var selected = document.getElementById('fileSelected');
    var nameEl = document.getElementById('fileName');
    var sizeEl = document.getElementById('fileSize');
    var btnAplicar = document.getElementById('btnAplicar');

    if (!file) {
        _selectedFile = null;
        selected.classList.remove('show');
        btnAplicar.disabled = true;
        return;
    }

    if (!file.name.endsWith('.zip')) {
        if (typeof Igris !== 'undefined') Igris.toast('Somente arquivos .zip sao aceitos.', 'warning');
        _selectedFile = null;
        selected.classList.remove('show');
        btnAplicar.disabled = true;
        return;
    }

    if (file.size > 50 * 1024 * 1024) {
        if (typeof Igris !== 'undefined') Igris.toast('Arquivo muito grande (max 50MB).', 'warning');
        _selectedFile = null;
        selected.classList.remove('show');
        btnAplicar.disabled = true;
        return;
    }

    _selectedFile = file;
    nameEl.textContent = file.name;
    sizeEl.textContent = formatBytes(file.size);
    selected.classList.add('show');
    btnAplicar.disabled = false;
}

/* Drag and drop */
(function() {
    var zone = document.getElementById('fileUploadZone');
    if (!zone) return;

    zone.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        zone.classList.add('dragover');
    });
    zone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        zone.classList.remove('dragover');
    });
    zone.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        zone.classList.remove('dragover');
        if (e.dataTransfer.files.length > 0) {
            setSelectedFile(e.dataTransfer.files[0]);
        }
    });
})();


/* ─── Gerar Pacote ─── */
async function gerarPacote() {
    var btn = document.getElementById('btnGerarPacote');
    var progressWrap = document.getElementById('packageProgress');
    var progressFill = document.getElementById('packageProgressFill');
    var progressText = document.getElementById('packageProgressText');

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-inline"></span> Gerando...';
    progressWrap.classList.add('show');
    progressText.classList.add('show');
    progressFill.style.width = '20%';
    progressText.textContent = 'Criando pacote de atualizacao...';

    try {
        progressFill.style.width = '40%';

        var resp = await fetch('api/atualizacao/gerar.php', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        progressFill.style.width = '80%';
        progressText.textContent = 'Finalizando pacote...';

        if (!resp.ok) {
            var errData = {};
            try { errData = await resp.json(); } catch (e2) {}
            throw new Error(errData.msg || 'Erro ao gerar pacote.');
        }

        // Sucesso - resposta e o ZIP binario
        var blob = await resp.blob();
        var fileCount = resp.headers.get('X-File-Count') || '?';
        var version = resp.headers.get('X-Version') || '?';
        var filename = 'induzi-update-' + version + '.zip';
        var sizeMB = (blob.size / 1048576).toFixed(1);

        progressFill.style.width = '100%';
        progressText.textContent = 'Pacote gerado com sucesso!';

        if (typeof Igris !== 'undefined') Igris.toast('Pacote gerado: ' + filename + ' (' + sizeMB + ' MB, ' + fileCount + ' arquivos)', 'success');

        // Iniciar download via blob URL
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);

    } catch (e) {
        progressFill.style.width = '100%';
        progressFill.style.background = '#ef4444';
        progressText.textContent = 'Erro: ' + e.message;
        if (typeof Igris !== 'undefined') Igris.toast('Erro: ' + e.message, 'error');
    }

    btn.disabled = false;
    btn.innerHTML =
        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>' +
        'Gerar Pacote';

    setTimeout(function() {
        progressWrap.classList.remove('show');
        progressText.classList.remove('show');
        progressFill.style.width = '0%';
        progressFill.style.background = '';
    }, 4000);
}


/* ─── Aplicar Atualizacao Manual ─── */
async function aplicarAtualizacao() {
    if (!_selectedFile) {
        if (typeof Igris !== 'undefined') Igris.toast('Selecione um arquivo ZIP primeiro.', 'warning');
        return;
    }

    var confirmed = true;
    if (typeof Igris !== 'undefined' && Igris.confirm) {
        confirmed = await Igris.confirm(
            'Aplicar atualizacao manual?',
            'O arquivo "' + _selectedFile.name + '" sera instalado. Um backup sera criado automaticamente.'
        );
    }
    if (!confirmed) return;

    var btn = document.getElementById('btnAplicar');
    var progressWrap = document.getElementById('applyProgress');
    var progressFill = document.getElementById('applyProgressFill');
    var progressText = document.getElementById('applyProgressText');

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-inline"></span> Aplicando...';
    progressWrap.classList.add('show');
    progressText.classList.add('show');
    progressFill.style.width = '10%';
    progressText.textContent = 'Enviando arquivo...';

    try {
        var formData = new FormData();
        formData.append('zipfile', _selectedFile);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'api/atualizacao/aplicar.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                var pct = Math.round((e.loaded / e.total) * 50) + 10;
                progressFill.style.width = pct + '%';
                progressText.textContent = 'Enviando... ' + Math.round((e.loaded / e.total) * 100) + '%';
            }
        };

        var result = await new Promise(function(resolve, reject) {
            xhr.onload = function() {
                try {
                    var data = JSON.parse(xhr.responseText);
                    resolve(data);
                } catch (e) {
                    reject(new Error('Resposta invalida do servidor'));
                }
            };
            xhr.onerror = function() {
                reject(new Error('Erro de rede'));
            };
            xhr.send(formData);
        });

        progressFill.style.width = '80%';
        progressText.textContent = 'Instalando atualizacao...';

        if (!result.ok) {
            throw new Error(result.msg || 'Falha ao aplicar atualizacao');
        }

        progressFill.style.width = '100%';
        progressText.textContent = 'Atualizacao aplicada com sucesso!';

        _selectedFile = null;
        document.getElementById('fileSelected').classList.remove('show');
        document.getElementById('fileInput').value = '';
        btn.disabled = true;

        if (typeof Igris !== 'undefined') Igris.toast('Atualizacao aplicada! Recarregue a pagina.', 'success');
        carregarBackups();

    } catch (e) {
        progressFill.style.width = '100%';
        progressFill.style.background = '#ef4444';
        progressText.textContent = 'Erro: ' + e.message;
        if (typeof Igris !== 'undefined') Igris.toast('Erro: ' + e.message, 'error');
    }

    btn.disabled = !_selectedFile;
    btn.innerHTML =
        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>' +
        'Aplicar Atualizacao';

    setTimeout(function() {
        progressWrap.classList.remove('show');
        progressText.classList.remove('show');
        progressFill.style.width = '0%';
        progressFill.style.background = '';
    }, 5000);
}


/* ─── Carregar Historico ─── */
async function carregarHistorico() {
    var container = document.getElementById('historicoContent');

    if (container.dataset.loaded === '1') return;
    container.innerHTML = '<div class="backup-empty"><span class="spinner-inline"></span> Carregando historico...</div>';

    try {
        var resp = await fetch('api/atualizacao/verificar.php?full_changelog=1', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        var data = await resp.json();

        if (!data.ok) {
            container.innerHTML = '<div class="backup-empty">Erro ao carregar historico</div>';
            return;
        }

        var versions = data.data.changelog || [];
        if (versions.length === 0) {
            container.innerHTML = '<div class="backup-empty">Nenhum registro de versao encontrado</div>';
            return;
        }

        var html = '<div class="timeline">';

        for (var i = 0; i < versions.length; i++) {
            var v = versions[i];
            var isCurrent = (i === 0);
            var dotClass = isCurrent ? 'current' : 'past';

            html += '<div class="timeline-item">';
            html += '<div class="timeline-dot ' + dotClass + '">';
            if (isCurrent) {
                html += '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>';
            } else {
                html += '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle></svg>';
            }
            html += '</div>';
            html += '<div class="timeline-version">' + escapeHtml(v.version || '?') + (isCurrent ? ' <span style="font-size:0.7rem;color:var(--color-accent);font-weight:500;">(atual)</span>' : '') + '</div>';
            html += '<div class="timeline-date">' + escapeHtml(v.date || '') + '</div>';

            if (v.changes && v.changes.length > 0) {
                html += '<ul class="timeline-changes">';
                for (var j = 0; j < v.changes.length; j++) {
                    var c = v.changes[j];
                    var badgeClass = 'change';
                    var badgeLabel = 'Alteracao';
                    var changeText = '';

                    if (typeof c === 'string') {
                        changeText = c;
                    } else if (typeof c === 'object' && c !== null) {
                        changeText = c.text || c.description || '';
                        if (c.type === 'new' || c.type === 'feature') {
                            badgeClass = 'new';
                            badgeLabel = 'Novo';
                        } else if (c.type === 'fix' || c.type === 'bugfix') {
                            badgeClass = 'fix';
                            badgeLabel = 'Correcao';
                        } else if (c.type === 'improve' || c.type === 'enhancement') {
                            badgeClass = 'improve';
                            badgeLabel = 'Melhoria';
                        } else if (c.type === 'security') {
                            badgeClass = 'security';
                            badgeLabel = 'Seguranca';
                        }
                    }

                    html += '<li>' +
                        '<span class="change-badge ' + badgeClass + '">' + badgeLabel + '</span>' +
                        '<span>' + escapeHtml(changeText) + '</span>' +
                    '</li>';
                }
                html += '</ul>';
            }

            html += '</div>'; // timeline-item
        }

        html += '</div>'; // timeline
        container.innerHTML = html;
        container.dataset.loaded = '1';

    } catch (e) {
        container.innerHTML = '<div class="backup-empty">Erro ao carregar historico: ' + escapeHtml(e.message) + '</div>';
    }
}


/* ─── Limpeza: Cache Service Worker ─── */
async function limparCacheSW() {
    var confirmed = true;
    if (typeof Igris !== 'undefined' && Igris.confirm) {
        confirmed = await Igris.confirm(
            'Limpar cache do Service Worker?',
            'Todos os caches do service worker serao removidos. A pagina pode ficar mais lenta temporariamente.'
        );
    }
    if (!confirmed) return;

    try {
        if ('caches' in window) {
            var keys = await caches.keys();
            for (var i = 0; i < keys.length; i++) {
                await caches.delete(keys[i]);
            }
        }

        if (navigator.serviceWorker) {
            var registrations = await navigator.serviceWorker.getRegistrations();
            for (var r = 0; r < registrations.length; r++) {
                await registrations[r].unregister();
            }
        }

        if (typeof Igris !== 'undefined') Igris.toast('Cache do Service Worker limpo!', 'success');
    } catch (e) {
        if (typeof Igris !== 'undefined') Igris.toast('Erro: ' + e.message, 'error');
    }
}


/* ─── Limpeza: Cache SPA ─── */
function limparCacheSPA() {
    try {
        if (typeof SpaRouter !== 'undefined' && SpaRouter._cache) {
            SpaRouter._cache = {};
            if (typeof Igris !== 'undefined') Igris.toast('Cache SPA limpo!', 'success');
        } else {
            /* Fallback: clear sessionStorage keys that look like SPA cache */
            var keysToRemove = [];
            for (var i = 0; i < sessionStorage.length; i++) {
                var key = sessionStorage.key(i);
                if (key && (key.startsWith('spa_') || key.startsWith('induzi_spa_'))) {
                    keysToRemove.push(key);
                }
            }
            for (var k = 0; k < keysToRemove.length; k++) {
                sessionStorage.removeItem(keysToRemove[k]);
            }
            if (typeof Igris !== 'undefined') Igris.toast('Cache SPA limpo! (' + keysToRemove.length + ' entradas)', 'success');
        }
    } catch (e) {
        if (typeof Igris !== 'undefined') Igris.toast('Erro: ' + e.message, 'error');
    }
}


/* ─── Limpeza: localStorage ─── */
async function limparLocalStorage() {
    var confirmed = true;
    if (typeof Igris !== 'undefined' && Igris.confirm) {
        confirmed = await Igris.confirm(
            'Limpar localStorage do Induzi?',
            'Dados locais como preferencias e cache de sessao serao removidos. Seus dados no servidor nao serao afetados.'
        );
    }
    if (!confirmed) return;

    try {
        var keysToRemove = [];
        for (var i = 0; i < localStorage.length; i++) {
            var key = localStorage.key(i);
            if (key && key.startsWith('induzi_')) {
                keysToRemove.push(key);
            }
        }
        for (var k = 0; k < keysToRemove.length; k++) {
            localStorage.removeItem(keysToRemove[k]);
        }
        if (typeof Igris !== 'undefined') Igris.toast('localStorage limpo! (' + keysToRemove.length + ' chaves removidas)', 'success');
    } catch (e) {
        if (typeof Igris !== 'undefined') Igris.toast('Erro: ' + e.message, 'error');
    }
}


/* ─── Limpeza: OPcache ─── */
async function limparOPcache() {
    var confirmed = true;
    if (typeof Igris !== 'undefined' && Igris.confirm) {
        confirmed = await Igris.confirm(
            'Limpar OPcache?',
            'O cache de opcodes PHP sera limpo. Isso pode causar uma leve lentidao temporaria.'
        );
    }
    if (!confirmed) return;

    try {
        var resp = await fetch('api/admin/clear-cache.php', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        var data = await resp.json();

        if (!data.ok) {
            throw new Error(data.msg || 'Falha ao limpar OPcache');
        }

        if (typeof Igris !== 'undefined') Igris.toast(data.msg || 'OPcache limpo!', 'success');
    } catch (e) {
        if (typeof Igris !== 'undefined') Igris.toast('Erro: ' + e.message, 'error');
    }
}


/* ─── Carregar Status do Sistema ─── */
async function carregarStatus() {
    var serverEl = document.getElementById('statusServer');
    var dbEl = document.getElementById('statusDatabase');
    var storageEl = document.getElementById('statusStorage');
    var appEl = document.getElementById('statusApp');

    serverEl.innerHTML = '<li><span class="s-label">Carregando...</span><span class="s-value"><span class="spinner-inline"></span></span></li>';
    dbEl.innerHTML = '<li><span class="s-label">Carregando...</span><span class="s-value"><span class="spinner-inline"></span></span></li>';
    storageEl.innerHTML = '<li><span class="s-label">Carregando...</span><span class="s-value"><span class="spinner-inline"></span></span></li>';
    appEl.innerHTML = '<li><span class="s-label">Carregando...</span><span class="s-value"><span class="spinner-inline"></span></span></li>';

    try {
        var resp = await fetch('api/admin/system-status.php', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        var data = await resp.json();

        if (!data.ok) {
            var errorHtml = '<li><span class="s-label">Erro</span><span class="s-value err">Falha ao carregar</span></li>';
            serverEl.innerHTML = errorHtml;
            dbEl.innerHTML = errorHtml;
            storageEl.innerHTML = errorHtml;
            appEl.innerHTML = errorHtml;
            return;
        }

        var s = data.data;
        var sv = s.server || {};
        var db = s.database || {};
        var st = s.storage || {};
        var ap = s.app || {};

        /* Server */
        serverEl.innerHTML =
            statusItem('PHP', sv.php_version || '-') +
            statusItem('SAPI', sv.sapi || '-') +
            statusItem('Memoria PHP', sv.memory_limit || '-') +
            statusItem('Max Upload', sv.upload_max_filesize || '-') +
            statusItem('Max POST', sv.post_max_size || '-') +
            statusItem('Tempo Max', (sv.max_execution_time || '-') + 's') +
            statusItem('OPcache', sv.opcache_enabled ? 'Ativo' : 'Inativo', sv.opcache_enabled ? 'ok' : 'warn');

        /* Database */
        dbEl.innerHTML =
            statusItem('MySQL', db.mysql_version || '-') +
            statusItem('Banco', db.db_name || '-') +
            statusItem('Tabelas', db.table_count !== undefined ? db.table_count : '-') +
            statusItem('Tamanho', db.total_size ? formatBytes(db.total_size) : '-') +
            statusItem('Usuarios', db.users_count !== undefined ? db.users_count : '-') +
            statusItem('Projetos', db.projects_count !== undefined ? db.projects_count : '-') +
            statusItem('Registros', db.project_data_rows !== undefined ? db.project_data_rows : '-');

        /* Storage */
        storageEl.innerHTML =
            statusItem('Total Arquivos', st.file_count !== undefined ? st.file_count : '-') +
            statusItem('Tamanho Total', st.total_size ? formatBytes(st.total_size) : '-') +
            (st.folders && st.folders.users ? statusItem('Pasta Users', formatBytes(st.folders.users.size) + ' (' + st.folders.users.files + ' arq.)') : '') +
            (st.folders && st.folders.projects ? statusItem('Pasta Projects', formatBytes(st.folders.projects.size) + ' (' + st.folders.projects.files + ' arq.)') : '');

        /* Application */
        appEl.innerHTML =
            statusItem('Versao Induzi', ap.version || '-') +
            statusItem('Data Versao', ap.version_date || '-') +
            statusItem('Usuarios', ap.users !== undefined ? ap.users : '-') +
            statusItem('Projetos', ap.projects !== undefined ? ap.projects : '-') +
            statusItem('Data Keys', ap.data_keys !== undefined ? ap.data_keys : '-');

    } catch (e) {
        var errHtml = '<li><span class="s-label">Erro</span><span class="s-value err">' + escapeHtml(e.message) + '</span></li>';
        serverEl.innerHTML = errHtml;
        dbEl.innerHTML = errHtml;
        storageEl.innerHTML = errHtml;
        appEl.innerHTML = errHtml;
    }
}


/* ─── Helpers ─── */
function escapeHtml(str) {
    if (!str) return '';
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

function formatBytes(bytes) {
    if (bytes === 0 || bytes === null || bytes === undefined) return '0 B';
    bytes = parseInt(bytes);
    if (isNaN(bytes)) return '-';
    var sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
    var i = Math.floor(Math.log(bytes) / Math.log(1024));
    if (i < 0) i = 0;
    if (i >= sizes.length) i = sizes.length - 1;
    return (bytes / Math.pow(1024, i)).toFixed(i > 0 ? 1 : 0) + ' ' + sizes[i];
}

function statusItem(label, value, cls) {
    var valClass = 's-value';
    if (cls) valClass += ' ' + cls;
    return '<li><span class="s-label">' + escapeHtml(label) + '</span><span class="' + valClass + '">' + escapeHtml(String(value)) + '</span></li>';
}
</script>

</div><!-- /main-content close -->
</div><!-- /layout close -->
</body>
</html>
<?php spaFragmentEnd(); ?>
