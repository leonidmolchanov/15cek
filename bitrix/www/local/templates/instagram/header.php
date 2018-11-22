<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>
<!doctype html>
<html class="no-js" lang="<?=LANGUAGE_ID;?>">

<head>
    <?$APPLICATION->ShowHead();?>
    <title><?$APPLICATION->ShowTitle()?></title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" href="<?=SITE_TEMPLATE_PATH?>/images/apple-touch-icon.png">
    <link rel="shortcut icon" type="image/ico" href="<?=SITE_TEMPLATE_PATH?>/images/favicon.ico" />

    <!-- Plugin-CSS -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/themify-icons.css">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/animate.css">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/magnific-popup.css">

    <!-- Main-Stylesheets -->
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/space.css">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/theme.css">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/overright.css">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/normalize.css">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/style.css">
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/responsive.css">
    <script src="<?=SITE_TEMPLATE_PATH?>/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body data-spy="scroll" data-target="#mainmenu" data-offset="50">
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="preloade">
    <span><i class="ti-mobile"></i></span>
</div>

<!--Header-Area-->
<header class="blue-bg relative fix" id="home">
    <div class="section-bg overlay-bg angle-bg ripple ">
        <div class="parallax-image">
            <img src="<?=SITE_TEMPLATE_PATH?>/images/header-bg.jpg" alt="">
        </div>
    </div>
    <!--Mainmenu-->
    <!--Mainmenu-->
<!--    <nav class="navbar navbar-default mainmenu-area navbar-fixed-top" data-spy="affix" data-offset-top="60">-->
<!--        <div class="container">-->
<!--            <div class="navbar-header">-->
<!--                <button type="button" data-toggle="collapse" class="navbar-toggle" data-target="#mainmenu">-->
<!--                    <span class="icon-bar"></span>-->
<!--                    <span class="icon-bar"></span>-->
<!--                    <span class="icon-bar"></span>-->
<!--                </button>-->
<!--                <a href="#" class="navbar-brand">-->
<!--                    <!--<img src="images/logo.png" alt="">-->-->
<!--                    <h2 class="text-white logo-text">--><?// echo $MESS['LEFT_LOGO_TEXT'];?><!--</h2>-->
<!--                </a>-->
<!--            </div>-->
<!---->
<!--    --><?//$APPLICATION->IncludeComponent(
//        "bitrix:menu",
//        "top_menu",
//        array(
//            "ALLOW_MULTI_SELECT" => "N",
//            "CHILD_MENU_TYPE" => "left",
//            "DELAY" => "N",
//            "MAX_LEVEL" => "1",
//            "MENU_CACHE_GET_VARS" => array(
//            ),
//            "MENU_CACHE_TIME" => "3600",
//            "MENU_CACHE_TYPE" => "N",
//            "MENU_CACHE_USE_GROUPS" => "Y",
//            "ROOT_MENU_TYPE" => "top",
//            "USE_EXT" => "N",
//            "COMPONENT_TEMPLATE" => "top_menu"
//        ),
//        false
//    );?>
<!--        </div>-->
<!--    </nav>-->
    <!--Mainmenu/-->
    <!--Header-Text-->
    <div class="container text-white">

        <div class="row text-center">
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <div class="row">
                    <div class="col-sm-12">
                        <img src="<?=SITE_TEMPLATE_PATH?>/images/15cek_logo.png" alt="">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                    <div class="col-sm-3">
                        <a href="whatsapp://send?phone=+79502291515"><button type="button" class="btn btn-whatsapp  btn-sm"><img src="<?=SITE_TEMPLATE_PATH?>/images/icon/whatsapp.svg"> WhatsApp</button></a>
                    </div>
                    <div class="col-sm-3">
                        <a href="tg://resolve?domain=moroz15cek"><button type="button" class="btn btn-telegram  btn-sm"><img src="<?=SITE_TEMPLATE_PATH?>/images/icon/telegram.svg"></button></a>
                    </div>
                    <div class="col-sm-3">
                        <a href="https://vk.com/moroz15cek"><button type="button" class="btn btn-vk  btn-sm"><img src="<?=SITE_TEMPLATE_PATH?>/images/icon/vk.svg"></button></a>
                    </div>
                <div class="col-sm-3">
                    <a href="mailto:inst15cek@gmail.com"><button type="button" class="btn btn-mail  btn-sm"><span class="ti-email"></span></button></a>
                 </div>
<!--                    <div class="col-sm-2">-->
<!--                    <a href="#"><button type="button" class="btn btn-kik  btn-sm">Kik-moroz15cek</button></a>-->
<!--                    </div>-->
<!--                <div class="col-sm-2">-->
<!--                </div>-->
                </div>
                <!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in </p>
                <div class="space-20"></div>
                <a href="#" class="btn btn-white">Google play</a>
                <a href="#" class="btn btn-white">App store</a>
                -->
        </div>
    </div>
    <!--Header-Text/-->
</header>
<!--Header-Area/-->