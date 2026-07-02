<?
if (!isset($_POST['siteId']) || !is_string($_POST['siteId'])) {
    die();
}

if (!isset($_POST['templateName']) || !is_string($_POST['templateName'])) {
    die();
}

if (
    $_SERVER['REQUEST_METHOD'] != 'POST' ||
    preg_match('/^[A-Za-z0-9_]{2}$/',
        $_POST['siteId']) !== 1 ||
    preg_match('/^[.A-Za-z0-9_-]+$/',
        $_POST['templateName']) !== 1
) {
    die;
}

define('STOP_STATISTICS',
    true);
define('NOT_CHECK_PERMISSIONS',
    true);
define('SITE_ID',
    $_POST['siteId']);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use \Bitrix\Main\Loader,
    \Bitrix\Sale\Fuser,
    \Bitrix\Sale\Internals\BasketTable,
    \Bitrix\Catalog\MeasureRatioTable,
    Sotbit\Origami\Helper\Config;

if (
    !Loader::includeModule('catalog') ||
    !Loader::includeModule('sale') ||
    !Loader::includeModule('sotbit.origami')
) {
    die;
}

if (!check_bitrix_sessid()) {
    die;
}

global $APPLICATION;
global $USER;

$_POST['arParams']['AJAX'] = 'Y';

$arParams = isset($_POST["arParams"]) ? $_POST["arParams"] : array();
if (Config::get('BASKET_TYPE') == 'origami_top_without_basket') {
    $templateName = 'origami_top_without_basket';
} else {
    $templateName = htmlspecialcharsEx($_POST["templateName"]);
}

if (isset($_POST["refresh"])) {
    $ID = htmlspecialcharsEx($_POST["ID"]);
    if (isset($_POST["ID"]) && isset($_POST["count"])) {
        $count = htmlspecialcharsEx($_POST["count"]);
        $PRODUCT_ID = htmlspecialcharsEx($_POST["productID"]);

        $ratio = MeasureRatioTable::getList(
            array(
                'select' => array(
                    'RATIO',
                    'PRODUCT_ID'
                ),
                'filter' => array('PRODUCT_ID' => $PRODUCT_ID)
            )
        )->Fetch();

        $val = $ratio["RATIO"];

        if ($count <= $val) {
            $count = $val;
        } else {
            $ost = fmod($count,
                $val);
            if ($ost != 0) {
                $count = $count - $ost;
            }
        }

        $arFields = array(
            "QUANTITY" => $count
        );
    } elseif (isset($_POST["ID"]) && isset($_POST["delay"])) {
        $arFields = array(
            "DELAY" => "Y",
        );
    } elseif (isset($_POST["ID"]) && isset($_POST["buy"])) {
        $arFields = array(
            "DELAY" => "N",
        );
    }

    $resultBasket = BasketTable::Update($ID,
        $arFields);
} elseif (isset($_POST["deleteList"])) {
    if ($_POST["tab"] == "buy") {
        $filter = array(
            'FUSER_ID' => Fuser::getId(),
            'LID' => SITE_ID,
            'ORDER_ID' => false,
            'DELAY' => 'N'
        );
    } else {
        $filter = array(
            'FUSER_ID' => Fuser::getId(),
            'LID' => SITE_ID,
            'ORDER_ID' => false,
            'DELAY' => 'Y',
        );
    }

    $dbBasket = BasketTable::getList(array(
        'filter' => $filter,
        'select' => array('ID')
    ));

    while ($arBasket = $dbBasket->Fetch()) {
        BasketTable::Delete($arBasket["ID"]);
    }
}

$arParams["TAB_ACTIVE"] = ($_POST["tab"] == "delay") ? "DELAY" : "BUY";
$APPLICATION->RestartBuffer();
header('Content-Type: text/html; charset=' . LANG_CHARSET);

$APPLICATION->IncludeComponent('bitrix:sale.basket.basket.line',
    $templateName,
    $arParams);
?>
