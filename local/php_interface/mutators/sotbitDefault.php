<?
if (!defined('WIZARD_DEFAULT_SITE_ID')) {
    define('WIZARD_DEFAULT_SITE_ID', 's1');
}
if (!defined('WIZARD_SITE_ID')) {
    define('WIZARD_SITE_ID', 's1');
}

if (!class_exists('\Bitrix\Conversion\Internals\MobileDetect')) {
    eval('
    namespace Bitrix\Conversion\Internals;
    class MobileDetect {
        public function isMobile() { return false; }
        public function isTablet() { return false; }
    }
    ');
}
