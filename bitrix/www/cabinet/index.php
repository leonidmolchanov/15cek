<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
?><?
global $USER;
if ($USER->IsAuthorized()){

    $APPLICATION->IncludeComponent(
        "bitrix:main.profile",
        "account",
        array(
            "CHECK_RIGHTS" => "N",
            "SEND_INFO" => "N",
            "SET_TITLE" => "Y",
            "USER_PROPERTY" => array(
            ),
            "USER_PROPERTY_NAME" => "",
            "COMPONENT_TEMPLATE" => "account"
        ),
        false
    );
}else{
    echo "Ты не авторизован!";
}
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>