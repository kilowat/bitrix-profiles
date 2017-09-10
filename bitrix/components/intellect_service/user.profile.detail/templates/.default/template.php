<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<!--start component profile detail-->
<div class="profile-detail">
  <div class="content-block">
    <div class="prop-block">

      <div class="row">
        <?foreach($arResult["PROFILE_PROPS"] as $key=>$props):?>
        <div class="row">
          <div class="prop-header"><?=$key?></div>
          <div class="prop-list">
            <div class="table">
              <?foreach($props as $prop):?>
              <div class="table-row">
                <div class="table-cell">
                  <?=$prop["NAME"]?>:
                </div>
                <div class="table-cell">
                  <?=$prop["VALUE"]?>
                </div>
              </div>
              <?endforeach?>
            </div>
          </div>
        </div>
        <?endforeach?>
      </div>

    </div>
    <div class="action-block">
      <div class="buttons-row ">
        <a href="<?=$arParams["PATH_TO_EDIT"]?>?ID=<?=$arResult["PROFILE_DETAIL"]["ID"]?>" title="" class="detail-link-btn blue confirm"><span><i class="ic-dialog-round"></i></span>Редактировать</a>
      </div>
      <div class="buttons-row ">
        <a href="<?=$arResult["URL_TO_DETELE"]?>" class="detail-link-btn red cancel" onclick="return app.profile.del(this)" title=""><span><i class="ic-cancel"></i></span> Удалить</a>
      </div>
    </div>
  </div>

</div>
<!--end component profile detail-->
