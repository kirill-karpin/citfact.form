<?php

class InputHelper {

	private $fieldName;
	private $errroPrefix = ' *';
	private $errorPlaceholder;
	private $errorClass = 'errorInput';
	private $arResult;




	public function __construct(&$arResult){
		$this->arResult = $arResult;
	}

	public function setFieldName($fieldName){
		$this->fieldName = $fieldName;
		if ($this->arResult['ERRORS'][$this->fieldName]){
			$this->errorPlaceholder = true;
		} else {
			$this->errorPlaceholder = false;
		}
	}
	public function setErrorPrefix($prefix) {
		$this->errroPrefix = $prefix;
	}

	public function setErrorClass($className){
		$this->errorClass = $className;
	}


	public function getPlaceHolder(){

		if (isset($this->arResult['ERRORS'][ $this->fieldName])){
			return GetMessage('ERROR'); //$arResult['ERRORS'][$fieldName];
		} elseif (!empty($this->arResult['FORM'][$this->fieldName])){
			return ($this->arResult['FORM'][$this->fieldName]);
		} else {
			$placeholder = $this->arResult['HLBLOCK']['DISPLAY_FIELDS'][$this->fieldName]['EDIT_FORM_LABEL'];
			if ( $this->arResult['HLBLOCK']['DISPLAY_FIELDS'][$this->fieldName]['MANDATORY'] == 'Y') {
				$placeholder .= $this->errroPrefix;
			}
			return $placeholder ;
		}
	}

	public function getErrorClass(){
		if ($this->errorPlaceholder) {
			return $this->errorClass;
		}
	}

	public function isError(){
		return $this->errorPlaceholder;
	}
}