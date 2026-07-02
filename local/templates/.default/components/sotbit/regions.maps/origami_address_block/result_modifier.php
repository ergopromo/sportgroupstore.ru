<?php

use Sotbit\Regions\Maps\Base;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
if (!function_exists(__NAMESPACE__ . '\getElementByMaps')) {
    function getElementByMaps($mapPropertyCode, $iblockId)
    {
        $dbSections = CIBlockSection::GetList(array("SORT" => "ASC"),
            array('IBLOCK_ID' => $iblockId, "SECTION_ID" => 0, "ACTIVE" => "Y"), false, array("NAME", "ID"), false);
        while ($arSections = $dbSections->Fetch()) {
            $dbElements = CIBlockElement::GetList(Array("SORT" => "ASC"),
                Array(
                    "IBLOCK_ID" => $iblockId,
                    "SUBSECTION" => $arSections["ID"],
                    "ACTIVE" => "Y",
                    "!PROPERTY_" . $mapPropertyCode => false
                ),
                false,
                false,
                Array("IBLOCK_ID", "ID", "NAME", "PREVIEW_PICTURE", "DETAIL_PICTURE", "PROPERTY_" . $mapPropertyCode));
            while ($arElements = $dbElements->GetNextElement()) {
                $arProperties = $arElements->GetProperties();
                $arRegions[$arSections["ID"]]["NAME"] = $arSections["NAME"];
                $arRegions[$arSections["ID"]]["ITEMS"][$arElements->fields["ID"]] = $arElements->fields;
                if ($arElements->fields["PREVIEW_PICTURE"]) {
                    $arRegions[$arSections["ID"]]["ITEMS"][$arElements->fields["ID"]]["PREVIEW_PICTURE"] = CFile::GetFileArray($arElements->fields["PREVIEW_PICTURE"]);
                } else {
                    $arRegions[$arSections["ID"]]["ITEMS"][$arElements->fields["ID"]]["DETAIL_PICTURE"] = CFile::GetFileArray($arElements->fields["DETAIL_PICTURE"]);
                }
                $arRegions[$arSections["ID"]]["ITEMS"][$arElements->fields["ID"]]["PROPERTY"] = $arProperties;
            }
        }
        return $arRegions;
    }
}

if (!function_exists(__NAMESPACE__ . '\setTextMap')) {
    function setTextMap($arrayStore, $arParams)
    {
        if ($arrayStore["PROPERTY"]["ADDRESS"]["VALUE"]) {
            $text = '<h2 class="content_balloon__title">' . $arrayStore["NAME"] . "&#44 &nbsp;" . $arrayStore["PROPERTY"]["ADDRESS"]["VALUE"] . '</h2>';
        } else {
            $text = '<h2 class="content_balloon__title">' . $arrayStore["NAME"] . '</h2>';
        }

        foreach ($arrayStore["PROPERTY"] as $code => $prop) {
            if (in_array($code, $arParams["MARKER_FIELDS_IBLOCK"]) && $prop["VALUE"]) {
                $text .= '<h6 class="content_balloon__title-item">' . $prop["NAME"] . '</h6>';
                if (isset($prop["VALUE"]["TEXT"])) {
                    $text .= '<span class="content_balloon__item">' . $prop["VALUE"]["TEXT"] . '</span>';
                } elseif (is_array($prop["VALUE"])) {
                    foreach ($prop["VALUE"] as $type => $value) {
                        $text .= '<span class="content_balloon__item">' . $value . '</span>';
                    }
                } else {
                    $text .= '<span class="content_balloon__item">' . $prop["VALUE"] . '</span>';
                }

                if (!empty($arrayStore["PROPERTY"]["PHONE"]["VALUE"])) {

                    $text .= '<h6 class="content_balloon__title-item">' . GetMessage("SOTBIT_ADDRESS_BALLOON_CONTACT_INFORMATION") . '</h6>';

                    foreach ($arrayStore["PROPERTY"]["PHONE"]["VALUE"] as $value) {
                        $text .= '<a href="tel:' . $value . '" class="content_balloon__item">' . $value . '</a>';
                    }

                    if(!empty($arrayStore["PROPERTY"]["EMAIL"]["VALUE"])) {
                        foreach ($arrayStore["PROPERTY"]["EMAIL"]["VALUE"] as $value) {
                            $text .= '<a href="mailto:' . $value . '" class="content_balloon__item content_balloon__item--main-color">' . $value . '</a>';
                        }
                    }
                }

                if ($arParams["PROPERTY_SCHEDULE"] && $arrayStore["PROPERTY"][$arParams["PROPERTY_SCHEDULE"]]["VALUE"]) {
                    $text .= '<h6 class="content_balloon__title-item">' . GetMessage("SOTBIT_ADDRESS_BALLOON_SCHEDULE") . '</h6>';
                    if ($arrayStore["PROPERTY"][$arParams["PROPERTY_SCHEDULE"]]["VALUE"]["TEXT"]) {
                        $text .= '<span class="content_balloon__item">' . $arrayStore["PROPERTY"][$arParams["PROPERTY_SCHEDULE"]]["VALUE"]["TEXT"] . '</span>';
                    } else {
                        $text .= '<span class="content_balloon__item">' . $arrayStore["PROPERTY"][$arParams["PROPERTY_SCHEDULE"]]["VALUE"] . '</span>';
                    }
                }
            }
        }

        return $text;
    }
}
// infoblock data source
if ($arParams["ADDRESS_DATA_SOURCE"] == "iblock" && isset($arParams["IBLOCK_ID"])) {

    $arResult['MAP_DATA'] = [];

    if ($arParams['TYPE'] == "yandex") {

        $arResult["REGIONS"] = getElementByMaps("YANDEX_MAP", $arParams["IBLOCK_ID"]);

        if ($arResult["REGIONS"]) {
            foreach ($arResult["REGIONS"] as $region) {
                foreach ($region["ITEMS"] as $store) {

                    $textMap = setTextMap($store, $arParams);

                    $coordinate = explode(",", $store["PROPERTY_YANDEX_MAP_VALUE"]);

                    if (empty($arResult['MAP_DATA'])) {
                        $arResult['MAP_DATA'] = [
                            'yandex_lat' => ($arParams['MAP_CALCULATE_CENTER'] == "Y" ?
                                $arResult['MAP_CENTER'][0] : $coordinate[0]),
                            'yandex_lon' => ($arParams['MAP_CALCULATE_CENTER'] == "Y" ?
                                $arResult['MAP_CENTER'][1] : $coordinate[1]),
                            'yandex_scale' => $arParams['MAP_SCALE'],
                        ];
                    }
                    $marker = $arResult['MARKER'] ? $arResult['MARKER'] : '';
                    $position[] = [
                        'MARKER' => $marker,
                        'TEXT' => $textMap,
                        'LAT' => $coordinate[0],
                        'LON' => $coordinate[1],
                    ];
                }
            }
        }
    }

    if ($arParams['TYPE'] == "google") {
        $arResult["REGIONS"] = getElementByMaps("GOOGLE_MAP", $arParams["IBLOCK_ID"]);
        if ($arResult["REGIONS"]) {
            foreach ($arResult["REGIONS"] as $region) {
                foreach ($region["ITEMS"] as $store) {
                    $textMap = setTextMap($store, $arParams);
                    $coordinate = explode(",", $store["PROPERTY_GOOGLE_MAP_VALUE"]);
                    if (empty($arResult['MAP_DATA'])) {
                        $arResult['MAP_DATA'] = [
                            'google_lat' => ($arParams['MAP_CALCULATE_CENTER'] == "Y" ?
                                $arResult['MAP_CENTER'][0] : $coordinate[0]),
                            'google_lon' => ($arParams['MAP_CALCULATE_CENTER'] == "Y" ?
                                $arResult['MAP_CENTER'][1] : $coordinate[1]),
                            'google_scale' => $arParams['MAP_SCALE'],
                        ];
                    }

                    $marker = ($arResult['MARKER'] ? $arResult['MARKER'] : '');

                    $position[] = [
                        'MARKER' => $marker,
                        'TEXT' => $textMap,
                        'LAT' => $coordinate[0],
                        'LON' => $coordinate[1],
                    ];
                }
            }
        }
    }

    if (!empty($position)) {
        $arResult['MAP_DATA']['PLACEMARKS'] =
            array_merge(($arResult['MAP_DATA']['PLACEMARKS'] ?? []), $position);
    }
} //sotbit.regions data source
else {
// create coordinates
    $arResult['MAP_DATA'] = [];
    if (!empty($arResult['REGIONS'])) {
        foreach ($arResult['REGIONS'] as $regionId => $regionVal) {

            $position = [];

            // points info
            $text = '';
            $text = '<h2 class="content_balloon__title">'.$regionVal["NAME"]. "&#44 &nbsp;". $regionVal["UF_ADDRESS"].'</h2>';

            if($regionVal["UF_PHONE"] || $regionVal["UF_EMAIL"]){
                $text .= '<h6 class="content_balloon__title-item">'.GetMessage("SOTBIT_ADDRESS_BALLOON_CONTACT_INFORMATION").'</h6>';

                if($regionVal["UF_PHONE"]){
                    foreach (unserialize($regionVal["UF_PHONE"]) as $value){
                        $text .= '<a href="tel:'.$value.'" class="content_balloon__item">'.$value.'</a>';
                    }
                }
                if($regionVal["UF_EMAIL"]){
                    foreach (unserialize($regionVal["UF_EMAIL"]) as $value){
                        $text .= '<a href="mailto:'.$value.'" class="content_balloon__item content_balloon__item--main-color">'.$value.'</a>';
                    }
                }
            }

            $arFieldLang = Base::getUserFields();

            foreach ($arParams['MARKER_FIELDS'] as $field) {
                if($field == "UF_PHONE" || $field == "UF_EMAIL"){
                    continue;
                }
                $lang = '';
                if (!empty($regionVal[$field])) {
                    if (!empty($arFieldLang[$field]) && $field != "NAME") {
                        $lang = $arFieldLang[$field];

                        $text .= '<h6 class="content_balloon__title-item">' . $lang . '</h6>';
                        if (Base::is_serialized($regionVal[$field])) {

                            foreach (unserialize($regionVal[$field]) as $value) {
                                $text .= '<span class="content_balloon__item">' . $value . '</span>';
                            }

                        } else {
                            $text .= '<span class="content_balloon__item">' . $regionVal[$field] . '</span>';
                        }
                    }
                }
            }

            // yandex
            if ($arParams['TYPE'] == "yandex") {
                if (!$regionVal["MAP_YANDEX"]) {
                    unset($arResult['REGIONS'][$regionId]);
                    continue;
                }
                if (!empty($regionVal['MAP_YANDEX'][0]['VALUE'])) {
                    $coordinate = explode(",", $regionVal['MAP_YANDEX'][0]['VALUE']);

                    if (empty($arResult['MAP_DATA'])) {
                        $arResult['MAP_DATA'] = [
                            'yandex_lat' => ($arParams['MAP_CALCULATE_CENTER'] == "Y" ?
                                $arResult['MAP_CENTER'][0] : $coordinate[0]),
                            'yandex_lon' => ($arParams['MAP_CALCULATE_CENTER'] == "Y" ?
                                $arResult['MAP_CENTER'][1] : $coordinate[1]),
                            'yandex_scale' => $arParams['MAP_SCALE'],
                        ];
                    }

                    $marker = ($regionVal['MAP_YANDEX']['MARKER'] ? $regionVal['MAP_YANDEX']['MARKER'] : ($arResult['MARKER'] ? $arResult['MARKER'] : ''));

                    $position[] = [
                        'MARKER' => $marker,
                        'TEXT' => $text,
                        'LAT' => $coordinate[0],
                        'LON' => $coordinate[1],
                    ];
                }
            }

            // google
            if ($arParams['TYPE'] == "google") {
                if (!$regionVal["MAP_GOOGLE"]) {
                    unset($arResult['REGIONS'][$regionId]);
                    continue;
                }
                if (!empty($regionVal['MAP_GOOGLE']['VALUE'][0]['VALUE'])) {
                    $coordinate = explode(",", $regionVal['MAP_GOOGLE']['VALUE'][0]['VALUE']);

                    if (empty($arResult['MAP_DATA'])) {
                        $arResult['MAP_DATA'] = [
                            'google_lat' => ($arParams['MAP_CALCULATE_CENTER'] == "Y" ?
                                $arResult['MAP_CENTER'][0] : $coordinate[0]),
                            'google_lon' => ($arParams['MAP_CALCULATE_CENTER'] == "Y" ?
                                $arResult['MAP_CENTER'][1] : $coordinate[1]),
                            'google_scale' => $arParams['MAP_SCALE'],
                        ];
                    }

                    $marker = ($regionVal['MAP_GOOGLE']['MARKER'] ? $regionVal['MAP_GOOGLE']['MARKER'] : ($arResult['MARKER'] ? $arResult['MARKER'] : ''));

                    $position[] = [
                        'MARKER' => $marker,
                        'TEXT' => $text,
                        'LAT' => $coordinate[0],
                        'LON' => $coordinate[1],
                    ];
                }
            }

            if (!empty($position)) {
                $arResult['MAP_DATA']['PLACEMARKS'] =
                    array_merge(($arResult['MAP_DATA']['PLACEMARKS'] ?? []), $position);
            }

        }
    }
}