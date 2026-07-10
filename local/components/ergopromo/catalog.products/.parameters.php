<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentParameters = [
    'GROUPS' => [],
    'PARAMETERS' => [
        'IBLOCK_TYPE' => [
            'PARENT' => 'BASE',
            'NAME' => 'Тип инфоблока',
            'TYPE' => 'STRING',
            'DEFAULT' => 'sotbit_origami_catalog',
        ],
        'IBLOCK_ID' => [
            'PARENT' => 'BASE',
            'NAME' => 'Инфоблок',
            'TYPE' => 'STRING',
            'DEFAULT' => '36',
        ],
        'LABEL_PROPERTY' => [
            'PARENT' => 'BASE',
            'NAME' => 'Свойство-метка',
            'TYPE' => 'STRING',
            'DEFAULT' => 'KHIT',
        ],
        'ELEMENT_COUNT' => [
            'PARENT' => 'BASE',
            'NAME' => 'Количество товаров',
            'TYPE' => 'STRING',
            'DEFAULT' => '8',
        ],
        'SORT_FIELD' => [
            'PARENT' => 'BASE',
            'NAME' => 'Поле сортировки',
            'TYPE' => 'STRING',
            'DEFAULT' => 'sort',
        ],
        'SORT_ORDER' => [
            'PARENT' => 'BASE',
            'NAME' => 'Направление сортировки',
            'TYPE' => 'LIST',
            'VALUES' => [
                'ASC' => 'По возрастанию',
                'DESC' => 'По убыванию',
            ],
            'DEFAULT' => 'ASC',
        ],
        'PRICE_CODE' => [
            'PARENT' => 'BASE',
            'NAME' => 'Тип цены',
            'TYPE' => 'STRING',
            'DEFAULT' => 'BASE',
        ],
        'TITLE' => [
            'PARENT' => 'BASE',
            'NAME' => 'Заголовок блока',
            'TYPE' => 'STRING',
            'DEFAULT' => 'Популярные товары',
        ],
        'CATALOG_URL' => [
            'PARENT' => 'BASE',
            'NAME' => 'Ссылка на каталог',
            'TYPE' => 'STRING',
            'DEFAULT' => '/catalog/',
        ],
        'CATALOG_LINK_TEXT' => [
            'PARENT' => 'BASE',
            'NAME' => 'Текст ссылки на каталог',
            'TYPE' => 'STRING',
            'DEFAULT' => 'Перейти в каталог',
        ],
        'PICTURE_WIDTH' => [
            'PARENT' => 'BASE',
            'NAME' => 'Ширина превью',
            'TYPE' => 'STRING',
            'DEFAULT' => '826',
        ],
        'PICTURE_HEIGHT' => [
            'PARENT' => 'BASE',
            'NAME' => 'Высота превью',
            'TYPE' => 'STRING',
            'DEFAULT' => '560',
        ],
        'CACHE_TIME' => [
            'DEFAULT' => 36000000,
        ],
    ],
];
