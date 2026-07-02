<?php

use Bitrix\Main\Localization\Loc;
use Sotbit\Origami\Helper\Config;
use \Bitrix\Main\Type\DateTime;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
global $APPLICATION;

$this->setFrameMode(true);
$blockID = $this->randString();
?>
<div class="promotion_detail__banner"
style="<?=($arResult['BACKGROUND'])?"background-image:url('".$arResult['BACKGROUND']['SRC']."');height:".$arResult['BACKGROUND']['HEIGHT']."px":""?>">
	<div class="promotion_detail__banner_background"></div>
	<div class="puzzle_block puzzle_block__promotion_detail bootstrap_style" data-timer="timerID_<?=$blockID?>">
		<div class="promotion_detail__banner_info">
			<div class="promotion_detail__banner_info_inner">
				<div class="promotion_detail__banner_title">
					<?=$arResult['NAME']?>
				</div>
				<? if($arResult['PROPERTIES']['DESCRIPTION']['VALUE']): ?>
					<div class="promotion_detail__banner_description">
                        <?=$arResult['PROPERTIES']['DESCRIPTION']['VALUE']?>
					</div>
                <? endif; ?>
				<div class="promotion_detail__banner_label">
                    <?=Loc::getMessage('BANNER_LABEL')?>
				</div>
			</div>
		</div>
		<? if($arResult['ACTIVE_IMG']['SRC']): ?>
		    <div class="promotion_detail__banner_active_img" style="background-image: url('<?=$arResult['ACTIVE_IMG']['SRC']?>')">
        <? endif; ?>
    </div>

        <?
        if (Config::get('TIMER_PROMOTIONS') == 'Y') {
            $curTime = (new DateTime())->toString();

            if (!empty($arResult['DATE_ACTIVE_TO']) && $curTime < $arResult['DATE_ACTIVE_TO']) {
                $APPLICATION->IncludeComponent(
                    "sotbit:origami.timer",
                    "origami_default",
                    array(
                        "COMPONENT_TEMPLATE" => "origami_default",
                        "ID" => $arResult["ID"],
                        "BLOCK_ID" => $blockID,
                        "ACTIVATE" => "Y",
                        "TIMER_SIZE" => "lg",
                        "TIMER_DATE_END" => $arResult["DATE_ACTIVE_TO"]
                    ),
                    $component
                );
            }
        }
        ?>
	</div>
</div>
<div class="no-padding bootstrap_style">
	<? if($arResult['DATE_ACTIVE_TO_DISPLAY']): ?>
		<div class="promotion_detail__date">
            <?= Loc::getMessage('PROMOTION_DETAIL_UNTIL') ?> <?= $arResult['DATE_ACTIVE_TO_DISPLAY'] ?>
            <? if (isset($arResult['PROPERTIES']['PERIOD']['VALUE']) && $arResult['PROPERTIES']['PERIOD']['VALUE'] != ""): ?>
                | <?= $arResult['PROPERTIES']['PERIOD']['NAME'] ?>: <?= $arResult['PROPERTIES']['PERIOD']['VALUE'] ?>
            <? endif; ?>
		</div>
		<? endif; ?>
    <? if($arResult['DETAIL_TEXT']): ?>
		<div class="promotion_detail__text">
            <?= $arResult['DETAIL_TEXT'] ?>
		</div>
    <? endif; ?>
</div>
