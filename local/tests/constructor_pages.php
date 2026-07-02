<?php
// Для Bitrix-проектов — подключаем окружение (или свои параметры подключения к БД)
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
global $DB;

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Страницы и блоки конструктора</title>
<style>
body { font-family: Arial, sans-serif; font-size: 14px; }
h2 { margin-top: 30px; color: #1d3557; }
table { border-collapse: collapse; margin-bottom: 20px; }
th, td { border: 1px solid #aaa; padding: 6px 10px; vertical-align: top; }
th { background: #e7ecef; }
pre { margin: 0; font-size: 13px; white-space: pre-wrap; word-break: break-all; }
</style></head><body>";

$sql = "
SELECT
    p.ID as page_id,
    p.TITLE as page_title,
    b.ID as block_id,
    b.CODE as block_code,
    b.SORT as block_sort,
    b.CONTENT as block_content
FROM b_landing_page p
LEFT JOIN b_landing_block b ON b.LID = p.ID AND b.DELETED='N'
WHERE p.DELETED='N'
ORDER BY p.ID, b.SORT
";

$res = $DB->Query($sql);

$currentPageId = null;
while ($row = $res->Fetch()) {
    // Новый раздел для новой страницы
    if ($row['page_id'] !== $currentPageId) {
        if ($currentPageId !== null) {
            echo "</tbody></table>";
        }
        $currentPageId = $row['page_id'];
        echo "<h2>Страница: [{$row['page_id']}] " . htmlspecialchars($row['page_title']) . "</h2>";
        echo "<table><thead>
        <tr>
            <th>ID блока</th>
            <th>Код блока</th>
            <th>Сортировка</th>
            <th>Параметры блока (CONTENT)</th>
        </tr>
        </thead><tbody>";
    }
    if ($row['block_id']) {
        // Блоки могут быть пустыми (например, если их удалили)
        $json = json_decode($row['block_content'], true);
        $pretty = $json ? json_encode($json, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : $row['block_content'];
        echo "<tr>";
        echo "<td>{$row['block_id']}</td>";
        echo "<td>" . htmlspecialchars($row['block_code']) . "</td>";
        echo "<td>{$row['block_sort']}</td>";
        echo "<td><pre>" . htmlspecialchars($pretty) . "</pre></td>";
        echo "</tr>";
    }
}
// Закрываем последнюю таблицу
if ($currentPageId !== null) {
    echo "</tbody></table>";
}
echo "</body></html>";
?>
