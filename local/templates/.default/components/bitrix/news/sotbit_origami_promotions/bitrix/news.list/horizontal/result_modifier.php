<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
    die();
}

use \Bitrix\Main\Type\DateTime;

if($arResult["ITEMS"])
{
    $curTime = (new DateTime())->toString();

    foreach ($arResult["ITEMS"] as $i => &$arItem)
    {
        if (!empty($arItem['DATE_ACTIVE_TO'])) {
            $arItem["DISPLAY_ACTIVE_TO"] = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"],
                MakeTimeStamp($arItem["DATE_ACTIVE_TO"],
                    CSite::GetDateFormat()));
        } else {
            $arItem["DISPLAY_ACTIVE_TO"] = "";
        }
    }
}

