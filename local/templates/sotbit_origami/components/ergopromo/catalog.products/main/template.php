<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $arParams */
/** @var array $arResult */
/** @var CBitrixComponent $component */
/** @var CMain $APPLICATION */

$this->setFrameMode(true);
?>
<section class="sg-popular-products" aria-labelledby="sg-popular-products-title">
    <div class="sg-popular-products__inner">
        <div class="sg-section-head">
            <h2 class="sg-section-head__title" id="sg-popular-products-title">
                <?= htmlspecialcharsbx($arParams['TITLE']) ?>
            </h2>
            <?php if ($arParams['CATALOG_URL'] !== ''): ?>
                <a class="sg-section-head__link" href="<?= htmlspecialcharsbx($arParams['CATALOG_URL']) ?>">
                    <?= htmlspecialcharsbx($arParams['CATALOG_LINK_TEXT']) ?>
                </a>
            <?php endif; ?>
        </div>

        <div class="sg-popular-products__grid">
            <?php foreach ($arResult['ITEMS'] as $item): ?>
                <?php
                $APPLICATION->IncludeComponent(
                    'ergopromo:product.mini-card',
                    'default',
                    [
                        'ITEM' => $item,
                        'SHOW_LABELS' => 'Y',
                        'SHOW_OLD_PRICE' => 'Y',
                        'BUTTON_TEXT' => 'В корзину',
                        'BUTTON_TEXT_OFFERS' => 'Подробнее',
                        'BASKET_URL' => '/personal/cart/',
                    ],
                    $component,
                    ['HIDE_ICONS' => 'Y']
                );
                ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
