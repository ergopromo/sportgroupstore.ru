<?php

use Sotbit\Origami\Helper\BanerTextPosition;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
global $APPLICATION;

$url = $APPLICATION->GetCurPage();
if (is_array($arResult["ITEMS"])) {
    foreach ($arResult["ITEMS"] as $item => $arItem) {
        if (is_array($arItem["PROPERTIES"]["SHOW_SECTIONS"]["VALUE"])) {
            foreach ($arItem["PROPERTIES"]["SHOW_SECTIONS"]["VALUE"] as $sectionValue) {
                $sectionValue = str_replace(array(
                    '*',
                    '/'
                ),
                    array(
                        '.*',
                        "\/"
                    ),
                    $sectionValue);

                if ($sectionValue == "\/") {
                    $sectionValue = "^\/$";
                }
                $result = preg_match('/' . $sectionValue . '/ui',
                    $url);
                if ($result) {
                    $newItems[] = $arItem;
                }
            }
        } else {
            $newItems[] = $arItem;
        }
    }

    $arResult["ITEMS"] = $newItems;

    if(is_array($arResult['ITEMS'])) {
        foreach ($arResult["ITEMS"] as &$arItem) {
            if (is_array($arItem["PROPERTIES"]["IMAGES_WEBP"]["VALUE"])) {
                foreach ($arItem["PROPERTIES"]["IMAGES_WEBP"]["VALUE"] as $key => $imageWebp) {
                    $arItem["PROPERTIES"]["IMAGES_WEBP"]["VALUE"][$key] = CFile::GetFileArray($imageWebp);
                    $originalName[$key] = $arItem["PROPERTIES"]["IMAGES_WEBP"]["VALUE"][$key]["ORIGINAL_NAME"];
                }
            }
            $arItem["PROPERTIES"]["IMAGES_WEBP"]["WEBP_ORIGINAL_NAME"] = $originalName;
            $values = [
                'left' => 'style="align-items: start;padding-left: 75px;"',
                'centre' => 'style="align-items: center;"',
                'right' => 'style="align-items: end;padding-right: 100px;"',
            ];
            $arItem['textPosition'] = BanerTextPosition::getPosition($arItem, $values);
        }
    }
}
