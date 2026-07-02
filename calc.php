<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetPageProperty("description", "Рассчет стоимости работ в калькуляторе является оценочным - точная стоимость будет рассчитана после получения запроса");
	$APPLICATION->SetPageProperty("keywords", "калькулятор электромонтажных работ");
	$APPLICATION->SetPageProperty("title", "Калькулятор: расчет стоимости электромонтажных работ, СКУД, СКС, общестроительных услуг");
	$APPLICATION->SetTitle("Калькулятор: расчет стоимости по видам работ");
	CModule::IncludeModule("iblock");
	CModule::IncludeModule("main");
	?><script>
	function calk(id_sect, id_el){
		var value_kol=jQuery("#kol-vo_"+id_sect+"_"+id_el).attr("value");
		var value_price=jQuery("#price_"+id_sect+"_"+id_el).attr("value");
		var itog = value_kol*value_price;
		//jQuery("#itog_"+id_sect+"_"+id_el).empty();
		jQuery("#itog_"+id_sect+"_"+id_el).attr("value",itog);
		var col=0;
		jQuery(".itogo").each(function (i) {
			var itog=+jQuery(this).attr("value");
			col=col+itog;
		});
		if(col<=10000){
			col=10000;
		}
		var col_length=col.length-1;
		col=""+col;
		col=col.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');

		jQuery(".itog").empty();
		jQuery(".itog").append(col);
	}
	function reload(){
		var col=0;
		jQuery(".itogo").each(function (i) {
			jQuery(this).attr("value","0");
		});
		jQuery(".calk").each(function (i) {
			jQuery(this).attr("value","0");
		});
		if(col<=10000){
			col=10000;
		}
		var col_length=col.length-1;
		col=""+col;
		col=col.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');

		jQuery(".itog").empty();
		jQuery(".itog").append(col);
	}
	function check_t(id_sect, id_el){
		var col=0;
		jQuery("input:checked").each(function (i) {
			var it=jQuery(this).attr("id");
			var itog=+jQuery("#itog_"+it).attr("value");
			col=col+itog;
		});

		jQuery(".itog").empty();
		jQuery(".itog").append(col);
	}
	function sel_v(id_sect){
		jQuery(".list_type").hide();
		jQuery("#sel_rab_"+id_sect).show();
	}
</script>
<div class="top2">Калькулятор: расчет стоимости по
	видам работ
</div>
<form method="post" action="mail.php">
	<div style="clear:both"></div>
	<div class="calc" style="font-size:12px;">
		<?
			$ids=Array();
			$arFilter = Array('IBLOCK_ID'=>9, 'ACTIVE'=>'Y');
			$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, true);
			while($ar_result = $db_list->GetNext())
			{
				$ids[]=$ar_result['ID'];
			?>
			<span style="cursor:pointer; background:#594b33; color:#FFFFFF; padding:2px 5px; margin-left:10px; margin-bottom:20px;" class="tabs" id="tab_<?=$ar_result['ID']?>" onclick="sel_v('<?=$ar_result['ID']?>')"><?=$ar_result['NAME']?></span>
			<?}
		?>




		<?
			$arFilter = Array('IBLOCK_ID'=>9, 'ACTIVE'=>'Y');
			$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, true);
			while($ar_result = $db_list->GetNext())
			{
				if($ids[0]!=$ar_result["ID"]){
					$style="style='display:none'";
					}else{
					$style="";
				}
			?>
			<table <?=$style?> id="sel_rab_<?=$ar_result["ID"]?>" class="list_type" width="730" cellspacing="0" cellpadding="0">
				<tr style="background:d8ebf7">
					<td style="width:500px; font:14px Tahoma; color:#3a3f42; padding:3px 0 3px 20px">
						Наименование
					</td>
					<td style="font:14px Tahoma; color:#3a3f42; padding:3px 0 3px 20px" align="center">
						Еденицы измерения
					</td>
					<td style="font:14px Tahoma; color:#3a3f42; padding:3px auto">
						Кол-во
					</td>
				</tr>
				<?
					$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_ED", "PROPERTY_PRICE");
					$arFilter = Array("IBLOCK_ID"=>9, "SECTION_ID"=>$ar_result["ID"], "ACTIVE"=>"Y");
					$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
					$i=0;
					while($ob = $res->GetNextElement())
					{
						$arFields = $ob->GetFields();
						if($i%2==0){
							//$class="style='background:#edf8ff;'";
							$class="style='background:#fff3db;'";
							}else{
							$class="";
						}
					?>
					<tr <?=$class?>>
						<td style="padding:3px 0 3px 20px">
							<!--<input type="checkbox" onclick="check_t(<?=$ar_result["ID"]?>,<?=$arFields["ID"]?>)" name="name_<?=$ar_result["ID"]?>_<?=$arFields["ID"]?>" id="<?=$ar_result["ID"]?>_<?=$arFields["ID"]?>" class="<?=$ar_result["ID"]?>">--> <?=$arFields["NAME"];?>
						</td>
						<td style="padding:3px 0" align="center">
							<?=$arFields["PROPERTY_ED_VALUE"];?>
						</td>
						<td style="padding:3px 20px 3px 0">
							<input class="calk" size="5" name="itogo_cols[<?=$ar_result["ID"]?>][<?=$arFields["ID"]?>]" type="text" onblur="if(this.value=='') this.value='0';" onfocus="if(this.value=='0') this.value='';" onkeyup="this.value = this.value.replace (/\D/, ''); calk(<?=$ar_result["ID"]?>,<?=$arFields["ID"]?>)" id="kol-vo_<?=$ar_result["ID"]?>_<?=$arFields["ID"]?>" value="0">
							<input type="hidden" name="price" id="price_<?=$ar_result["ID"]?>_<?=$arFields["ID"]?>" value="<?=$arFields["PROPERTY_PRICE_VALUE"];?>">
							<input type="hidden" name="itogo_col[<?=$ar_result["ID"]?>][<?=$arFields["ID"]?>]" class="itogo" id="itog_<?=$ar_result["ID"]?>_<?=$arFields["ID"]?>" value="0">
						</td>
					</tr>
					<?
						$i++;
					}
				?>
			</table>
			<?}
		?>
	</div>
	<div class="itogs" style="width:730px; margin-top:10px; margin-left:20px; font-size:18px;">
		ИТОГО: <div style="float:right; margin-right:20px; font:24px Tahoma;"><span class="itog">10 000</span> руб.</div>
	</div>
	<br>
	<div class="itogs" style="width:730px; margin-top:10px; margin-left:20px; font-size:18px;">
		<a href="javascript:reload()">Очистить форму</a>
	</div>
	<br>
	<p style="font-size:12px;margin-left:20px; width:600px">
		Внимание, минимальная стоимость заказа 10000 руб.<br/>
		Рассчет является оценочным и не является
		офертой.  Точная стоимость работ зависит от особенностей проекта, инженерных
		решений, сроков и условий работ и оплаты.  Для получения уточнного расчета
		направляйте запросы нам на адрес info@s-co.ru желательно вместе с проектом и
		спецификацией
	</p>
	<!--
	<br/></br>
	<p style="font-size:14px;margin-left:20px"><b>Переслать оценочный расчет по адресу</b></p>

	<div style="padding-top:10px; float:left;">
		<input type="text" value="Контактное лицо" onblur="if(this.value=='') this.value='Контактное лицо';" onfocus="if(this.value=='Контактное лицо') this.value='';" maxlength="50" name="a"><span style="color:red"> *</span><br>
		<input type="text" value="E-mail" onblur="if(this.value=='') this.value='E-mail';" onfocus="if(this.value=='E-mail') this.value='';" maxlength="50" name="e"><span style="color:red"> *</span><br>
		<input type="text" value="Телефон" onblur="if(this.value=='') this.value='Телефон';" onfocus="if(this.value=='Телефон') this.value='';" maxlength="50" name="q"><br>
		<input type="checkbox" value="Y" name="svaz"> связаться со мной для уточнения расчета<br>
		<div class="incalc" style="padding-left: 53px; float: left;"><input type="submit" value="Отправить" name="Submit"></div>



	</div>
	-->
</form>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
