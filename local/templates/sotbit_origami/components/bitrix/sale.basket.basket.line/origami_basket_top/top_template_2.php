<?php

use Sotbit\Origami\Helper\Config;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @global array $arParams
 * @global array $arResult
 * @global string $cartId
 */

if ($arResult['DISABLE_USE_BASKET']) {
    return;
}

$iconSprite = SITE_DIR . 'include/sotbit_origami/redesign/icons.svg';
$compositeStub = !empty($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] === 'Y';
?>
<?php if ($arResult['SHOW_COMPARE']): ?>
    <a
        class="sg-header__icon-btn sg-header__icon-btn--badge header-two__basket-compare <?= ($arResult['NUM_PRODUCTS_COMPARE'] > 0) ? 'active' : '' ?>"
        <?php if ($arResult['NUM_PRODUCTS_COMPARE'] != 0): ?>href="<?= Config::get('COMPARE_PAGE') ?>"<?php endif; ?>
        aria-label="Сравнение"
    >
        <svg width="20" height="20" aria-hidden="true">
            <use xlink:href="<?= htmlspecialcharsbx($iconSprite) ?>#icon-sg-compare"></use>
        </svg>
        <span class="sg-header__badge basket-item-count" id="compare-count"><?= (int)$arResult['NUM_PRODUCTS_COMPARE'] ?></span>
    </a>
<?php endif; ?>

<?php if ($arResult['SHOW_DELAY']): ?>
    <a
        class="sg-header__icon-btn sg-header__icon-btn--badge header-two__basket-favorites <?= ($arResult['NUM_PRODUCTS_DELAY'] > 0) ? 'active' : '' ?>"
        href="<?= $arParams['PATH_TO_BASKET'] ?>#favorit"
        aria-label="Избранное"
        <?php if ($arResult['NUM_PRODUCTS_DELAY'] > 0): ?>onmouseenter="<?= $cartId ?>.toggleOpenCloseCart('open', 'favorites')"<?php endif; ?>
    >
        <svg width="20" height="20" aria-hidden="true">
            <use xlink:href="<?= htmlspecialcharsbx($iconSprite) ?>#icon-sg-heart"></use>
        </svg>
        <span class="sg-header__badge basket-item-count" id="favorites-count"><?= (int)$arResult['NUM_PRODUCTS_DELAY'] ?></span>
    </a>
<?php endif; ?>

<?php if ($arParams['SHOW_PERSONAL_LINK'] === 'Y'): ?>
    <a
        class="sg-header__icon-btn sg-header__profile"
        href="<?= htmlspecialcharsbx($arParams['PATH_TO_PERSONAL'] ?: SITE_DIR . 'personal/') ?>"
        aria-label="Личный кабинет"
    >
        <svg width="20" height="20" aria-hidden="true">
            <use xlink:href="<?= htmlspecialcharsbx($iconSprite) ?>#icon-sg-profile"></use>
        </svg>
    </a>
<?php endif; ?>

<?php if ($arResult['SHOW_BASKET']): ?>
    <a
        class="sg-header__icon-btn sg-header__icon-btn--badge header-two__basket-buy <?= ($arResult['NUM_PRODUCTS'] > 0) ? 'active' : '' ?>"
        href="<?= $arParams['PATH_TO_BASKET'] ?>"
        aria-label="Корзина"
        <?php if ($arResult['NUM_PRODUCTS'] > 0): ?>onmouseenter="<?= $cartId ?>.toggleOpenCloseCart('open', 'buy')"<?php endif; ?>
    >
        <svg width="20" height="20" aria-hidden="true">
            <use xlink:href="<?= htmlspecialcharsbx($iconSprite) ?>#icon-sg-bag"></use>
        </svg>
        <?php if (!$compositeStub && $arParams['SHOW_NUM_PRODUCTS'] === 'Y' && ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] === 'Y')): ?>
            <span class="sg-header__badge basket-item-count" id="basket-count"><?= (int)$arResult['NUM_PRODUCTS'] ?></span>
        <?php endif; ?>
    </a>
<?php endif; ?>
