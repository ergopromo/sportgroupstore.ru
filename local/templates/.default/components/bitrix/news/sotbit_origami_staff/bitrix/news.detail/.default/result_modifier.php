<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
    die();
}

if($arResult["PROPERTIES"]["ORIGAMI_USER"]["VALUE"]){
    $order = array('sort' => 'asc');
    $tmp = 'sort';
    $rsUsers = CUser::GetList($order, $tmp, array("ID"=>$arResult["PROPERTIES"]["ORIGAMI_USER"]["VALUE"]), array("FIELDS"=>$arParams["USER_DISPLAYED_FIELDS"]))->fetch();
    $arResult["USER_DISPLAYED_FIELDS"] = $rsUsers;
}
