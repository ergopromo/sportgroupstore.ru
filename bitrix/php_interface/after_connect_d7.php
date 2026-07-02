<?
$connection = Bitrix\Main\Application::getConnection();
$this->queryExecute('SET NAMES "utf8mb3"');
$this->queryExecute('SET collation_connection = "utf8mb3_unicode_ci"');
$this->queryExecute("SET sql_mode=''");
//$this->queryExecute("SET innodb_strict_mode='OFF'");
?>