<article class="ps-section">
    <div class="ps-container ps-container--narrow">
        <h1 style="font-size:clamp(1.5rem,4vw,2.5rem);margin-bottom:var(--ps-space-3);"><?= e($post['title']) ?></h1>
        <div style="font-size:var(--ps-font-sm);color:var(--ps-text-muted);margin-bottom:var(--ps-space-8);">
            <?= date('d de F de Y', strtotime($post['published_at'] ?? $post['created_at'])) ?>
            <?php if ($post['category']): ?> | <?= e($post['category']) ?><?php endif; ?>
            | <?= number_format($post['views']) ?> visualizacoes
        </div>

        <div class="ps-content-body">
            <?= $post['content'] ?>
        </div>

        <?php if ($post['tags']): ?>
        <div style="margin-top:var(--ps-space-8);display:flex;gap:var(--ps-space-2);flex-wrap:wrap;">
            <?php foreach (explode(',', $post['tags']) as $tag): ?>
                <span class="ps-tag">#<?= e(trim($tag)) ?></span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div style="margin-top:var(--ps-space-10);padding-top:var(--ps-space-6);border-top:1px solid var(--ps-border);text-align:center;">
            <a href="<?= url('blog') ?>" class="ps-btn ps-btn--ghost">&larr; Voltar ao Blog</a>
        </div>
    </div>
</article>
