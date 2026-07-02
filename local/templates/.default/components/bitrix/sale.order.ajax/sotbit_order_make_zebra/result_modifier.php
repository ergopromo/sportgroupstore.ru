<?
use Bitrix\Main\Loader;
use Sotbit\Origami\Helper\Config;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

if(Loader::includeModule('sotbit.origami')) {
    $deliveryList = unserialize(Config::get('DELIVERY_LIST')) ?: [];
    $deliveryMsgPrice = Config::get('DELIVERY_MESSAGE_PRICE');

    if($arResult['DELIVERY'])
    {
        foreach($arResult['DELIVERY'] as &$delivery)
        {
            if(
                !$delivery['PRICE'] &&
                is_array($deliveryList) &&
                $deliveryMsgPrice &&
                in_array($delivery['ID'], $deliveryList)
            ) {
                $delivery['PRINT_PRICE'] = $delivery['PRICE_FORMATED'] = $deliveryMsgPrice;
            }
        }
    }
}