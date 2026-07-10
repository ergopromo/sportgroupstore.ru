<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentParameters = [
    'GROUPS' => [],
    'PARAMETERS' => [
        'ITEM' => [
            'PARENT' => 'BASE',
            'NAME' => 'Данные товара',
            'TYPE' => 'STRING',
            'DEFAULT' => '',
        ],
        'SHOW_LABELS' => [
            'PARENT' => 'BASE',
            'NAME' => 'Показывать метки',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'SHOW_OLD_PRICE' => [
            'PARENT' => 'BASE',
            'NAME' => 'Показывать старую цену',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'BUTTON_TEXT' => [
            'PARENT' => 'BASE',
            'NAME' => 'Текст кнопки',
            'TYPE' => 'STRING',
            'DEFAULT' => 'В корзину',
        ],
        'BUTTON_TEXT_OFFERS' => [
            'PARENT' => 'BASE',
            'NAME' => 'Текст кнопки для SKU',
            'TYPE' => 'STRING',
            'DEFAULT' => 'Подробнее',
        ],
        'BASKET_URL' => [
            'PARENT' => 'BASE',
            'NAME' => 'URL корзины',
            'TYPE' => 'STRING',
            'DEFAULT' => '/personal/cart/',
        ],
    ],
];
