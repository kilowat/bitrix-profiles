<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("sale");

if(empty($_REQUEST["ID"]))
	LocalRedirect("/personal/customer-profiles/");

$arProfile = CSaleOrderUserProps::GetByID($_REQUEST["ID"]);

$arResult["PROFILE_DETAIL"] = $arProfile;

$APPLICATION->SetTitle($arProfile["NAME"], false);

$APPLICATION->AddChainItem("Редактировать".$arProfile["NAME"], "");

global
$arFilter;

$validateArr = array();

$arFilter["USER_PROPS"] = "Y";
$arFilter["ACTIVE"] = "Y";
$orderPropsId = array();
$orderPropsVal = array();
$profileProps = array();

$db_propVals = CSaleOrderUserPropsValue::GetList(array("ID" => "ASC"), Array("USER_PROPS_ID"=>$_REQUEST["ID"]));

while ($arPropVals = $db_propVals->Fetch())
{
  $orderPropsId[] = $arPropVals["ORDER_PROPS_ID"];
  $orderPropsVal[$arPropVals["ORDER_PROPS_ID"]] = array("VALUE"=>$arPropVals["VALUE"], "PROFILE_PROP_ID"=>$arPropVals["ID"]);
	$profileProps[$arPropVals["ID"]] = $arPropVals;
}

$arFilter["ID"] = $orderPropsId;

$db_props = CSaleOrderProps::GetList(
  array("SORT" => "ASC"),
	$arFilter,
  array('PROPS_GROUP_ID',"NAME","ID","REQUIED", "DESCRIPTION"),
  false,
  array('PROPS_GROUP_ID',"NAME","ID", "REQUIED","DESCRIPTION")
);

while($profileRes = $db_props->Fetch()){
	if ($arPropsGroup = CSaleOrderPropsGroup::GetByID($profileRes["PROPS_GROUP_ID"]))
		$groupName = $arPropsGroup["NAME"];
    $profileRes["VALUE"] = $orderPropsVal[$profileRes["ID"]]["VALUE"];
		$profileRes["PROFILE_PROP_ID"] = $orderPropsVal[$profileRes["ID"]]["PROFILE_PROP_ID"];
		$arResult["PROFILE_PROPS"][$groupName][] = $profileRes;
	}


if($_POST["save"] && check_bitrix_sessid()){

	if(empty($_REQUEST["PROFILE_NAME"])){
		$validateArr[] = 0; //profile name id
	}

	$_SESSION["PROFILE"]["FORM_VALUE"][0] = $_REQUEST["PROFILE_NAME"];


	if(count($validateArr) == 0){

		$userProfileProps = array();

		foreach($_REQUEST as $key=>$request){
			if(preg_match('/PROP_/', $key)){
				$PROP_ID = explode("_", $key)[1];
				$curProfileProp = $profileProps[$PROP_ID];

				$_SESSION["PROFILE"]["FORM_VALUE"][$PROP_ID] = $request;
				if($curProfileProp["PROP_REQUIED"] == "Y"){
					if(empty($request)){
						$validateArr[] = $PROP_ID;
					}
				}
				$userProfileProps[] = array(
		 	   "VALUE" => $request,
				 "PROFILE_PROP_ID"=>$PROP_ID,
				);
			}
		}
		if(count($validateArr) == 0){
			$arFields = array(
				 "NAME" => $_REQUEST["PROFILE_NAME"],
			);
			$USER_PROPS_ID = CSaleOrderUserProps::update($arProfile["ID"], $arFields);

			foreach($userProfileProps as $addProps){
				CSaleOrderUserPropsValue::update($addProps["PROFILE_PROP_ID"], array("VALUE"=>$addProps["VALUE"]));

				if($USER_PROPS_ID){
					$_SESSION["MSG_PROFILE"] = "Профиль покупателя успешно обновлен";
					LocalRedirect($APPLICATION->GetCurPageParam("ID=".$arResult["PROFILE_DETAIL"]["ID"], array("ID")));
				}else{
					$_SESSION["MSG_PROFILE"] = "При обновлении профиля возникла ошибка, попробуйте позже или обратитесь в техническую поддержку";
				}
				unset($_SESSION["PROFILE"]);

			}
		}else{
			$_SESSION["PROFILE"]["VALIDATE"]= $validateArr;
		}

	}else{
		$_SESSION["PROFILE"]["VALIDATE"]= $validateArr;
	}
	$_SESSION["PROFILE"]["VALIDATE"]= $validateArr;
}

$this->IncludeComponentTemplate();

unset($_SESSION["PROFILE"]);
?>
