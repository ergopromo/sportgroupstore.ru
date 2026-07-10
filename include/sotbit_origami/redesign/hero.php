<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$siteDir = SITE_DIR;
$heroBg = $siteDir . 'include/sotbit_origami/redesign/hero-bg.png';
?>
<section class="sg-hero" aria-label="Главный баннер">
    <div class="sg-hero__media" aria-hidden="true">
        <img
            class="sg-hero__bg"
            src="<?= htmlspecialcharsbx($heroBg) ?>"
            alt=""
            width="1440"
            height="900"
            loading="eager"
            fetchpriority="high"
        >
        <div class="sg-hero__overlay"></div>
    </div>

    <div class="sg-hero__inner">
        <p class="sg-hero__eyebrow">Более 500 товаров для спорта и восстановления</p>

        <div class="sg-hero__content">
            <h1 class="sg-hero__title">
                Результат начинается<br>
                с правильного топлива
            </h1>
            <p class="sg-hero__subtitle">
                Подобранные составы для тренировок, восстановления<br>
                и повседневной поддержки. Без лишнего.
            </p>
        </div>

        <div class="sg-hero__cta">
            <a class="sg-hero__btn" href="<?= htmlspecialcharsbx($siteDir . 'catalog/') ?>">
                Посмотреть каталог
            </a>
            <div class="sg-hero__progress" aria-hidden="true">
                <span class="sg-hero__progress-fill"></span>
            </div>
        </div>
    </div>
</section>
