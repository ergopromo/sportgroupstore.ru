<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Ergopromo\Catalog\ProductRepository;

class CatalogProductsComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams): array
    {
        $arParams['IBLOCK_ID'] = (int)($arParams['IBLOCK_ID'] ?? 0);
        $arParams['IBLOCK_TYPE'] = (string)($arParams['IBLOCK_TYPE'] ?? '');
        $arParams['LABEL_PROPERTY'] = trim((string)($arParams['LABEL_PROPERTY'] ?? 'KHIT'));
        $arParams['ELEMENT_COUNT'] = max(1, (int)($arParams['ELEMENT_COUNT'] ?? 8));
        $arParams['SORT_FIELD'] = trim((string)($arParams['SORT_FIELD'] ?? 'sort'));
        $arParams['SORT_ORDER'] = strtoupper((string)($arParams['SORT_ORDER'] ?? 'ASC'));
        $arParams['PRICE_CODE'] = trim((string)($arParams['PRICE_CODE'] ?? 'BASE'));
        $arParams['TITLE'] = trim((string)($arParams['TITLE'] ?? 'Популярные товары'));
        $arParams['CATALOG_URL'] = trim((string)($arParams['CATALOG_URL'] ?? '/catalog/'));
        $arParams['CATALOG_LINK_TEXT'] = trim((string)($arParams['CATALOG_LINK_TEXT'] ?? 'Перейти в каталог'));
        $arParams['CACHE_TIME'] = (int)($arParams['CACHE_TIME'] ?? 36000000);
        $arParams['CACHE_TYPE'] = (string)($arParams['CACHE_TYPE'] ?? 'A');
        $arParams['PICTURE_WIDTH'] = max(120, (int)($arParams['PICTURE_WIDTH'] ?? 400));
        $arParams['PICTURE_HEIGHT'] = max(120, (int)($arParams['PICTURE_HEIGHT'] ?? 400));

        return $arParams;
    }

    public function executeComponent(): void
    {
        if ($this->arParams['IBLOCK_ID'] <= 0) {
            return;
        }

        if ($this->startResultCache(
            false,
            [
                $this->arParams['LABEL_PROPERTY'],
                $this->arParams['ELEMENT_COUNT'],
                $this->arParams['SORT_FIELD'],
                $this->arParams['SORT_ORDER'],
                $this->arParams['PRICE_CODE'],
                SITE_ID,
            ]
        )) {
            $repository = new ProductRepository(
                $this->arParams['IBLOCK_ID'],
                $this->arParams['PRICE_CODE']
            );

            $this->arResult = [
                'ITEMS' => $repository->getByLabel([
                    'label_property' => $this->arParams['LABEL_PROPERTY'],
                    'count' => $this->arParams['ELEMENT_COUNT'],
                    'sort_field' => $this->arParams['SORT_FIELD'],
                    'sort_order' => $this->arParams['SORT_ORDER'],
                    'picture_width' => $this->arParams['PICTURE_WIDTH'],
                    'picture_height' => $this->arParams['PICTURE_HEIGHT'],
                ]),
            ];

            $this->setResultCacheKeys(['ITEMS']);
            $this->endResultCache();
        }

        if (empty($this->arResult['ITEMS'])) {
            return;
        }

        $this->includeComponentTemplate();
    }
}
