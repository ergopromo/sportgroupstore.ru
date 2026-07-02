<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;
global $USER;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Sotbit\Origami\Helper\Config;

$useRegion = (Config::get('USE_REGIONS') == 'Y') ? true : false;
$page = $APPLICATION->GetCurPage(false);
$arParams["SHOW_BASKET"] = Config::checkAction("BUY");
$arParams["SHOW_DELAY"] = Config::checkAction("DELAY");
$arParams["SHOW_COMPARE"] = Config::checkAction("COMPARE");
?>
<!-- The menu -->
<nav id="menu" class="bootstrap_style">
    <div>

        <div class="container_menu_mobile__search_block">
            <?
            $APPLICATION->IncludeComponent(
                "bitrix:search.title",
                "origami_mobile",
                array(
                    "INPUT_ID" => "title-search-input-mobile",
                    "CONTAINER_ID" => "title-search-mobile",
                    "NUM_CATEGORIES" => "1",
                    "CHECK_DATES" => "N",
                    "ORDER" => "date",
                    "PAGE" => SITE_DIR."catalog/",
                    "SHOW_INPUT" => "Y",
                    "SHOW_OTHERS" => "N",
                    "TOP_COUNT" => "5",
                    "USE_LANGUAGE_GUESS" => "Y",
                    "CATEGORY_0" => array("iblock_catalog"),
                    "CATEGORY_0_iblock_catalog" => array("all"),
                    "CATEGORY_0_TITLE" => Loc::getMessage('MENU_PRODUCTS'),
                    "PRICE_CODE" => array("BASE"),
                    "SHOW_PREVIEW" => "Y",
                    "PREVIEW_WIDTH" => "80",
                    "PREVIEW_HEIGHT" => "80"
                )
            );
            ?>
        </div>
        <div class="header_info_block__item header_info_block__block_region">
            <div class="header_info_block__block_region__title">
                <div id="mobileRegion" class="mobileRegionTwo"></div>
            </div>
        </div>
        <ul class="container_menu_mobile__list_wrapper">
            <li><a  class="container_menu_mobile__list_link" href="<?=SITE_DIR?>catalog/"><?=Loc::getMessage('MENU_CATALOG');?></a>
                <?if (!empty($arResult)):?>
                <ul id="container_menu_mobile">
                    <?
                    $previousLevel = 0;
                    foreach($arResult as $arItem):?>

                    <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
                        <?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
                    <?endif?>

                    <?if ($arItem["IS_PARENT"]):?>

                        <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                        <li class="container_menu_mobile__list_li">
                            <?if($arItem['LINK'] != $page):?>
                            <a href="<?=$arItem["LINK"]?>" class="container_menu_mobile__list_link"  title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?></a>
                            <?else:?>
                            <span class="menu-catalog__section-title"><?=$arItem['TEXT']?></span>
                            <?endif?>
                            <ul class="root-item">
                        <?else:?>
                                <li class="container_menu_mobile__list_li">
                                    <?if($arItem['LINK'] != $page):?>
                                        <a href="<?=$arItem["LINK"]?>" class="container_menu_mobile__list_link"  title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?></a>
                                    <?else:?>
                                        <span class="menu-catalog__section-title"><?=$arItem['TEXT']?></span>
                                    <?endif?>
                                    <ul>
                        <?endif?>

                    <?else:?>

                        <?if ($arItem["PERMISSION"] > "D"):?>

                            <?if ($arItem["DEPTH_LEVEL"] == 1):?>
                                <li class="container_menu_mobile__list_li">
                                    <?if($arItem['LINK'] != $page):?>
                                        <a href="<?=$arItem["LINK"]?>" class="container_menu_mobile__list_link"  title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?></a>
                                    <?else:?>
                                        <span class="menu-catalog__section-title"><?=$arItem['TEXT']?></span>
                                    <?endif?>
                                </li>
                            <?else:?>
                                <li class="container_menu_mobile__list_li">
                                    <?if($arItem['LINK'] != $page):?>
                                        <a href="<?=$arItem["LINK"]?>" class="container_menu_mobile__list_link"  title="<?=$arItem["TEXT"]?>"><?=$arItem["TEXT"]?></a>
                                    <?else:?>
                                        <span class="menu-catalog__section-title"><?=$arItem['TEXT']?></span>
                                    <?endif?>
                                </li>
                            <?endif?>

                        <?else:?>
                            <li class="container_menu_mobile__list_li"><a class="container_menu_mobile__list_link" href="" title="<?=Loc::getMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
                        <?endif?>

                    <?endif?>

                    <?$previousLevel = $arItem["DEPTH_LEVEL"];?>

                    <?endforeach?>

                    <?if ($previousLevel > 1)://close last item tags?>
                        <?=str_repeat("</ul></li>", ($previousLevel-1) );?>
                    <?endif?>
                </ul>
                <?endif;?>
            </li>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "origami_mobile_menu_top",
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
                        "USE_EXT" => "N",
                        "COMPONENT_TEMPLATE" => "",
                        "MENU_THEME" => "site"
                    ),
                    false
                );?>
        </ul>
        <div class="container_menu_mobile__list">
            <div class="container_menu_mobile__item fonts__small_text">
                <a class="container_menu_mobile__item_link" href="<?=Config::get('PERSONAL_PAGE')?>">
                    <span class="mobile_icon_user">
                       <svg width="14" height="14">
                            <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_authorized_medium"></use>
                        </svg>
                    </span>
                    <?=Loc::getMessage('MENU_PERSONAL_ACCOUNT');?>
                </a>
            </div>
            <?if($arParams["SHOW_COMPARE"]):?>
            <div class="container_menu_mobile__item fonts__small_text">
                <a class="container_menu_mobile__item_link" href="<?=Config::get('COMPARE_PAGE')?>">
                    <span class="mobile_icon_chart-bar">
                        <svg class="" width="14" height="14">
                            <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_compare"></use>
                        </svg>
                    </span>
                    <?=Loc::getMessage('MENU_COMPARISON');?>
                    <span class="container_menu_mobile__item_link_col" id="mobile-menu-compare"></span>
                </a>
            </div>
            <?endif;?>
            <?if($arParams["SHOW_DELAY"]):?>
            <div class="container_menu_mobile__item fonts__small_text">
                <a class="container_menu_mobile__item_link" href="<?=Config::get('BASKET_PAGE')?>">
                    <span class="mobile_icon_heart">
                        <svg class="" width="14" height="14">
                            <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_favourite"></use>
                        </svg>
                    </span>
                    <?=Loc::getMessage('MENU_FAVOURITES');?>
                    <span class="container_menu_mobile__item_link_col" id="mobile-menu-delay"></span>
                </a>
            </div>
            <?endif;?>
            <?if($arParams["SHOW_BASKET"]):?>
            <div class="container_menu_mobile__item fonts__small_text">
                <a class="container_menu_mobile__item_link" href="<?=Config::get('BASKET_PAGE')?>">
                    <span class="mobile_icon_shopping-basket">
                        <svg class="" width="14" height="14">
                            <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_cart"></use>
                        </svg>
                    </span>
                    <?=Loc::getMessage('MENU_CART');?>
                    <span class="container_menu_mobile__item_link_col" id="mobile-menu-basket"></span>
                </a>
            </div>
            <?endif;?>
            <?if($USER->IsAuthorized()):?>
                <div class="container_menu_mobile__item fonts__small_text">
                    <a class="container_menu_mobile__item_link" href="?logout=yes&<?=bitrix_sessid_get()?>">
                        <span class="mobile_icon_login">
                            <svg class="" width="14" height="14">
                                <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_login"></use>
                            </svg>
                        </span>
                        <?=Loc::getMessage('MENU_LOGOUT');?>
                    </a>
                </div>
            <?endif?>

        </div>
        <div class="container_menu__contact">
            <p class="container_menu__contact_title fonts__main_text"><?=Loc::getMessage('MENU_CONTACT_INFO');?></p>

            <?if(
            Loader::includeModule('sotbit.regions') &&
            \SotbitOrigami::isUseRegions() &&
            !\SotbitOrigami::isDemoEnd() &&
            is_dir($_SERVER['DOCUMENT_ROOT'].'/bitrix/components/sotbit/regions.data')
            ):?>
            <?
                $APPLICATION->IncludeComponent(
                    "sotbit:regions.data",
                    "origami_mobile_menu_contacts",
                    [
                        "CACHE_TIME"    => "36000000",
                        "CACHE_TYPE"    => "A",
                        "REGION_FIELDS" => ['UF_ADDRESS', 'UF_EMAIL', 'UF_PHONE'],
                        "REGION_ID"     => $_SESSION['SOTBIT_REGIONS']['ID']
                    ]
                );
            ?>

            <?else:?>
            <?$APPLICATION->IncludeComponent("bitrix:main.include", "", [
                        "AREA_FILE_SHOW" => "file",
                        "PATH"           =>
                            SITE_DIR."include/sotbit_origami/mmenu_contacts_address.php",
                    ]);?>

                    <?
                    $APPLICATION->IncludeComponent("bitrix:main.include", "", [
                        "AREA_FILE_SHOW" => "file",
                        "PATH"           =>
                            SITE_DIR."include/sotbit_origami/mmenu_contacts_email.php",
                    ]);

                    $APPLICATION->IncludeComponent("bitrix:main.include", "", [
                        "AREA_FILE_SHOW" => "file",
                        "PATH"           =>
                            SITE_DIR."include/sotbit_origami/mmenu_contacts_phone.php",
                    ]);
                ?>
            <?endif;?>
        </div>
        <div class="container_menu__contact_soc contact-soc-menu">
            <?
            $vk = Config::get('VK');
            $tw = Config::get('TW');
            $ok = Config::get('OK');
            $inst = Config::get('INST');
            $telega = Config::get('TELEGA');
            if($vk)
            {
                ?>
                <a class="contact-soc-menu__link" href="<?=$vk?>">
                    <svg class="contact-soc-menu__icon">
                        <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_vk"></use>
                    </svg>
                </a>
                <?
            }
            if($tw)
            {
                ?>
                <a class="contact-soc-menu__link" href="<?=$tw?>">
                    <svg class="contact-soc-menu__icon">
                        <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_twitter"></use>
                    </svg>
                </a>
                <?
            }
            if($ok)
            {
                ?>
                <a class="contact-soc-menu__link" href="<?=$ok?>">
                    <svg class="contact-soc-menu__icon">
                        <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_odnoklassniki"></use>
                    </svg>
                </a>
                <?
            }
            if($inst)
            {
                ?>
                <a class="contact-soc-menu__link" href="<?=$inst?>">
                    <svg class="contact-soc-menu__icon">
                        <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_instagram"></use>
                    </svg>
                </a>
                <?
            }
            if($telega)
            {
                ?>
                <a class="contact-soc-menu__link" href="<?=$telega?>">
                    <svg class="contact-soc-menu__icon">
                        <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_telegram"></use>
                    </svg>
                </a>
                <?
            }
            ?>
            <?if(Config::get("HEADER_CALL") == "Y" && \Bitrix\Main\Loader::includeModule('sotbit.orderphone')):?>
                <a href="javascript:void(0)" class="menu-contact__call-back main-color-btn-fill" onclick="callbackPhone('<?=SITE_DIR?>','<?=SITE_ID?>',this)">
                    <?=Loc::getMessage('REGIONS_DATA_ORDERCALL_TITLE')?>
                </a>
            <?endif;?>
        </div>
    </div>

</nav>
