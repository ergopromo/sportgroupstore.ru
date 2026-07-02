<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

use Bitrix\Main\Loader;
use Sotbit\Origami\Helper\Config;
use Sotbit\Origami\Image\Basket;

if (Config::get("IMAGE_FOR_OFFER") == 'PRODUCT' && $arResult["BASKET_ITEMS"] && $arResult['GRID']['ROWS'])
{
    $Basket = new Basket();
    $Basket->setMediumHeight(190);
    $Basket->setMediumWidth(190);
    $arProductID = [];

    foreach($arResult["BASKET_ITEMS"] as $arItem)
    {
        $arProductID[] = $arItem['PRODUCT_ID'];
    }

    $images = $Basket->getImages($arProductID);

    foreach($arResult['GRID']['ROWS'] as &$arRow)
    {
        $arRow['data'] = $Basket->changeImages($arRow['data'], $images[$arRow['data']['PRODUCT_ID']]);
    }
}

if (Loader::includeModule('sotbit.origami')) {
    $deliveryList = unserialize(Config::get('DELIVERY_LIST')) ?: [];
    $deliveryMsgPrice = Config::get('DELIVERY_MESSAGE_PRICE');

    if ($arResult['DELIVERY']) {
        foreach ($arResult['DELIVERY'] as &$delivery) {
            if (
                !$delivery['PRICE'] &&
                is_array($deliveryList) &&
                $deliveryMsgPrice &&
                in_array($delivery['ID'],
                    $deliveryList)
            ) {
                $delivery['PRINT_PRICE'] = $delivery['PRICE_FORMATED'] = $deliveryMsgPrice;
            }
        }
    }
}