<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("sale");

$APPLICATION->AddChainItem("Добавление профиля покупателя");

global
$arFilter;

$validateArr = array();
//get person type
$db_ptype = CSalePersonType::GetList(Array("SORT" => "DESC"), Array("LID"=>SITE_ID));
$bFirst = True;
while ($ptype = $db_ptype->Fetch())
{
	$ptype["CHECKED"] = false;
	$arResult["PERSON_TYPE"][] = $ptype;
}

$arFilter["PERSON_TYPE_ID"] = $arResult["PERSON_TYPE"][0]["ID"];
foreach($arResult["PERSON_TYPE"] as &$persType){
	if(!empty($arFilter["PERSON_TYPE_ID"])){
		if($_SESSION["PROFILE_FILTER"]["PERSON_TYPE_ID"] == $persType["ID"]){
			$persType["CHECKED"] = true;
		}else{
			$arResult["PERSON_TYPE"][0]["CHECKED"] = true;
		}
	}
}


if(!empty($_REQUEST["PERSON_TYPE_ID"])){
		$arFilter["PERSON_TYPE_ID"] = $_REQUEST["PERSON_TYPE_ID"];
		$_SESSION["PROFILE_FILTER"]["PERSON_TYPE_ID"] =  $_REQUEST["PERSON_TYPE_ID"];
}elseif(!empty($_SESSION["PROFILE_FILTER"]["PERSON_TYPE_ID"])){
		$arFilter["PERSON_TYPE_ID"] = $_SESSION["PROFILE_FILTER"]["PERSON_TYPE_ID"];
}

$arFilter["USER_PROPS"] = "Y";
$arFilter["ACTIVE"] = "Y";
	$db_props = CSaleOrderProps::GetList(
	        array("SORT" => "ASC"),
					$arFilter,
	        array('PROPS_GROUP_ID',"NAME","ID","DESCRIPTION","REQUIED", "TYPE", "DEFAULT_VALUE"),
	        false,
	        array('PROPS_GROUP_ID',"NAME","ID","DESCRIPTION","REQUIED", "TYPE", "DEFAULT_VALUE")
	    );

	while($profileRes = $db_props->Fetch()){
		if ($arPropsGroup = CSaleOrderPropsGroup::GetByID($profileRes["PROPS_GROUP_ID"]))
			$groupName = $arPropsGroup["NAME"];

		switch($profileRes["TYPE"]){
			case "SELECT":
                $dbVarsSelect = CSaleOrderPropsVariant::GetList(
                    array("SORT" => "ASC"),
                    array("ORDER_PROPS_ID" => $profileRes["ID"])
                );var_dump($dbVarsSelectValues = $dbVarsSelect->Fetch());
                while ($dbVarsSelectValues = $dbVarsSelect->Fetch())
                {
                    var_dump($dbVarsSelectValues);
                    $profileRes["VALUES"][] = $dbVarsSelectValues;
                }
				//var_dump($profileRes);
				break;
		}

		//var_dump($profileRes);

		$arResult["PROFILE_PROPS"][$groupName][] = $profileRes;
	}


if($_POST["save"] && check_bitrix_sessid()){

	$_SESSION["PROFILE"]["FORM_VALUE"][0] = $_REQUEST["PROFILE_NAME"];

	if(empty($_REQUEST["PROFILE_NAME"])){
		$validateArr[] = 0; // 0 -is profile name id
	}
	$PERSON_TYPE_ID = intval($_REQUEST["PERSON_TYPE_ID"]);

	$arFields = array(
		 "NAME" => $_REQUEST["PROFILE_NAME"],
		 "USER_ID" => $USER->GetID(),
		 "PERSON_TYPE_ID" => $PERSON_TYPE_ID,
	);

	if(count($validateArr) == 0){

		$userProfileProps = array();

		foreach($_REQUEST as $key=>$request){
			if(preg_match('/PROP_/', $key)){
				$PROP_ID = explode("_", $key)[1];

				$PROP_INFO = CSaleOrderProps::GetByID($PROP_ID);
				$_SESSION["PROFILE"]["FORM_VALUE"][$PROP_ID] = $request;
				if($PROP_INFO["REQUIED"] == "Y"){
					if(empty($request)){
						$validateArr[] = $PROP_ID;
					}
				}
				$userProfileProps[] = array(
				    "USER_PROPS_ID" => false,
		 	   	    "ORDER_PROPS_ID" => $PROP_ID,
		 	        "VALUE" => $request,
                    "NAME" => $PROP_INFO["NAME"]
				);
			}
		}
		if(count($validateArr) == 0){

			$USER_PROPS_ID = CSaleOrderUserProps::Add($arFields);
			foreach($userProfileProps as $addProps){
				$addProps["USER_PROPS_ID"] = $USER_PROPS_ID;
				CSaleOrderUserPropsValue::Add($addProps);
				if($USER_PROPS_ID){
					$_SESSION["MSG_PROFILE"] = "Новый профиль покупателя успешно добавлен";

				}else{
					$_SESSION["MSG_PROFILE"] = "При добавлении профиля возникла ошибка, попробуйте позже или обратитесь в техническую поддержку";
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
