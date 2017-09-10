<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule('sale');

$arProfile = CSaleOrderUserProps::GetByID($_REQUEST["ID"]);

$arResult["PROFILE_DETAIL"] = $arProfile;

$APPLICATION->SetTitle($arProfile["NAME"], false);

$arResult["URL_TO_DETELE"] = $arParams["PATH_TO_DELETE"]."?del_id=".$arProfile["ID"]."&".bitrix_sessid_get();


$APPLICATION->AddChainItem($arProfile["NAME"], "");

$arFilter["USER_PROPS"] = "Y";
$arFilter["ACTIVE"] = "Y";
$orderPropsId = array();
$orderPropsVal = array();


$db_propVals = CSaleOrderUserPropsValue::GetList(array("ID" => "ASC"), Array("USER_PROPS_ID"=>$_REQUEST["ID"]));

while ($arPropVals = $db_propVals->Fetch())
{
  $orderPropsId[] = $arPropVals["ORDER_PROPS_ID"];
  $orderPropsVal[$arPropVals["ORDER_PROPS_ID"]] = $arPropVals["VALUE"];
}

$arFilter["ID"] = $orderPropsId;

$db_props = CSaleOrderProps::GetList(
  array("SORT" => "ASC"),
	$arFilter,
  array('PROPS_GROUP_ID',"NAME","ID"),
  false,
  array('PROPS_GROUP_ID',"NAME","ID")
);

while($profileRes = $db_props->Fetch()){
	if ($arPropsGroup = CSaleOrderPropsGroup::GetByID($profileRes["PROPS_GROUP_ID"]))
		$groupName = $arPropsGroup["NAME"];
    $profileRes["VALUE"] = $orderPropsVal[$profileRes["ID"]];
		$arResult["PROFILE_PROPS"][$groupName][] = $profileRes;
	}

$this->IncludeComponentTemplate();

?>
