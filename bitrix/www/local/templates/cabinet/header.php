<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?$APPLICATION->ShowHead();?>
    <title><?$APPLICATION->ShowTitle()?></title>
    <?
    use Bitrix\Main\Page\Asset;
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/lib/font-awesome/css/font-awesome.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/lib/Ionicons/css/ionicons.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/lib/perfect-scrollbar/css/perfect-scrollbar.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/lib/jquery-switchbutton/jquery.switchButton.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/lib/rickshaw/rickshaw.min.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/lib/chartist/chartist.css");
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/bracket.css");
    ?>
</head>

<body>
<!-- ########## START: LEFT PANEL ########## -->

<?$APPLICATION->IncludeComponent("bitrix:menu", "left_menu", Array(
    "COMPONENT_TEMPLATE" => "vertical_multilevel",
    "ROOT_MENU_TYPE" => "left",	// Тип меню для первого уровня
    "MENU_CACHE_TYPE" => "N",	// Тип кеширования
    "MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
    "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
    "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
    "MAX_LEVEL" => "1",	// Уровень вложенности меню
    "CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
    "USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
    "DELAY" => "N",	// Откладывать выполнение шаблона меню
    "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
),
    false
);?>
<!-- ########## END: LEFT PANEL ########## -->

<!-- ########## START: HEAD PANEL ########## -->
<?$APPLICATION->ShowPanel()?>
<div class="br-header">
    <div class="br-header-left">
        <?
        global $USER;
        if ($USER->IsAuthorized()){ ?>
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
            <?
        }else{

        }
        ?>
    </div><!-- br-header-left -->
    <div class="br-header-right">
        <?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth", Array(
            "FORGOT_PASSWORD_URL" => "",	// Страница забытого пароля
            "PROFILE_URL" => "/cabinet/",	// Страница профиля
            "REGISTER_URL" => "",	// Страница регистрации
            "SHOW_ERRORS" => "N",	// Показывать ошибки
        ),
            false
        );?>


    </div><!-- br-header-right -->
</div><!-- br-header -->
<!-- ########## END: HEAD PANEL ########## -->


<!-- ########## START: MAIN PANEL ########## -->
<div class="br-mainpanel">
    <div class="">
        <h4 class="tx-gray-800 mg-b-5"><?$APPLICATION->ShowTitle()?></h4>