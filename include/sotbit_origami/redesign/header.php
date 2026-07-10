<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Composite\BufferArea;
use Bitrix\Main\Loader;
use Sotbit\Origami\Helper\Config;

global $APPLICATION, $USER;

$isHome = in_array($APPLICATION->GetCurPage(false), [SITE_DIR, '/'], true);
$personalPage = Config::get('PERSONAL_PAGE') ?: SITE_DIR . 'personal/';
$basketPage = Config::get('BASKET_PAGE') ?: SITE_DIR . 'personal/cart/';

$navItems = [
    ['label' => 'Каталог', 'href' => SITE_DIR . 'catalog/'],
    ['label' => 'О нас', 'href' => SITE_DIR . 'about/'],
    ['label' => 'Энциклопедия', 'href' => SITE_DIR . 'about/'],
    ['label' => 'Акции', 'href' => SITE_DIR . 'promotions/'],
    ['label' => 'Новости', 'href' => SITE_DIR . 'news/'],
    ['label' => 'Блог', 'href' => SITE_DIR . 'blog/'],
    ['label' => 'Контакты', 'href' => SITE_DIR . 'contacts/'],
];
?>
<header class="sg-header" id="sg-header">
    <div class="sg-header__inner">
        <button class="sg-header__burger" type="button" aria-label="Меню" data-sg-menu-open>
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="sg-header__logo">
            <?php if (!$isHome): ?>
                <a href="<?= SITE_DIR ?>" class="sg-header__logo-link">СПОРТГРУПП</a>
            <?php else: ?>
                <span class="sg-header__logo-link">СПОРТГРУПП</span>
            <?php endif; ?>
        </div>

        <nav class="sg-header__nav" aria-label="Основное меню">
            <?php foreach ($navItems as $item): ?>
                <a href="<?= htmlspecialcharsbx($item['href']) ?>" class="sg-header__nav-link">
                    <?= htmlspecialcharsbx($item['label']) ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="sg-header__actions">
            <button class="sg-header__icon-btn" type="button" aria-label="Поиск" data-sg-search-toggle>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                    <circle cx="9" cy="9" r="6.5" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M14 14L18 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </button>

            <a class="sg-header__icon-btn" href="<?= $personalPage ?>" aria-label="Личный кабинет">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                    <circle cx="10" cy="7" r="3.5" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M4.5 17.5C5.4 14.2 7.5 12.5 10 12.5C12.5 12.5 14.6 14.2 15.5 17.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </a>

            <div class="sg-header__basket">
                <?php
                $frame = new BufferArea('sg-header-basket');
                $frame->begin();

                $templateBasket = Config::get('BASKET_TYPE') === 'origami_top_without_basket'
                    ? 'origami_top_without_basket'
                    : 'origami_basket_top';

                $APPLICATION->IncludeComponent(
                    'bitrix:sale.basket.basket.line',
                    $templateBasket,
                    [
                        'PATH_TO_BASKET' => $basketPage,
                        'PATH_TO_PERSONAL' => $personalPage,
                        'SHOW_PERSONAL_LINK' => 'N',
                        'SHOW_NUM_PRODUCTS' => 'Y',
                        'SHOW_TOTAL_PRICE' => 'N',
                        'SHOW_PRODUCTS' => 'Y',
                        'POSITION_FIXED' => 'N',
                        'SHOW_AUTHOR' => 'N',
                        'HIDE_ON_BASKET_PAGES' => 'N',
                        'PATH_TO_REGISTER' => SITE_DIR . 'login/',
                        'PATH_TO_PROFILE' => $personalPage,
                        'PATH_TO_ORDER' => Config::get('ORDER_PAGE'),
                        'SHOW_EMPTY_VALUES' => 'Y',
                        'SHOW_REGISTRATION' => 'Y',
                        'SHOW_DELAY' => 'Y',
                        'SHOW_NOTAVAIL' => 'N',
                        'SHOW_IMAGE' => 'Y',
                        'SHOW_PRICE' => 'Y',
                        'SHOW_SUMMARY' => 'Y',
                        'COMPOSITE_FRAME_MODE' => 'A',
                        'COMPOSITE_FRAME_TYPE' => 'AUTO',
                    ],
                    false
                );

                $frame->end();
                ?>
            </div>
        </div>
    </div>

    <div class="sg-header__search" data-sg-search-panel hidden>
        <div class="sg-header__search-inner">
            <?php
            if (Loader::includeModule('sotbit.origami')) {
                $APPLICATION->IncludeComponent(
                    'bitrix:search.title',
                    'origami_header_3',
                    [
                        'NUM_CATEGORIES' => '1',
                        'TOP_COUNT' => '5',
                        'CHECK_DATES' => 'N',
                        'SHOW_OTHERS' => 'N',
                        'PAGE' => SITE_DIR . 'catalog/',
                        'CATEGORY_0_TITLE' => 'Каталог',
                        'CATEGORY_0' => ['iblock_sotbit_origami_catalog'],
                        'SHOW_INPUT' => 'Y',
                        'INPUT_ID' => 'sg-title-search-input',
                        'CONTAINER_ID' => 'sg-search',
                        'ORDER' => 'date',
                        'USE_LANGUAGE_GUESS' => 'N',
                        'PRICE_VAT_INCLUDE' => 'Y',
                        'COMPONENT_TEMPLATE' => 'origami_header_3',
                    ],
                    false
                );
            }
            ?>
        </div>
    </div>
</header>

<div class="sg-mobile-menu" data-sg-menu hidden>
    <div class="sg-mobile-menu__backdrop" data-sg-menu-close></div>
    <div class="sg-mobile-menu__panel">
        <div class="sg-mobile-menu__head">
            <span class="sg-header__logo-link">СПОРТГРУПП</span>
            <button class="sg-mobile-menu__close" type="button" aria-label="Закрыть" data-sg-menu-close>&times;</button>
        </div>
        <nav class="sg-mobile-menu__nav">
            <?php foreach ($navItems as $item): ?>
                <a href="<?= htmlspecialcharsbx($item['href']) ?>" class="sg-mobile-menu__link">
                    <?= htmlspecialcharsbx($item['label']) ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </div>
</div>
