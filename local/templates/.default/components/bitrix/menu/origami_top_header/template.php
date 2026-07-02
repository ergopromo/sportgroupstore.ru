<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
$page = $APPLICATION->GetCurPage(false);
$obName = 'oh1-top-menu' . '__' . $this->randString();
?>

<?if(!empty($arResult)):?>
<nav class="oh1-top-menu">
    <ul class="oh1-top-menu__list">
    <?
    $previousLevel = 0;
    foreach($arResult as $arItem):?>

        <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
            <?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
        <?endif?>

        <?if($arItem["IS_PARENT"]):?>

            <?if($arItem["DEPTH_LEVEL"] == 1):?>
                <li class="oh1-top-menu__list-item <?if($arItem["SELECTED"]):?>oh1-top-menu__list-item--active<?endif;?> <?if(isset($arItem["CHILD_SELECTED"])):?>oh1-top-menu__list-item--current<?endif;?>">
                    <a href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>" class="oh1-top-menu__list-item-text origami_icons_button">
                        <?=$arItem["TEXT"]?>
                    </a>
                    <ul class="oh1-top-menu__sublist">
            <?else:?>
                <li class="category_link__active_content_item <?if($arItem["SELECTED"]):?>active<?endif;?> <?if(isset($arItem["CHILD_SELECTED"])):?>current<?endif;?>">
                    <a href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>" class="oh1-top-menu__list-item-text">
                        <?=$arItem["TEXT"]?>
                    </a>
                    <ul class="oh1-top-menu__sublist">
            <?endif?>

        <?else:?>

            <?if($arItem["PERMISSION"] > "D"):?>

                <?if($arItem["DEPTH_LEVEL"] == 1):?>
                    <li class="oh1-top-menu__list-item <?if($arItem["SELECTED"]):?>oh1-top-menu__list-item--active<?endif;?> <?if(isset($arItem["CHILD_SELECTED"]) || $item["SELECTED"]):?>oh1-top-menu__list-item--current<?endif;?>">
                        <? if($arItem["LINK"] != $page): ?>
                            <a href="<?= $arItem["LINK"] ?>" title="<?=$arItem["TEXT"]?>" class="oh1-top-menu__list-item-text">
                                <?=$arItem["TEXT"]?>
                            </a>
                        <? else: ?>
                            <span class="oh1-top-menu__list-item-text">
                                  <?=$arItem["TEXT"]?>
                            </span>
                        <? endif ?>
                    </li>
                <?else:?>
                    <li class="oh1-top-menu__sublist-item <?if($arItem["SELECTED"]):?>active<?endif;?> <?if(isset($arItem["CHILD_SELECTED"])):?>current<?endif;?>">
                        <? if($arItem["LINK"] != $page): ?>
                            <a href="<?= $arItem["LINK"] ?>" title="<?=$arItem["TEXT"]?>" class="oh1-top-menu__list-item-text">
                                <?=$arItem["TEXT"]?>
                            </a>
                        <? else: ?>
                            <span class="oh1-top-menu__list-item-text">
                                  <?=$arItem["TEXT"]?>
                            </span>
                        <? endif ?>
                    </li>
                <?endif?>

            <?else:?>

                <?if($arItem["DEPTH_LEVEL"] == 1):?>
                    <li><a href="" title="<?=Loc::getMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
                <?else:?>
                    <li><a href="" title="<?=Loc::getMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
                <?endif?>

            <?endif?>

        <?endif?>

        <?$previousLevel = $arItem["DEPTH_LEVEL"];?>

    <?endforeach?>
    <li class="oh1-top-menu__list-item" data-more="true">
        <span class="oh1-top-menu__list-item-text"><?=Loc::getMessage("SOTBIT_TOP_MENU_MORE");?></span>
        <ul class="oh1-top-menu__sublist"></ul>
    </li>
    <?if($previousLevel > 1): //close last item tags?>
        <?=str_repeat("</ul></li>", ($previousLevel - 1) );?>
    <?endif?>

    </ul>
</nav>
<?endif?>
<script>
    var OrigamiHeaderOneTopMenu = new JCOrigamiHeaderOneTopMenu();
</script>