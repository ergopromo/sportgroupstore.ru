<?php
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__) . "/../..");
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
use Bitrix\Iblock\SectionTable;

if (!Loader::includeModule('iblock')) {
    die("Модуль инфоблоков не подключен.\n");
}

$iblockId = 36;
$counter = 0;

$sections = \Bitrix\Iblock\SectionTable::getList([
    'filter' => ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'],
    'select' => ['ID'],
])->fetchAll();

foreach ($sections as $section) {
    $sectionId = $section['ID'];

    $res = CIBlockElement::GetList(
        [],
        [
            'IBLOCK_ID' => $iblockId,
            'SECTION_ID' => $sectionId,
            'ACTIVE' => 'Y',
            'INCLUDE_SUBSECTIONS' => 'Y'
        ],
        false,
        ['nTopCount' => 1],
        ['ID']
    );

    if ($res->SelectedRowsCount() == 0) {
        $bs = new CIBlockSection;
        $bs->Update($sectionId, ['ACTIVE' => 'N']);
        echo "Раздел ID=$sectionId деактивирован (пустой)\n";
        $counter++;
    }
}

echo "Готово. Всего отключено: $counter разделов\n";