<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Помощь");

LocalRedirect(SITE_DIR.'help/payment/');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
<?php
LocalRedirect("/help/usloviya_zakaza/", true, "301 Moved Permanently");
?>