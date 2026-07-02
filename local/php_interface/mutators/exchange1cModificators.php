<?
use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler("iblock", "OnBeforeIBlockSectionAdd", function(&$arFields) {
    global $USER;
    if ($USER->GetID() == 10) {
        global $APPLICATION;
        $APPLICATION->ThrowException("Пользователю запрещено создавать разделы.");
        return false;
    }
    return true;
});

$eventManager->addEventHandler("iblock", "OnBeforeIBlockSectionUpdate", function(&$arFields) {
    global $USER;
    if ($USER->GetID() == 10) {
        global $APPLICATION;
        $APPLICATION->ThrowException("Пользователю запрещено изменять разделы.");
        return false;
    }
    return true;
});

$eventManager->addEventHandler("iblock", "OnBeforeIBlockSectionDelete", function($sectionId) {
    global $USER;
    if ($USER->GetID() == 10) {
        global $APPLICATION;
        $APPLICATION->ThrowException("Пользователю запрещено удалять разделы.");
        return false;
    }
    return true;
});
