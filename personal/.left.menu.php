<?
use Sotbit\Origami\Helper\Config;
$basketPage = Config::get("BASKET_PAGE");
$personalOrderPage = Config::get("PERSONAL_ORDER_PAGE");

$aMenuLinks = Array(
	Array(
		"Мой кабинет", 
		"index.php", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Текущие заказы",
		$personalOrderPage,
		Array(),
		Array(),
		""
	),
	Array(
		"Личный счет", 
		"account/", 
		Array(), 
		Array(), 
		"CBXFeatures::IsFeatureEnabled('SaleAccounts')" 
	),
	Array(
		"Личные данные", 
		"private/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"История заказов", 
		"orders/?filter_history=Y",
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Профили заказов", 
		"profiles/", 
		Array(), 
		Array(), 
		"" 
	),
	Array(
		"Корзина",
		$basketPage,
		Array(),
		Array(),
		""
	),
	Array(
		"Подписки", 
		"subscribe/", 
		Array(), 
		Array(), 
		"" 
	)
);
?>