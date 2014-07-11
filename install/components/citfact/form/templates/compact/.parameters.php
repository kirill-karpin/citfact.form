<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array();

$arTemplateParameters["FORM_TITLE"] = array(
	"NAME"  => GetMessage('FORM_TITLE'),
	"TYPE"    => "STRING",
	"DEFAULT" => GetMessage('FORM_TITLE'),
);

	$arTemplateParameters["FORM_TITLE_ENG"] = array(
		"NAME"  => GetMessage('FORM_TITLE_ENG'),
		"TYPE"    => "STRING",
		"DEFAULT" => GetMessage('FORM_TITLE_ENG'),
	);


$arTemplateParameters["PHONE_FIELD"] = array(
		"NAME"    => GetMessage('PHONE_FIELD'),
		"TYPE"    => "STRING",
		"DEFAULT" => "UF_PHONE",
);
