<?
/*
•	Назначение: Кастомный тип свойства "Состав (детальный)" с поддержкой собственного списка нутриентов в настройках свойства, полноценная работа одиночного/множественного режима, без задваивания интерфейса и с гарантированным отображением выпадающего списка. Всё хранится в JSON.
•	
•	История изменений:
•	v7.2 – Исправлен парсинг списка нутриентов, устранено задваивание интерфейса (уникальные имена полей), выпадающий список работает корректно. (2025-07-29)
*/

class CIBlockPropertyNutritionalInfo
{
    public static function GetUserTypeDescription()
    {
        return [
            'PROPERTY_TYPE'        => 'S',
            'USER_TYPE'            => 'NutritionalInfo',
            'DESCRIPTION'          => 'Состав (детальный)',
            'GetPropertyFieldHtml' => [__CLASS__, 'GetPropertyFieldHtml'],
            'ConvertToDB'          => [__CLASS__, 'ConvertToDB'],
            'ConvertFromDB'        => [__CLASS__, 'ConvertFromDB'],
            'GetSettingsHTML'      => [__CLASS__, 'GetSettingsHTML'],
            'PrepareSettings'      => [__CLASS__, 'PrepareSettings'],
        ];
    }

    public static function PrepareSettings($arProperty)
    {
        $result = [];
        if (isset($arProperty['USER_TYPE_SETTINGS']['NUTRIENTS'])) {
            $nutrients = $arProperty['USER_TYPE_SETTINGS']['NUTRIENTS'];
            if (is_array($nutrients)) {
                $result['NUTRIENTS'] = array_values(array_filter(array_map('trim', $nutrients), 'strlen'));
            } elseif (is_string($nutrients)) {
                $tmp = @unserialize($nutrients);
                $result['NUTRIENTS'] = is_array($tmp) ? array_values(array_filter(array_map('trim', $tmp), 'strlen')) : [];
            } else {
                $result['NUTRIENTS'] = [];
            }
        } else {
            $result['NUTRIENTS'] = [];
        }
        return $result;
    }

    public static function GetSettingsHTML($arProperty, $strHTMLControlName, &$arPropertyFields)
    {
        $arPropertyFields = [
            "HIDE" => ["ROW_COUNT", "COL_COUNT", "DEFAULT_VALUE", "SMART_FILTER", "WITH_DESCRIPTION", "FILTRABLE", "MULTIPLE_CNT", "IS_REQUIRED"],
        ];
        $list = [];
        if (!empty($arProperty['USER_TYPE_SETTINGS']['NUTRIENTS'])) {
            $list = $arProperty['USER_TYPE_SETTINGS']['NUTRIENTS'];
            if (is_string($list)) $list = @unserialize($list);
            if (!is_array($list)) $list = [];
        }
        ob_start();
        ?>
        <tr>
            <td colspan="2">
                <b>Список нутриентов:</b>
                <table id="nutrient-enum-table" class="internal" style="min-width:400px;">
                    <thead>
                    <tr><td>Нутриент</td><td></td></tr>
                    </thead>
                    <tbody>
                    <? if ($list): foreach ($list as $i => $v): ?>
                        <tr>
                            <td>
                                <input type="text" name="<?= $strHTMLControlName["NAME"] ?>[NUTRIENTS][<?= $i ?>]" value="<?= htmlspecialcharsbx($v) ?>" style="width:90%">
                            </td>
                            <td>
                                <a href="#" onclick="this.closest('tr').remove();return false;">&times;</a>
                            </td>
                        </tr>
                    <? endforeach; endif ?>
                    </tbody>
                </table>
                <div style="margin-top:7px;">
                    <input type="button" value="+ Добавить нутриент" onclick="addNutrientRowEnum()">
                </div>
            </td>
        </tr>
        <script>
            function addNutrientRowEnum() {
                var tbl = document.getElementById('nutrient-enum-table').getElementsByTagName('tbody')[0];
                var i = tbl.rows.length;
                var tr = tbl.insertRow();
                var td1 = tr.insertCell(0);
                var td2 = tr.insertCell(1);
                td1.innerHTML = '<input type="text" name="<?= $strHTMLControlName["NAME"] ?>[NUTRIENTS]['+i+']" value="" style="width:90%">';
                td2.innerHTML = '<a href="#" onclick="this.closest(\'tr\').remove();return false;">&times;</a>';
            }
        </script>
        <?
        return ob_get_clean();
    }

    public static function GetPropertyFieldHtml($arProperty, $value, $strHTMLControlName)
    {
        $nutrients = [];
        if (!empty($arProperty['USER_TYPE_SETTINGS']['NUTRIENTS'])) {
            $nutrients = $arProperty['USER_TYPE_SETTINGS']['NUTRIENTS'];
            if (is_string($nutrients)) $nutrients = @unserialize($nutrients);
            if (!is_array($nutrients)) $nutrients = [];
            $nutrients = array_values(array_filter(array_map('trim', $nutrients), 'strlen'));
        }

        $multiple = ($arProperty['MULTIPLE'] == 'Y');
        $values = [];

        if (isset($value['VALUE']) && $value['VALUE']) {
            $decoded = json_decode($value['VALUE'], true);
            if ($multiple && is_array($decoded)) {
                $values = $decoded;
            } elseif (is_array($decoded)) {
                $values[] = $decoded;
            }
        }

        if (!$multiple && count($values) === 0) {
            $values[] = ['NUTRIENT' => '', 'VALUE' => ''];
        }

        $prop_id = (int)$arProperty['ID'];
        $prefix = 'B_NUTRINFO_'.$prop_id; // уникальный префикс, чтобы не пересекаться со стандартным Bitrix

        ob_start();
        ?>
        <style>
            /* Скрытие дублирующихся стандартных полей для usertype */
            #tr_PROPERTY_<?= $prop_id ?> .adm-input, #tr_PROPERTY_<?= $prop_id ?> textarea, #tr_PROPERTY_<?= $prop_id ?> select { display:none !important; }
        </style>
        <table class="internal" id="nutritional-info-table-<?= $prop_id ?>">
            <thead>
            <tr class="heading">
                <td>Нутриент</td>
                <td>Значение</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            <? foreach ($values as $key => $item): ?>
                <tr data-row-index="<?= $key ?>">
                    <td>
                        <? if ($multiple): ?>
                            <select name="<?= $prefix ?>[NUTRIENT][<?= $key ?>]" style="width:160px;">
                        <? else: ?>
                            <select name="<?= $prefix ?>[NUTRIENT]" style="width:160px;">
                        <? endif; ?>
                            <option value="">-- не выбран --</option>
                            <? foreach ($nutrients as $nut): ?>
                                <option value="<?= htmlspecialcharsbx($nut) ?>"<?= ($item['NUTRIENT'] == $nut ? ' selected' : '') ?>><?= htmlspecialcharsbx($nut) ?></option>
                            <? endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <? if ($multiple): ?>
                            <input type="text" name="<?= $prefix ?>[VALUE][<?= $key ?>]" value="<?= htmlspecialcharsbx($item['VALUE']) ?>" style="width:160px;">
                        <? else: ?>
                            <input type="text" name="<?= $prefix ?>[VALUE]" value="<?= htmlspecialcharsbx($item['VALUE']) ?>" style="width:160px;">
                        <? endif; ?>
                    </td>
                    <td style="text-align:center;">
                        <? if ($multiple): ?>
                        <a href="#" onclick="window.deleteNutrientRow_<?= $prop_id ?>(this);return false;">&times;</a>
                        <? endif; ?>
                    </td>
                </tr>
            <? endforeach; ?>
            </tbody>
        </table>
        <? if ($multiple): ?>
        <div style="margin-top:10px;">
            <input type="button" value="+ Добавить нутриент" onclick="window.addNutrientRow_<?= $prop_id ?>()">
        </div>
        <script>
            if (typeof window.addNutrientRow_<?= $prop_id ?> !== 'function') {
                let nutrientRowIndex_<?= $prop_id ?> = <?= count($values) ?>;
                let selectHtml_<?= $prop_id ?> = <?= json_encode('<select name="' . $prefix . '[NUTRIENT][__INDEX__]" style="width:160px;"><option value="">-- не выбран --</option>' . implode('', array_map(function($v){ return '<option value="' . htmlspecialcharsbx($v) . '">' . htmlspecialcharsbx($v) . '</option>'; }, $nutrients)) . '</select>') ?>;
                window.addNutrientRow_<?= $prop_id ?> = function() {
                    let table = document.getElementById('nutritional-info-table-<?= $prop_id ?>').getElementsByTagName('tbody')[0];
                    let newIndex = nutrientRowIndex_<?= $prop_id ?>;
                    let row = table.insertRow();
                    row.setAttribute('data-row-index', newIndex);

                    let cell1 = row.insertCell(0);
                    cell1.innerHTML = selectHtml_<?= $prop_id ?>.replace(/__INDEX__/g, newIndex);

                    let cell2 = row.insertCell(1);
                    cell2.innerHTML = '<input type="text" name="<?= $prefix ?>[VALUE]['+newIndex+']" value="" style="width:160px;">';

                    let cell3 = row.insertCell(2);
                    cell3.style.textAlign = 'center';
                    cell3.innerHTML = '<a href="#" onclick="window.deleteNutrientRow_<?= $prop_id ?>(this);return false;">&times;</a>';

                    nutrientRowIndex_<?= $prop_id ?>++;
                };
                window.deleteNutrientRow_<?= $prop_id ?> = function(link) {
                    let row = link.closest('tr');
                    row.parentNode.removeChild(row);
                };
            }
        </script>
        <? endif; ?>
        <?
        return ob_get_clean();
    }

    public static function ConvertToDB($arProperty, $value)
    {
        // Получаем наши уникальные имена полей
        $prop_id = (int)$arProperty['ID'];
        $prefix = 'B_NUTRINFO_'.$prop_id;
        $input = $_REQUEST[$prefix] ?? [];

        $multiple = ($arProperty['MULTIPLE'] == 'Y');
        $filtered = [];

        if ($multiple) {
            if (!empty($input['NUTRIENT']) && is_array($input['NUTRIENT'])) {
                foreach ($input['NUTRIENT'] as $key => $nut) {
                    $val = isset($input['VALUE'][$key]) ? trim($input['VALUE'][$key]) : '';
                    if ($nut !== '' && $val !== '') {
                        $filtered[] = ['NUTRIENT' => $nut, 'VALUE' => $val];
                    }
                }
            }
        } else {
            $nut = isset($input['NUTRIENT']) ? $input['NUTRIENT'] : '';
            $val = isset($input['VALUE']) ? trim($input['VALUE']) : '';
            if ($nut !== '' && $val !== '') {
                $filtered = ['NUTRIENT' => $nut, 'VALUE' => $val];
            }
        }

        $result = ['VALUE' => '', 'DESCRIPTION' => ''];
        if ($filtered) {
            $result['VALUE'] = json_encode($filtered, JSON_UNESCAPED_UNICODE);
        }
        return $result;
    }

    public static function ConvertFromDB($arProperty, $value)
    {
        return $value;
    }
}

// SI: Регистрация обработчика типа
AddEventHandler(
    'iblock',
    'OnIBlockPropertyBuildList',
    ['CIBlockPropertyNutritionalInfo', 'GetUserTypeDescription']
);
