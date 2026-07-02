<?
foreach ($arResult["ITEMS"] as $key=> &$arItem){
    if($arItem["TAGS"]) {
        $tags = explode(',',$arItem['TAGS']);
        $arItem['SHOW_TAGS'] = $tags;

        foreach ($arItem['SHOW_TAGS'] as &$tag){
            $tag = trim($tag);
        }
    }
}
?>