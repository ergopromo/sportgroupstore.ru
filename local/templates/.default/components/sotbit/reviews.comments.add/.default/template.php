<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

global $USER;
global $APPLICATION;

$origamiIsInstalled = \Bitrix\Main\Loader::includeModule('sotbit.origami');
$frame = $this->createFrame()->begin();
?>
<div class="success"
     style="display: none;"><?= GetMessage(CSotbitReviews::iModuleID . "_COMMENTS_SUCCESS_TEXT") ?></div>
<div class="add-comments add-comments__btn">
    <div class="spoiler__comments">
        <? if (
                ($USER->IsAuthorized() && COption::GetOptionString(CSotbitReviews::iModuleID, "COMMENTS_REGISTER_USERS_" . SITE_ID) == 'Y')
                || COption::GetOptionString(CSotbitReviews::iModuleID, "COMMENTS_REGISTER_USERS_" . SITE_ID) != 'Y'
        ) : ?>
            <div class="main_btn">
                <?= GetMessage(CSotbitReviews::iModuleID . "_COMMENTS_SPOILER_TITLE") ?>
            </div>
        <? endif; ?>
    </div>
    <div class="spoiler-comments-body add-new-comment">
        <? if (
                ($USER->IsAuthorized() && COption::GetOptionString(CSotbitReviews::iModuleID, "COMMENTS_REGISTER_USERS_" . SITE_ID) == 'Y')
                || COption::GetOptionString(CSotbitReviews::iModuleID, "COMMENTS_REGISTER_USERS_" . SITE_ID, "") != 'Y'
        ) : ?>
            <? if ($arResult['BAN'] != "Y" && $arResult['CAN_REPEAT'] == 1) : ?>
                <div class="comments-add-block">
                    <p class="add-check-error" style="display: none;"></p>
                    <form class="comment" id="add_comment"
                          action="javascript:void(null);">
                        <input type="hidden" name="ID_ELEMENT"
                               value="<?= $arParams['ID_ELEMENT'] ?>"/>
                        <input type="hidden"
                               name="MODERATION"
                               value="<?= COption::GetOptionString(CSotbitReviews::iModuleID, "COMMENTS_MODERATION_" . SITE_ID) ?>"/>
                        <input type="hidden" name="SITE_DIR" value="<?= SITE_DIR ?>"/>
                        <input type="hidden" name="PAGE_URL" value="<?= $APPLICATION->GetCurPage() ?>"/>
                        <input type="hidden" name="SPAM_ERROR"
                               value="<?= GetMessage(CSotbitReviews::iModuleID . "_COMMENTS_SPAM_ERROR") ?>"/>
                        <input type="hidden" name="PARENT" value="<?= $arParams['PARENT'] ?>"/>
                        <input type="hidden" name="TEMPLATE" value="<?= $templateName ?>"/>
                        <input type="hidden" name="PRIMARY_COLOR" value="<?= $arParams['PRIMARY_COLOR'] ?>"/>
                        <input type="hidden"
                               name="TEXTBOX_MAXLENGTH"
                               value="<?= $arParams['TEXTBOX_MAXLENGTH'] ?>"/>
                        <input type="hidden"
                               name="BUTTON_BACKGROUND"
                               value="<?= $arParams['BUTTON_BACKGROUND'] ?>"/>
                        <input type="hidden"
                               name="NOTICE_EMAIL"
                               value="<?= $arParams['NOTICE_EMAIL'] ?>"/>
                        <p class="text"><?= GetMessage(CSotbitReviews::iModuleID . "_COMMENTS_TEXT") ?></p>
                        <span id="comments-editor">
                    <? if (!$origamiIsInstalled && COption::GetOptionString(CSotbitReviews::iModuleID, "COMMENTS_EDITOR_" . SITE_ID) == "Y"): ?>
                        <?
                        $APPLICATION->IncludeComponent(
                        "bitrix:main.post.form",
                        "",
                        [
                            'BUTTONS' => [],
                            'PARSER' => [],
                            'PIN_EDITOR_PANEL' => 'N',
                            'TEXT' => [
                                'SHOW' => 'Y',
                                'VALUE' => "",
                                'NAME' => 'text'
                            ]
                        ]);
                        ?>
                    <? else: ?>
                        <textarea name="text" id="contentbox"
                                  maxlength="<?= $arParams["TEXTBOX_MAXLENGTH"] ?>"></textarea>
                        <p class="count"><?= GetMessage(CSotbitReviews::iModuleID . "_COMMENTS_ADD_COUNT") ?> <span
                                class="count-now">0</span> / <?= $arParams["TEXTBOX_MAXLENGTH"] ?></p>
                    <? endif; ?>
                    </span>
                        <? if (!empty($arResult['RECAPTCHA2_SITE_KEY'])): ?>
                            <div id="recaptcha-comment-0" class="captcha-block"></div>
                        <? endif; ?>
                        <div class="add-comments__buttons">
                            <button class="main_btn comment_submit" type="submit" name="submit"
                                    id="comment_submit"><?= GetMessage(CSotbitReviews::iModuleID . "_COMMENTS_SUBMIT_VALUE") ?></button>
                            <button class="main_btn comment_cancel" type="button"
                                    id="reset-form"><?= GetMessage(CSotbitReviews::iModuleID . "_COMMENTS_ADD_CANCEL") ?></button>
                        </div>
                    </form>
                </div>
            <? else: ?>
                <? if ($arResult['CAN_REPEAT'] == 0): ?>
                    <p class="not-error"><?= GetMessage(CSotbitReviews::iModuleID . "_REPEAT") ?></p>
                <? else: ?>
                    <p class="not-error"><?= GetMessage(CSotbitReviews::iModuleID . "_REPEAT_TIME") . ' ' . $arResult['CAN_REPEAT'] ?></p>
                <? endif; ?>
            <? endif; ?>
        <? else: ?>
            <p class="not-error not-ban-error"><?= GetMessage(CSotbitReviews::iModuleID . "_COMMENTS_USER_BAN_TITLE") ?></p>
            <? if (!empty($arResult['REASON'])): ?>
                <p class="reason-title"><?= GetMessage(CSotbitReviews::iModuleID . "_COMMENTS_USER_BAN_REASON_TITLE") ?></p>
                <p class="reason-text"><?= $arResult['REASON'] ?></p>
            <? endif; ?>
        <? endif; ?>
    </div>
</div>
<? $frame->end(); ?>
