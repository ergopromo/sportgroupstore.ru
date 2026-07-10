<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $arParams */
/** @var array $arResult */

$item = $arResult['ITEM'];
$price = $item['PRICE'] ?? [];
$picture = $item['PICTURE'] ?? [];
$labels = $item['LABELS'] ?? [];
$hasOffers = !empty($item['HAS_OFFERS']);
$showOldPrice = $arParams['SHOW_OLD_PRICE'] === 'Y'
    && !empty($price['BASE_VALUE'])
    && (float)$price['BASE_VALUE'] > (float)($price['VALUE'] ?? 0);

$buttonText = $hasOffers ? $arParams['BUTTON_TEXT_OFFERS'] : $arParams['BUTTON_TEXT'];
$buttonHref = $hasOffers
    ? $item['URL']
    : $arParams['BASKET_URL'] . '?action=ADD2BASKET&id=' . (int)($price['PRODUCT_ID'] ?? $item['ID']) . '&quantity=1';
?>
<article class="sg-product-mini">
    <a class="sg-product-mini__media" href="<?= htmlspecialcharsbx($item['URL']) ?>">
        <?php if ($arParams['SHOW_LABELS'] === 'Y' && $labels): ?>
            <span class="sg-product-mini__labels">
                <?php foreach ($labels as $label): ?>
                    <span
                        class="sg-product-mini__label"
                        style="background-color: <?= htmlspecialcharsbx($label['COLOR']) ?>"
                    >
                        <?= htmlspecialcharsbx($label['NAME']) ?>
                    </span>
                <?php endforeach; ?>
            </span>
        <?php endif; ?>

        <img
            class="sg-product-mini__image"
            src="<?= htmlspecialcharsbx($picture['SRC'] ?? '') ?>"
            alt="<?= htmlspecialcharsbx($picture['ALT'] ?? $item['NAME']) ?>"
            loading="lazy"
            width="400"
            height="400"
        >
    </a>

    <div class="sg-product-mini__body">
        <h3 class="sg-product-mini__title">
            <a class="sg-product-mini__title-link" href="<?= htmlspecialcharsbx($item['URL']) ?>">
                <?= htmlspecialcharsbx($item['NAME']) ?>
            </a>
        </h3>

        <?php if (!empty($price['PRINT'])): ?>
            <div class="sg-product-mini__price-row">
                <span class="sg-product-mini__price"><?= $price['PRINT'] ?></span>
                <?php if ($showOldPrice): ?>
                    <span class="sg-product-mini__price-old"><?= $price['BASE_PRINT'] ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <a
            class="sg-product-mini__btn<?= $hasOffers ? ' sg-product-mini__btn--secondary' : '' ?>"
            href="<?= htmlspecialcharsbx($buttonHref) ?>"
        >
            <?= htmlspecialcharsbx($buttonText) ?>
        </a>
    </div>
</article>
