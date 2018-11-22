<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require("include/settings.php");
?>
   <? if ($USER->IsAuthorized()){ ?>

    <script>
        accounts=[];
    </script>
    <?
    if (CModule::IncludeModule("iblock")):

        $arSelect = Array("ID", "NAME", "PROPERTY_SSID", "PROPERTY_ID", "PROPERTY_CSRFTOKEN", "PROPERTY_MAIN");
        $arFilter = Array("IBLOCK_ID"=>$IBLOCK_ID);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        $i=0;
        while($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();
            ?>
            <script>
                accounts.push(["<?=$arFields['NAME']?>","<?=$i?>","<?=$arFields['PROPERTY_SSID_VALUE']?>","<?=$arFields['ID']?>","<?=$arFields['PROPERTY_CSRFTOKEN_VALUE']?>","<?=$arFields['PROPERTY_MAIN_VALUE']?>"]);
            </script>
            <?
            $i++;
        }
    endif;
    ?>
<div class="" id="spinner">
    <div class="d-flex  ht-300 pos-relative align-items-center">
           <img src="<?=SITE_TEMPLATE_PATH?>/img/loading.gif" alt="Загрузка" >
    </div>
    <div class="d-flex  ht-200 pos-relative align-items-center">
    <div class="progress-bar progress-bar-lg wd-100p" role="progressbar" id="progressLine" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id="progress"></span></div>
    </div>
    <div class="row">
    <button type="button"   onclick="reloadPage()" class="btn btn-success tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Остановить</button>
    </div>
</div>
    <div class="br-pagebody" id="pageWindow">
        <div class="br-section-wrapper">

            <div class="row" id="alert">


            </div>

            <form>
            <div class="row" id="searchPanel">
                <div class="col-lg">
                    Имя аккаунта:<input class="form-control mr-sm-2 my-sm-0" id="accName" placeholder="Имя аккаунта" type="text">
                </div><!-- col -->
                <div class="col-lg mg-t-10 mg-lg-t-0">
                    Глубина просмотра:<select  class="form-control mr-sm-2 my-sm-0" id="accCount">
                        <option  value="0">Неограничено</option>
                        <option  selected value="2">60</option>
                        <option value="3">90</option>
                        <option value="4">120</option>
                        <option value="5">150</option>
                        <option value="6">180</option>
                    </select>
                </div><!-- col -->
                <div class="col-lg mg-t-10 mg-lg-t-0">
                    Тип фильтра:<select onchange="changeFilterType()" class="form-control mr-sm-2 my-sm-0" id="filterType">
                        <option selected="" value="rang">По рейтингу</option>
                        <option value="highFiler">Умный фильтр</option>
                    </select>
                </div><!-- col -->
                <div class="col-lg mg-t-10 mg-lg-t-0" id="HighFilterDiv"> Шаг:
                <select id="HighFilter" class="form-control mr-sm-2 my-sm-0"  name="highFilterInterval">
                    <option value="5">5</option>
                    <option selected value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    <option value="30">30</option>
                </select>
                </div>
                <div class="col-lg mg-t-10 mg-lg-t-0">
                    запрос от:<select  id="accountsMenu" class="form-control mr-sm-2 my-sm-0">
                    </select>
                </div><!-- col -->
                <div class="col-lg mg-t-10 mg-lg-t-0">
                    <br>
                    <button type="button"   onclick="getPost(this.form)" class="btn btn-success tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Запросить</button>
                </div>
                </div>
        </form>
            <div class="row mg-t-10 mg-b-10">
                <div class="col-lg">
                    <button type="button"   onclick="move('back')" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Назад</button>
                </div>
                <div class="col-lg">
                    <button type="button"   onclick="move('next')" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Вперед</button>
                </div>
            </div>
            <div class="row" id="postContentDiv">

            </div>


    </div>
    </div>

    <script>
        document.getElementById("spinner").style.display = "none";
        document.getElementById("HighFilterDiv").style.display="none";
        getPostArr=[];
        movePosition=0;
        ws = new WebSocket ('ws://15cek.ru:8090/<?=bitrix_sessid_get()?>');
        ws.onopen = function() {
            console.log("Соединение установлено.");
        };

        ws.onclose = function(event) {
            console.log("соединение закрыто");
        }
        ws.onmessage = function(message) {
            message = JSON.parse(message.data)
            if(message.action == "loadPostModule"){
                document.getElementById('progress').innerText = "";
                console.log("module");
                getPostArr=[];
            }

            else if(message.action == "subscription"){

if(message.head=="OK"){
    $("#alert").empty();
    $("#alert").append('<div class="alert alert-bordered pd-y-20" role="alert">\n' +
        '                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
        '                        <span aria-hidden="true">&times;</span>\n' +
        '                    </button>\n' +
        '                    <div class="d-flex align-items-center justify-content-start">\n' +
        '                        <i class="icon ion-ios-close success-icon tx-52 tx-success mg-r-20"></i>\n' +
        '                        <div>\n' +
        '                            <h5 class="mg-b-2 tx-success">Заявка на подписку отправлена!</h5>\n' +
        '                        </div>\n' +
        '                    </div>\n' +
        '                </div>');
}

            }

            else if(message.action == "startSendPosts"){
                $("#postContentDiv").empty();
                $("#alert").empty();
                getPostArr=[];
                message.body.forEach(function (item){
    getPostArr.push(item)
                })
            console.log(message.count)
            }
            else if(message.action == "procSendPosts") {
                message.body.forEach(function (item){
                    getPostArr.push(item)
                })
                console.log(message.procent)
                document.getElementById('progress').innerText = message.procent+"%";
                procentLine = (message.procent / 10).toFixed()
                $("#progressLine").attr('class', 'progress-bar progress-bar-lg wd-'+procentLine *10+'p');
            }
            else if(message.action == "endSendPosts") {
                message.body.forEach(function (item){
                    getPostArr.push(item)
                })
                console.log("Конец запроса");
                document.getElementById("spinner").style.display = "none";
                document.getElementById("pageWindow").style.display="block";

                if($("#filterType option:selected").val() =="rang") {
                    getPostArr.sort(function (a, b) {
                        return b[0] - a[0];
                    });
                }
                else if($("#filterType option:selected").val()=="highFiler")
                {

console.log("hiFilter")
                    getPostArr.forEach(function(item, key){
                        start = key -  Number($("#HighFilter option:selected").val());
                        end = key +  Number($("#HighFilter option:selected").val());
                        startModify = start ;
                        endModify = end ;
                        for (i = start; i < end; i++) {
                            if(!getPostArr[i]){
                                if(i<0){
                                    startModify +=1;
                                    endModify +=1;
                                }
                                else if(i>0){
                                    startModify -=1;
                                    endModify -=1;
                                }
                            }
                        }
                        countSum = 0;
                        y=0;
                        for (i = startModify; i < endModify; i++) {
                            if(i !== key) {
                                countSum += getPostArr[i][0];
                                y++
                            }
                        }
                        countSum = countSum / y ;
                        magicInt = getPostArr[key][0] / countSum
                        getPostArr[key][3] = magicInt.toFixed(2) ;
                    });

                    getPostArr.sort(function (a, b) {
                        return b[3] - a[3];
                    });


                }

                showLoadContent(getPostArr);
            }
            else if(message.action == "error") {
                console.log("err");
                subscriptionContent = "";
                if(message.pageId){
                    subscriptionContent =  '<button type="button" onclick="subscriptionAccount('+message.pageId+')" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Пописаться</button>';
                }
                $("#postContentDiv").empty();
                document.getElementById("spinner").style.display = "none";
                document.getElementById("pageWindow").style.display="block";
                $("#alert").append('<div class="alert alert-danger alert-bordered pd-y-20" role="alert">\n' +
                    '                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '                        <span aria-hidden="true">&times;</span>\n' +
                    '                    </button>\n' +
                    '                    <div class="d-flex align-items-center justify-content-start">\n' +
                    '                        <i class="icon ion-ios-close alert-icon tx-52 tx-danger mg-r-20"></i>\n' +
                    '                        <div>\n' +
                    '                            <h5 class="mg-b-2 tx-danger">'+message.head+'</h5>\n' +
                    '                            <p class="mg-b-0 tx-gray">'+message.body+'</p>\n' +
                    subscriptionContent+
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '                </div>');

            }
            else if(message.action == "inform") {
                console.log(message.body)
                document.getElementById('progress').innerText = message.body;
            }
            };

        ws.onclose = function(error){
            document.getElementById("searchPanel").style.display="none";
            $("#alert").append('<div class="alert alert-danger alert-bordered pd-y-20" role="alert">\n' +
                '                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                '                        <span aria-hidden="true">&times;</span>\n' +
                '                    </button>\n' +
                '                    <div class="d-flex align-items-center justify-content-start">\n' +
                '                        <i class="icon ion-ios-close alert-icon tx-52 tx-danger mg-r-20"></i>\n' +
                '                        <div>\n' +
                '                            <h5 class="mg-b-2 tx-danger">Произошло отключение от сервера!</h5>\n' +
                '                            <p class="mg-b-0 tx-gray">Проблемы с подключением к серверу код ошибки: '+error.code+', Попробуйте обновить страницу или обратитесь к администратору.</p>\n' +
               ' <button type="button" onclick="reloadPage()"  data-dismiss="alert" aria-label="Close">\n' +
            '                        <span aria-hidden="true">Обновить</span>\n' +
            '                    </button>\n' +
                '</div>\n' +
                '                    </div>\n' +
                '                </div>');
        }
        console.log(accounts)
        accounts.forEach(function (item) {
            console.log(item[5])
            if(item[5]==1){
                $("#accountsMenu").append('<option selected  data-item="' + item[1] + '" value="' + item[0] + '" data-csrftoken="' + item[4] + '" data-ssid="' + item[2] + '" data-id="' + item[3] + '">' + item[0] + '</option>');

            }else {
                $("#accountsMenu").append('<option  data-item="' + item[1] + '" value="' + item[0] + '" data-csrftoken="' + item[4] + '" data-ssid="' + item[2] + '" data-id="' + item[3] + '">' + item[0] + '</option>');
            }
        })

        function getPost(data) {
            if($("#accName").val()) {
                ws.send(JSON.stringify({
                    type: 'startLoad',
                    csrftoken: $("#accountsMenu option:selected").attr('data-csrftoken'),
                    sessionid: $("#accountsMenu option:selected").attr('data-ssid'),
                    accName: $("#accName").val(),
                    count: $("#accCount").val()
                }));
                document.getElementById("spinner").style.display = "block";
                document.getElementById("pageWindow").style.display="none";
            }
            else{
                alert("Не введено имя аккаунта!")
            }
        }
// Функция отображения контента
        function showLoadContent(getPostArr) {
            console.log(getPostArr[0])
            for (i = 0; i < 20; i++) {
                $("#postContentDiv").append('<div class="col-md ">\n' +
                    '                    <div class="thumbnail ">\n' +
                    '                        <a href="https://www.instagram.com/p/' + getPostArr[i][1] + '/" target="_blank"><img  height="150" src="' + getPostArr[i][2] + '" alt="Image"></a>\n' +
                    '                            <p class="card-text">Просмотры:'+getPostArr[i][0]+'</p>\n' +
                    '                            <p class=""><font size="1">'+getPostArr[i][1]+'</font></p>\n' +
                    '                    </div>\n' +
                    '            </div>')
            }


        }
        // Функция навигация по постам
        function move(step) {

            if(step=='next' && movePosition+20<=getPostArr.length){
                console.log('next')
                movePosition=movePosition+20;
                refreshLoadContent(movePosition);
            }
            else if(step=='back' && movePosition-20>=0){
                movePosition=movePosition-20;
                refreshLoadContent(movePosition);
            }

        }
        // Функция навигационного обновления контента
        function refreshLoadContent(movePosition) {
            $("#postContentDiv").empty();

            for (i = movePosition; i < movePosition + 20 ; i++) {
                if(getPostArr[i]) {
                    $("#postContentDiv").append('<div class="col-md ">\n' +
                        '                    <div class="thumbnail ">\n' +
                        '                        <a href="https://www.instagram.com/p/' + getPostArr[i][1] + '/" target="_blank"><img  height="150" src="' + getPostArr[i][2] + '" alt="Image"></a>\n' +
                        '                            <p class="card-text">Просмотры:' + getPostArr[i][0] + '</p>\n' +
                        '                            <p class=""><font size="1">' + getPostArr[i][1] + '</font></p>\n' +
                        '                    </div>\n' +
                        '            </div>')
                }
            }

        }
        // Функция смены типа фильтра
        function changeFilterType() {
            if($("#filterType option:selected").val()=="highFiler") {
                document.getElementById("HighFilterDiv").style.display="block";
            }
            else{
                document.getElementById("HighFilterDiv").style.display="none";

            }
        }

        function reloadPage() {
            window.location.reload(false);
        }

        function subscriptionAccount(pageId) {
            console.log("ww")
            ws.send(JSON.stringify({
                type: 'subscription',
                test: 'test',
                pageId: pageId,
                csrftoken: $("#accountsMenu option:selected").attr('data-csrftoken'),
                sessionid: $("#accountsMenu option:selected").attr('data-ssid')
            }));

        }

    </script>


    <? } ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>