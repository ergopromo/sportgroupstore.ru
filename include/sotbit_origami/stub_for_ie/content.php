<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;
use Bitrix\Main\Loader;

Asset::getInstance()->addCss("/include/sotbit_origami/stub_for_ie/style.css");
CJSCore::Init(array("jquery", "popup"));
?>
<div id="stub_popup_content" style="display: none">
    <p class="stub__title">
        <?=Loc::getMessage("STUB_TITLE")?>
    </p>
    <p class="stub__message">
        <?=Loc::getMessage("STUB_MESSAGE")?>
    </p>
    <div class="stub__list-browser">
        <a class="stub__browser-chrome" href="https://www.google.by/chrome/">Google Chrome</a>
        <a class="stub__browser-opera" href="https://www.opera.com/ru/computer/thanks?ni=stable&os=windows">Opera</a>
        <a class="stub__browser-firefox" href="https://yandex.ru/firefox/download?from=lp_s">Firefox</a>
        <a class="stub__browser-edge" href="https://www.microsoft.com/ru-ru/edge">Microsoft Edge</a>
    </div>
    <?if(Loader::includeModule('sotbit.b2bshop')):?>
        <div class="stub__to_b2b-wrapper">
            <a class="stub__to_b2b" href="/b2bcabinet"><?=Loc::getMessage('GO_TO_B2B')?></a>
        </div>
    <?endif;?>
    <span class="popup-window-close-icon popup-window-close-icon-pos"></span>
</div>
<div id="stub_popup_content_overlay" style="display: none"></div>
<script>
    function addEvent(evnt, elem, func){
        if (elem.addEventListener)  // W3C DOM
            elem.addEventListener(evnt,func);
        else if (elem.attachEvent) { // IE DOM
            elem.attachEvent("on"+evnt, func);
        }
        else { // No much to do
            elem["on"+evnt] = func;
        }
    }

    addEvent('DOMContentLoaded', document, function (){
        var plugIE = document.querySelector('#stub_popup_content');
        var plugOverlayIE = document.querySelector('#stub_popup_content_overlay');
        var closeBtnIE = document.querySelector('.popup-window-close-icon-pos');
        plugIE.style.display = 'block';
        plugOverlayIE.style.display = 'block';

        addEvent('click', plugOverlayIE, function (){
            plugIE.style.display = 'none';
            plugOverlayIE.style.display = 'none';
        })

        addEvent('click', closeBtnIE, function (){
            plugIE.style.display = 'none';
            plugOverlayIE.style.display = 'none';
        })

    });
</script>
<?

