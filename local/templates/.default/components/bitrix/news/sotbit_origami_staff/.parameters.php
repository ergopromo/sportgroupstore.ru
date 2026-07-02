<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!empty($arCurrentValues['IBLOCK_ID']) && !empty($arCurrentValues['IBLOCK_TYPE'])) {

    CModule::IncludeModule("iblock");

    $rsProperties = CIBlockProperty::GetList(Array("sort" => "asc", "id" => "asc"),
        Array("ACTIVE" => "Y", "IBLOCK_ID" => $arCurrentValues["IBLOCK_ID"]));
    while ($resProperties = $rsProperties->Fetch()) {
        $arProperties[$resProperties["CODE"]] = '['.$resProperties['ID'].'] '.$resProperties["NAME"];
    }
}
$userProfileFields = array(
    "NAME"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_NAME"),
    "LAST_NAME"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_LAST_NAME"),
    "SECOND_NAME"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_SECOND_NAME"),
    "FIELD_EMAIL"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_EMAIL"),
    "PERSONAL_PROFESSION"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_PERSONAL_PROFESSION"),
    "PERSONAL_WWW"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_PERSONAL_WWW"),
    "PERSONAL_ICQ"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_PERSONAL_ICQ"),
    "PERSONAL_GENDER"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_PERSONAL_GENDER"),
    "PERSONAL_BIRTHDAY"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_PERSONAL_BIRTHDAY"),
    "PERSONAL_PHONE"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_PERSONAL_PHONE"),
    "PERSONAL_FAX"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_PERSONAL_FAX"),
    "PERSONAL_MOBILE"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_PERSONAL_MOBILE"),
    "PERSONAL_PAGER"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_PERSONAL_PAGER"),
    "PERSONAL_STREET"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_PERSONAL_STREET"),
    "PERSONAL_MAILBOX"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_PERSONAL_MAILBOX"),
    "PERSONAL_CITY"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_PERSONAL_CITY"),
    "PERSONAL_STATE"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_PERSONAL_STATE"),
    "PERSONAL_ZIP"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_PERSONAL_ZIP"),
    "PERSONAL_COUNTRY"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_PERSONAL_COUNTRY"),
    "PERSONAL_NOTES"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_PERSONAL_NOTES"),
    "WORK_COMPANY"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_WORK_COMPANY"),
    "WORK_DEPARTMENT"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_WORK_DEPARTMENT"),
    "WORK_POSITION"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_WORK_POSITION"),
    "WORK_WWW"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_WORK_WWW"),
    "WORK_PHONE"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_WORK_PHONE"),
    "WORK_FAX"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_WORK_FAX"),
    "WORK_PAGER"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_WORK_PAGER"),
    "WORK_STREET"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_WORK_STREET"),
    "WORK_MAILBOX"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_WORK_MAILBOX"),
    "WORK_CITY"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_WORK_CITY"),
    "WORK_STATE"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_WORK_STATE"),
    "WORK_ZIP"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_WORK_ZIP"),
    "WORK_COUNTRY"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_WORK_COUNTRY"),
    "WORK_PROFILE"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_WORK_PROFILE"),
    "WORK_NOTES"=>GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELD_WORK_NOTES")
);

$arTemplateParameters = array(
	"DISPLAY_DATE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PICTURE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PREVIEW_TEXT" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"USE_SHARE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_USE_SHARE"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"N",
		"REFRESH"=> "Y",
	),
    "MAIN_TEL" => Array(
        "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_MAIN_TEL"),
        "TYPE" => "LIST",
        "MULTIPLE" => "N",
        "VALUES" => $arProperties,
        "ADDITIONAL_VALUES" => "Y",
    ),
    "MAIN_EMAIL" => Array(
        "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_MAIN_EMAIL"),
        "TYPE" => "LIST",
        "MULTIPLE" => "N",
        "VALUES" => $arProperties,
        "ADDITIONAL_VALUES" => "Y",
    ),
    "PROPERTIES_SOCIAL_NETWORK" => Array(
        "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PROPERTIES_SOCIAL_NETWORK"),
        "TYPE" => "LIST",
        "MULTIPLE" => "Y",
        "SIZE"     => "5",
        "VALUES" => $arProperties,
        "ADDITIONAL_VALUES" => "Y",
    ),
    "PROPERTIES_DISPLAYED_ON_DETAIL" => Array(
        "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PROPERTIES_DISPLAYED_ON_DETAIL"),
        "TYPE" => "LIST",
        "MULTIPLE" => "Y",
        "SIZE"     => "5",
        "VALUES" => $arProperties,
        "ADDITIONAL_VALUES" => "Y",
    ),
    "USER_DISPLAYED_FIELDS" => Array(
    "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_USER_DISPLAYED_FIELDS"),
    "TYPE" => "LIST",
    "MULTIPLE" => "Y",
    "SIZE"     => "5",
    "VALUES" => $userProfileFields,
    "ADDITIONAL_VALUES" => "Y",
),
);

if ($arCurrentValues["USE_SHARE"] == "Y")
{
	$arTemplateParameters["SHARE_HIDE"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_HIDE"),
		"TYPE" => "CHECKBOX",
		"VALUE" => "Y",
		"DEFAULT" => "N",
	);

	$arTemplateParameters["SHARE_TEMPLATE"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_TEMPLATE"),
		"DEFAULT" => "",
		"TYPE" => "STRING",
		"MULTIPLE" => "N",
		"COLS" => 25,
		"REFRESH"=> "Y",
	);
	
	if (strlen(trim($arCurrentValues["SHARE_TEMPLATE"])) <= 0)
		$shareComponentTemlate = false;
	else
		$shareComponentTemlate = trim($arCurrentValues["SHARE_TEMPLATE"]);

	include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/components/bitrix/main.share/util.php");

	$arHandlers = __bx_share_get_handlers($shareComponentTemlate);

	$arTemplateParameters["SHARE_HANDLERS"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SYSTEM"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arHandlers["HANDLERS"],
		"DEFAULT" => $arHandlers["HANDLERS_DEFAULT"],
	);

	$arTemplateParameters["SHARE_SHORTEN_URL_LOGIN"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SHORTEN_URL_LOGIN"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	);
	
	$arTemplateParameters["SHARE_SHORTEN_URL_KEY"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SHORTEN_URL_KEY"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	);
}

?>