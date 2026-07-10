<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Sotbit\Origami\Helper\Config;

global $APPLICATION;
?>
<footer class="sg-footer">
    <div class="sg-footer__inner">
        <div class="sg-footer__grid">
            <div class="sg-footer__col">
                <p class="sg-footer__title">Каталог</p>
                <?php $APPLICATION->IncludeComponent(
                    'bitrix:menu',
                    'sotbit_bottom_menu',
                    [
                        'ALLOW_MULTI_SELECT' => 'N',
                        'DELAY' => 'N',
                        'MAX_LEVEL' => '1',
                        'MENU_CACHE_TIME' => '36000000',
                        'MENU_CACHE_TYPE' => 'A',
                        'MENU_CACHE_USE_GROUPS' => 'Y',
                        'ROOT_MENU_TYPE' => 'sotbit_left',
                        'USE_EXT' => 'Y',
                        'COMPONENT_TEMPLATE' => 'sotbit_bottom_menu',
                        'CHILD_MENU_TYPE' => 'sotbit_left',
                        'MAX_ITEMS' => '7',
                    ],
                    false
                ); ?>
            </div>

            <div class="sg-footer__col">
                <p class="sg-footer__title">Информация</p>
                <?php $APPLICATION->IncludeComponent(
                    'bitrix:menu',
                    'sotbit_bottom_menu',
                    [
                        'ALLOW_MULTI_SELECT' => 'N',
                        'DELAY' => 'N',
                        'MAX_LEVEL' => '1',
                        'MENU_CACHE_TIME' => '36000000',
                        'MENU_CACHE_TYPE' => 'A',
                        'MENU_CACHE_USE_GROUPS' => 'Y',
                        'ROOT_MENU_TYPE' => 'sotbit_bottom1',
                        'USE_EXT' => 'N',
                        'COMPONENT_TEMPLATE' => 'sotbit_bottom_menu',
                        'CHILD_MENU_TYPE' => 'sotbit_left',
                    ],
                    false
                ); ?>
            </div>

            <div class="sg-footer__col">
                <p class="sg-footer__title">Доставка</p>
                <?php $APPLICATION->IncludeComponent(
                    'bitrix:menu',
                    'sotbit_bottom_menu',
                    [
                        'ALLOW_MULTI_SELECT' => 'N',
                        'DELAY' => 'N',
                        'MAX_LEVEL' => '1',
                        'MENU_CACHE_TIME' => '36000000',
                        'MENU_CACHE_TYPE' => 'A',
                        'MENU_CACHE_USE_GROUPS' => 'Y',
                        'ROOT_MENU_TYPE' => 'sotbit_bottom2',
                        'USE_EXT' => 'N',
                        'COMPONENT_TEMPLATE' => 'sotbit_bottom_menu',
                        'CHILD_MENU_TYPE' => 'sotbit_left',
                    ],
                    false
                ); ?>
            </div>

            <div class="sg-footer__col sg-footer__col--contacts">
                <p class="sg-footer__title">Контакты</p>
                <div class="sg-footer__contacts">
                    <?php $APPLICATION->IncludeComponent('bitrix:main.include', '', [
                        'AREA_FILE_SHOW' => 'file',
                        'PATH' => SITE_DIR . 'include/sotbit_origami/contacts_address.php',
                    ]); ?>
                    <?php $APPLICATION->IncludeComponent('bitrix:main.include', '', [
                        'AREA_FILE_SHOW' => 'file',
                        'PATH' => SITE_DIR . 'include/sotbit_origami/contacts_phone.php',
                    ]); ?>
                    <?php $APPLICATION->IncludeComponent('bitrix:main.include', '', [
                        'AREA_FILE_SHOW' => 'file',
                        'PATH' => SITE_DIR . 'include/sotbit_origami/contacts_email.php',
                    ]); ?>
                </div>
            </div>
        </div>

        <div class="sg-footer__bottom">
            <div class="sg-footer__social">
                <?php $APPLICATION->IncludeComponent(
                    'bitrix:eshop.socnet.links',
                    'sotbit_socnet_links',
                    [
                        'FACEBOOK' => Config::get('FB'),
                        'VKONTAKTE' => Config::get('VK'),
                        'TWITTER' => Config::get('TW'),
                        'INSTAGRAM' => Config::get('INST'),
                        'YOUTUBE' => Config::get('YOUTUBE'),
                        'TELEGRAM' => Config::get('TELEGA'),
                    ]
                ); ?>
            </div>
            <div class="sg-footer__copy">
                <?php $APPLICATION->IncludeComponent('bitrix:main.include', '', [
                    'AREA_FILE_SHOW' => 'file',
                    'PATH' => SITE_DIR . 'include/sotbit_origami/copyright.php',
                ]); ?>
            </div>
        </div>
    </div>
</footer>
