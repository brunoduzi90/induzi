<section class="ps-section">
    <div class="ps-container ps-container--narrow">
        <h1 style="margin-bottom:var(--ps-space-8);">Blog</h1>

        <?php if (empty($posts['data'])): ?>
            <p style="color:var(--ps-text-muted);text-align:center;padding:var(--ps-space-10) 0;">Nenhum post publicado ainda.</p>
        <?php else: ?>
            <?php foreach ($posts['data'] as $post): ?>
            <article class="ps-card ps-animate-on-scroll" style="margin-bottom:var(--ps-space-4);">
                <div class="ps-card__body">
                    <h2 class="ps-card__title"><a href="<?= url('blog/' . e($post['slug'])) ?>" style="color:var(--ps-text-primary);text-decoration:none;"><?= e($post['title']) ?></a></h2>
                    <div style="font-size:var(--ps-font-sm);color:var(--ps-text-muted);margin-bottom:var(--ps-space-3);">
                        <?= date('d/m/Y', strtotime($post['published_at'] ?? $post['created_at'])) ?>
                        <?php if ($post['category']): ?> | <?= e($post['category']) ?><?php endif; ?>
                    </div>
                    <p class="ps-card__desc"><?= e($post['excerpt'] ?? substr(strip_tags($post['content']), 0, 200)) ?></p>
                    <a href="<?= url('blog/' . e($post['slug'])) ?>" class="ps-btn ps-btn--ghost ps-btn--sm">Ler mais &rarr;</a>
                </div>
            </article>
            <?php endforeach; ?>

            <?php if ($posts['last_page'] > 1): ?>
            <nav class="ps-pagination" aria-label="Paginacao do blog">
                <?php for ($i = 1; $i <= $posts['last_page']; $i++): ?>
                    <a href="<?= url('blog') ?>?page=<?= $i ?>" class="ps-pagination__link <?= $i === $posts['current_page'] ? 'is-active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </nav>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
