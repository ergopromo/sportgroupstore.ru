<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
    die();
}

if($arResult['ITEMS']) {
    $arResult['SECTIONS'] = [];
    $idSections = [];

    foreach ($arResult['ITEMS'] as $item) {
        $idSections[] = $item['IBLOCK_SECTION_ID'];
    }

    $rs = CIBlockSection::GetList(["sort" => "asc"],
        ['ID' => $idSections, 'IBLOCK_ID' => $arParams['IBLOCK_ID'], "ACTIVE" => "Y"], false,
        ["ID", "NAME", "DESCRIPTION"], false);
    while ($section = $rs->Fetch()) {
        $arResult['SECTIONS'][$section['ID']] = $section;
    }

    foreach ($arResult['ITEMS'] as &$item) {
       if(!empty($arParams["PROPERTIES_SOCIAL_NETWORK"])){
           foreach ($item["PROPERTIES"] as $code=>$prop){
               if($prop["VALUE"] && in_array($code, $arParams["PROPERTIES_SOCIAL_NETWORK"])){
                   $item["SOCIAL_NETWORK"][$code]["HINT"] = $prop["HINT"];
                   $item["SOCIAL_NETWORK"][$code]["VALUE"] = $prop["VALUE"];
               }
           }
        }
        $arResult['SECTIONS'][$item['IBLOCK_SECTION_ID']]["ITEMS"][] = $item;
    }

    unset($arResult['ITEMS']);
}