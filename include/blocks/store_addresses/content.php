<?
use Sotbit\Origami\Helper\Config;

$APPLICATION->IncludeComponent(
    "sotbit:regions.maps",
    "origami_address_block",
    array(
        "ADDRESS_DATA_SOURCE" => "iblock",
        "COMPONENT_TEMPLATE" => "origami_address_block",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "CONTROLS" => array(
            0 => "TYPECONTROL",
            1 => "SCALELINE",
        ),
        "IBLOCK_ID" => Config::get("IBLOCK_ID_SHOP"),
        "IBLOCK_TYPE" => Config::get("IBLOCK_TYPE_SHOP"),
        "INIT_MAP_TYPE" => "MAP",
        "MAP_CALCULATE_CENTER" => "Y",
        "MAP_HEIGHT" => "100%",
        "MAP_SCALE" => "5",
        "MAP_WIDTH" => "100%",
        "MARKER_FIELDS" => array(
            0 => "NAME",
            1 => "UF_EMAIL",
            2 => "UF_PHONE",
        ),
        "OPTIONS" => array(
            0 => "ENABLE_SCROLL_ZOOM",
            1 => "ENABLE_DBLCLICK_ZOOM",
            2 => "ENABLE_DRAGGING",
        ),
        "REGIONS" => array(
            0 => "1",
            1 => "2",
            2 => "3",
        ),
        "SHOW_ADDRESS" => "iblock",
        "TYPE" => "yandex",
        "MARKER_FIELDS_IBLOCK" => array(
            0 => "",
            1 => "METRO",
            2 => "",
        ),
        "SHOW_STORE_PICTURE" => "Y",
        "PROPERTY_SCHEDULE" => "SCHEDULE",
        "BLOCK_TITLE" => $settings['fields']['title']['value'],
        "CONTACTS_PAGE_URL" => $settings['fields']['contact_page_url']['value'],
    ),
    false
);
?>