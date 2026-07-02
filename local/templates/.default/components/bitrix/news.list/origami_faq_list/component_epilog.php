<div class="questions__form-wrapper">
    <div class="questions__form">
        <?
        CModule::IncludeModule('form');
        $FORM_SID = "QUESTIONS";
        $rsForm = CForm::GetBySID($FORM_SID);
        $arForm = $rsForm->Fetch();
        $APPLICATION->IncludeComponent(
            "bitrix:form.result.new",
            "origami_webform_new",
            array(
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "A",
                "CHAIN_ITEM_LINK" => "",
                "CHAIN_ITEM_TEXT" => "",
                "COMPOSITE_FRAME_MODE" => "A",
                "COMPOSITE_FRAME_TYPE" => "AUTO",
                "EDIT_URL" => "",
                "IGNORE_CUSTOM_TEMPLATE" => "N",
                "LIST_URL" => "",
                "AJAX_MODE" => "Y",
                "SEF_MODE" => "N",
                "SUCCESS_URL" => "",
                "USE_EXTENDED_ERRORS" => "N",
                "WEB_FORM_ID" => $arForm['ID'],
                "COMPONENT_TEMPLATE" => "origami_webform_new",
                "VARIABLE_ALIASES" => array(
                    "WEB_FORM_ID" => "WEB_FORM_ID",
                    "RESULT_ID" => "RESULT_ID",
                )
            ),
            false
        ); ?>
    </div>
</div>
