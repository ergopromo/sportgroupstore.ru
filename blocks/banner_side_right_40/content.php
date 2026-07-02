<?php

use Sotbit\Origami\Helper\Config;

global $mainBanner;
$mainBanner = [
    'ACTIVE'               => 'Y',
    'PROPERTY_BANNER_TYPE' => Config::getBanner(['MAIN', 'SIDE']),
];
$useRegion = (Config::get('USE_REGIONS') == 'Y') ? true : false;

if ($useRegion && $_SESSION['SOTBIT_REGIONS']['ID']) {
    $mainBanner['PROPERTY_REGIONS'] = [
        false,
        $_SESSION['SOTBIT_REGIONS']['ID']
    ];
}

$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"origami_banner_3", 
	array(
		"ACTIVE_DATE_FORMAT" => "j F Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_TEXT",
			2 => "PREVIEW_PICTURE",
			3 => "DETAIL_TEXT",
			4 => "DETAIL_PICTURE",
			5 => "DATE_ACTIVE_FROM",
			6 => "ACTIVE_FROM",
			7 => "",
		),
		"FILTER_NAME" => "mainBanner",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "27",
		"IBLOCK_TYPE" => "sotbit_origami_advertising",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "banner_3",
		"PREVIEW_TRUNCATE_LEN" => "120",
		"PROPERTY_CODE" => array(
			0 => "NEW_TAB",
			1 => "URL",
			2 => "VIDEO_URL",
			3 => "BUTTON_TEXT",
			4 => "BANNER_TYPE",
			5 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => $settings["fields"]["sort_by1"]["value"],
		"SORT_BY2" => $settings["fields"]["sort_by2"]["value"],
		"SORT_ORDER1" => $settings["fields"]["sort_order1"]["value"],
		"SORT_ORDER2" => $settings["fields"]["sort_order2"]["value"],
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "origami_banner_3",
		"TEMPLATE_THEME" => "blue",
		"MEDIA_PROPERTY" => "",
		"SLIDER_PROPERTY" => "",
		"SEARCH_PAGE" => "/search/",
		"USE_RATING" => "N",
		"USE_SHARE" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);
?>
