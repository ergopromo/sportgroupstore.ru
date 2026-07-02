<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/*
 * Назначение: Страница детального просмотра заказа пользователя
 *
 * История изменений:
 * v1.1 – Изменен шаблон на ergopromo_custom для единообразия логики отображения кнопки "Оплатить" (2025-10-29)
 * v1.0 – Исходная версия (дата неизвестна)
 */

$APPLICATION->SetTitle("Заказы");

$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order", 
	"ergopromo_custom", 
	array(
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => SITE_DIR."personal/order/",
		"ORDERS_PER_PAGE" => "10",
		"PATH_TO_PAYMENT" => SITE_DIR."personal/order/payment/",
		"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
		"SET_TITLE" => "Y",
		"SAVE_IN_SESSION" => "N",
		"NAV_TEMPLATE" => "arrows",
		"SHOW_ACCOUNT_NUMBER" => "Y",
		"ALLOW_INNER" => "N",
		"ONLY_INNER_FULL" => "N",
		"COMPONENT_TEMPLATE" => "ergopromo_custom",
		"DETAIL_HIDE_USER_INFO" => array(
		),
		"PROP_1" => array(
		),
		"PROP_2" => array(
		),
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_GROUPS" => "Y",
		"PATH_TO_CATALOG" => "/catalog/",
		"DISALLOW_CANCEL" => "N",
		"CUSTOM_SELECT_PROPS" => array(
		),
		"HISTORIC_STATUSES" => array(
			0 => "F",
		),
		"RESTRICT_CHANGE_PAYSYSTEM" => array(
		),
		"REFRESH_PRICES" => "N",
		"ORDER_DEFAULT_SORT" => "ID",
		"STATUS_COLOR_AS" => "gray",
		"STATUS_COLOR_CO" => "gray",
		"STATUS_COLOR_F" => "gray",
		"STATUS_COLOR_N" => "green",
		"STATUS_COLOR_PR" => "gray",
		"STATUS_COLOR_PSEUDO_CANCELLED" => "red",
		"SEF_URL_TEMPLATES" => array(
			"list" => "index.php",
			"detail" => "detail/#ID#/",
			"cancel" => "cancel/#ID#/",
		)
	),
	false
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");