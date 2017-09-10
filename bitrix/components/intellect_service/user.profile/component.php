<?php
use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs('/bitrix/components/intellect_service/user.profile/templates/.default/vendor.js');

$componentPage = "add";

$this->IncludeComponentTemplate($componentPage);