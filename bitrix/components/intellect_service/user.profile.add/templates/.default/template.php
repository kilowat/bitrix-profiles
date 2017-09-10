<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
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
          <div class="table-row">
            <div class="table-cell">
              <label for="profile-input-<?=$item["ID"]?>"><?=$item["NAME"]?>:</label>
            </div>
            <div class="table-cell <?if($item["REQUIED"]=="Y"):?>requare-input<?endif?>">
              <input type="text" name="PROP_<?=$item["ID"]?>" class="grey-input <?if(in_array($item["ID"],$_SESSION["PROFILE"]["VALIDATE"])):?>error<?endif?>" id="profile-input-<?=$item["ID"]?>" value="<?=$_SESSION["PROFILE"]["FORM_VALUE"][$item["ID"]]?>">
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
