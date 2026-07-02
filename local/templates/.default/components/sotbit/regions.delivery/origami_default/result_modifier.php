<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Sotbit\Origami\Helper\Config;

if(!Loader::includeModule('sotbit.regions')){
    return false;
}

$regions = \Sotbit\Regions\System\Location::getLocations();
$arResult['REGION_LIST_COUNTRIES'] = $regions['REGION_LIST_COUNTRIES'];

$deliveryList = false;
$deliveryMsgPrice = false;
if(Loader::includeModule('sotbit.origami')) {
    $deliveryList = unserialize(Config::get('DELIVERY_LIST'));
    $deliveryMsgPrice = Config::get('DELIVERY_MESSAGE_PRICE');
}

if($arResult["PRODUCT"])
{
    $arResult["PRODUCT"]['WIDTH'] /= 10;
    $arResult["PRODUCT"]['HEIGHT'] /= 10;
    $arResult["PRODUCT"]['LENGTH'] /= 10;
    $arResult["PRODUCT"]['WEIGHT'] /= 1000;
}
if ($arResult['DELIVERY'])
{
    foreach ($arResult['DELIVERY'] as &$delivery)
    {
        if($delivery['LOGOTIP'])
        {
            $delivery['LOGOTIP'] = CFile::ResizeImageGet(
                $delivery['LOGOTIP'],
                [
                    'width'  => 125,
                    'height' => 125
                ],
                BX_RESIZE_IMAGE_PROPORTIONAL
            );
            $delivery['LOGOTIP']['SRC'] = $delivery['LOGOTIP']['src'];
        }

        if(
            !$delivery['PRICE'] &&
            is_array($deliveryList) &&
            $deliveryMsgPrice &&
            in_array($delivery['ID'], $deliveryList)
        ) {
            $delivery['PRINT_PRICE'] = $deliveryMsgPrice;
        }
    }
}
if ($arResult['PAYMENT'])
{
    foreach ($arResult['PAYMENT'] as &$payment)
    {
        if($payment['LOGOTIP'])
        {
            $payment['LOGOTIP'] = CFile::ResizeImageGet(
                $payment['LOGOTIP'],
                [
                    'width'  => 110,
                    'height' => 110
                ],
                BX_RESIZE_IMAGE_PROPORTIONAL
            );
            $payment['LOGOTIP']['SRC'] = $payment['LOGOTIP']['src'];
        }
    }
}