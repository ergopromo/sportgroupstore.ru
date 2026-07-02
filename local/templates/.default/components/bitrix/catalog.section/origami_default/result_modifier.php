<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use \Sotbit\Origami\Config\Option;
Loader::includeModule('sotbit.origami');

$tmp = array();
$tmpD = array();
$tmpPhoto = array();
if($arResult['ITEMS'])
{
    foreach($arResult['ITEMS'] as $j => $item)
    {
        $tmp[$item['ID']] = $item['PREVIEW_PICTURE'];
        $tmpD[$item['ID']] = $item['DETAIL_PICTURE'];

        if(isset($item["DISPLAY_PROPERTIES"]["MORE_PHOTO"]))
        {
            if(isset($item["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"]["ID"]))
                $tmpPhoto[$item['ID']][] = $item["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"];
            else $tmpPhoto[$item['ID']] = $item["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"];
        }

        if($item['OFFERS'])
        {
            foreach($item['OFFERS'] as $offer)
            {
                $tmp[$offer['ID']] = $offer['PREVIEW_PICTURE'];
                $tmpD[$offer['ID']] = $offer['DETAIL_PICTURE'];
                //$tmpPhoto[$offer['ID']] = $offer['MORE_PHOTO'];
            }
        }
    }
}

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

if($arResult['ITEMS'])
{
    foreach ($arResult['ITEMS'] as $j => $item)
    {
        $arResult['ITEMS'][$j]['PREVIEW_PICTURE'] = $tmp[$item['ID']];
        $arResult['ITEMS'][$j]['DETAIL_PICTURE'] = $tmpD[$item['ID']];
        $arResult['ITEMS'][$j]['MORE_PHOTO'] = $tmpPhoto[$item['ID']];

        if ($item['JS_OFFERS'])
        {
            foreach ($item['JS_OFFERS'] as $i => $offer)
            {
                $arResult['ITEMS'][$j]['JS_OFFERS'][$i]['PREVIEW_PICTURE'] = $tmp[$offer['ID']];
                $arResult['ITEMS'][$j]['JS_OFFERS'][$i]['DETAIL_PICTURE'] = $tmpD[$offer['ID']];
            }
        }
    }
}

unset($tmp, $tmpD, $tmpPhoto);

if($arParams['ELEMENT_SORT_FIELD'] === 'PROPERTY_RATING'){
    if($arResult['ITEMS'] && \Bitrix\Main\Loader::includeModule('sotbit.reviews') && Option::get('ACTIVE_TAB_COMPLEX_REVIEWS_', SITE_ID) === 'Y'){
        foreach ($arResult['ITEMS'] as &$item){
            $votesValue = CSotbitReviews::getReviewByItemId($item['ID']);
            $item['RATING'] = $votesValue;
        }
        if($arParams['ELEMENT_SORT_ORDER'] === 'ASC'){
            usort($arResult['ITEMS'], fn($a, $b) => $a['RATING'] <=> $b['RATING']);
        }elseif ($arParams['ELEMENT_SORT_ORDER'] === 'DESC'){
            usort($arResult['ITEMS'], fn($a, $b) => $b['RATING'] <=> $a['RATING']);
        }
    }
}

$arResult["ALL_PRICES_NAMES"] = \SotbitOrigami::getAllNamePrices($arResult);
