<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тест");
?>

<!-- Подключение Bootstrap Icons (если ещё не подключены) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="mt-4 mb-4 pt-4">
  <div class="container">
    <h2 class="b-title mb-3">Контакты</h2>

    <div class="map-wrapper">
      <div id="map"></div>
    </div>

    <div class="contact-box">
      <div class="row">
        <div class="col-md-3 text-center mb-3 mb-md-0">
          <div>
            <i class="bi bi-geo-alt icon-large"></i>
            <div class="b-text fw-bold mt-2"><b>Адрес:</b></div>
            <div class="b-text">Санкт-Петербург<br>ул. 9-я Советская, д. 4–6, Литер А, офис 412</div>
          </div>
        </div>

        <div class="col-md-3 text-center mb-3 mb-md-0">
          <div>
            <i class="bi bi-telephone icon-large"></i>
            <div class="b-text fw-bold mt-2"><b>Телефоны:</b></div>
            <div class="b-text">
              <a href="tel:88004444846">8 (800) 444-48-46</a><br>
              <a href="tel:89117385438">8 (911) 738-54-38</a>
            </div>
          </div>
        </div>

        <div class="col-md-3 text-center mb-3 mb-md-0">
          <div>
            <i class="bi bi-envelope icon-large"></i>
            <div class="b-text fw-bold mt-2"><b>E-mail:</b></div>
            <div class="b-text">
              <a href="mailto:sales@sportgroupstore.ru">sales@sportgroupstore.ru</a><br>
              <a href="mailto:sportgroup777@gmail.com">sportgroup777@gmail.com</a>
            </div>
          </div>
        </div>

        <div class="col-md-3 text-center">
          <div>
            <i class="bi bi-clock icon-large"></i>
            <div class="b-text fw-bold mt-2"><b>Режим работы:</b></div>
            <div class="b-text">Пн–Пт: с 10:00 до 18:00</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://api-maps.yandex.ru/2.1/?apikey=617eccdb-975c-43c7-8724-a2dc461b99ab&lang=ru_RU" type="text/javascript"></script>
  <script type="text/javascript">
    ymaps.ready(function () {
      var myMap = new ymaps.Map("map", {
        center: [59.938180, 30.373495],
        zoom: 17,
        controls: ['zoomControl', 'fullscreenControl']
      });

      var myPlacemark = new ymaps.Placemark([59.938180, 30.373495], {
        balloonContent: 'Санкт-Петербург, ул. 9-я Советская, д. 4–6, Литер А, офис 412'
      }, {
        preset: 'islands#redDotIcon'
      });

      myMap.geoObjects.add(myPlacemark);
    });
  </script>
</div>
<div class="container mt-5">
    <h3 class="mb-3">Форма обратной связи</h3>
    <?$APPLICATION->IncludeComponent(
	"bitrix:main.feedback", 
	"bootstrap_placeholder", 
	array(
		"EMAIL_TO" => "s.manushin@ergopromo.ru",
		"REQUIRED_FIELDS" => array(
			0 => "NAME",
			1 => "EMAIL",
			2 => "MESSAGE",
		),
		"EVENT_MESSAGE_ID" => array(
			0 => "7",
		),
		"OK_TEXT" => "Спасибо, ваше сообщение отправлено!",
		"COMPONENT_TEMPLATE" => "bootstrap_v4",
		"USE_CAPTCHA" => "Y"
	),
	false
);?>
</div>

<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>