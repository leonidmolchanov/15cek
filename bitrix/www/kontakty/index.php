<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("tags", "15cek");
$APPLICATION->SetPageProperty("keywords_inner", "15cek");
$APPLICATION->SetPageProperty("title", "15cek");
$APPLICATION->SetPageProperty("keywords", "15cek");
$APPLICATION->SetPageProperty("description", "15cek");
$APPLICATION->SetTitle("Контакты");
?>
    <div class="container">
    <div class="row">
    <div class="offset-top">
        <div class="space-80"></div>
        <div class="space-80"></div>
        <div class="row text-white wow fadeIn">
            <div class="col-xs-12 text-center">

                <a href="https://wa.me/79502291515"><button type="button" class="btn btn-whatsapp  btn-lg"><img src="<?=SITE_TEMPLATE_PATH?>/images/icon/whatsapp.svg"> WhatsApp</button></a>
                <a href="https://vk.com/moroz15cek"><button type="button" class="btn btn-vk  btn-lg"><img src="<?=SITE_TEMPLATE_PATH?>/images/icon/vk.svg"></button></a>
                <a href="mailto:inst15cek@gmail.com"><button type="button" class="btn btn-mail  btn-lg"><span class="ti-email"></span></button></a>
                <a href="https://telegram.me/moroz15cek"><button type="button" class="btn btn-telegram  btn-lg"><img src="<?=SITE_TEMPLATE_PATH?>/images/icon/telegram.svg"></button></a>
                <a href="#"><button type="button" class="btn btn-kik  btn-lg">Kik-moroz15cek</button></a>
                <div class="space-20"></div>
                <p><? echo $MESS['COPYRIGHT'];?></p>
            </div>
        </div>
        <div class="space-20"></div>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>