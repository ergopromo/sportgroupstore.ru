<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

/**
 * @var string $componentPath
 * @var string $componentName
 * @var array $arCurrentValues
 * @var array $arTemplateParameters
 */

Loader::includeModule('iblock');
$rsIBlock = CIBlock::GetList(
    ['SORT' => 'ASC'],
    ["ACTIVE" => "Y"]
);
while ($arr = $rsIBlock->Fetch()) {
    $id = (int)$arr['ID'];
    if (isset($offersIblock[$id])) {
        continue;
    }

    $arIBlock[$id] = '[' . $id . '] ' . $arr['NAME'];
}

$arTemplateParameters['IBLOCK_ID'] = [
    'NAME' => GetMessage('SOTBIT_ORIGAMU_LEFT_MENU_IBLOCK_ID'),
    'TYPE' => 'LIST',
    'MULTIPLE' => 'N',
    'VALUES' => $arIBlock
];

?>