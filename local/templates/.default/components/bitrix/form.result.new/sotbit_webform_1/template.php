<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Security\Random;
use Sotbit\Origami\Config\Option;
use Sotbit\Origami\Helper\Config;
use Bitrix\Main\Page\Asset;
$this->setFrameMode(true);

$telMask = Option::get('MASK', SITE_ID);
$prefix = '_' . Random::getString(3);
$bxajaxid = CAjax::GetComponentID($component->__name, $component->__template->__name, $arParams['AJAX_OPTION_ADDITIONAL']);

if ($_REQUEST['formresult'] == 'addok' || $_REQUEST['AJAX_CALL'] == 'Y') {
    $APPLICATION->RestartBuffer();
}

Asset::getInstance()->addJs($templateFolder . "/js/jquery.maskedinput.min.js");
$typeMask = (Config::get('TYPE_MASK_VIEW') == 'FLAGS') ? 'Y' : 'N';
if ($typeMask == 'Y') {
    CJSCore::Init(['phone_number']);
}
$idBlock = $arParams['BLOCK_ID'];
?>
<div class="feedback_block feedback_block__main-page">
    <div class="puzzle_block main-container">
        <div class="feedback_block__text">
            <? if ($arResult["isFormTitle"] == "Y"): ?>
                <div class="feedback_block__title fonts__middle_title"><?= $arResult["FORM_TITLE"] ?></div>
            <? endif ?>
            <? if ($arResult["isFormDescription"] == "Y"): ?>
                <div class="feedback_block__comment fonts__small_text"><?= $arResult["FORM_DESCRIPTION"] ?></div>
            <? endif ?>
            <? if ($arResult["FORM_NOTE"]): ?>
                <div class="success-message">
                    <span><?= $arResult["FORM_NOTE"] ?></span>
                </div>
            <? endif; ?>
            <? if($arResult['isFormErrors'] == 'Y'): ?>
                <?=$arResult['FORM_ERRORS_TEXT']?>
            <? endif; ?>
        </div>

        <?if ($_REQUEST['formresult'] == 'addok' || $_REQUEST['AJAX_CALL'] == 'Y') {
            die;
        }
        ?>
        <?= $arResult["FORM_HEADER"] ?>
        <div class="row">
            <?
            foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
                $fieldType = $arQuestion['STRUCTURE'][0]['FIELD_TYPE'];
                if ($fieldType == 'hidden') {
                    echo $arQuestion["HTML_CODE"];
                } else {
                    ?>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-12">
                        <? if ($arQuestion['CAPTION'] == Loc::getMessage("SOTBIT_FORM_TEL")): ?>
                            <div class="phone_input_feedback">
                                <? if ($typeMask == 'Y'): ?>
                                    <span class="phone_input__flag">
                                        <span id="flag<?= $arResult['arForm']['SID'] . $idBlock ?>"></span>
                                    </span>
                                <? endif; ?>
                        <? endif; ?>
                                    <div class="main-input-md__wrapper <?= ($typeMask == 'N') ? 'fullsize' : '' ?> ">
                                    <input
                                        type="<?= $arQuestion["CAPTION"] == Loc::getMessage("SOTBIT_FORM_TEL") ? "text" : $fieldType ?>"
                                        name="form_<?= $fieldType ?>_<?= $arQuestion['STRUCTURE'][0]['ID'] ?>"
                                        <? if ($arQuestion['CAPTION'] == Loc::getMessage("SOTBIT_FORM_TEL")): ?>
                                            class="main-input-md js-phone filled"
                                            placeholder="<?= $telMask ?>"
                                            id='number<?= $arResult['arForm']['SID'] . $idBlock ?>'
                                        <? else: ?>
                                            class="main-input-md"
                                            id="<?= $fieldType ?>__<?= $arQuestion['STRUCTURE'][0]['ID'] . $prefix ?>"
                                            onchange="isInputFilled(this)"
                                        <? endif; ?>
                                        <?= ($arQuestion['REQUIRED'] == 'Y') ? 'required' : '' ?>
                                    >
                                    <label class="main-label-md"
                                        <? if ($arQuestion['CAPTION'] == Loc::getMessage("SOTBIT_FORM_TEL")): ?>
                                            for='number<?= $arResult['arForm']['SID'] . $idBlock ?>'>
                                        <? else: ?>
                                           for="<?= $fieldType ?>__<?= $arQuestion['STRUCTURE'][0]['ID'] . $prefix ?>">
                                        <? endif; ?>
                                        <?= $arQuestion["CAPTION"] ?>  <?= ($arQuestion['REQUIRED'] == 'Y') ? '*' : '' ?>
                                    </label>
                                </div>
                        <? if ($arQuestion['CAPTION'] == Loc::getMessage("SOTBIT_FORM_TEL")): ?>
                            </div>
                        <? endif; ?>
                    </div>
                    <?
                }
            }
            ?>

            <?
            if ($arResult["isUseCaptcha"] == "Y") {
                ?>
            <div class="col-xl-3 col-lg-3 col-md-3 col-12">
                <div class="feedback_block__captcha">
                    <div class="feedback_block__captcha-new-input-wrapper">
                        <div class="main-input-md__wrapper">
                            <input type="text" class="main-input-md" name="captcha_word"
                                id="contacts-call-back-form-captcha" size="30" maxlength="50" value=""
                                onchange="isInputFilled(this)"
                                required/>
                            <label class="main-label-md" for="contacts-call-back-form-captcha">
                                <?= GetMessage('CAPTCHA_TITLE'); ?>
                            </label>
                        </div>
                        <div class="feedback_block__captcha_img">
                            <input type="hidden" name="captcha_sid"
                                value="<?= htmlspecialcharsbx($arResult["CAPTCHACode"]); ?>"/>
                            <img
                                src="/bitrix/tools/captcha.php?captcha_sid=<?= htmlspecialcharsbx($arResult["CAPTCHACode"]); ?>"
                                width="180" height="40" alt="captcha"/>
                            <div class="captcha-refresh" onclick="reloadCaptcha(this,'<?= SITE_DIR ?>');return false;">
                                <svg class="icon_refresh" width="16" height="14"
                                    style="color: <?= \Sotbit\Origami\Helper\Config::get('COLOR_BASE') ?>; ">
                                    <use
                                        xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_refresh"></use>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <?
            }
            ?>

            <div class="col-xl-3 col-lg-3 col-md-3 col-12">
                <input type="button" class="main_btn-big" name="web_form_submit"
                       value="<?= Loc::getMessage("FORM_SUBMIT") ?>"
                       onclick="sendForm('<?= $bxajaxid ?>','<?= \Sotbit\Origami\Helper\Config::get('COLOR_BASE') ?>', '<?= $prefix ?>')"
                    <? if ($_REQUEST['formresult'] == 'addok'): ?>
                        disabled="disabled"
                    <? endif; ?>
                >
                <input type="submit" style="display:none"
                       name="web_form_submit" id="submit_<?= $bxajaxid ?>">
            </div>
            <div class="feedback_block__compliance main_checkbox conf">
                <input type="checkbox" id="personal_phone_personal<?= $prefix ?>" class="checkbox__input"
                       checked="checked" name="personal">
                <label for="personal_phone_personal<?= $prefix ?>">
                    <span id="personal_checked<?= $prefix ?>"></span>
                    <span>
                        <span class="confidential">
                            <?= Loc::getMessage('SOTBIT_FORM_I_AGREE') ?>
                        </span>
                        <a href="<?= \Sotbit\Origami\Helper\Config::get('CONFIDENTIAL_PAGE') ?>" target="_blank">
                            <?= Loc::getMessage('SOTBIT_FORM_I_AGREE2') ?>
                        </a>
                    </span>
                </label>
                <input type="hidden" id="form_<?= $bxajaxid ?>" value="<?= $bxajaxid ?>">
            </div>
        </div>
        <?= $arResult["FORM_FOOTER"] ?>
    </div>
</div>

<script>
    <?if($typeMask == 'Y'):?>
        document.addEventListener('DOMContentLoaded', () => {
            if (document.getElementById("number" + "<?= $arResult['arForm']['SID'] . $idBlock?>")) {
                new BX.PhoneNumber.Input({
                    node: BX("number" + "<?= $arResult['arForm']['SID'] . $idBlock?>"),
                    forceLeadingPlus: true,
                    flagNode: BX("flag" + "<?= $arResult['arForm']['SID'] . $idBlock ?>"),
                    flagSize: 16,
                    countryPopupClassName: 'feedback_block__select-country-popup',
                    defaultCountry: 'ru',
                    onChange: function (e) {
                    }
                });
            }

            const form = document.querySelector('#form_<?= $bxajaxid ?>').closest('form');
            datefilds = Array.from(form.querySelectorAll('input[type="date"]'));
            fileFilds = Array.from(form.querySelectorAll('input[type="file"]'));
            const filds = [...datefilds, ...fileFilds];

            filds.forEach(i => i.style.color = '#fff');
            filds.forEach(i => {
                i.addEventListener('click', () => i.style.color = '#000');
                i.addEventListener('change', () => i.style.color = '#000');
                i.addEventListener('focusout', () => {
                    if (!i.value) {
                        i.style.color = '#fff';
                    }
                })
            });
        });
    <?endif;?>

    <?if($typeMask !== 'Y'):?>
        $(function () {
            let maska = "<?=Config::get('MASK')?>";
            maska = $.trim(maska);
            if (maska !== "") {
                $(".js-phone").mask(maska, {placeholder: "_"});
            }
        });
    <?endif;?>

    try {
        setClassInputFilled();
    } catch (error) {
        console.warn(error);
    }
</script>

