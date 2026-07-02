<?php

use Bitrix\Main\Composite\BufferArea;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;
use Sotbit\Origami\Config\Option;
use Sotbit\Origami\Helper\Config;

global $APPLICATION;
global $USER;
global $bannerHeader;

$useRegion = (Config::get('USE_REGIONS') == 'Y') ? true : false;
$page = $APPLICATION->GetCurPage(false);
$headerBgColor = Config::get('HEADER_BG_COLOR');

Asset::getInstance()->addJs(SITE_DIR . "local/templates/sotbit_origami/assets/plugin/swiper5.2.0/js/swiper.js");
Asset::getInstance()->addJs(SITE_DIR . "local/templates/sotbit_origami/assets/js/custom-slider.js");
Asset::getInstance()->addCss(SITE_DIR . "local/templates/sotbit_origami/assets/plugin/swiper5.2.0/css/swiper.min.css");
Asset::getInstance()->addCss(SITE_DIR . "local/templates/sotbit_origami/assets/css/style-swiper-custom.css");

?>
<div class="header-three header-three--white header-three--unfixed" id="header-three">
    <div class="header-three__wrapper">
        <div class="header-three__btn-menu-wrapper">
            <button class="header-three__btn-menu btn-menu" type="button" data-entity="open_menu">
                <svg class="header-three__btn-menu-icon" width="22" height="16">
                    <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_menu_header"></use>
                </svg>
            </button>
        </div>
        <div class="header-three__logo-wrapper">
            <? if($page != '/'):?>
                <a href="<?=SITE_DIR?>" class="header-three__logo">
                    <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => SITE_DIR."include/sotbit_origami/logo.php"
                            )
                        );?>
                </a>
            <?else:?>
                <span class="header-three__logo">
                    <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                array(
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => SITE_DIR."include/sotbit_origami/logo.php"
                                )
                            );?>
                </span>
            <?endif;?>
        </div>
        <div class="header-three__search-wrap search-wrap--unfixed search-wrap--close search-wrap--hide-input">
            <div class="header-three__city" id="header-city">
                <?$frame = new BufferArea("header-city");
                $frame->begin();?>
                <svg width="18" height="18">
                    <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_location"></use>
                </svg>
                <?
                if(\SotbitOrigami::isUseRegions())
                {
                    $template = Config::get('REGION_TEMPLATE');
                    if (!$template) {
                        $template = 'origami_location';
                    }

                    $APPLICATION->IncludeComponent(
                        "sotbit:regions.choose",
                        $template,
                        array('FROM_LOCATION' => 'Y'),
                        false
                    );
                }
                else
                {
                    ?>
                    <span>
                        <? $APPLICATION->IncludeComponent("bitrix:main.include",
                            "",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => SITE_DIR . "include/sotbit_origami/contacts_city.php"
                            ));?>
                    </span>
                    <?
                }
                $frame->end();
                ?>
            </div>
            <div class="header-three__search">
                <?
                echo Option::get('IBLOCK', SITE_ID);
                $APPLICATION->IncludeComponent(
                    "bitrix:search.title",
                    "origami_header_3",
                    array(
                        "NUM_CATEGORIES" => "1",
                        "TOP_COUNT" => "5",
                        "CHECK_DATES" => "N",
                        "SHOW_OTHERS" => "N",
                        "PAGE" => SITE_DIR."catalog/",
                        "CATEGORY_0_TITLE" => Loc::getMessage('PARAM_CATEGORY_TITLE'),
                        "CATEGORY_0" => array(
                            0 => "iblock_sotbit_origami_catalog",
                        ),
                        "CATEGORY_0_iblock_catalog" => array(
                            0 => Option::get("IBLOCK_ID", SITE_ID),
                        ),
                        "CATEGORY_OTHERS_TITLE" => Loc::getMessage('PARAM_OTHER'),
                        "SHOW_INPUT" => "Y",
                        "INPUT_ID" => "title-search-input",
                        "CONTAINER_ID" => "search",
                        "PRICE_CODE" => \SotbitOrigami::GetComponentPrices(["BASE","OPT","SMALL_OPT"]),
                        "SHOW_PREVIEW" => "Y",
                        "PREVIEW_WIDTH" => "75",
                        "PREVIEW_HEIGHT" => "75",
                        "CONVERT_CURRENCY" => "Y",
                        "COMPONENT_TEMPLATE" => "origami_header_2",
                        "ORDER" => "date",
                        "USE_LANGUAGE_GUESS" => "N",
                        "PRICE_VAT_INCLUDE" => "Y",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "CURRENCY_ID" => "RUB",
                        "CATEGORY_0_iblock_sotbit_origami_catalog" => array(
                            0 => "all",
                        )
                    ),
                    false
                );?>
                <div class="header-three__search-icon-open">
                    <svg width="18" height="18">
                        <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_search"></use>
                    </svg>
                </div>
                <div class="header-three__search-icon-close">
                    <svg width="14" height="14">
                        <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_cancel"></use>
                    </svg>
                </div>
            </div>
            <div class="header-three__contact">
                <?
                if(
                    \SotbitOrigami::isUseRegions()
                    && !\SotbitOrigami::isDemoEnd()
                    && is_dir($_SERVER['DOCUMENT_ROOT'].'/bitrix/components/sotbit/regions.data')
                ):?>
                    <?
                    $APPLICATION->IncludeComponent(
	"sotbit:regions.data",
	"origami_header_3",
	array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"REGION_FIELDS" => array(
			0 => "UF_ADDRESS",
			1 => "UF_EMAIL",
			2 => "UF_PHONE",
			3 => "UF_WORKING_MODE_SHORT",
		),
		"REGION_ID" => $_SESSION['SOTBIT_REGIONS']['ID'],
		"COMPONENT_TEMPLATE" => "origami_header_3"
	),
	false
);
                    ?>
                <?else:?>
                    <div class="contact-phone__link">
                        <svg class="contact-phone__link-icon" width="18" height="18">
                            <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_phone"></use>
                        </svg>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => SITE_DIR."include/sotbit_origami/contacts_phone.php")
                        );
                        ?>
                        <svg class="contact-phone__arrow-icon" width="10" height="6">
                            <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_dropdown_big"></use>
                        </svg>
                    </div>
                    <div class="contact-phone__drop-down">
                        <div class="contact-phone__drop-down-item contact-phone__drop-down-item--phone">
                            <svg width="18" height="18">
                                <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_phone"></use>
                            </svg>
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                array(
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => SITE_DIR."include/sotbit_origami/contacts_phone.php")
                            );
                            ?>
                        </div>
                        <div class="contact-phone__drop-down-item">
                            <svg width="18" height="20">
                                <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_time"></use>
                            </svg>
                            <p>
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "PATH" => SITE_DIR."include/sotbit_origami/contacts_worktime.php")
                                );
                                ?>
                            </p>
                        </div>
                        <div class="contact-phone__drop-down-item">
                            <svg width="18" height="20">
                                <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_mail"></use>
                            </svg>
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                array(
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => SITE_DIR."include/sotbit_origami/contacts_email.php")
                            );
                            ?>
                        </div>
                        <div class="contact-phone__drop-down-item">
                            <svg width="18" height="20">
                                <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_pin"></use>
                            </svg>
                            <p>
                                <?
                                $APPLICATION->IncludeComponent("bitrix:main.include", "", [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH"           =>
                                        SITE_DIR."include/sotbit_origami/contacts_address.php",
                                ]);
                                ?>
                            </p>
                        </div>
                        <?if(Config::get("HEADER_CALL") == "Y" && Loader::includeModule('sotbit.orderphone')):?>
                            <a href="javascript:void(0)" class="contact-phone__drop-down-btn"
                                onclick="callbackPhone('<?=SITE_DIR?>','<?=SITE_ID?>',this)">
                                <?=Loc::getMessage('CALLBACKPHONE')?>
                            </a>
                        <?endif;?>
                    </div>
                <?endif;?>
            </div>
        </div>
        <div class="header-three__basket <?=(Config::get('BASKET_TYPE') == 'origami_top_without_basket')? "right-panel--show" : "";?>">
            <?
            $frame = new BufferArea("header-basket");
            $frame->begin();

            $templateBasket = 'origami_basket_top';
            if (Config::get('BASKET_TYPE') == 'origami_top_without_basket') {
                $templateBasket = 'origami_top_without_basket';
            }

            $APPLICATION->IncludeComponent(
                "bitrix:sale.basket.basket.line",
                $templateBasket,
                array(
                    "PATH_TO_BASKET" => Config::get('BASKET_PAGE'),
                    "PATH_TO_PERSONAL" => Config::get('PERSONAL_PAGE'),
                    "SHOW_PERSONAL_LINK" => "N",
                    "SHOW_NUM_PRODUCTS" => "Y",
                    "SHOW_TOTAL_PRICE" => "Y",
                    "SHOW_PRODUCTS" => "Y",
                    "POSITION_FIXED" => "N",
                    "SHOW_AUTHOR" => "N",
                    "HIDE_ON_BASKET_PAGES" => "N",
                    "PATH_TO_REGISTER" => SITE_DIR."login/",
                    "PATH_TO_PROFILE" => Config::get('PERSONAL_PAGE'),
                    "COMPONENT_TEMPLATE" => ".default",
                    "PATH_TO_ORDER" => Config::get('ORDER_PAGE'),
                    "SHOW_EMPTY_VALUES" => "Y",
                    "PATH_TO_AUTHORIZE" => "",
                    "SHOW_REGISTRATION" => "Y",
                    "SHOW_DELAY" => "Y",
                    "SHOW_NOTAVAIL" => "N",
                    "SHOW_IMAGE" => "Y",
                    "SHOW_PRICE" => "Y",
                    "SHOW_SUMMARY" => "Y",
                    "COMPOSITE_FRAME_MODE" => "A",
                    "COMPOSITE_FRAME_TYPE" => "AUTO",
                    'IMAGE_FOR_OFFER' => Option::get('IMAGE_FOR_OFFER', SITE_ID),
                ),
                false
            );
            $frame->end();?>
        </div>

        <div class="header-three__personal <?=(Config::get('BASKET_TYPE') == 'origami_top_without_basket') ? "right-panel--show" : "";?>">
            <?$frame = new BufferArea("header-personal");
            $frame->begin();?>
            <?if($USER->IsAuthorized()):?>
                <a class="header-three__personal-link" href="<?=Config::get('PERSONAL_PAGE')?>">
                    <div class="header-three__personal-photo">
                        <?if($USER->GetParam('PERSONAL_PHOTO')):?>
                        <img src="<?=CFile::GetPath($USER->GetParam('PERSONAL_PHOTO'))?>" alt="PERSONAL_FOTO">
                        <?endif;?>
                    </div>
                </a>
            <? elseif (Config::get('BASKET_TYPE') == 'origami_basket_top'): ?>
                <?include $_SERVER["DOCUMENT_ROOT"] . SITE_DIR . "auth/index.php";?>
            <?endif;?>
            <?$frame->end();?>
        </div>
        <?
        $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "origami_main_header_5",
            array(
                "ALLOW_MULTI_SELECT" => "N",
                "CHILD_MENU_TYPE" => "left",
                "COMPOSITE_FRAME_MODE" => "A",
                "COMPOSITE_FRAME_TYPE" => "AUTO",
                "DELAY" => "N",
                "MAX_LEVEL" => "3",
                "MENU_CACHE_GET_VARS" => array(
                ),
                "MENU_CACHE_TIME" => "36000000",
                "MENU_CACHE_TYPE" => "A",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "ROOT_MENU_TYPE" => "sotbit_top",
                "USE_EXT" => "Y",
                'CACHE_SELECTED_ITEMS' => false,
                "COMPONENT_TEMPLATE" => "origami_main_header_5"
            ),
            false
        );
        ?>
    </div>
    <div class="header-two__nav">
        <div class="header-two__main-nav load">
            <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "origami_main_header_4",
                array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "sotbit_left",
                    "COMPOSITE_FRAME_MODE" => "A",
                    "COMPOSITE_FRAME_TYPE" => "AUTO",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "3",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "MENU_CACHE_TIME" => "36000000",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "ROOT_MENU_TYPE" => "sotbit_left",
                    "USE_EXT" => "Y",
                    'CACHE_SELECTED_ITEMS' => false,
                    "COMPONENT_TEMPLATE" => "origami_main_header_2"
                ),
                false
            );?>
            <div class="header-two__main-navigation">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "origami_top_header_2",
                    array(
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "left",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "3",
                        "MENU_CACHE_GET_VARS" => array(
                        ),
                        "MENU_CACHE_TIME" => "36000000",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "sotbit_top",
                        "USE_EXT" => "Y",
                        'CACHE_SELECTED_ITEMS' => false,
                        "COMPONENT_TEMPLATE" => "origami_top_header_2",
                        "MENU_THEME" => "site"
                    ),
                    false
                );?>
            </div>
        </div>
    </div>
</div>
<?

$bannerHeader = [
    'ACTIVE'               => 'Y',
    'PROPERTY_BANNER_TYPE' => Config::getBanner(['HEADER']),
];

if ($useRegion && $_SESSION['SOTBIT_REGIONS']['ID']) {
    $bannerHeader['PROPERTY_REGIONS'] = [
        false,
        $_SESSION['SOTBIT_REGIONS']['ID']
    ];
}

$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "origami_banner_header_6",
    [
        "ACTIVE_DATE_FORMAT"              => "j F Y",
        "ADD_SECTIONS_CHAIN"              => "N",
        "AJAX_MODE"                       => "N",
        "AJAX_OPTION_ADDITIONAL"          => "",
        "AJAX_OPTION_HISTORY"             => "N",
        "AJAX_OPTION_JUMP"                => "N",
        "AJAX_OPTION_STYLE"               => "Y",
        "CACHE_FILTER"                    => "N",
        "CACHE_GROUPS"                    => "Y",
        "CACHE_TIME"                      => "36000000",
        "CACHE_TYPE"                      => "A",
        "CHECK_DATES"                     => "Y",
        "DETAIL_URL"                      => "",
        "DISPLAY_BOTTOM_PAGER"            => "N",
        "DISPLAY_DATE"                    => "Y",
        "DISPLAY_NAME"                    => "Y",
        "DISPLAY_PICTURE"                 => "Y",
        "DISPLAY_PREVIEW_TEXT"            => "Y",
        "DISPLAY_TOP_PAGER"               => "N",
        "FIELD_CODE"                      => [
            "NAME",
            "PREVIEW_TEXT",
            "PREVIEW_PICTURE",
            "DETAIL_TEXT",
            "DETAIL_PICTURE",
            "DATE_ACTIVE_FROM",
            "ACTIVE_FROM",
            "",
        ],
        "FILTER_NAME"                     => "bannerHeader",
        "HIDE_LINK_WHEN_NO_DETAIL"        => "N",
        "IBLOCK_ID"                       => Config::get('IBLOCK_ID_BANNERS'),
        "IBLOCK_TYPE"                     => Config::get('IBLOCK_TYPE_BANNERS'),
        "INCLUDE_IBLOCK_INTO_CHAIN"       => "N",
        "INCLUDE_SUBSECTIONS"             => "Y",
        "MESSAGE_404"                     => "",
        "NEWS_COUNT"                      => "20",
        "PAGER_BASE_LINK_ENABLE"          => "N",
        "PAGER_DESC_NUMBERING"            => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL"                  => "N",
        "PAGER_SHOW_ALWAYS"               => "N",
        "PAGER_TEMPLATE"                  => ".default",
        "PAGER_TITLE"                     => "",
        "PARENT_SECTION"                  => "",
        "PARENT_SECTION_CODE"             => "",
        "PREVIEW_TRUNCATE_LEN"            => "120",
        "PROPERTY_CODE"                   => [
            "NEW_TAB",
            "URL",
            "VIDEO_URL",
            "BUTTON_TEXT",
            "BANNER_TYPE",
            "IMAGES_WEBP",
            "TEXT_COLOR",
            "SHOW_SECTIONS",
        ],
        "SET_BROWSER_TITLE"               => "N",
        "SET_LAST_MODIFIED"               => "N",
        "SET_META_DESCRIPTION"            => "N",
        "SET_META_KEYWORDS"               => "N",
        "SET_STATUS_404"                  => "N",
        "SET_TITLE"                       => "N",
        "SHOW_404"                        => "N",
        "SORT_BY1"                        => "SORT",
        "SORT_BY2"                        => "ACTIVE_FROM",
        "SORT_ORDER1"                     => "DESC",
        "SORT_ORDER2"                     => "ASC",
        "STRICT_SECTION_CHECK"            => "N",
        "COMPONENT_TEMPLATE"              => "origami_banner_header_6",
        "TEMPLATE_THEME"                  => "blue",
        "MEDIA_PROPERTY"                  => "",
        "SLIDER_PROPERTY"                 => "",
        "SEARCH_PAGE"                     => "/search/",
        "USE_RATING"                      => "N",
        "USE_SHARE"                       => "N",
        "COMPOSITE_FRAME_MODE"            => "A",
        "COMPOSITE_FRAME_TYPE"            => "AUTO",
    ],
    false
);
?>

<?
$APPLICATION->IncludeComponent(
    "bitrix:menu",
    "origami_main_header_sidebar",
    array(
        "ALLOW_MULTI_SELECT" => "N",
        "CHILD_MENU_TYPE" => "sotbit_side",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "DELAY" => "N",
        "MAX_LEVEL" => "1",
        "MENU_CACHE_GET_VARS" => array(
        ),
        "MENU_CACHE_TIME" => "36000000",
        "MENU_CACHE_TYPE" => "A",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "ROOT_MENU_TYPE" => "sotbit_side",
        "USE_EXT" => "Y",
        'CACHE_SELECTED_ITEMS' => false,
        "COMPONENT_TEMPLATE" => "origami_main_header_sidebar"
    ),
    false
);
?>
<?
$typeFix = "";
if(Config::get("HEADER_FIX_DESKTOP")=="Y" && Config::get("HEADER_FIX_MOBILE") == "Y") {
    $typeFix = "all";
} elseif(Config::get("HEADER_FIX_DESKTOP")=="Y") {
    $typeFix = "desktop";
} elseif(Config::get("HEADER_FIX_MOBILE")=="Y") {
    $typeFix = "mobile";
}
?>
<? if ($typeFix): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.fixedHeader('<?=$typeFix?>');
        });
    </script>
<? endif; ?>
