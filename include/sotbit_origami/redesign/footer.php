<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Sotbit\Origami\Helper\Config;

$siteDir = SITE_DIR;
$year = date('Y');

$catalogLinks = [
    ['label' => 'Протеины', 'href' => $siteDir . 'catalog/sportivnoe-pitanie/proteins/'],
    ['label' => 'Гейнеры', 'href' => $siteDir . 'catalog/sportivnoe-pitanie/geiner/'],
    ['label' => 'Предтреники', 'href' => $siteDir . 'catalog/sportivnye-dobavki/predtrenirovochnyy-kompleks/'],
    ['label' => 'Аминокислоты', 'href' => $siteDir . 'catalog/sportivnye-dobavki/aminokislotnyy-kompleks/'],
    ['label' => 'Изотоники', 'href' => $siteDir . 'catalog/sportivnoe-pitanie/'],
    ['label' => 'Добавки', 'href' => $siteDir . 'catalog/sportivnye-dobavki/'],
    ['label' => 'Витамины', 'href' => $siteDir . 'catalog/sportivnye-dobavki/'],
    ['label' => 'Аксессуары', 'href' => $siteDir . 'catalog/turisticheskaya-posuda/'],
];

$infoLinks = [
    ['label' => 'О компании', 'href' => $siteDir . 'about/'],
    ['label' => 'Акции', 'href' => $siteDir . 'promotions/'],
    ['label' => 'Новости', 'href' => $siteDir . 'news/'],
    ['label' => 'Блог', 'href' => $siteDir . 'blog/'],
    ['label' => 'Энциклопедия', 'href' => $siteDir . 'about/'],
];

$docLinks = [
    ['label' => 'Публичная оферта', 'href' => $siteDir . 'help/oferta/'],
    ['label' => 'Политика конфиденциальности', 'href' => $siteDir . 'help/confidentiality/'],
    ['label' => 'Правила продажи', 'href' => $siteDir . 'help/rules/'],
    ['label' => 'Условия доставки', 'href' => $siteDir . 'about/delivery/'],
    ['label' => 'Условия оплаты', 'href' => $siteDir . 'help/payment/'],
];

$vkLink = Config::get('VK');
$tgLink = Config::get('TELEGA');
?>
<footer class="sg-footer">
    <div class="sg-footer__inner">
        <div class="sg-footer__columns">
            <div class="sg-footer__brand">
                <a href="<?= $siteDir ?>" class="sg-footer__logo-link" aria-label="СПОРТГРУПП">
                    <img
                        class="sg-footer__logo"
                        src="<?= $siteDir ?>include/sotbit_origami/images/Logo.svg"
                        alt="СПОРТГРУПП"
                        width="100"
                        height="95"
                        loading="lazy"
                    >
                </a>
                <p class="sg-footer__tagline">
                    Спортивное питание<br>
                    с проверенными составами<br>
                    и честными описаниями.
                </p>
                <?php if ($vkLink || $tgLink): ?>
                    <div class="sg-footer__socials">
                        <?php if ($vkLink): ?>
                            <a
                                class="sg-footer__social-link"
                                href="<?= htmlspecialcharsbx($vkLink) ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="ВКонтакте"
                            >
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                    <path fill="currentColor" d="M10.77 15.5c-5.09 0-7.97-3.5-8.08-9.33h2.56c.08 4.29 1.97 6.11 3.44 6.48V6.17h2.41v3.7c1.47-.16 3.02-1.83 3.54-3.7h2.41c-.39 2.28-2.02 3.95-3.18 4.64 1.16.54 3.02 2.16 3.73 4.29h-2.66c-.56-1.74-2.06-3.08-4.17-3.2v3.2Z"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                        <?php if ($tgLink): ?>
                            <a
                                class="sg-footer__social-link"
                                href="<?= htmlspecialcharsbx($tgLink) ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Telegram"
                            >
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                    <path fill="currentColor" d="M16.5 4.2 3.7 9.2c-.95.37-.93 1.67.03 2.01l3.2 1.05 1.23 3.9c.28.88 1.44 1.08 2 .35l1.8-2.2 3.74 2.76c.72.53 1.75.13 1.93-.72L17.6 5.3c.2-.95-.72-1.7-1.6-1.1Z"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="sg-footer__col">
                <p class="sg-footer__title">Каталог</p>
                <ul class="sg-footer__links">
                    <?php foreach ($catalogLinks as $item): ?>
                        <li><a href="<?= htmlspecialcharsbx($item['href']) ?>"><?= htmlspecialcharsbx($item['label']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="sg-footer__col">
                <p class="sg-footer__title">Информация</p>
                <ul class="sg-footer__links">
                    <?php foreach ($infoLinks as $item): ?>
                        <li><a href="<?= htmlspecialcharsbx($item['href']) ?>"><?= htmlspecialcharsbx($item['label']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="sg-footer__col">
                <p class="sg-footer__title">Документы</p>
                <ul class="sg-footer__links">
                    <?php foreach ($docLinks as $item): ?>
                        <li><a href="<?= htmlspecialcharsbx($item['href']) ?>"><?= htmlspecialcharsbx($item['label']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="sg-footer__col sg-footer__col--contacts">
                <p class="sg-footer__title">Контакты</p>
                <div class="sg-footer__contacts">
                    <a class="sg-footer__phone" href="tel:+79117385438">+7 911 738-54-38</a>
                    <a href="mailto:sales@sportgroupstore.ru">sales@sportgroupstore.ru</a>
                    <a href="mailto:sportgroup777@gmail.com">sportgroup777@gmail.com</a>
                    <span>Пн–Пт 10:00–18:00</span>
                    <span class="sg-footer__address">Санкт-Петербург, 9-я Советская ул., д. 4–6, Лит. А, офис № 412</span>
                </div>
            </div>
        </div>

        <div class="sg-footer__divider" aria-hidden="true"></div>

        <div class="sg-footer__bar">
            <p class="sg-footer__copy">© <?= $year ?> OOO «СПОРТГРУПП». Все права защищены.</p>
            <div class="sg-footer__payments" aria-label="Способы оплаты">
                <span>Visa</span>
                <span>Mastercard</span>
                <span>МИР</span>
            </div>
        </div>
    </div>
</footer>
