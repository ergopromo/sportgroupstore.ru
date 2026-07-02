<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->createFrame()->begin();
?>

<?if($arResult['SECTIONS']):?>
    <?foreach ($arResult['SECTIONS'] as $section):?>
        <div class="staff-list__row staff-list-row">
            <h2 class="staff-list-row__title"><?=$section["NAME"]?></h2>
            <?if($section["DESCRIPTION"]):?>
                <p class="staff-list-row__description"><?=$section["DESCRIPTION"]?></p>
            <?endif;?>
            <div class="staff-list-row__content">
                <?foreach ($section["ITEMS"] as $arItem):?>
                    <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <div class="staff-list-row__item staff-list-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <div class="staff-list-item__inner">
                            <div class="staff-list-item__img-block">
                                <div class="staff-list-item__img-wrap">
                                    <?if($arItem["PREVIEW_PICTURE"]["SRC"]):?>
                                        <img class="staff-list-item__img" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>">
                                    <?elseif ($arItem["DETAIL_PICTURE"]["SRC"]):?>
                                        <img class="staff-list-item__img" src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arItem["DETAIL_PICTURE"]["ALT"]?>">
                                    <?endif;?>
                                </div>
                                <?if($arItem["SOCIAL_NETWORK"]):?>
                                    <div class="staff-list-item__social-block">
                                        <?foreach ($arItem["SOCIAL_NETWORK"] as $network):?>
                                            <a href="<?=$network["VALUE"]?>" class="staff-list-item__social-link" target="_blank">
                                                <svg class="staff-list-item__social-link-svg">
                                                    <?if($network["HINT"]):?>
                                                        <use
                                                                xlink:href="<?=$network["HINT"]?>">
                                                        </use>
                                                    <?else:?>
                                                        <path d="M7.2 0C3.22699 0 0 2.35685 0 5.24481C0 6.70539 0.815422 8.0166 2.11663 8.96265C1.90843 10.0083 1.35325 10.9544 0.555181 11.7178C0.433735 11.834 0.520482 12 0.676626 12C2.41157 11.9668 4.00771 11.3195 5.13542 10.2905C5.7947 10.4232 6.48867 10.5062 7.2 10.5062C11.173 10.5062 14.4 8.14938 14.4 5.26141C14.4 2.37344 11.173 0 7.2 0ZM4.68434 6.12448C4.1812 6.12448 3.76482 5.72614 3.76482 5.24481C3.76482 4.76348 4.1812 4.36514 4.68434 4.36514C5.18747 4.36514 5.60386 4.76348 5.60386 5.24481C5.58651 5.72614 5.18747 6.12448 4.68434 6.12448ZM7.2 6.12448C6.69687 6.12448 6.28048 5.72614 6.28048 5.24481C6.28048 4.76348 6.69687 4.36514 7.2 4.36514C7.70313 4.36514 8.11952 4.76348 8.11952 5.24481C8.10217 5.72614 7.70313 6.12448 7.2 6.12448ZM9.71566 6.12448C9.21253 6.12448 8.79614 5.72614 8.79614 5.24481C8.79614 4.76348 9.21253 4.36514 9.71566 4.36514C10.2188 4.36514 10.6352 4.76348 10.6352 5.24481C10.6178 5.72614 10.2188 6.12448 9.71566 6.12448Z"/>
                                                    <?endif;?>
                                                </svg>
                                            </a>
                                        <?endforeach;?>
                                    </div>
                                <?endif;?>

                            </div>
                            <div class="staff-list-item__info-block">
                                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="staff-list-item__name"><?=$arItem["NAME"]?></a>
                                <?if($arItem["PROPERTIES"]["ORIGAMI_POSITION"]["VALUE"]):?>
                                    <span class="staff-list-item__post"><?=$arItem["PROPERTIES"]["ORIGAMI_POSITION"]["VALUE"]?></span>
                                <?endif;?>
                                <div class="staff-list-item__hidden-info-wrap">
                                    <div class="staff-list-item__hidden-info">
                                        <?if(isset($arParams["MAIN_TEL"]) && $arItem["PROPERTIES"][$arParams["MAIN_TEL"]]["VALUE"]):?>
                                            <div class="staff-list-item__hidden-info-item">
                                                <svg class="staff-list-item__hidden-info-icon" width="12" height="12">
                                                    <use
                                                            xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_phone_filled">
                                                    </use>
                                                </svg>
                                                <a href="tel:<?=$arItem["PROPERTIES"][$arParams["MAIN_TEL"]]["VALUE"]?>" class="staff-list-item__hidden-info-text"><?=$arItem["PROPERTIES"][$arParams["MAIN_TEL"]]["VALUE"]?></a>
                                            </div>
                                        <?endif;?>
                                        <?if(isset($arParams["MAIN_EMAIL"]) && $arItem["PROPERTIES"][$arParams["MAIN_EMAIL"]]["VALUE"]):?>
                                            <div class="staff-list-item__hidden-info-item">
                                                <svg class="staff-list-item__hidden-info-icon" width="12" height="8">
                                                    <use
                                                            xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_mail_filled">
                                                    </use>
                                                </svg>
                                                <a href="mailto:<?=$arItem["PROPERTIES"][$arParams["MAIN_EMAIL"]]["VALUE"]?>" class="staff-list-item__hidden-info-text"><?=$arItem["PROPERTIES"][$arParams["MAIN_EMAIL"]]["VALUE"]?></a>
                                            </div>
                                        <?endif;?>
                                        <?if($arItem["PROPERTIES"]["ORIGAMI_ASK_QUESTION"]["VALUE"]):?>
                                            <button type="button" class="staff-list-item__hidden-info-btn" onclick="window.callback_staff('<?=SITE_DIR?>',
                                                    '<?=SITE_ID?>',this, '<?=$arItem["NAME"]?>')">
                                                <?=GetMessage("NEWS_ASK_QUESTION")?>
                                            </button>
                                        <?endif;?>
                                    </div>
                                </div>
                            </div>
                            <div class="staff-list-item__toggle-btn">
                                <svg class="staff-list-item__toggle-btn-icon" width="10" height="6">
                                    <use
                                            xlink:href="/local/templates/sotbit_origami/assets/img/sprite.svg#icon_chevron_down_medium">
                                    </use>
                                </svg>
                            </div>
                        </div>
                    </div>
                <?endforeach;?>
            </div>
        </div>
    <?endforeach;?>
<?endif;?>
