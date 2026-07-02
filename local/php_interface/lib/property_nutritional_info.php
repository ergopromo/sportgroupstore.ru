<?
/**
 * Назначение:
 * Класс для кастомного типа свойства "Состав (детальный)", созданный по образцу рабочего модуля.
 * Обеспечивает хранение и редактирование пар "нутриент-значение" с привязкой к Highload-блоку.
 *
 * История изменений:
 * v9.0 - Полная переработка кода в соответствии с архитектурой PROPERTY_TYPE. (2025-07-29)
 * v8.0 - Финальная версия. Использование подхода PROPERTY_TYPE. (2025-07-29)
 */
class CIBlockPropertyNutritionalInfo
{
    /**
     * Возвращает описание типа свойства для системы.
     */
    public static function GetUserTypeDescription()
    {
        return [
            'PROPERTY_TYPE'        => 'S', // Базовый тип хранения - Строка
            'USER_TYPE'            => 'NutritionalInfo', // Уникальный ID нашего типа
            'DESCRIPTION'          => 'Состав (детальный)',
            'GetPropertyFieldHtml' => [__CLASS__, 'GetPropertyFieldHtml'],
            'ConvertToDB'          => [__CLASS__, 'ConvertToDB'],
            'ConvertFromDB'        => [__CLASS__, 'ConvertFromDB'],
            'GetSettingsHTML'      => [__CLASS__, 'GetSettingsHTML'],
            'PrepareSettings'      => [__CLASS__, 'PrepareSettings'],
        ];
    }

    /**
     * Готовит настройки свойства.
     */
    public static function PrepareSettings($arProperty)
    {
        $hlblock_id = 0;
        if (isset($arProperty['USER_TYPE_SETTINGS']['HLBLOCK_ID'])) {
            $hlblock_id = (int)$arProperty['USER_TYPE_SETTINGS']['HLBLOCK_ID'];
        }
        return ['HLBLOCK_ID' => $hlblock_id];
    }

    /**
     * HTML для настроек свойства (выбор HL-блока).
     */
    public static function GetSettingsHTML($arProperty, $strHTMLControlName, &$arPropertyFields)
    {
        $arPropertyFields = [
            "HIDE" => ["ROW_COUNT", "COL_COUNT", "DEFAULT_VALUE", "SMART_FILTER", "WITH_DESCRIPTION", "FILTRABLE", "MULTIPLE_CNT", "IS_REQUIRED"],
        ];
        
        if (!CModule::IncludeModule('highloadblock')) {
            return '<tr><td colspan="2" style="color: red;">Модуль highloadblock не установлен.</td></tr>';
        }

        $hlblock_id = 0;
        if (isset($arProperty['USER_TYPE_SETTINGS']['HLBLOCK_ID'])) {
            $hlblock_id = (int)$arProperty['USER_TYPE_SETTINGS']['HLBLOCK_ID'];
        }

        $result = '<tr>
            <td>Highload-блок для привязки:</td>
            <td><select name="' . $strHTMLControlName['NAME'] . '[HLBLOCK_ID]">';
        
        $rsBlocks = Bitrix\Highloadblock\HighloadBlockTable::getList(['order' => ['NAME']]);
        while ($arBlock = $rsBlocks->fetch()) {
            $selected = ($arBlock['ID'] == $hlblock_id) ? ' selected' : '';
            $result .= '<option value="' . $arBlock['ID'] . '"' . $selected . '>[' . $arBlock['ID'] . '] ' . htmlspecialcharsbx($arBlock['NAME']) . '</option>';
        }
        $result .= '</select></td></tr>';
        return $result;
    }

    /**
     * HTML для поля редактирования в карточке элемента.
     */
    public static function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        if (!CModule::IncludeModule('highloadblock')) {
            return 'Модуль highloadblock не установлен.';
        }

        $values = [];
        if (isset($value['VALUE']) && $value['VALUE']) {
            $decoded = json_decode($value['VALUE'], true);
            if (is_array($decoded)) {
                $values = $decoded;
            }
        }

        $hlblock_id = (int)$arProperty['USER_TYPE_SETTINGS']['HLBLOCK_ID'];
        if (!$hlblock_id) {
            return '<b>Ошибка:</b> в настройках свойства не указан ID Highload-блока.';
        }

        $nutrientNames = [];
        if (!empty($values)) {
            $ids = array_column($values, 'ID');
            if (!empty($ids)) {
                $hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById($hlblock_id)->fetch();
                $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
                $entity_data_class = $entity->getDataClass();
                $rsData = $entity_data_class::getList(['select' => ['ID', 'UF_NAME'], 'filter' => ['ID' => $ids]]);
                while ($arData = $rsData->fetch()) {
                    $nutrientNames[$arData['ID']] = $arData['UF_NAME'];
                }
            }
        }

        ob_start();
        ?>
        <div id="nutritional-info-wrapper-<?= $arProperty['ID'] ?>">
            <table class="internal" id="nutritional-info-table-<?= $arProperty['ID'] ?>" style="width: 100%;">
                <thead>
                <tr class="heading">
                    <td style="width: 45%;">Нутриент</td>
                    <td style="width: 45%;">Количество (с ед. изм.)</td>
                    <td style="width: 10%;"></td>
                </tr>
                </thead>
                <tbody>
                <? foreach ($values as $key => $val): ?>
                    <tr data-row-index="<?= $key ?>">
                        <td>
                            <input type="text" name="<?= htmlspecialcharsbx($strHTMLControlName['VALUE']) ?>[NAME][<?= $key ?>]" value="<?= htmlspecialcharsbx($nutrientNames[$val['ID']] ?? 'Элемент не найден') ?>" readonly="readonly" style="width: 90%;">
                            <input type="hidden" name="<?= htmlspecialcharsbx($strHTMLControlName['VALUE']) ?>[ID][<?= $key ?>]" value="<?= (int)$val['ID'] ?>">
                            <input type="button" value="..." onclick="openNutrientSelector_<?= $arProperty['ID'] ?>_<?= $key ?>(this)">
                        </td>
                        <td>
                            <input type="text" name="<?= htmlspecialcharsbx($strHTMLControlName['VALUE']) ?>[VALUE][<?= $key ?>]" value="<?= htmlspecialcharsbx($val['VALUE']) ?>" style="width: 100%;">
                        </td>
                        <td style="text-align: center;">
                            <a href="#" onclick="deleteNutrientRow(this); return false;" style="color: red; text-decoration: none;">&times;</a>
                        </td>
                    </tr>
                <? endforeach; ?>
                </tbody>
            </table>
            <div style="text-align: center; margin-top: 10px;">
                <input type="button" value="Добавить нутриент" onclick="addNutrientRow_<?= $arProperty['ID'] ?>()">
            </div>
        </div>
        <script>
            let nutrientRowIndex_<?= $arProperty['ID'] ?> = <?= count($values) ?>;
            function addNutrientRow_<?= $arProperty['ID'] ?>() {
                let table = document.getElementById('nutritional-info-table-<?= $arProperty['ID'] ?>').getElementsByTagName('tbody')[0];
                let newRow = table.insertRow();
                let newIndex = nutrientRowIndex_<?= $arProperty['ID'] ?>;
                newRow.setAttribute('data-row-index', newIndex);
                let cell1 = newRow.insertCell(0);
                cell1.innerHTML = `
                    <input type="text" name="<?= htmlspecialcharsbx($strHTMLControlName['VALUE']) ?>[NAME][${newIndex}]" value="" readonly="readonly" style="width: 90%;">
                    <input type="hidden" name="<?= htmlspecialcharsbx($strHTMLControlName['VALUE']) ?>[ID][${newIndex}]" value="">
                    <input type="button" value="..." onclick="openNutrientSelector_<?= $arProperty['ID'] ?>_${newIndex}(this)">
                `;
                let cell2 = newRow.insertCell(1);
                cell2.innerHTML = `<input type="text" name="<?= htmlspecialcharsbx($strHTMLControlName['VALUE']) ?>[VALUE][${newIndex}]" value="" style="width: 100%;">`;
                let cell3 = newRow.insertCell(2);
                cell3.style.textAlign = 'center';
                cell3.innerHTML = `<a href="#" onclick="deleteNutrientRow(this); return false;" style="color: red; text-decoration: none;">&times;</a>`;
                
                window.openNutrientSelector_<?= $arProperty['ID'] ?>_ = function(button) {
                    let rowIndex = button.closest('tr').getAttribute('data-row-index');
                    let url = '/bitrix/admin/highloadblock_rows_list.php?ENTITY_ID=<?= $hlblock_id ?>&lang=ru&func_name=setNutrientValue_<?= $arProperty['ID'] ?>&elid=' + rowIndex;
                    jsUtils.OpenWindow(url, {width: 900, height: 600});
                }

                nutrientRowIndex_<?= $arProperty['ID'] ?>++;
            }
            
            <? foreach ($values as $key => $val): ?>
                window.openNutrientSelector_<?= $arProperty['ID'] ?>_<?= $key ?> = function(button) {
                    let rowIndex = button.closest('tr').getAttribute('data-row-index');
                    let url = '/bitrix/admin/highloadblock_rows_list.php?ENTITY_ID=<?= $hlblock_id ?>&lang=ru&func_name=setNutrientValue_<?= $arProperty['ID'] ?>&elid=' + rowIndex;
                    jsUtils.OpenWindow(url, {width: 900, height: 600});
                }
            <? endforeach; ?>

            function setNutrientValue_<?= $arProperty['ID'] ?>(elementId, elementName, rowIndex) {
                let row = document.querySelector('#nutritional-info-table-<?= $arProperty['ID'] ?> tr[data-row-index="' + rowIndex + '"]');
                if (row) {
                    row.querySelector('input[name*="[ID]"]').value = elementId;
                    row.querySelector('input[name*="[NAME]"]').value = elementName;
                }
            }

            function deleteNutrientRow(link) {
                let row = link.closest('tr');
                row.parentNode.removeChild(row);
            }
        </script>
        <?
        return ob_get_clean();
    }

    /**
     * Готовит значение для сохранения в БД.
     */
    public static function ConvertToDB($arProperty, $value)
    {
        $result = ['VALUE' => '', 'DESCRIPTION' => ''];
        if (is_array($value['VALUE']) && isset($value['VALUE']['ID'])) {
            $filteredValue = [];
            foreach ($value['VALUE']['ID'] as $key => $id) {
                if (!empty($id) && isset($value['VALUE']['VALUE'][$key]) && $value['VALUE']['VALUE'][$key] !== '') {
                    $filteredValue[] = [
                        'ID' => (int)$id,
                        'VALUE' => trim($value['VALUE']['VALUE'][$key])
                    ];
                }
            }
            if (!empty($filteredValue)) {
                $result['VALUE'] = json_encode($filteredValue);
            }
        }
        return $result;
    }

    /**
     * Готовит значение из БД для отображения.
     */
    public static function ConvertFromDB($arProperty, $value)
    {
        return $value;
    }
}
