<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

\Bitrix\Main\UI\Extension::load("ui.bootstrap4");
?>

<div class="mb-4">
	<?php if (!empty($arResult["ERROR_MESSAGE"])) {
		foreach($arResult["ERROR_MESSAGE"] as $v)
			ShowError($v);
	}
	if($arResult["OK_MESSAGE"] <> ''): ?>
		<div class="alert alert-success"><?=$arResult["OK_MESSAGE"]?></div>
	<?php endif; ?>

	<form action="<?=POST_FORM_ACTION_URI?>" method="POST">
		<?=bitrix_sessid_post()?>

		<?php
		$placeholderName = GetMessage("MFT_NAME") . (empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"]) ? " *" : "");
		$placeholderEmail = GetMessage("MFT_EMAIL") . (empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"]) ? " *" : "");
		$placeholderMessage = GetMessage("MFT_MESSAGE") . (empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"]) ? " *" : "");
		?>

		<div class="form-group">
			<input
				type="text"
				name="user_name"
				class="form-control"
				value="<?=$arResult["AUTHOR_NAME"]?>"
				placeholder="Ваше имя"
				<?php if (empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])): ?>required<?php endif; ?>
			/>
		</div>

		<div class="form-group">
			<input
				type="email"
				name="user_email"
				class="form-control"
				value="<?=$arResult["AUTHOR_EMAIL"]?>"
				placeholder="Ваш e-mail"
				<?php if (empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])): ?>required<?php endif; ?>
			/>
		</div>
        
        <div class="form-group">
        	<input
	        	type="tel"
	        	name="user_phone"
	        	class="form-control"
	        	value="<?=htmlspecialchars($_POST["user_phone"] ?? "")?>"
	        	placeholder="Ваш номер"
		<?php if (empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])): ?>required<?php endif; ?>
        	/>
        </div>


		<div class="form-group">
			<textarea
				class="form-control"
				name="MESSAGE"
				rows="5"
				placeholder="<?=$placeholderMessage?>"
				<?php if (empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])): ?>required<?php endif; ?>
			><?=$arResult["MESSAGE"]?></textarea>
		</div>

		<?php if ($arParams["USE_CAPTCHA"] == "Y"): ?>
			<div class="form-row">
				<div class="form-group col-md-4">
					<input
						type="text"
						name="captcha_word"
						class="form-control"
						placeholder="<?=GetMessage("MFT_CAPTCHA_CODE")?> *"
						required
					/>
				</div>
				<div class="form-group col-md-4">
					<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
					<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="38" alt="CAPTCHA">
				</div>
			</div>
		<?php endif; ?>

		<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
		<button	type="submit" name="submit"	class="btn btn-primary">
	Отправить
</button>
	</form>
</div>
