<section class="ps-section">
    <div class="ps-container ps-container--narrow">
        <h1 style="margin-bottom:var(--ps-space-8);">Perguntas Frequentes</h1>

        <?php if (empty($faqs)): ?>
            <p style="color:var(--ps-text-muted);">Nenhuma pergunta disponivel no momento.</p>
        <?php else: ?>
            <div class="ps-accordion" itemscope itemtype="https://schema.org/FAQPage">
                <?php foreach ($faqs as $faq): ?>
                <details class="ps-accordion__item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <summary class="ps-accordion__header" itemprop="name"><?= e($faq['title']) ?></summary>
                    <div class="ps-accordion__body" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <div itemprop="text"><?= $faq['content'] ?></div>
                    </div>
                </details>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        <?php foreach ($faqs as $i => $faq): ?>
        {
            "@type": "Question",
            "name": <?= json_encode($faq['title']) ?>,
            "acceptedAnswer": {
                "@type": "Answer",
                "text": <?= json_encode(strip_tags($faq['content'])) ?>
            }
        }<?= $i < count($faqs) - 1 ? ',' : '' ?>
        <?php endforeach; ?>
    ]
}
</script>
