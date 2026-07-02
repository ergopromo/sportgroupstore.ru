<?
global $settings, $arrFilter;

$picture = $settings['fields']['image_from']['value'];
$showDescription = ($settings['fields']['show_description']['value'] == "Y") ? true : false;

$arrFilter = array();
$arrFilter[">UF_SHOW_ON_MAIN_PAGE"] = 0;
$arrFilter[">" . $picture] = 0;

use Sotbit\Origami\Helper\Config;
$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list", 
	"origami_popular_categories_advanced", 
	array(
		"ADD_SECTIONS_CHAIN" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CACHE_FILTER" => "Y",
		"FILTER_NAME" => "arrFilter",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"COUNT_ELEMENTS" => "N",
		"IBLOCK_ID" => "23",
		"IBLOCK_TYPE" => "sotbit_origami_catalog",
		"SECTION_FIELDS" => array(
			0 => "NAME",
			1 => "SECTION_PAGE_URL",
			2 => $showDescription?"DESCRIPTION":"",
			3 => ($picture=="PICTURE")?"PICTURE":"",
			4 => "",
		),
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "UF_SHOW_ON_MAIN_PAGE",
			1 => ($picture=="UF_PHOTO_DETAIL")?"UF_PHOTO_DETAIL":"",
			2 => "",
		),
		"SHOW_PARENT_NAME" => "Y",
		"TOP_DEPTH" => $settings["fields"]["top_depth"]["value"],
		"SHOW_SUBSECTIONS" => "N",
		"VIEW_MODE" => "LINE",
		"LINK_TO_THE_CATALOG" => $settings["fields"]["link_catalog"]["value"],
		"BLOCK_NAME" => $settings["fields"]["title"]["value"],
		"COUNT_SECTIONS" => $settings["fields"]["count_sections"]["value"],
		"COMPONENT_TEMPLATE" => "origami_popular_categories_advanced",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => "",
		"COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
		"ADDITIONAL_COUNT_ELEMENTS_FILTER" => "additionalCountFilter",
		"HIDE_SECTIONS_WITH_ZERO_COUNT_ELEMENTS" => "N"
	),
	false
);
?>