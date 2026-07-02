<?php
/**
 * db_init.php
 * Этот файл выполняется при каждом подключении к БД в Битриксе
 * Можно устанавливать сессионные параметры MySQL, а также php.ini настройки.
 */

// 1) Увеличим время выполнения скрипта и память в PHP
ini_set('max_execution_time', '600');   // 600 секунд = 10 минут
ini_set('memory_limit', '512M');

// 2) Подключаемся к БД один раз
use Bitrix\Main\Application;

$connection = Application::getConnection();

// Устанавливаем параметры MySQL-сессии
$connection->queryExecute("SET SESSION max_allowed_packet = 134217728");   // 128 MB
$connection->queryExecute("SET SESSION wait_timeout = 600");
$connection->queryExecute("SET SESSION net_read_timeout = 600");
$connection->queryExecute("SET SESSION net_write_timeout = 600");
$connection->queryExecute("SET SESSION keep_files_on_create = 1");
$connection->queryExecute("SET SESSION innodb_flush_log_at_trx_commit = 2");
$connection->queryExecute("SET SESSION innodb_lock_wait_timeout = 120");

// 3) Переопределяем WizardServices для установки (чтобы не рвалось по GetCurrentSiteID)
use Bitrix\Main\Loader;

// Обработчик, который вызовется в самом начале (OnBeforeProlog)
AddEventHandler('main', 'OnBeforeProlog', function() {
    if (class_exists('WizardServices')) {
        // Создаём класс-потомок, чтобы переопределить метод GetCurrentSiteID()
        if (!class_exists('\MyCustomWizardServices')) {
            class MyCustomWizardServices extends \WizardServices
            {
                public static function GetCurrentSiteID($siteId = null)
                {
                    // Принудительно возвращаем 's1', чтобы не лазить в базу
                    return 's1';
                }
            }
        }

        // Меняем в рантайме, чтобы все вызовы шли через наш класс
        class_alias('\MyCustomWizardServices', 'WizardServices');
    }
});
