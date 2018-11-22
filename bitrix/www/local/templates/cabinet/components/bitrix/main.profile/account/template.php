<?
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
?>
<div class="br-profile-page">
    <div class="card shadow-base bd-0 rounded-0 widget-4">
        <div class="card-header ht-75">

        </div><!-- card-header -->
        <div class="card-body">
            <div class="card-profile-img">
                <?
                $renderImage = CFile::ResizeImageGet($arResult["arUser"]["PERSONAL_PHOTO"], Array("width" => 640, "height" => 640));
                echo CFile::ShowImage($renderImage['src'], 100, 100, "border=0", "", true);
                ?>
            </div><!-- card-profile-img -->
            <h4 class="tx-normal tx-roboto tx-white"><?=$arResult["arUser"]["NAME"]?> <?=$arResult["arUser"]["LAST_NAME"]?></h4>
            <p class="mg-b-25"><?=$arResult["arUser"]["TITLE"]?></p>


        </div><!-- card-body -->
    </div>
</div>

<div class="ht-70 bg-gray-100 pd-x-20 d-flex align-items-center justify-content-center shadow-base">
    <ul class="nav nav-outline active-info align-items-center flex-row" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#register-info" role="tab">Регистрационная информация</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#register-data" role="tab">Личные данные</a></li>
    </ul>
</div>

<?ShowError($arResult["strProfileError"]);?>
<?
if ($arResult['DATA_SAVED'] == 'Y')
    ShowNote(GetMessage('PROFILE_DATA_SAVED'));
?>
<script type="text/javascript">
    <!--
    var opened_sections = [<?
        $arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
        $arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
        if (strlen($arResult["opened"]) > 0)
        {
            echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
        }
        else
        {
            $arResult["opened"] = "reg";
            echo "'reg'";
        }
        ?>];
    //-->

    var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
</script>
<form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
    <?=$arResult["BX_SESSION_CHECK"]?>
    <input type="hidden" name="lang" value="<?=LANG?>" />
    <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
<div class="tab-content br-profile-body">
    <div class="tab-pane fade active show" id="register-info" aria-expanded="true">
        <div class="row">
            <div class="col-lg-8">
                <div class="br-section-wrapper">
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Регистрационная информация</h6>
                    <p class="mg-b-30 tx-gray-600"><? if ($arResult['DATA_SAVED'] == 'Y')
                            ShowNote(GetMessage('PROFILE_DATA_SAVED'));
                        ?></p>

                    <div class="form-layout form-layout-1">
                        <div class="row mg-b-25">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label"><?=GetMessage('NAME')?> <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" placeholder="Введите имя">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label"><?=GetMessage('LAST_NAME')?> <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="LAST_NAME" maxlength="50" value="<?=$arResult["arUser"]["LAST_NAME"]?>" placeholder="Введите фамилию">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label"><?=GetMessage('SECOND_NAME')?> <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="SECOND_NAME" maxlength="50" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" placeholder="Введите отчество">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label class="form-control-label"><?=GetMessage('EMAIL')?> <span class="tx-danger">*</span></label>
                                    <input class="form-control" ttype="text" name="EMAIL" maxlength="50" value="<? echo $arResult["arUser"]["EMAIL"]?>" placeholder="Введите email">
                                </div>
                            </div><!-- col-8 -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label"><?echo GetMessage("main_profile_title")?> <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="TITLE" maxlength="50" value="<?=$arResult["arUser"]["TITLE"]?>" placeholder="Обращение">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label"><?=GetMessage('LOGIN')?> <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="text" name="LOGIN" maxlength="50" value="<? echo $arResult["arUser"]["LOGIN"]?>" placeholder="">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label"><?=GetMessage('NEW_PASSWORD_REQ')?> <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off"  placeholder="Введите новый пароль">
                                </div>
                            </div><!-- col-4 -->
                            <?if($arResult["SECURE_AUTH"]):?>
                                <span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
                                <noscript>
				<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
                                </noscript>
                                <script type="text/javascript">
                                    document.getElementById('bx_auth_secure').style.display = 'inline-block';
                                </script>
                            <?endif?>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label"><?=GetMessage('NEW_PASSWORD_CONFIRM')?> <span class="tx-danger">*</span></label>
                                    <input class="form-control" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off" placeholder="Введите подтверждение пароля">
                                </div>
                            </div><!-- col-4 -->
                        </div><!-- row -->
                        <div class="row">

                                <input type="submit" class="btn btn-info mg-l-25 mg-r-25" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>">
                                <input class="btn btn-secondary mg-l-25 mg-r-25" type="reset"  value="<?=GetMessage('MAIN_RESET');?>">
                        </div>

                    </div>

                </div>
            </div><!-- col-lg-8 -->
        </div><!-- row -->
    </div><!-- tab-pane -->
    <div class="tab-pane fade" id="register-data" aria-expanded="true">
        <div class="row">
            <div class="col-lg-8">
                <div class="br-section-wrapper">
                    <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Личные данные</h6>
                    <p class="mg-b-30 tx-gray-600"><? if ($arResult['DATA_SAVED'] == 'Y')
                            ShowNote(GetMessage('PROFILE_DATA_SAVED'));
                        ?></p>

                    <div class="form-layout form-layout-1">
                        <div class="row mg-b-25">
                            <div class="col-lg-4">


                                <label class="form-control-label"><?=GetMessage('USER_GENDER')?></label>
                                <select class="form-control select2 select2-hidden-accessible" name="PERSONAL_GENDER" aria-hidden="true">
                                    <option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
                                    <option value="M"<?=$arResult["arUser"]["PERSONAL_GENDER"] == "M" ? " SELECTED=\"SELECTED\"" : ""?>><?=GetMessage("USER_MALE")?></option>
                                    <option value="F"<?=$arResult["arUser"]["PERSONAL_GENDER"] == "F" ? " SELECTED=\"SELECTED\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
                                </select>
                            </div><!-- col-4 -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label"><?=GetMessage("USER_BIRTHDAY_DT")?> (<?=$arResult["DATE_FORMAT"]?>): </label>
<?
                                        $APPLICATION->IncludeComponent(
                                            'bitrix:main.calendar',
                                            '',
                                            array(
                                                'SHOW_INPUT' => 'Y',
                                                'FORM_NAME' => 'form1',
                                                'INPUT_NAME' => 'PERSONAL_BIRTHDAY',
                                                'INPUT_VALUE' => $arResult["arUser"]["PERSONAL_BIRTHDAY"],
                                                'SHOW_TIME' => 'N'
                                            ),
                                            null,
                                            array('HIDE_ICONS' => 'Y')
                                        );

                                        //=CalendarDate("PERSONAL_BIRTHDAY", $arResult["arUser"]["PERSONAL_BIRTHDAY"], "form1", "15")
                                        ?>
                                </div>
                            </div><!-- col-4 -->

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label"><?=GetMessage("USER_PHOTO")?> </label>

                            <?
                                    if (strlen($arResult["arUser"]["PERSONAL_PHOTO"])>0)
                                    {
                                        ?>
                                        <br />
                                        <?=$arResult["arUser"]["PERSONAL_PHOTO_HTML"]?>
                                        <?
                                    }
                                    ?>
                            </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label"><?=GetMessage("USER_PHOTO")?> </label>

                                <?=$arResult["arUser"]["PERSONAL_PHOTO_INPUT"]?>
                                </div>
                            </div>
                        </div><!-- row -->
                        <div class="row">

                            <input type="submit" class="btn btn-info mg-l-25 mg-r-25" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?>">
                            <input class="btn btn-secondary mg-l-25 mg-r-25" type="reset"  value="<?=GetMessage('MAIN_RESET');?>">
                        </div>

                    </div><!-- form-layout -->


                </div>
            </div><!-- col-lg-8 -->
        </div><!-- row -->
    </div><!-- tab-pane -->

</div>

</form>
