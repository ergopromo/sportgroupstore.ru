<?

use Bitrix\Main\Page\Asset;
use Bitrix\Main\Localization\Loc;
use Sotbit\Origami\Helper\Config;
use Bitrix\Main\Loader;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$APPLICATION->ShowAjaxHead();
Asset::getInstance()->addJs(SITE_DIR . "local/templates/.default/components/bitrix/form.result.new/origami_wantgift/script.js");
Asset::getInstance()->addCss(SITE_DIR . "local/templates/.default/components/bitrix/form.result.new/origami_wantgift/style.css");
Loader::includeModule('sotbit.origami');
$telMask = \Sotbit\Origami\Config\Option::get('MASK', SITE_ID);
Asset::getInstance()->addJs(SITE_DIR . "local/templates/sotbit_origami/assets/plugin/jquerymask/jquery.maskedinput.min.js");
$typeMask = (Config::get('TYPE_MASK_VIEW') == 'FLAGS') ? 'Y' : 'N';
if ($typeMask == 'Y')
    CJSCore::Init(['phone_number']);
?>

<div class="sotbit_want_gift_wrapper">
    <div class="sotbit_order_phone__title_narrowly">

        <? if ($arResult["isFormTitle"]) { ?>
            <div class="sotbit_order_phone__title"><?= $arResult["FORM_TITLE"] ?>
            </div>
        <? } ?>

    </div>
    <div class="want_gift-resizeable_content">
        <? if ($arResult["IMG_PRODUCT"]["SRC"]) : ?>
            <div class="sotbit_want_gift_image">
                <img src="<?= $arResult["IMG_PRODUCT"]["SRC"] ?>" alt="<?= $arResult["IMG_PRODUCT"]["NAME"] ?>">
                <div class="sotbit_want_gift_name"><?= $arResult["IMG_PRODUCT"]["NAME"] ?></div>
                <div class="sotbit_want_gift_price">
                    <?= $arResult["IMG_PRODUCT"]["PRICE"] ?>
                </div>
                <? if ($arResult["IMG_PRODUCT"]["OLD_PRICE"]): ?>
                    <div class="sotbit_want_gift_oldprice">
                        <?= $arResult["IMG_PRODUCT"]["OLD_PRICE"] ?>
                    </div>
                <? endif; ?>
            </div>
        <? endif; ?>

        <div class="sotbit_order_phone">
            <div class="sotbit_order_phone__title_wide">
                <? if ($arResult["isFormTitle"]) { ?>
                    <div class="sotbit_order_phone__title"><?= $arResult["FORM_TITLE"] ?>
                    </div>
                <? } ?>
            </div>
            <div class="want_gift-resizeable_content_wide">
                <div class="popup-error-message">
                    <? if ($arResult["isFormErrors"] == "Y"): ?><?= $arResult["FORM_ERRORS_TEXT"]; ?><? endif; ?>
                </div>
                <div class="sotbit_order_success_show">

                    <? if ($arResult["FORM_NOTE"]) : ?>
                        <div class="popup-window-message-content">

                            <svg class="popup-window-icon-check">
                                <use
                                    xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_check_form"></use>
                            </svg>

                            <div>
                                <div class="popup-window-message-title"><?= GetMessage('OK_THANKS'); ?></div>
                                <div style="font-size: 16px;"><?= $arResult["FORM_NOTE"] ?></div>
                            </div>

                        </div>
                    <? endif; ?>

                </div>
                <? if (empty($arResult["FORM_NOTE"]))
                {
                ?>
                <?= $arResult["FORM_HEADER"] ?>
                <?
                foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
                    if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'textarea'): ?>
                        <div class="sotbit_order_phone__block main-textarea-md__wrapper">
                            <textarea
                                class="contacts-textarea main-textarea-md"
                                <?= ($arQuestion['REQUIRED'] == 'Y') ? 'required' : '' ?>
                                id="contacts-textarea_<?= $arQuestion['STRUCTURE'][0]['ID'] ?>"
                                onchange="isInputFilled(this)"></textarea>
                            <label class="main-label-textarea-md"
                                   for="contacts-textarea_<?= $arQuestion['STRUCTURE'][0]['ID'] ?>">
                                <?= $arQuestion["CAPTION"] ?><?= ($arQuestion['REQUIRED'] == 'Y') ? '*' : '' ?></label>
                        </div>
                    <?elseif ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'tel'):?>
                        <div class="wantgift__phone sotbit_order_phone__block">
                            <? if ($typeMask == 'Y'): ?>
                            <span class="phone_input__flag">
                                <span id="flag<?= $arResult['arForm']['SID'] ?>" onclick="fixCountryPopup(this)"></span>
                            </span>
                            <? endif; ?>

                            <div class="main-input-md__wrapper <?= ($typeMask == 'N') ? 'fullsize' : '' ?> ">
                                <input
                                    type="text"
                                    name="form_tel_<?= $arQuestion['STRUCTURE'][0]['ID'] ?>"
                                    class="main-input-md js-phone filled phone-callback--form"
                                    placeholder="<?= $telMask ?>"
                                    id='number<?= $arResult['arForm']['SID'] ?>'
                                >
                                <label class="main-label-md"
                                       for='number<?= $arResult['arForm']['SID'] ?>'>
                                    <?= $arQuestion["CAPTION"] ?>  <?= ($arQuestion['REQUIRED'] == 'Y') ? '*' : '' ?>
                                </label>
                            </div>
                        </div>
                    <?else:?>
                        <div class="sotbit_order_phone__block main-input-md__wrapper">
                            <input
                                type="<?= ($arQuestion['CAPTION'] !== Loc::getMessage('OK_LINK_PRODUCT')) ? $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] : 'text' ?>"
                                name="form_<?= ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'tel') ? 'text' : $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] ?>_<?= $arQuestion['STRUCTURE'][0]['ID'] ?>"
                                id="form_<?= ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'tel') ? 'text' : $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] ?>_<?= $arQuestion['STRUCTURE'][0]['ID'] ?>"
                                <?= ($arQuestion['REQUIRED'] == 'Y') ? 'required' : '' ?>
                                class="main-input-md"
                                onchange="isInputFilled(this)"
                            >
                            <label
                                class="main-label-md"
                                for="form_<?= ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'tel') ? 'text' : $arQuestion['STRUCTURE'][0]['FIELD_TYPE'] ?>_<?= $arQuestion['STRUCTURE'][0]['ID'] ?>">
                                <?= $arQuestion['CAPTION'] ?>
                                <?= ($arQuestion['REQUIRED'] == 'Y') ? '*' : '' ?>
                            </label>
                        </div>
                    <?endif;?>

                <?}?>

                <input type="hidden" name="img" value="<?= $arResult["IMG_PRODUCT"]["SRC"] ?>"/>
                <input type="hidden" name="name" value="<?= $arResult["IMG_PRODUCT"]["NAME"] ?>"/>
                <input type="hidden" name="price" value="<?= $arResult["IMG_PRODUCT"]["PRICE"] ?>"/>

                <? if ($arResult["isUseCaptcha"] == "Y") {
                    ?>
                    <div class="sotbit_order_phone__block">
                        <div class="feedback_block__captcha">
                            <div class="feedback_block__captcha_input main-input-md__wrapper">
                                <input type="text" class="main-input-md" name="captcha_word"
                                       id="callback-popup_captcha-input" size="30" maxlength="50" value=""
                                       onchange="isInputFilled(this)"
                                       required/>
                                <label class="main-label-md" for="callback-popup_captcha-input">
                                    <?= GetMessage('CAPTCHA_TITLE'); ?>
                                </label>
                            </div>
                            <div class="feedback_block__captcha_img">
                                <input type="hidden" name="captcha_sid"
                                       value="<?= htmlspecialcharsbx($arResult["CAPTCHACode"]); ?>"/>
                                <img
                                    src="/bitrix/tools/captcha.php?captcha_sid=<?= htmlspecialcharsbx($arResult["CAPTCHACode"]); ?>" alt="captcha"/>
                                <div class="captcha-refresh"
                                     onclick="reloadCaptcha(this,'<?= SITE_DIR ?>');return false;">
                                    <svg class="icon_refresh" width="16" height="14">
                                        <use
                                            xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_refresh"></use>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>

                <div class="confidential-field">
                    <div class="main_checkbox">
                        <input type="checkbox"
                               id="want_gift"
                               name="personal"
                               class="checkbox__input"
                               checked="checked">
                        <label for="want_gift">
                            <span></span>
                            <span><?= Loc::getMessage('OK_CONFIDENTIAL') ?>
                                <a href="<?= Config::get('CONFIDENTIAL_PAGE', $arParams['SITE_ID']) ?>" target="_blank">
                                    <?= Loc::getMessage('OK_CONFIDENTIAL2') ?>  </a></span>
                        </label>
                    </div>
                </div>
                <div class="popup-window-submit_button">
                    <input type="button" name="web_form_submit" class="main_btn"
                           value="<?= htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>"
                           onclick="sendForm('<?= $arResult['arForm']['SID'] ?>', '<?= Config::get('COLOR_BASE', $arParams['SITE_ID']) ?>')">
                    <input type="submit" name="web_form_submit" style="display:none;"
                           value="<?= htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]); ?>">
                    <?= $arResult["FORM_FOOTER"] ?>
                    <?
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<? if ($typeMask == 'Y'): ?>
    <script>
        BX.ready(function () {
            if (document.getElementById("number" + "<?= $arResult['arForm']['SID'] ?>")) {
                new BX.PhoneNumber.Input({
                    node: BX("number" + "<?= $arResult['arForm']['SID'] ?>"),
                    forceLeadingPlus: true,
                    flagNode: BX("flag" + "<?= $arResult['arForm']['SID'] ?>"),
                    flagSize: 16,
                    className: 'callback-popup__select-country',
                    defaultCountry: 'ru',
                    onChange: function (e) {
                    }
                });
            }
        });
    </script>
<? else: ?>
    <script>
        $(function () {
            let maska = "<?=Config::get('MASK')?>";
            maska = $.trim(maska);
            if (maska !== "")
                $(".sotbit_order_phone form input.phone-callback--form").mask(maska, {placeholder: "_"});
        });
    </script>
<? endif; ?>
<script>
    function sendForm(sid, color) {
        if ($("form[name='" + sid + "'] input[name='personal']").is(':checked')) {
            $("form[name='" + sid + "'] input[type='submit']").trigger('click');
        } else {
          $('.main_checkbox').addClass('not-checked');
        }
    }

    if(document.querySelector(".sotbit_want_gift_image > img") !== null){
        document.querySelector(".sotbit_want_gift_image > img").addEventListener("load", function () {
            window.resizeWGPopup();
        })
    }

    try {
        setClassInputFilled();
    } catch (error) {
        console.warn(error);
    }
</script>
