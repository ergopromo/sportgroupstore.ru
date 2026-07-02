<?php

use Sotbit\Origami\Helper\BanerTextPosition;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
    die();
}
$arResult['SIDE'] = [];
$arResult['MAIN'] = [];

if(is_array($arResult['ITEMS'])) {
    foreach ($arResult['ITEMS'] as $item) {
        if (is_array($item['PROPERTIES']['BANNER_TYPE']['VALUE_XML_ID'])) {
            if (in_array('SIDE',
                $item['PROPERTIES']['BANNER_TYPE']['VALUE_XML_ID'])) {
                $arResult['SIDE'][] = $item;
            }
            if (in_array('MAIN',
                $item['PROPERTIES']['BANNER_TYPE']['VALUE_XML_ID'])) {
                $values = [
                    'left' => 'style="left: 4rem;"',
                    'centre' => 'style="left: 12rem;"',
                    'right' => 'style="left: 20rem;"',
                ];
                $item['textPosition'] = BanerTextPosition::getPosition($item, $values);
                $arResult['MAIN'][] = $item;
            }
        }
    }
}
unset($arResult['ITEMS']);

