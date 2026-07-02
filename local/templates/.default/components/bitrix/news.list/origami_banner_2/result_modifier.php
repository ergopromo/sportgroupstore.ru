<?php

use Sotbit\Origami\Helper\BanerTextPosition;


if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

if (is_array($arResult['ITEMS'])) {
    foreach ($arResult['ITEMS'] as $item) {
        if (
            is_array($item['PROPERTIES']['BANNER_TYPE']['VALUE_XML_ID']) &&
            in_array('MAIN', $item['PROPERTIES']['BANNER_TYPE']['VALUE_XML_ID'])
        ) {

            $values = [
                'left' => 'style="left: 8vw;"',
                'centre' => 'style="left: 24vw;"',
                'right' => 'style="left: 40vw;"',
            ];
            $item['textPosition'] = BanerTextPosition::getPosition($item, $values);
            $arResult['BIG_CANVAS'][] = $item;
        }
    }
}

unset($arResult['ITEMS']);
