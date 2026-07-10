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

$compositeStub = !empty($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] === 'Y';
$sgIcons = include $_SERVER['DOCUMENT_ROOT'] . SITE_DIR . 'include/sotbit_origami/redesign/icons_paths.php';
?>
<?php if ($arResult['SHOW_COMPARE']): ?>
    <a
        class="sg-header__icon-btn sg-header__icon-btn--badge header-two__basket-compare <?= ($arResult['NUM_PRODUCTS_COMPARE'] > 0) ? 'active' : '' ?>"
        <?php if ($arResult['NUM_PRODUCTS_COMPARE'] != 0): ?>href="<?= Config::get('COMPARE_PAGE') ?>"<?php endif; ?>
        aria-label="Сравнение"
    >
        <img
            class="sg-icon-img"
            src="<?= htmlspecialcharsbx($sgIcons['compare_header']) ?>"
            width="20"
            height="20"
            alt=""
            aria-hidden="true"
        >
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
        <img
            class="sg-icon-img"
            src="<?= htmlspecialcharsbx($sgIcons['like']) ?>"
            width="20"
            height="20"
            alt=""
            aria-hidden="true"
        >
        <span class="sg-header__badge basket-item-count" id="favorites-count"><?= (int)$arResult['NUM_PRODUCTS_DELAY'] ?></span>
    </a>
<?php endif; ?>

<?php if ($arParams['SHOW_PERSONAL_LINK'] === 'Y'): ?>
    <a
        class="sg-header__icon-btn sg-header__profile"
        href="<?= htmlspecialcharsbx($arParams['PATH_TO_PERSONAL'] ?: SITE_DIR . 'personal/') ?>"
        aria-label="Личный кабинет"
    >
        <img
            class="sg-icon-img"
            src="<?= htmlspecialcharsbx($sgIcons['user']) ?>"
            width="20"
            height="20"
            alt=""
            aria-hidden="true"
        >
    </a>
<?php endif; ?>

<?php if ($arResult['SHOW_BASKET']): ?>
    <a
        class="sg-header__icon-btn sg-header__icon-btn--badge header-two__basket-buy <?= ($arResult['NUM_PRODUCTS'] > 0) ? 'active' : '' ?>"
        href="<?= $arParams['PATH_TO_BASKET'] ?>"
        aria-label="Корзина"
        <?php if ($arResult['NUM_PRODUCTS'] > 0): ?>onmouseenter="<?= $cartId ?>.toggleOpenCloseCart('open', 'buy')"<?php endif; ?>
    >
        <img
            class="sg-icon-img"
            src="<?= htmlspecialcharsbx($sgIcons['cart']) ?>"
            width="20"
            height="20"
            alt=""
            aria-hidden="true"
        >
        <?php if (!$compositeStub && $arParams['SHOW_NUM_PRODUCTS'] === 'Y' && ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] === 'Y')): ?>
            <span class="sg-header__badge basket-item-count" id="basket-count"><?= (int)$arResult['NUM_PRODUCTS'] ?></span>
        <?php endif; ?>
    </a>
<?php endif; ?>
