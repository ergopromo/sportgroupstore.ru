<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

class ProductMiniCardComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams): array
    {
        $arParams['ITEM'] = is_array($arParams['ITEM'] ?? null) ? $arParams['ITEM'] : [];
        $arParams['SHOW_LABELS'] = ($arParams['SHOW_LABELS'] ?? 'Y') === 'N' ? 'N' : 'Y';
        $arParams['SHOW_OLD_PRICE'] = ($arParams['SHOW_OLD_PRICE'] ?? 'Y') === 'N' ? 'N' : 'Y';
        $arParams['BUTTON_TEXT'] = trim((string)($arParams['BUTTON_TEXT'] ?? 'В корзину'));
        $arParams['BUTTON_TEXT_OFFERS'] = trim((string)($arParams['BUTTON_TEXT_OFFERS'] ?? 'Подробнее'));
        $arParams['BASKET_URL'] = trim((string)($arParams['BASKET_URL'] ?? '/personal/cart/'));

        return $arParams;
    }

    public function executeComponent(): void
    {
        if (empty($this->arParams['ITEM']['ID'])) {
            return;
        }

        $this->arResult = [
            'ITEM' => $this->arParams['ITEM'],
        ];

        $this->includeComponentTemplate();
    }
}
