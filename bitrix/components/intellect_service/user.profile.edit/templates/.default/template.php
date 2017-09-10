<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if(!empty($_SESSION["MSG_PROFILE"])):?>
	<script type="text/javascript">
		app.utils.showAlert({title:"Редактирование профиля", text:"<?=$_SESSION["MSG_PROFILE"]?>"});
	</script>
	<?unset($_SESSION["MSG_PROFILE"]);?>
<?endif?>
<?if(!empty($arResult["PROFILE_DETAIL"]["ID"])):?>
<!--start component profile edit-->
<div class="profile-edit">
  <form class="" action="<?=$APPLICATION->GetCurPageParam("ID=".$arResult["PROFILE_DETAIL"]["ID"], array("ID"))?>"  method="post">
  <?=bitrix_sessid_post()?>
	<input type="hidden" name="ID" value="<?=$arResult["PROFILE_DETAIL"]["ID"]?>">
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
              <input type="text" name="PROFILE_NAME" class="grey-input <?if(in_array(0,$_SESSION["PROFILE"]["VALIDATE"])):?>error<?endif?>" id="profile-input-0" value="<?=$arResult["PROFILE_DETAIL"]["NAME"]?>">
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
              <input type="text" name="PROP_<?=$item["PROFILE_PROP_ID"]?>" class="grey-input <?if(in_array($item["PROFILE_PROP_ID"],$_SESSION["PROFILE"]["VALIDATE"])):?>error<?endif?>" id="profile-input-<?=$item["ID"]?>" value="<?=$item["VALUE"]?>">
            </div>
            <?if(!empty($item["DESCRIPTION"])):?>
            <div class="table-cell tip-cell">
              <i class="ic-info-tip vtip" title="<?=$item["DESCRIPTION"]?>">
              </i>
            </div>
            <?endif?>
          </div>
          <?endforeach?>
        </div>
      </div>
      <?endforeach?>
      <div class="row text-center">
        <button type="submit" name="save" value="Y" class="detail-link-btn">Сохранить</button>
      </div>
    </div>
  </form>
</div>
<?endif?>
<?//unset($_SESSION["PROFILE"])?>
<!--end component profile edit-->
