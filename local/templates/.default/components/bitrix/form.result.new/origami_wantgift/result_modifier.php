<?php

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\Loader;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

Loader::includeModule('sale');
Loader::includeModule('catalog');

global $USER;
$userName = $USER->GetFullName();

try {
    $arResult["IMG_PRODUCT"]["SRC"] = $_REQUEST["img"];
    $arResult["IMG_PRODUCT"]["NAME"] = $_REQUEST["name"];
    $arResult["IMG_PRODUCT"]["PRICE"] = CCurrencyLang::CurrencyFormat($_REQUEST["price"], $_REQUEST["currency"] ?: CCurrency::GetBaseCurrency()) ?: $_REQUEST["oldPrice"];
    $arResult["IMG_PRODUCT"]["OLD_PRICE"] = CCurrencyLang::CurrencyFormat($_REQUEST["oldPrice"], $_REQUEST["currency"] ?: CCurrency::GetBaseCurrency()) ?: $_REQUEST["oldPrice"];

    if ($arResult["QUESTIONS"]) {
        foreach ($arResult["QUESTIONS"] as &$question) {
            if(mb_stripos($question['CAPTION'], Loc::getMessage('OK_NAME')) !== false) {
                $question['STRUCTURE'][0]['VALUE'] = $userName;
            }
        }
    }

} catch (\Bitrix\Main\LoaderException $e) {
}

try {
    \Bitrix\Main\Loader::includeModule('sotbit.origami');
    $Phone = new \Sotbit\Origami\Helper\Phone();
    $Phone->setMask(\Sotbit\Origami\Config\Option::get(
        'MASK',
        $arParams['SITE_ID']
    ));
    if ($arResult["QUESTIONS"]) {
        foreach ($arResult["QUESTIONS"] as &$question) {
            if (mb_stripos($question['CAPTION'] , Loc::getMessage('OK_PHONE')) !== false) {
                $question['STRUCTURE'][0]['FIELD_TYPE'] = 'tel';
                $question['STRUCTURE'][0]['PATTERN'] = $Phone->genHtmlMask($Phone->getMask());
                $question['STRUCTURE'][0]['MASK'] = $Phone->getMask();
                $question['HTML_CODE'] = $Phone->changeHtmlField($question['HTML_CODE']);
            }
        }
    }

} catch (\Bitrix\Main\LoaderException $e) {
}

if(!empty($arResult['FORM_NOTE'])) {
    $arResult['FORM_NOTE'] = Loc::getMessage("FORM_ADD_SUCCESS_MESSAGE");
}
?>
