<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

foreach ($arResult["ITEMS"] as $keyItem =>$items){
    if($items['DETAIL_PAGE_URL'] === $APPLICATION->GetCurPage(false)){
       unset($arResult["ITEMS"][$keyItem]);
    }
}
