<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Sotbit\Origami\Helper\Config;
Loader::includeModule('sotbit.origami');


$arTemplateParameters = array(
    "ADDRESS_DATA_SOURCE" => array(
        "NAME" => GetMessage(\SotbitRegions::entityId . "_ADDRESS_DATA_SOURCE"),
        "TYPE" => "LIST",
        "PARENT" => "DATA_SOURCE",
        "VALUES" => [
            "iblock" => GetMessage(\SotbitRegions::entityId . "_ADDRESS_DATA_SOURCE_IBLOCK"),
            "regions" => GetMessage(\SotbitRegions::entityId . "_ADDRESS_DATA_SOURCE_REGIONS"),
        ],
        "REFRESH" => "Y",
        "DEFAULT" => "regions",
    ),
);

if (!empty($arCurrentValues['ADDRESS_DATA_SOURCE']) && $arCurrentValues['ADDRESS_DATA_SOURCE'] == "iblock") {

    CModule::IncludeModule("iblock");

    $dbIBlockType = CIBlockType::GetList(
        array("sort" => "asc"),
        array("ACTIVE" => "Y")
    );
    while ($arIBlockType = $dbIBlockType->Fetch()) {
        if ($arIBlockTypeLang = CIBlockType::GetByIDLang($arIBlockType["ID"], LANGUAGE_ID)) {
            $arIblockType[$arIBlockType["ID"]] = "[" . $arIBlockType["ID"] . "] " . $arIBlockTypeLang["NAME"];
        }
    }

    $arIBlock = array();
    $iblockFilter = (
    !empty($arCurrentValues['IBLOCK_TYPE'])
        ? array('TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE' => 'Y')
        : array('ACTIVE' => 'Y')
    );
    $rsIBlock = CIBlock::GetList(array('SORT' => 'ASC'), $iblockFilter);
    while ($arr = $rsIBlock->Fetch()) {
        $id = (int)$arr['ID'];
        $arIBlock[$id] = '[' . $id . '] ' . $arr['NAME'];
    }

    if (!empty($arCurrentValues['IBLOCK_ID']) && !empty($arCurrentValues['IBLOCK_TYPE'])) {
        $rsProperties = CIBlockProperty::GetList(Array("sort" => "asc", "id" => "asc"),
            Array("ACTIVE" => "Y", "IBLOCK_ID" => $arCurrentValues['IBLOCK_ID']));
        while ($resProperties = $rsProperties->Fetch()) {
            $arProperties[$resProperties["CODE"]] = '[' . $resProperties['ID'] . '] ' . $resProperties["NAME"];
        }
    }

    $arTemplateParameters["REGIONS"] = [
        "HIDDEN" => 'Y',
    ];
    $arTemplateParameters["MARKER_FIELDS"] = [
        "HIDDEN" => 'Y',
    ];
    $arTemplateParameters["IBLOCK_TYPE"] = [
        "NAME" => GetMessage(\SotbitRegions::entityId . "_IBLOCK_TYPE"),
        "TYPE" => "LIST",
        "VALUES" => $arIblockType,
        "PARENT" => "BASE",
        "REFRESH" => "Y",
        "ADDITIONAL_VALUES" => "Y",
    ];
    $arTemplateParameters["IBLOCK_ID"] = [
        "NAME" => GetMessage(\SotbitRegions::entityId . "_IBLOCK_ID"),
        "PARENT" => "BASE",
        "TYPE" => "LIST",
        "VALUES" => $arIBlock,
        "REFRESH" => "Y",
        "ADDITIONAL_VALUES" => "Y",
    ];
    $arTemplateParameters["MARKER_FIELDS_IBLOCK"] = [
        "NAME" => GetMessage(\SotbitRegions::entityId . "_MAPS_MARKER_FIELDS"),
        "PARENT" => "BASE",
        "TYPE" => "LIST",
        "MULTIPLE" => "Y",
        "SIZE" => "5",
        "VALUES" => $arProperties,
        "ADDITIONAL_VALUES" => "Y",
    ];
    $arTemplateParameters["SHOW_STORE_PICTURE"] = [
        "NAME" => GetMessage(\SotbitRegions::entityId . "_SHOW_STORE_PICTURE"),
        "PARENT" => "VISUAL",
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",
    ];
    $arTemplateParameters["PROPERTY_SCHEDULE"] = [
        "NAME" => GetMessage(\SotbitRegions::entityId . "_PROPERTY_SCHEDULE"),
        "PARENT" => "VISUAL",
        "TYPE" => "LIST",
        "VALUES" => $arProperties,
        "ADDITIONAL_VALUES" => "Y",
    ];
}