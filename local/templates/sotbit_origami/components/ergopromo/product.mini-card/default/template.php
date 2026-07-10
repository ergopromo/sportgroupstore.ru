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
$brand = trim((string)($item['BRAND'] ?? ''));
$category = trim((string)($item['CATEGORY'] ?? ''));
$meta = trim((string)($item['META'] ?? ''));

$buttonHref = $hasOffers
    ? $item['URL']
    : $arParams['BASKET_URL'] . '?action=ADD2BASKET&id=' . (int)($price['PRODUCT_ID'] ?? $item['ID']) . '&quantity=1';
$cartLabel = $hasOffers ? $arParams['BUTTON_TEXT_OFFERS'] : $arParams['BUTTON_TEXT'];
?>
<article class="sg-product-mini">
    <a class="sg-product-mini__media" href="<?= htmlspecialcharsbx($item['URL']) ?>">
        <img
            class="sg-product-mini__image"
            src="<?= htmlspecialcharsbx($picture['SRC'] ?? '') ?>"
            alt="<?= htmlspecialcharsbx($picture['ALT'] ?? $item['NAME']) ?>"
            loading="lazy"
            width="413"
            height="280"
        >

        <?php if ($arParams['SHOW_LABELS'] === 'Y' && $labels): ?>
            <span class="sg-product-mini__labels">
                <?php foreach ($labels as $label): ?>
                    <?php
                    $labelClass = 'sg-product-mini__label';
                    if (($label['TYPE'] ?? '') === 'discount') {
                        $labelClass .= ' sg-product-mini__label--discount';
                    } else {
                        $labelClass .= ' sg-product-mini__label--hit';
                    }
                    ?>
                    <span class="<?= $labelClass ?>">
                        <?= htmlspecialcharsbx($label['NAME']) ?>
                    </span>
                <?php endforeach; ?>
            </span>
        <?php endif; ?>

        <span class="sg-product-mini__actions" aria-hidden="true">
            <span class="sg-product-mini__action-btn">
                <svg width="14" height="14" aria-hidden="true">
                    <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_favourite"></use>
                </svg>
            </span>
            <span class="sg-product-mini__action-btn">
                <svg width="14" height="14" aria-hidden="true">
                    <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_compare"></use>
                </svg>
            </span>
        </span>
    </a>

    <div class="sg-product-mini__body">
        <div class="sg-product-mini__info">
            <?php if ($brand !== ''): ?>
                <p class="sg-product-mini__brand"><?= htmlspecialcharsbx($brand) ?></p>
            <?php endif; ?>

            <div class="sg-product-mini__titles">
                <h3 class="sg-product-mini__title">
                    <a class="sg-product-mini__title-link" href="<?= htmlspecialcharsbx($item['URL']) ?>">
                        <?= htmlspecialcharsbx($item['NAME']) ?>
                    </a>
                </h3>

                <?php if ($category !== ''): ?>
                    <p class="sg-product-mini__category"><?= htmlspecialcharsbx($category) ?></p>
                <?php endif; ?>
            </div>

            <?php if ($meta !== ''): ?>
                <p class="sg-product-mini__meta"><?= htmlspecialcharsbx($meta) ?></p>
            <?php endif; ?>
        </div>

        <?php if (!empty($price['PRINT'])): ?>
            <div class="sg-product-mini__price-row">
                <span class="sg-product-mini__price"><?= $price['PRINT'] ?></span>
                <a
                    class="sg-product-mini__cart-btn"
                    href="<?= htmlspecialcharsbx($buttonHref) ?>"
                    aria-label="<?= htmlspecialcharsbx($cartLabel) ?>"
                >
                    <svg width="20" height="20" aria-hidden="true">
                        <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_cart_small"></use>
                    </svg>
                </a>
            </div>
        <?php endif; ?>
    </div>
</article>
