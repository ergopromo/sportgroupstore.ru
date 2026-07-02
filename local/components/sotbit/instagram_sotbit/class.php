<?php
require_once('help/Instagram.php');
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

class SotbitInstagramComponent extends \CBitrixComponent
{
     /**
     * @param $arParams
     *
     * @return array
     */
    public function onPrepareComponentParams($arParams)
    {
        return $arParams;
    }

    public function executeComponent()
    {
        global $USER;

        if ($USER->IsAdmin()) {
            $this->AbortResultCache();
        }
        if ($this->StartResultCache($this->arParams["CACHE_TIME"])) {
            $instagram =  new InstagramController();
            $this->arResult["LOGIN"] = $this->arParams["LOGIN"];
            $this->arResult["TITLE"] = $this->arParams["TITLE"];
            $this->arResult["SUBSCRIBE"] = "https://www.instagram.com/".$this->arParams["LOGIN"]."/";

            $this->arResult['POSTS'] = $instagram->getMediaPosts(11);
            $this->IncludeComponentTemplate();
        }
    }
}
