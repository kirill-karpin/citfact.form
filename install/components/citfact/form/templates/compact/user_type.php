<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * Display custom fields
 *
 * @param array $arResult
 * @param string $fieldFind
 * @return mixed
 */


$userTypePrint = function (&$arResult, $fieldFind = '') {

	global $DB;
    $entityFields = $arResult['HLBLOCK']['DISPLAY_FIELDS'];
    $valueList = $arResult['FORM'];
    $isPost = $arResult['IS_POST'];

	$inputHelper = new InputHelper($arResult);
    ?>
    <? foreach ($entityFields as $fieldName => $fieldValue): ?>

        <?

		$inputHelper->setFieldName($fieldName);
        if (!empty($fieldFind) && $fieldFind != $fieldValue['FIELD_NAME']) {
            continue;
        }
        ?>

		<div class="form-group <?$inputHelper->getErrorClass()?>"
			data-required="<?= ($fieldValue['MANDATORY'] == 'Y') ? 'true' : 'false' ?>"
			data-regexp="<?= $fieldValue['SETTINGS']['REGEXP'] ?>"
			data-min-length="<?= $fieldValue['SETTINGS']['MIN_LENGTH'] ?>"
			data-max-length="<?= $fieldValue['SETTINGS']['MAX_LENGTH'] ?>" >

        <?switch ($fieldValue['USER_TYPE_ID']):

            case 'string':
            case 'integer':
            case 'double':

                ?>
                    <input
						type="text"
						class="form-control <?$inputHelper->getErrorClass()?>"
						name="<?= $fieldValue['FIELD_NAME'] ?>"
						placeholder="<?=$inputHelper->getPlaceHolder()?>"
                        value="<?= $valueList[$fieldValue['FIELD_NAME']] ?>"
					/>

                <? break; ?>

            <?
            case 'textarea':
                ?>

                    <textarea
							class="form-control <?$inputHelper->getErrorClass()?>"
							placeholder="<?=$inputHelper->getPlaceHolder()?>"
                            name="<?= $fieldValue['FIELD_NAME'] ?>"><?= $valueList[$fieldValue['FIELD_NAME']] ?>
					</textarea>

                <? break; ?>

            <?
            case 'enumeration':
            case 'iblock_section':
            case 'iblock_element':
                ?>
                <? $keyValue = ($fieldValue['USER_TYPE_ID'] == 'enumeration') ? 'VALUE' : 'NAME'; ?>

                    <label><?= $fieldValue['EDIT_FORM_LABEL'] ?></label>
                    <? if ($fieldValue['SETTINGS']['DISPLAY'] == 'LIST'): ?>
                        <? $multiple = ($fieldValue['MULTIPLE'] == 'Y') ? 'multiple="multiple"' : ''; ?>
                        <select class="form-control" name="<?= $fieldValue['FIELD_NAME'] ?>" <?= $multiple ?>>
                            <? foreach ($fieldValue['VALUE'] as $key => $value): ?>
								<?if($key == 0):?>
									<option value=""><?=GetMessage("NO_TYPE")?></option>
								<?endif?>

                                <? $selected = ($value['SELECTED'] == 'Y') ? 'selected="selected"' : ''; ?>
                                <option value="<?= $value['ID'] ?>" <?= $selected ?>><?= $value[$keyValue] ?></option>
                            <? endforeach; ?>
                        </select>
                    <? else: ?>
                        <? if ($fieldValue['MULTIPLE'] == 'Y'): ?>
                            <? foreach ($fieldValue['VALUE'] as $value): ?>
                                <? $checked = ($value['SELECTED'] == 'Y') ? 'checked="checked"' : ''; ?>
                                <input type="checkbox" name="<?= $fieldValue['FIELD_NAME'] ?>"
                                       value="<?= $value['ID'] ?>" <?= $checked ?> /> <?= $value[$keyValue] ?>
                            <? endforeach; ?>
                        <? else: ?>
                            <? foreach ($fieldValue['VALUE'] as $value): ?>
                                <? $checked = ($value['SELECTED'] == 'Y') ? 'checked="checked"' : ''; ?>
                                <input type="radio" name="<?= $fieldValue['FIELD_NAME'] ?>"
                                       value="<?= $value['ID'] ?>" <?= $checked ?> /> <?= $value[$keyValue] ?>
                            <? endforeach; ?>
                        <?endif; ?>
                    <?endif; ?>

                <? break; ?>
			<? case 'datetime':?>
				<?CJSCore::Init(array('popup', 'date'));?>
				<input type="text" id="date_fld" name="<?= $fieldValue['FIELD_NAME'] ?>" placeholder="<?=date($DB->DateFormatToPHP(CSite::GetDateFormat("FULL")), time());?>">
				<img src="/bitrix/js/main/core/images/calendar-icon.gif"
					alt="change_date"
					class="calendar-icon"
					onclick="BX.calendar({node:this, field:'<?= $fieldValue['FIELD_NAME'] ?>', form: '', bTime: true, bHideTime: false});"
					onmouseover="BX.addClass(this, 'calendar-icon-hover');" onmouseout="BX.removeClass(this, 'calendar-icon-hover');">

				<?break;?>

            <?
            case 'boolean':
                ?>
                <?
                $defaultValue = $fieldValue['SETTINGS']['DEFAULT_VALUE'];
                $formValue = $valueList[$fieldValue['FIELD_NAME']];
                $realValue = ($isPost) ? $formValue : $defaultValue;
                ?>
                    <label><?= $fieldValue['EDIT_FORM_LABEL'] ?></label>
                    <? if ($fieldValue['SETTINGS']['DISPLAY'] == 'RADIO'): ?>
                        <input type="radio" name="<?= $fieldValue['FIELD_NAME'] ?>" value="1"
                               <? if ($realValue): ?>checked="checked"<? endif; ?> /> <?= GetMessage('YES') ?>
                        <input type="radio" name="<?= $fieldValue['FIELD_NAME'] ?>" value="0"
                               <? if (!$realValue): ?>checked="checked"<? endif; ?> /> <?= GetMessage('NO') ?>
                    <? elseif ($fieldValue['SETTINGS']['DISPLAY'] == 'DROPDOWN'): ?>
                        <select name="<?= $fieldValue['FIELD_NAME'] ?>">
                            <option <? if ($realValue): ?>selected="selected"<? endif; ?>
                                    value="1"><?= GetMessage('YES') ?></option>
                            <option <? if (!$realValue): ?>selected="selected"<? endif; ?>
                                    value="0"><?= GetMessage('NO') ?></option>
                        </select>
                    <? else: ?>
                        <input type="checkbox" name="<?= $fieldValue['FIELD_NAME'] ?>" value="1"
                               <? if ($realValue): ?>checked="checked"<? endif; ?> />
                    <?endif; ?>
                <? break; ?>

            <?
            case 'file':
                ?>
                    <label><?= $fieldValue['EDIT_FORM_LABEL'] ?></label>
                    <input type="file" name="<?= $fieldValue['FIELD_NAME'] ?>"/>
                <? break; ?>

            <?endswitch; ?>
		</div>

        <?
			if ($fieldFind == $fieldValue['FIELD_NAME']) {
				break;
			}
        ?>


    <? endforeach; ?>
<? }; ?>
