<?php

namespace Ergopromo\Catalog;

use Bitrix\Main\Loader;
use CCatalogProduct;
use CCatalogSKU;
use CCurrencyLang;
use CIBlockElement;
use CFile;
use CPrice;

/**
 * Выборка товаров каталога для списков ergopromo без Bitrix-компонентов каталога.
 */
class ProductRepository
{
    private int $iblockId;
    private string $priceCode;
    private ?int $priceGroupId = null;

    public function __construct(int $iblockId, string $priceCode = 'BASE')
    {
        $this->iblockId = $iblockId;
        $this->priceCode = $priceCode;
    }

    /**
     * @param array{
     *     label_property?: string,
     *     count?: int,
     *     sort_field?: string,
     *     sort_order?: string,
     *     picture_width?: int,
     *     picture_height?: int,
     * } $params
     * @return array<int, array<string, mixed>>
     */
    public function getByLabel(array $params): array
    {
        if (!Loader::includeModule('iblock')) {
            return [];
        }

        $labelCode = (string)($params['label_property'] ?? 'KHIT');
        $count = max(1, (int)($params['count'] ?? 8));
        $sortField = (string)($params['sort_field'] ?? 'sort');
        $sortOrder = strtoupper((string)($params['sort_order'] ?? 'ASC')) === 'DESC' ? 'DESC' : 'ASC';
        $pictureWidth = max(120, (int)($params['picture_width'] ?? 400));
        $pictureHeight = max(120, (int)($params['picture_height'] ?? 400));

        $filter = [
            'IBLOCK_ID' => $this->iblockId,
            'ACTIVE' => 'Y',
            'ACTIVE_DATE' => 'Y',
            '!PROPERTY_' . $labelCode => false,
        ];

        $select = [
            'ID',
            'IBLOCK_ID',
            'NAME',
            'CODE',
            'DETAIL_PAGE_URL',
            'PREVIEW_PICTURE',
            'DETAIL_PICTURE',
            'PROPERTY_' . $labelCode,
        ];

        $items = [];
        $rs = CIBlockElement::GetList(
            [$sortField => $sortOrder, 'ID' => 'DESC'],
            $filter,
            false,
            ['nTopCount' => $count],
            $select
        );

        while ($element = $rs->GetNext()) {
            $items[] = $this->normalizeItem(
                $element,
                $labelCode,
                $pictureWidth,
                $pictureHeight
            );
        }

        return $items;
    }

    /**
     * @param array<string, mixed> $element
     * @return array<string, mixed>
     */
    private function normalizeItem(
        array $element,
        string $labelCode,
        int $pictureWidth,
        int $pictureHeight
    ): array {
        $productId = (int)$element['ID'];
        $pictureId = (int)($element['PREVIEW_PICTURE'] ?: $element['DETAIL_PICTURE']);
        $picture = $this->resizePicture($pictureId, $pictureWidth, $pictureHeight, (string)$element['NAME']);

        $priceData = $this->resolvePrice($productId);
        $labels = $this->resolveLabels($element, $labelCode);

        return [
            'ID' => $productId,
            'NAME' => (string)$element['NAME'],
            'URL' => (string)$element['DETAIL_PAGE_URL'],
            'PICTURE' => $picture,
            'PRICE' => $priceData,
            'LABELS' => $labels,
            'AVAILABLE' => $priceData['CAN_BUY'],
            'BASKET' => [
                'PRODUCT_ID' => $priceData['PRODUCT_ID'],
                'QUANTITY' => 1,
            ],
            'HAS_OFFERS' => $priceData['HAS_OFFERS'],
        ];
    }

    /**
     * @return array{SRC: string, SRC_2X?: string, ALT: string}
     */
    private function resizePicture(int $pictureId, int $width, int $height, string $alt): array
    {
        if ($pictureId <= 0) {
            return [
                'SRC' => '/local/templates/sotbit_origami/assets/img/no_photo_medium.svg',
                'ALT' => $alt,
            ];
        }

        $resized = CFile::ResizeImageGet(
            $pictureId,
            ['width' => $width, 'height' => $height],
            BX_RESIZE_IMAGE_PROPORTIONAL,
            true
        );

        if (!is_array($resized) || empty($resized['src'])) {
            return [
                'SRC' => CFile::GetPath($pictureId),
                'ALT' => $alt,
            ];
        }

        return [
            'SRC' => (string)$resized['src'],
            'SRC_2X' => !empty($resized['src']) ? (string)$resized['src'] : '',
            'ALT' => $alt,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function resolvePrice(int $productId): array
    {
        $default = [
            'VALUE' => 0.0,
            'PRINT' => '',
            'BASE_VALUE' => 0.0,
            'BASE_PRINT' => '',
            'DISCOUNT_PERCENT' => 0,
            'CURRENCY' => 'RUB',
            'CAN_BUY' => false,
            'PRODUCT_ID' => $productId,
            'HAS_OFFERS' => false,
        ];

        if (!Loader::includeModule('catalog')) {
            return $default;
        }

        $catalogProduct = CCatalogProduct::GetByID($productId);
        if (!$catalogProduct) {
            return $default;
        }

        $buyId = $productId;
        $hasOffers = (int)$catalogProduct['TYPE'] === CCatalogProduct::TYPE_SKU;

        if ($hasOffers) {
            $offers = CCatalogSKU::getOffersList(
                $productId,
                $this->iblockId,
                ['ACTIVE' => 'Y'],
                ['ID', 'NAME']
            );

            if (empty($offers[$productId])) {
                return array_merge($default, ['HAS_OFFERS' => true]);
            }

            $bestOffer = $this->pickCheapestOffer(array_keys($offers[$productId]));
            if (!$bestOffer) {
                return array_merge($default, ['HAS_OFFERS' => true]);
            }

            $buyId = (int)$bestOffer['ID'];
        }

        $optimal = CCatalogProduct::GetOptimalPrice(
            $buyId,
            1,
            [],
            'N',
            [],
            SITE_ID
        );

        if (empty($optimal['RESULT_PRICE'])) {
            return array_merge($default, [
                'HAS_OFFERS' => $hasOffers,
                'PRODUCT_ID' => $buyId,
            ]);
        }

        $price = $optimal['RESULT_PRICE'];
        $currency = (string)($price['CURRENCY'] ?? 'RUB');
        $value = (float)($price['DISCOUNT_PRICE'] ?? 0);
        $baseValue = (float)($price['BASE_PRICE'] ?? $value);
        $discountPercent = $baseValue > 0
            ? (int)round((1 - $value / $baseValue) * 100)
            : 0;

        return [
            'VALUE' => $value,
            'PRINT' => CCurrencyLang::CurrencyFormat($value, $currency, true),
            'BASE_VALUE' => $baseValue,
            'BASE_PRINT' => CCurrencyLang::CurrencyFormat($baseValue, $currency, true),
            'DISCOUNT_PERCENT' => max(0, $discountPercent),
            'CURRENCY' => $currency,
            'CAN_BUY' => $value > 0,
            'PRODUCT_ID' => $buyId,
            'HAS_OFFERS' => $hasOffers,
        ];
    }

    /**
     * @param int[] $offerIds
     * @return array{ID: int, PRICE: float}|null
     */
    private function pickCheapestOffer(array $offerIds): ?array
    {
        $priceGroupId = $this->getPriceGroupId();
        if ($priceGroupId <= 0) {
            return null;
        }

        $best = null;

        foreach ($offerIds as $offerId) {
            $row = CPrice::GetList(
                [],
                [
                    'PRODUCT_ID' => $offerId,
                    'CATALOG_GROUP_ID' => $priceGroupId,
                ]
            )->Fetch();

            if (!$row) {
                continue;
            }

            $price = (float)$row['PRICE'];
            if ($best === null || $price < $best['PRICE']) {
                $best = [
                    'ID' => (int)$offerId,
                    'PRICE' => $price,
                ];
            }
        }

        return $best;
    }

    private function getPriceGroupId(): int
    {
        if ($this->priceGroupId !== null) {
            return $this->priceGroupId;
        }

        $this->priceGroupId = 0;

        if (!Loader::includeModule('catalog')) {
            return $this->priceGroupId;
        }

        $group = \CCatalogGroup::GetList(
            [],
            ['=NAME' => $this->priceCode],
            false,
            false,
            ['ID']
        )->Fetch();

        if ($group) {
            $this->priceGroupId = (int)$group['ID'];
        }

        return $this->priceGroupId;
    }

    /**
     * @param array<string, mixed> $element
     * @return array<int, array{CODE: string, NAME: string, COLOR: string}>
     */
    private function resolveLabels(array $element, string $labelCode): array
    {
        $propertyKey = 'PROPERTY_' . $labelCode . '_VALUE';
        if (empty($element[$propertyKey])) {
            return [];
        }

        $value = (string)($element[$propertyKey] ?? '');
        if ($value === '') {
            return [];
        }

        $name = $value;
        if (in_array($value, ['Y', 'y', '1'], true)) {
            $name = $labelCode === 'KHIT' ? 'Хит' : $labelCode;
        }

        $hint = (string)($element['PROPERTY_' . $labelCode . '_HINT'] ?? '');

        return [[
            'CODE' => $labelCode,
            'NAME' => $name,
            'COLOR' => $hint !== '' ? $hint : '#00b02a',
        ]];
    }
}
