<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $frame = $this->createFrame()->begin(); ?>
<? global $USER;
global $APPLICATION; ?>
<div class="add-questions add-questions__btn">
    <div class="success questions-success"
         style="display:none;"><?= GetMessage(CSotbitReviews::iModuleID . "_QUESTIONS_SUCCESS_TEXT") ?></div>
    <? if ($USER->IsAuthorized() || COption::GetOptionString(CSotbitReviews::iModuleID, "QUESTIONS_REGISTER_USERS_" . SITE_ID, "") != 'Y'):
        if ($arResult['BAN'] != "Y"): ?>
            <div class="spoiler">
                <div class="main_btn">
                    <?= GetMessage(CSotbitReviews::iModuleID . "_QUESTIONS_SPOILER_TITLE") ?>
                </div>
            </div>
         <?endif;?>
    <?endif;?>
    <div class="spoiler-questions-body">
        <? if ($USER->IsAuthorized() || COption::GetOptionString(CSotbitReviews::iModuleID, "QUESTIONS_REGISTER_USERS_" . SITE_ID, "") != 'Y'):
            if ($arResult['BAN'] != "Y"):
                ?>
                <? if ($arResult['CAN_REPEAT'] == 1): ?>
                <div class="questions-add-block">
                    <p class="add-check-error" style="display:none;"></p>
                    <form class="question" id="add_question" action="javascript:void(null);">
                        <input type="hidden" name="ID_ELEMENT" value="<?= $arParams['ID_ELEMENT'] ?>"/>
                        <input type="hidden" name="SITE_DIR" value="<?= SITE_DIR ?>"/>
                        <input type="hidden" name="PAGE_URL" value="<?= $APPLICATION->GetCurPage() ?>"/>
                        <input type="hidden" name="SPAM_ERROR"
                               value="<?= GetMessage(CSotbitReviews::iModuleID . "_QUESTIONS_SPAM_ERROR") ?>"/>
                        <input type="hidden" name="TEMPLATE" value="<?= $templateName ?>"/>
                        <input type="hidden" name="NOTICE_EMAIL" value="<?= $arParams['NOTICE_EMAIL'] ?>"/>
                        <input type="hidden" name="MODERATION"
                               value="<?= COption::GetOptionString(CSotbitReviews::iModuleID, "QUESTIONS_MODERATION_" . SITE_ID, "") ?>"/>
                        <p class="text"><?= GetMessage(CSotbitReviews::iModuleID . "_QUESTIONS_TEXT") ?></p>
                        <span id="question-editor" class="questions-popup__question-editor">
				<? if (COption::GetOptionString(CSotbitReviews::iModuleID, "QUESTIONS_EDITOR_" . SITE_ID, "") == "Y"): ?>
                    <? $APPLICATION->IncludeComponent("bitrix:main.post.form", "", Array(
                        'BUTTONS' => array(),
                        'PARSER' => array(),
                        'PIN_EDITOR_PANEL' => 'N',
                        'TEXT' => array(
                            'SHOW' => 'Y',
                            'VALUE' => "",
                            'NAME' => 'text'
                        )
                    )); ?>

                <? else: ?>
                    <textarea name="text" id="contentbox" maxlength="<?= $arParams["TEXTBOX_MAXLENGTH"] ?>"></textarea>
                    <p class="count"><?= GetMessage(CSotbitReviews::iModuleID . "_QUESTIONS_ADD_COUNT") ?> <span
                            class="count-now">0</span> / <?= $arParams["TEXTBOX_MAXLENGTH"] ?></p>
                <? endif; ?>
				</span>

                        <? if (isset($arResult['RECAPTCHA2_SITE_KEY']) && !empty($arResult['RECAPTCHA2_SITE_KEY'])): ?>
                            <div data-captcha-question="Y" id="captcha-question-0" class="captcha-block"></div>
                        <? endif; ?>
                        <button class="main_btn add-questions__form-btn" type="submit" name="submit"
                                id="question_submit"><?= GetMessage(CSotbitReviews::iModuleID . "_QUESTIONS_SUBMIT_VALUE") ?></button>
                        <button class="main_btn add-questions__form-btn_reset" type="button"
                                id="reset-form"><?= GetMessage(CSotbitReviews::iModuleID . "_QUESTIONS_ADD_CANCEL") ?></button>
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
                <p class="not-error not-ban-error"><?= GetMessage(CSotbitReviews::iModuleID . "_QUESTIONS_USER_BAN_TITLE") ?></p>
                <? if (isset($arResult['REASON']) && !empty($arResult['REASON'])): ?>
                    <p class="reason-title"><?= GetMessage(CSotbitReviews::iModuleID . "_QUESTIONS_USER_BAN_REASON_TITLE") ?></p>
                    <p class="reason-text"><?= $arResult['REASON'] ?></p>
                <? endif; ?>
            <? endif; ?>
        <? else: ?>
        <? endif; ?>
    </div>
</div>
<? $frame->end(); ?>
