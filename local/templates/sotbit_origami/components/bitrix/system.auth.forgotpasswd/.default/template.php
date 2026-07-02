<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

global $APPLICATION;

if ($_REQUEST['ajax_mode'] == "Y") {
    $APPLICATION->ShowAjaxHead();
    $arResult["AUTH_AUTH_URL"] = str_replace('&amp;', '&', urldecode($arResult["AUTH_AUTH_URL"]));
    $backUrl = new \Bitrix\Main\Web\Uri($arResult["AUTH_AUTH_URL"]);
    $backUrl->deleteParams(['ajax_mode']);
    $arResult["AUTH_AUTH_URL"] = $backUrl->getUri();
} else {
    $APPLICATION->ShowHead();
}

//one css for all system.auth.* forms
$this->addExternalCss("/local/templates/sotbit_origami/components/bitrix/system.auth.forgotpasswd/.default/style.css");
if (mb_strtolower(SITE_CHARSET) == 'windows-1251') {
    array_walk_recursive(
        $arResult,
        function (&$val) {$val = \Bitrix\Main\Text\Encoding::convertEncodingToCurrent($val);},
    );
}?>
<? if ($_REQUEST['ajax_mode'] == "Y"): ?>
    <div class="sotbit-side-panel__main-header">
        <p class="sotbit-side-panel__main-title"><?= GetMessage('FORGOT_H1'); ?></p>
    </div>
<? endif; ?>
<div class="bx-authform forgot-password">
    <?if (isset($arParams["~AUTH_RESULT"]["MESSAGE"]) && isset($arParams["~AUTH_RESULT"]["TYPE"])) :
        $text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);?>
        <div
            class="alert <?= ($arParams["~AUTH_RESULT"]["TYPE"] == "OK" ? "alert-success" : "alert-danger") ?>"><?= nl2br(htmlspecialcharsbx($text)) ?></div>
    <? endif ?>
    <? if(!isset($arParams["~AUTH_RESULT"]["TYPE"]) || $arParams["~AUTH_RESULT"]["TYPE"] != "OK"): ?>
        <p class="bx-authform-content-container"><?= GetMessage("AUTH_FORGOT_PASSWORD_1") ?></p>
        <form class="authform-for-got" name="bform2" target="_top" action="<?=$arResult["AUTH_URL"]?>" method="post">
            <? if ($arResult["BACKURL"] <> ''): ?>
                <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
            <? endif ?>
            <input type="hidden" name="AUTH_FORM" value="Y">
            <input type="hidden" name="TYPE" value="SEND_PWD">
            <input type="hidden" name="forgot_password" value="yes">
            <div class="bx-authform-formgroup-container">
                <div class="bx-authform-input-container main-input-bg__wrapper">
                    <input class="authform-login-input main-input-bg main-input-bg--gray" id="USER_LOGIN" type="text"
                           name="USER_LOGIN" maxlength="255"
                           value="<?= $arResult["LAST_LOGIN"] ?>" required onchange="isInputFilled(this); window.USER_EMAIL.value = window.USER_LOGIN.value"/>
                    <label for="USER_LOGIN"
                           class="bx-authform-label-container main-label-bg"><? echo GetMessage("AUTH_LOGIN_EMAIL") ?></label>
                    <input type="hidden" name="USER_EMAIL" id="USER_EMAIL"/>
                </div>
            </div>
            <? if ($arResult["USE_CAPTCHA"]): ?>
                <div class="feedback_block__captcha">
                    <p class="feedback_block__captcha_text">
                        <?= GetMessage('CAPTCHA_TITLE'); ?>
                    </p>
                    <div class="feedback_block__captcha_input">
                        <input type="text" name="captcha_word" size="30" maxlength="50" value="" required/>
                    </div>
                    <div class="feedback_block__captcha_img">
                        <input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>" width="180"
                             height="40" alt="captcha"/>
                        <div class="feedback_block__captcha_reload"
                             onclick="reloadCaptcha(this,'<?= SITE_DIR ?>');return false;"></div>
                    </div>
                </div>
            <? endif; ?>
            <div class="bx-authform-get-password-container">
                <button type="submit" class="bx-authform-get-password btn auth-btn main_btn"><?= GetMessage("AUTH_SEND"); ?></button>
            </div>
            <div class="bx-authform-link-container">
                <a class="bx-authform-link" href="<?= $arResult["AUTH_AUTH_URL"]; ?>"><?= GetMessage("AUTH_AUTH"); ?></a>
            </div>
        </form>
    <?endif;?>
</div>
<script>
    try {
        setClassInputFilled();
    } catch (error) {
        console.warn(error);
    }
</script>
