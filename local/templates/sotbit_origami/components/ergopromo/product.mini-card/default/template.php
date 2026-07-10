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

$cartLabel = $hasOffers ? $arParams['BUTTON_TEXT_OFFERS'] : $arParams['BUTTON_TEXT'];
$productId = (int)($price['PRODUCT_ID'] ?? $item['ID']);
$cartAjaxUrl = SITE_DIR . 'include/sotbit_origami/ajax/product_cart.php';
$iconSprite = SITE_DIR . 'include/sotbit_origami/redesign/icons.svg';
?>
<article class="sg-product-mini">
    <a class="sg-product-mini__media" href="<?= htmlspecialcharsbx($item['URL']) ?>">
        <img
            class="sg-product-mini__image"
            src="<?= htmlspecialcharsbx($picture['SRC'] ?? '') ?>"
            alt="<?= htmlspecialcharsbx($picture['ALT'] ?? $item['NAME']) ?>"
            loading="lazy"
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
                <?php if ($hasOffers): ?>
                    <a
                        class="sg-product-mini__cart-btn"
                        href="<?= htmlspecialcharsbx($item['URL']) ?>"
                        aria-label="<?= htmlspecialcharsbx($cartLabel) ?>"
                    >
                        <svg width="20" height="20" aria-hidden="true">
                            <use xlink:href="<?= htmlspecialcharsbx($iconSprite) ?>#icon-sg-bag"></use>
                        </svg>
                    </a>
                <?php else: ?>
                    <div
                        class="sg-product-mini__cart-control"
                        data-sg-cart-control
                        data-product-id="<?= $productId ?>"
                        data-cart-url="<?= htmlspecialcharsbx($cartAjaxUrl) ?>"
                    >
                        <button
                            type="button"
                            class="sg-product-mini__cart-btn"
                            data-sg-cart-add
                            aria-label="<?= htmlspecialcharsbx($cartLabel) ?>"
                        >
                            <svg width="20" height="20" aria-hidden="true">
                                <use xlink:href="<?= htmlspecialcharsbx($iconSprite) ?>#icon-sg-bag"></use>
                            </svg>
                        </button>
                        <div class="sg-product-mini__qty" data-sg-cart-qty-panel hidden>
                            <button
                                type="button"
                                class="sg-product-mini__qty-btn"
                                data-sg-cart-minus
                                aria-label="Уменьшить количество"
                            >&minus;</button>
                            <span class="sg-product-mini__qty-value" data-sg-cart-qty>1</span>
                            <button
                                type="button"
                                class="sg-product-mini__qty-btn"
                                data-sg-cart-plus
                                aria-label="Увеличить количество"
                            >+</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</article>
