<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
    CJSCore::Init(array("jquery"));
    $templateFolder = $this->GetFolder();
    Bitrix\Main\Page\Asset::getInstance()->addJs($templateFolder."/vendor.js");
?>

<?if(!empty($_SESSION["MSG_PROFILE"])):?>
    <?=$_SESSION["MSG_PROFILE"]?>
	<?unset($_SESSION["MSG_PROFILE"]);?>
<?endif?>
<!--start component profile edit-->
<div class="profile-edit">
  <form class="" action="<?=$APPLICATION->GetCurPage()?>"  method="post">
  <?=bitrix_sessid_post()?>
  <div class="profile-info">
    <div class="table">
      <div class="table-row">
        <div class="table-cell">
          Тип профиля:
        </div>
        <?foreach($arResult["PERSON_TYPE"] as $key=>$ptype):?>
        <div class="table-cell">
          <div class="table-cell label-cell">
              <input type="radio" class="change-p-type" <?if($ptype["CHECKED"]):?>checked="checked" <?endif?> id="ptype-<?=$ptype["ID"]?>" name="PERSON_TYPE_ID" data-url="<?=$APPLICATION->GetCurPageParam('PERSON_TYPE_ID='.$ptype["ID"],array("PERSON_TYPE_ID"))?>" value="<?=$ptype["ID"]?>">
          </div>
          <div class="table-cell">
            <label for="ptype-<?=$ptype["ID"]?>"><?=$ptype["NAME"]?></label>
          </div>
        </div>
        <?endforeach?>
      </div>
    </div>
  </div>

    <div class="profile-input-block" id="group-id<?=$key?>">

      <div class="profile-input-item">
        <div class="profile-item-header">
          Данные профиля
        </div>
        <div class="table">
          <div class="table-row">
            <div class="table-cell">
              <label for="profile-input-zero">Название профиля:</label>
            </div>
            <div class="table-cell requare-input">
              <input type="text" name="PROFILE_NAME" class="grey-input <?if(in_array(0,$_SESSION["PROFILE"]["VALIDATE"])):?>error<?endif?>" id="profile-input-0" value="<?=$_SESSION["PROFILE"]["FORM_VALUE"][0]?>">
            </div>
            <div class="table-cell tip-cell">
              <i class="ic-info-tip vtip" title="Удобное для Вас название профиля покупателя">
              </i>
            </div>
          </div>
        </div>
      </div>
      <?foreach($arResult["PROFILE_PROPS"] as $key=>$grpoup):?>
      <div class="profile-input-item">
        <div class="profile-item-header">
          <?=$key?>
        </div>
        <div class="table">
          <?foreach($grpoup as $item):?>
              <?$currentValue = $_SESSION["PROFILE"]["FORM_VALUE"][$item["ID"]];?>
          <div class="table-row">
            <div class="table-cell">
              <label for="profile-input-<?=$item["ID"]?>"><?=$item["NAME"]?>:</label>
            </div>
            <div class="table-cell <?if($item["REQUIED"]=="Y"):?>requare-input<?endif?>">
                <?if($item["TYPE"] === "LOCATION"):?>
                    <?
                    CSaleLocation::proxySaleAjaxLocationsComponent(
                        array(
                            "AJAX_CALL" => "N",
                            'CITY_OUT_LOCATION' => 'Y',
                            'COUNTRY_INPUT_NAME' => 'PROP_'.$item["ID"],
                            'CITY_INPUT_NAME' => 'PROP_'.$item["ID"],
                            'LOCATION_VALUE' => '',
                        )
                    );
                    ?>
                 <?elseif($item["TYPE"] === "TEXT"):?>
                    <input type="text" name="PROP_<?=$item["ID"]?>" class="grey-input <?if(in_array($item["ID"],$_SESSION["PROFILE"]["VALIDATE"])):?>error<?endif?>" id="profile-input-<?=$item["ID"]?>" value="<?=(isset($currentValue)) ? $currentValue : $item["DEFAULT_VALUE"];?>">
                 <?elseif($item["TYPE"] === "TEXTAREA"):?>
                    <textarea
                            class="grey-input"
                            id="profile-input-<?=$item["ID"]?>"
                            name="PROP_<?=$item["ID"]?>"><?=(isset($currentValue)) ? $currentValue : $item["DEFAULT_VALUE"];?></textarea>
                <?elseif($item["TYPE"] == "CHECKBOX"):?>
                    <input
                            class="grey-input""
                            id="profile-input-<?=$item["ID"]?>"
                            type="checkbox"
                            name="PROP_<?=$item["ID"]?>"
                            value="Y"
                        <?if ($currentValue == "Y" || !isset($currentValue) && $item["DEFAULT_VALUE"] == "Y") echo " checked";?>/>
                <?elseif($item["TYPE"] == "SELECT"):?>
                    <select
                            class="grey-input"
                            name="PROP_<?=$item["ID"]?>"
                            id="profile-input-<?=$item["ID"]?>">
                        <?
                        foreach ($item["VALUES"] as $value)
                        {
                            ?>
                            <option value="<?= $value["VALUE"]?>" <?if ($value["VALUE"] == $currentValue || !isset($currentValue) && $value["VALUE"]==$property["DEFAULT_VALUE"]) echo " selected"?>>
                                <?= $value["NAME"]?>
                            </option>
                            <?
                        }
                        ?>
                    </select>
                <?endif?>



            </div>
            <div class="table-cell tip-cell">
                <?if(!empty($item["DESCRIPTION"])):?>
                    <i class="ic-info-tip vtip" title="<?=$item["DESCRIPTION"]?>"></i>
                <?endif?>
            </div>
          </div>
          <?endforeach?>
        </div>
      </div>
      <?endforeach?>
      <div class="row text-center">
        <button type="submit" name="save" value="Y" class="detail-link-btn">Добавить</button>
      </div>
    </div>
  </form>
</div>
<?//unset($_SESSION["PROFILE"])?>
<!--end component profile edit-->
