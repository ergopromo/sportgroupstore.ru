<?
/*
· Назначение: Инициализация проекта без вывода. Подключение модификаторов и системных настроек. Добавлена безопасная попытка исключить путь /bitrix/admin/1c_exchange.php из CSRF-проверки, без критических зависимостей от версии ядра.
·
· История изменений:
· v1.2 – Добавлена безопасная (через class_exists) настройка исключений CSRF для 1C-обмена; предотвращён фатал при отсутствии класса Configuration (2025-10-21)
· v1.1 – Подключены MutatorsManager и property_nutritional_info, оформлены use-импорты (2025-09-15)
· v1.0 – Исходная версия init.php с базовыми подключениями (2025-09-01) */

require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/mutators/property_nutritional_info.php");

use Local\PhpInterface\Mutators\MutatorsManager;
use Bitrix\Main\Page\Asset;

// Подключение MutatorsManager
require_once __DIR__ . '/mutators/mutatorsManager.php';

/** 
 * Профилактика CSRF для 1C-обмена (только если поддерживается текущим ядром).
 * Безопасная проверка наличия класса, чтобы исключить фатальные ошибки на старых версиях.
 */
if (class_exists('\Bitrix\Main\Security\Csrf\Configuration')) {
    /** @var \Bitrix\Main\Security\Csrf\Configuration $cfg */
    $cfg = \Bitrix\Main\Security\Csrf\Configuration::getInstance();
    $opts = $cfg->getOptions();
    // SI: Исключение только для /bitrix/admin/1c_exchange.php; глобальные настройки не изменяются.
    $exclude = isset($opts['exclude']) && is_array($opts['exclude']) ? $opts['exclude'] : [];
    if (!in_array('/bitrix/admin/1c_exchange.php', $exclude, true)) {
        $exclude[] = '/bitrix/admin/1c_exchange.php';
    }
    $cfg->setOptions([
        'enabled' => isset($opts['enabled']) ? (bool)$opts['enabled'] : true,
        'exclude' => $exclude,
    ]);
}

// Регистрируем все модификации
MutatorsManager::register();
