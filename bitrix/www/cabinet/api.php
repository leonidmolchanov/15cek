<?
require_once ($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
if($_REQUEST['sessid']==bitrix_sessid()):
    CModule::IncludeModule('iblock');
    if($_REQUEST['type']=='add'):
    $el = new CIBlockElement;

    $PROP = array();
    $PROP['SSID'] = $_REQUEST['accSsid'];  // свойству с кодом 12 присваиваем значение "Белый"
    $PROP['ID'] = $_REQUEST['accId'];  // свойству с кодом 12 присваиваем значение "Белый"
        $PROP['CSRFTOKEN'] = $_REQUEST['accCsrftocken'];  //

        $arLoadProductArray = Array(
        "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
        "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
        "IBLOCK_ID"      => 5,
        "PROPERTY_VALUES"=> $PROP,
        "NAME"           => $_REQUEST['accName'],
        "ACTIVE"         => "Y"
    );

    if($PRODUCT_ID = $el->Add($arLoadProductArray)):

    else:
        header('x', true, 404);
endif;
elseif($_REQUEST['type']=='delete'):
    if(!CIBlockElement::Delete((int)$_REQUEST['blockId']))
    {
        header('x', true, 404);
    }
    else{
}
    elseif($_REQUEST['type']=='setDefaultAcc'):
        $accountsArr = json_decode($_REQUEST['accountsArr']);
        $PROPERTY_VALUE = 0 ;  // значение свойства
        $PROPERTY_CODE = "MAIN";  // код свойства
        foreach ($accountsArr as &$value) {
            CIBlockElement::SetPropertyValuesEx((int)$value, false, array($PROPERTY_CODE => $PROPERTY_VALUE));
        }
        $PROPERTY_VALUE = 1 ;  // значение свойства

        $ELEMENT_ID = (int)$_REQUEST['blockId'];
        CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, false, array($PROPERTY_CODE => $PROPERTY_VALUE));
    elseif($_REQUEST['type']=='nodeGetUser'):
echo "active";
    elseif($_REQUEST['type']=='change'):

        $el = new CIBlockElement;

        $PROP = array();
        $PROP['SSID'] = $_REQUEST['accSsid'];  // свойству с кодом 12 присваиваем значение "Белый"
        $PROP['ID'] = $_REQUEST['accId'];  // свойству с кодом 12 присваиваем значение "Белый"
        $PROP['CSRFTOKEN'] = $_REQUEST['accCsrftocken'];  // свойству с кодом 12 присваиваем значение "Белый"
        $arLoadProductArray = Array(
            "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
            "IBLOCK_SECTION" => false,          // элемент лежит в корне раздела
            "PROPERTY_VALUES"=> $PROP,
            "NAME"           => $_REQUEST['accName'],
            "ACTIVE"         => "Y"            // активен
        );

        $PRODUCT_ID = $_REQUEST['blockId'];  // изменяем элемент с кодом (ID) 2
        if($res = $el->Update($PRODUCT_ID, $arLoadProductArray)):

            else:
                header('x', true, 404);

        endif;


    endif;
else:
//header('x', true, 404);
endif;
?>