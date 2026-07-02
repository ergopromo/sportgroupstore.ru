<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

global $APPLICATION;

$this->setFrameMode(true);
Loc::loadMessages(__FILE__);

$params = [];
$arKeysParams = [
    'INIT_MAP_TYPE',
    'MAP_DATA',
    'MAP_WIDTH',
    'MAP_HEIGHT',
    'CONTROLS',
    'OPTIONS',
    'API_KEY',
    'MARKER',
];

$params = array_intersect_key($arParams, array_flip($arKeysParams));
$params['MAP_DATA'] = serialize($arResult['MAP_DATA']);
$params = array_filter($params);
$containerID = $component->randString();
?>

<div class="puzzle_block main-container">
    <div class="address-block-wrap" id="<?=$containerID?>">
        <div class="address-block-wrap__title-block">
            <h2 class="address-block-wrap__title"><?=$arParams["BLOCK_TITLE"]?></h2>
            <a href="<?=$arParams["CONTACTS_PAGE_URL"]?>" class="address-block-wrap__link"><?=GetMessage("ORIGAMI_ADDRESS_CONTACTS_PAGE");?></a>
        </div>
        <ul class="address-block-wrap__tabs-block">
            <li class="address-block-wrap__tab-item active">
                <?=GetMessage("ORIGAMI_ADDRESS_SHOW_LIST");?>
            </li>
            <li class="address-block-wrap__tab-item">
                <?=GetMessage("ORIGAMI_ADDRESS_SHOW_MAP");?>
            </li>
        </ul>
        <div class="address-block-wrap__content address-block">
            <div class="address-block__sidebar sidebar-address-block address-block__tab-content active">
                <div class="sidebar-address-block__search-block">
                    <div class="sidebar-address-block__search-wrap">
                        <input class="sidebar-address-block__search" type="text" placeholder="<?=GetMessage("ORIGAMI_ADDRESS_SEARCH_PLACEHOLDER");?>">
                        <svg class="sidebar-address-block__search-icon">
                            <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_search"></use>
                        </svg>
                        <div class="sidebar-address-block__cancel-icon-wrap">
                            <svg class="sidebar-address-block__cancel-icon">
                                <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_cancel_small"></use>
                            </svg>
                        </div>
                    </div>
                </div>
                <?if (!empty($arResult["REGIONS"]) && is_array($arResult["REGIONS"])):?>
                    <?if($arParams["ADDRESS_DATA_SOURCE"] == "iblock"):?>
                        <ul class="sidebar-address-block__city-list sidebar-address-block-city-list">
                            <?$mapData=0;?>
                            <?foreach ($arResult["REGIONS"] as $key => $region): ?>
                                <li class="sidebar-address-block-city-list__item-wrap sidebar-address-block-city-list__js-show-child">

                                    <div class="sidebar-address-block-city-list__item">
                                        <span class="sidebar-address-block-city-list__name-city"><?=$region["NAME"]?></span>
                                        <svg class="sidebar-address-block-city-list__icon-dropdown">
                                            <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_dropdown"></use>
                                        </svg>
                                    </div>
                                    <? if (!empty($region["ITEMS"]) && is_array($region["ITEMS"])): ?>
                                        <div class="sidebar-address-block-city-list__sub-items-block">
                                        <ul class="sidebar-address-block-city-list__sub-items-list">
                                            <?foreach ($region["ITEMS"] as $storeId => $store):?>
                                                <li class="sidebar-address-block-city-list__sub-item sub-item-sidebar-address-block sidebar-address-block-city-list__js-show-popup" data-popup="<?=$storeId?>" data-marker="<?=$arResult["MAP_DATA"]["PLACEMARKS"][$mapData]["LAT"].$arResult["MAP_DATA"]["PLACEMARKS"][$mapData]["LON"]?>" data-lat="<?= $arResult["MAP_DATA"]["PLACEMARKS"][$mapData]["LAT"] ?>" data-lon="<?= $arResult["MAP_DATA"]["PLACEMARKS"][$mapData]["LON"] ?>">
                                                    <?if($arParams["SHOW_STORE_PICTURE"]=="Y" && ($store["PREVIEW_PICTURE"]["SRC"] || $store["DETAIL_PICTURE"]["SRC"])):?>
                                                        <div class="sub-item-sidebar-address-block__img-wrap">
                                                            <img class="sub-item-sidebar-address-block__img" src="<?=$store["PREVIEW_PICTURE"]["SRC"] ? $store["PREVIEW_PICTURE"]["SRC"] : $store["DETAIL_PICTURE"]["SRC"]?>" alt="address-preview-picture">
                                                        </div>
                                                    <?endif;?>
                                                    <div class="sub-item-sidebar-address-block__info">
                                                        <span class="sub-item-sidebar-address-block__address-name"><?=$store["NAME"]?><?=$store["PROPERTY"]["ADDRESS"]["VALUE"] ? "&#44 &nbsp;".$store["PROPERTY"]["ADDRESS"]["VALUE"] : ''?></span>
                                                        <?if($arParams["PROPERTY_SCHEDULE"] && $store["PROPERTY"][$arParams["PROPERTY_SCHEDULE"]]["VALUE"]):?>
                                                            <div class="sub-item-sidebar-address-block__time-work-block">
                                                                <svg class="sub-item-sidebar-address-block__time-icon">
                                                                    <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_clock"></use>
                                                                </svg>
                                                                <span class="sub-item-sidebar-address-block__time-text"><?=is_array($store["PROPERTY"][$arParams["PROPERTY_SCHEDULE"]]["VALUE"]) ? $store["PROPERTY"][$arParams["PROPERTY_SCHEDULE"]]["VALUE"]["TEXT"] : $store["PROPERTY"][$arParams["PROPERTY_SCHEDULE"]] ?></span>
                                                            </div>
                                                        <?endif;?>
                                                    </div>
                                                </li>
                                            <?$mapData++;?>
                                            <?endforeach;?>
                                        </ul>
                                    </div>
                                    <? endif; ?>
                                </li>
                            <?endforeach;?>
                        </ul>
                        <div class="sidebar-address-block__popup-wrap">
                            <?foreach ($arResult["REGIONS"] as $key => $region): ?>
                                <?foreach ($region["ITEMS"] as $storeId => $store):?>
                                    <div class="sidebar-address-block__popup popup-info-item-address-block" data-popup="<?=$storeId?>">
                                        <div class="popup-info-item-address-block__title-block">
                                            <?if($arParams["SHOW_STORE_PICTURE"]=="Y" && ($store["PREVIEW_PICTURE"]["SRC"] || $store["DETAIL_PICTURE"]["SRC"])):?>
                                                <div class="popup-info-item-address-block__img-wrap">
                                                    <img class="popup-info-item-address-block__img" src="<?=$store["PREVIEW_PICTURE"]["SRC"] ? $store["PREVIEW_PICTURE"]["SRC"] : $store["DETAIL_PICTURE"]["SRC"]?>" alt="address-preview-picture">
                                                </div>
                                            <?endif;?>
                                            <div class="popup-info-item-address-block__title-wrap">
                                                <span class="popup-info-item-address-block__title"><?=$store["NAME"]?><?=$store["PROPERTY"]["ADDRESS"]["VALUE"] ? "&#44 &nbsp;".$store["PROPERTY"]["ADDRESS"]["VALUE"] : ''?></span>
                                                <button class="popup-info-item-address-block__btn-open-map">
                                                    <svg class="popup-info-item-address-block__btn-open-map-icon">
                                                        <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_location_small"></use>
                                                    </svg>
                                                    <?=GetMessage("ORIGAMI_ADDRESS_SHOW_MAP");?>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="popup-info-item-address-block__content">
                                            <?
                                            $notShowProps = ["PHONE", $arParams["PROPERTY_SCHEDULE"]];
                                            ?>
                                            <?foreach ($arParams["MARKER_FIELDS_IBLOCK"] as $field):?>
                                                <?if($store["PROPERTY"][$field]["VALUE"] && !in_array($field, $notShowProps)):?>
                                                    <div class="popup-info-item-address-block__content-item">
                                                        <span class="popup-info-item-address-block__content-item-title"><?=$store["PROPERTY"][$field]["NAME"]?></span>
                                                        <?if(is_array($store["PROPERTY"][$field]["VALUE"])):?>
                                                            <?foreach ($store["PROPERTY"][$field]["VALUE"] as $value):?>
                                                                <span class="popup-info-item-address-block__content-item-text">
                                                                    <?=$value?>
                                                                </span>
                                                            <?endforeach;?>
                                                        <?else:?>
                                                            <span class="popup-info-item-address-block__content-item-text">
                                                                <?=$store["PROPERTY"][$field]["VALUE"]?>
                                                            </span>
                                                        <? endif; ?>
                                                    </div>
                                                <? endif; ?>
                                            <? endforeach; ?>
                                                <div class="popup-info-item-address-block__content-item">
                                                    <? if (!empty($store["PROPERTY"]["PHONE"]["VALUE"]) && is_array($store["PROPERTY"]["PHONE"]["VALUE"])): ?>
                                                        <span class="popup-info-item-address-block__content-item-title"><?=GetMessage("ORIGAMI_ADDRESS_TITLE_CONTACTS_INFO")?></span>
                                                        <? foreach ($store["PROPERTY"]["PHONE"]["VALUE"] as $value): ?>
                                                            <a href="tel:<?=$value?>" class="popup-info-item-address-block__content-item-text">
                                                                <?=$value?>
                                                            </a>
                                                        <? endforeach; ?>
                                                    <? endif; ?>
                                                    <? if (!empty($store["PROPERTY"]["EMAIL"]["VALUE"]) && is_array($store["PROPERTY"]["EMAIL"]["VALUE"])): ?>
                                                        <? foreach ($store["PROPERTY"]["EMAIL"]["VALUE"] as $value): ?>
                                                            <a href="mailto:<?=$value?>" class="popup-info-item-address-block__content-item-text popup-info-item-address-block__content-item-text--main-color">
                                                                <?=$value?>
                                                            </a>
                                                        <? endforeach; ?>
                                                    <? endif; ?>
                                                </div>
                                            <?if(!empty($store["PROPERTY"][$arParams["PROPERTY_SCHEDULE"]]["VALUE"])):?>
                                                <div class="popup-info-item-address-block__content-item">
                                                    <span class="popup-info-item-address-block__content-item-title"><?=GetMessage("ORIGAMI_ADDRESS_TITLE_SCHEDULE")?></span>
                                                    <span class="popup-info-item-address-block__content-item-text">
                                                       <?=$store["PROPERTY"][$arParams["PROPERTY_SCHEDULE"]]["VALUE"]["TEXT"] ? $store["PROPERTY"][$arParams["PROPERTY_SCHEDULE"]]["VALUE"]["TEXT"] : $store["PROPERTY"][$arParams["PROPERTY_SCHEDULE"]]["VALUE"]?>
                                                    </span>
                                                </div>
                                            <?endif;?>
                                        </div>
                                        <div class="popup-info-item-address-block__close-wrap">
                                            <svg class="popup-info-item-address-block__close-icon">
                                                <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_cancel_small"></use>
                                            </svg>
                                        </div>
                                    </div>
                                <?endforeach;?>
                            <?endforeach;?>
                        </div>
                    <?else:?>
                        <ul class="sidebar-address-block__city-list sidebar-address-block-city-list">
                            <?$mapData=0;?>
                            <?foreach ($arResult["REGIONS"] as $key => $region): ?>
                                <li class="sidebar-address-block-city-list__item-wrap sidebar-address-block-city-list__js-show-popup" data-popup="<?=$region["ID"]?>" data-marker="<?=$arResult["MAP_DATA"]["PLACEMARKS"][$mapData]["LAT"].$arResult["MAP_DATA"]["PLACEMARKS"][$mapData]["LON"]?>">
                                    <div class="sidebar-address-block-city-list__item">
                                        <span class="sidebar-address-block-city-list__name-city"><?=$region["NAME"]?></span>
                                    </div>
                                </li>
                                <?$mapData++;?>
                            <?endforeach;?>
                        </ul>
                        <div class="sidebar-address-block__popup-wrap">
                            <?foreach ($arResult["REGIONS"] as $key => $region): ?>
                                <div class="sidebar-address-block__popup popup-info-item-address-block" data-popup="<?=$region["ID"]?>">
                                    <div class="popup-info-item-address-block__title-block">

                                        <div class="popup-info-item-address-block__title-wrap">
                                            <span class="popup-info-item-address-block__title"><?=$region["NAME"]?><?=$region["UF_ADDRESS"] ? "&#44 &nbsp;".$region["UF_ADDRESS"] : ''?></span>
                                            <button class="popup-info-item-address-block__btn-open-map">
                                                <svg class="popup-info-item-address-block__btn-open-map-icon">
                                                    <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_location_small"></use>
                                                </svg>
                                                <?=GetMessage("ORIGAMI_ADDRESS_SHOW_MAP");?>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="popup-info-item-address-block__content">
                                        <?if($region["UF_PHONE"] || $region["UF_EMAIL"] ):?>
                                            <div class="popup-info-item-address-block__content-item">
                                                <span class="popup-info-item-address-block__content-item-title"><?=GetMessage("ORIGAMI_ADDRESS_TITLE_CONTACTS_INFO")?></span>
                                                <?foreach (unserialize($region["UF_PHONE"]) as $value):?>
                                                    <a href="tel:<?=$value?>" class="popup-info-item-address-block__content-item-text">
                                                        <?=$value?>
                                                    </a>
                                                <?endforeach;?>
                                                <?foreach (unserialize($region["UF_EMAIL"]) as $value):?>
                                                    <a href="mailto:<?=$value?>" class="popup-info-item-address-block__content-item-text popup-info-item-address-block__content-item-text--main-color">
                                                        <?=$value?>
                                                    </a>
                                                <?endforeach;?>
                                            </div>
                                        <?endif;?>
                                    </div>
                                    <div class="popup-info-item-address-block__close-wrap">
                                        <svg class="popup-info-item-address-block__close-icon">
                                            <use xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_cancel_small"></use>
                                        </svg>
                                    </div>
                                </div>
                            <?endforeach;?>
                        </div>
                    <?endif;?>
                <?endif;?>
            </div>
            <div class="address-block__map address-block__tab-content">
                <?
                    switch ($arParams['TYPE']) {
                        case 'yandex':
                            $APPLICATION->IncludeComponent(
                                "bitrix:map.yandex.view",
                                "origami_default",
                                $params,
                                false
                            );
                            break;
                        case 'google':
                            $APPLICATION->IncludeComponent(
                                "bitrix:map.google.view",
                                "sotbit_regions_address",
                                $params
                            );
                            break;
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const wrapContainer = document.querySelector('#<?=$containerID?>')
        if(wrapContainer !== undefined) {
            let <?=$containerID?> = new AddressBlock(wrapContainer);
        }
    });
</script>
