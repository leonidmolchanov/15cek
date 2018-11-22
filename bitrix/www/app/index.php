<?
define("NO_KEEP_STATISTIC", true); //Не учитываем статистику
define("NOT_CHECK_PERMISSIONS", true); //Не учитываем права доступа
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetTitle("test");
global $USER;
if ($USER->IsAuthorized()){
?>

    <!doctype html>
    <html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Система анализа постов instagram v.1.0</title>
        <meta name="description" content="Система анализа постов instagram">
        <meta name="keywords" content="Система анализа постов instagram">
        <meta name="author" content="shwan">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <link rel="stylesheet" href="css/main.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    </head>
    <body>
    <header class="header">
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" role="navigation">
            <a class="navbar-brand" href="#" role="banner">Система анализа постов instagram v.1.0</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault" aria-controls="navbarsDefault" aria-expanded="false" aria-label="Переключить навигацию">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsDefault">
                <!--
                 <ul class="navbar-nav mr-auto">
                     <li class="nav-item active">
                         <a class="nav-link" href="#">Главная <span class="sr-only">(current)</span></a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="#">О сайте</a>
                     </li>
                 </ul>
     -->
                <div id="sectionLogin">

                </div>
                <div><a href="#" class="btn btn-outline-success my-2 my-sm-0" onclick="restartApp()">Перезагрузка приложения</a></div>
                <span  class="my-2 my-sm-0" style="margin: 30px 30px 0px 100px;"> <p class="text-danger" id="errorString"></p></span>

            </div>
        </nav>

    </header>
    <main role="main">
        <div class="jumbotron">
            <div class="container" id="mainForm">
                <form class="form-inline my-2 my-lg-0" role="search">
                    Имя аккаунта:
                    <input id="accountName"  class="form-control mr-sm-2 my-sm-0"  name="pages">
<!--                    <select id="accountName"  class="form-control mr-sm-2 my-sm-0"  name="pages">-->
<!--                        <option value="15cek">15cek</option>-->
<!--                        <option selected value="hyper">hyper</option>-->
<!--                        <option value="barstoolsports">barstoolsports</option>-->
<!--                        <option value="433">433</option>-->
<!--                        <option value="shredded.union">shredded.union</option>-->
<!--                        <option value="milesplit">milesplit</option>-->
<!--                        <option value="risks">risks</option>-->
<!--                        <option value="mmashouts">mmashouts</option>-->
<!--                        <option value="heybarber">heybarber</option>-->
<!--                        <option value="senditofficial">senditofficial</option>-->
<!--                        <option value="technic">technic</option>-->
<!--                        <option value="get.sendy">get.sendy</option>-->
<!--                        <option value="bestcelebrations">bestcelebrations</option>-->
<!--                        <option value="danger">viralnova_365</option>-->
<!--                        <option value="hazards">hazards</option>-->
<!--                        <option value="sportbible">sportbible</option>-->
<!--                        <option value="gymbeaston">gymbeaston</option>-->
<!--                        <option value="watersexmagic">watersexmagic</option>-->
<!--                        <option value="spittinchiclets">spittinchiclets</option>-->
<!--                        <option value="5thyear">5thyear</option>-->
<!--                        <option value="fit_grammers">fit_grammers</option>-->
<!--                        <option value="getbsf">getbsf</option>-->
<!--                        <option value="allfails">allfails</option>-->
<!--                        <option value="prankster">prankster</option>-->
<!--                        <option value="flipping.universee">flipping.universee</option>-->
<!--                        <option value="funningtv">funningtv</option>-->
<!--                        <option value="key.performance">key.performance</option>-->
<!--                    </select>-->
                    Глубина просмотра: <select id="filterDepth" class="form-control mr-sm-2 my-sm-0"  name="selectItems">
                        <option selected value="0">Неограничено</option>
                        <option value="30">60</option>
                        <option value="60">90</option>
                        <option value="90">120</option>
                        <option value="120">150</option>
                    </select>
                    Тип фильтрации: <select  id="filterType" class="form-control mr-sm-2 my-sm-0"   onchange="showHighFilter(this.selectedIndex)" name="filter">
                        <option selected value="rang">По рейтингу</option>
                        <option value="highFiler">Умный фильтр</option>
                    </select>
                    <a class="btn btn-primary my-2 my-sm-0" href="#" onClick="getPost()" id="beginButton" style="margin: 0px 0px 0px 30px;">Начать</a>
                    <p style="margin: 0px 0px 0px 20px;" id="HighSelectP">Шаг :</p> <select id="HighFilter" class="form-control mr-sm-2 my-sm-0"  name="highFilterInterval">
                        <option value="5">5</option>
                        <option selected value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="30">30</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="container">
            <br>
            <div id="navigateButtonTop">
                <a class="btn btn-primary my-2 my-sm-0" href="#" onClick="refreshTable('back')" style="margin: 30px 30px 30px 30px;">Назад</a>
                <a class="btn btn-primary my-2 my-sm-0" href="#" onClick="refreshTable('forward')" style="margin: 30px 30px 30px 300px;">Вперед</a>
            </div>
            <br>
            <br>

            <div class="progress">
                <div class="progress-bar progress-bar-info progress-bar-striped progress-bar-animated" role="progressbar"
                     aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" id="procentProgress" style="width:0%">
                    <span id="procentIndicator"></span>
                </div>
            </div>
            <span id="countString"></span>
            <table class="table table-striped" id="taskTable">
<!--                <thead>-->
<!--                <tr>-->
<!--                    <th>#</th>-->
<!--                    <th>Количество просмотров</th>-->
<!--                    <th>Ссылка на источник</th>-->
<!--                    <th>Preview</th>-->
<!---->
<!--                </tr>-->
<!--                </thead>-->
                <tbody>
                <!-- Content -->
                </tbody>
            </table>
            <br>
            <div id="navigateButtonBottom">
                <a class="btn btn-primary my-2 my-sm-0" href="#" onClick="refreshTable('back')" style="margin: 30px 30px 30px 30px;">Назад</a>
                <a class="btn btn-primary my-2 my-sm-0" href="#" onClick="refreshTable('forward')" style="margin: 30px 30px 30px 300px;">Вперед</a>
            </div>
        </div>
    </main>
    <footer role="contentinfo" class="footer">
        <div class="container">
            <div id="message"></div>
            <br>
            <span class="text-muted">© RB Studio, 2018. Все права защищены.</span>
        </div>
    </footer>
    </body>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script>
        var sessionid;
        var csrftoken;
        var ds_user;
        var taskArray;
        var refresh=0;
        var url = "http://95.213.180.74:8000/auth";
        document.getElementById("navigateButtonTop").style.display = "none";
        document.getElementById("navigateButtonBottom").style.display = "none";
        function auth() {
            console.log("auth")
            if(document.getElementById("login").value=="") {

                document.getElementById("errorString").innerHTML="Не указан логин";
            }
            if(document.getElementById("password").value=="") {
                document.getElementById("errorString").innerHTML="Не указан пароль";
            }

            if(document.getElementById("login").value!=="" && document.getElementById("password").value!=="") {
                document.getElementById("errorString").innerHTML="Идет процесс авторизации...";
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        type: "login",
                        login: document.getElementById("login").value,
                        password: document.getElementById("password").value
                    },
                    dataType: 'json',
                    success: function (responce) {
                        if (responce.success == true) {
                            console.log("Вход выполнен!")
                            window.location.reload(false);
                        }
                        else if (responce.success == false) {
                            console.log("Ошибка авторизации!")
                            window.location.reload(false);
                        }
                    }, error: function () {
                        function sleep(time, callback) {
                            var stop = new Date().getTime();
                            while(new Date().getTime() < stop + time) {
                                ;
                            }
                            callback();
                        }
                        sleep(4000, function() {
                            window.location.reload(false);
                        });
                    }
                });
            }
        }
        document.getElementById("HighFilter").style.display = "none";
        document.getElementById("HighSelectP").style.display = "none";
        function showHighFilter(status) {
            console.log(status)
            if(status==1){
                document.getElementById("HighSelectP").style.display = "block";
                document.getElementById("HighFilter").style.display = "block";
            }
            else if(status==0){
                document.getElementById("HighSelectP").style.display = "none";
                document.getElementById("HighFilter").style.display = "none";
            }
        }
        function logout() {
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    type: "logout",
                },
                dataType: 'json',
                success: function (responce) {
                    if (responce.success == true) {
                        console.log("Выход выполнен!")
                        window.location.reload(false);
                    }
                }
            });
        }

        $.ajax({
            type: 'POST',
            url: url,
            data: {
                type: "status"
            },
            dataType: 'json',
            success: function (responce) {
                if(responce.success==false){
                    content = '<form class="form-inline my-2 my-lg-0" role="login">\n' +
                        '                <input id="login" class="form-control mr-sm-2" type="text" placeholder="Логин" aria-label="Логин">\n' +
                        '                <input  id="password" class="form-control mr-sm-2" type="password" placeholder="Пароль" aria-label="Пароль">\n' +
                        '                <a href="#" class="btn btn-outline-success my-2 my-sm-0" onclick="auth()">Авторизация</a>\n' +
                        '            </form>';
                    document.getElementById("sectionLogin").innerHTML=content;
                    document.getElementById("mainForm").style.display = "none";

                }
                else if(responce.success==true){
                    content = '<form class="form-inline my-2 my-lg-0" role="logout">\n' +
                        '                <a href="#" class="btn btn-outline-success my-2 my-sm-0" onclick="logout()">Выйти</a>\n' +
                        '            </form>';
                    document.getElementById("mainForm").style.display = "block";
                    document.getElementById("sectionLogin").innerHTML=content;
                    sessionid=responce.sessionid;
                    csrftoken = responce.csrftoken;
                    ds_user = responce.ds_user;
                }

            }
        });

        function getPost() {
            console.log(document.getElementById("accountName").value)
            console.log(document.getElementById("filterDepth").value)
            console.log(document.getElementById("filterType").value)
            console.log(document.getElementById("HighFilter").value)

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    type: "getProc",
                    status: "start",
                    accountName: document.getElementById("accountName").value,
                    filterDepth: document.getElementById("filterDepth").value,
                    filterType: document.getElementById("filterType").value,
                    HighFilter: false

                },
                dataType: 'json',
                success: function (responce) {
                    if (responce.success == true) {
                        console.log("Пошел процесс выгрузки постов!");
                        $('#taskTable > tbody:last-child').empty();
                        document.getElementById("message").innerHTML = "";
                        document.getElementById("countString").innerHTML = "";
                        document.getElementById("procentProgress").classList.remove('bg-success');
                        document.getElementById("procentProgress").style.width = 0+"%";
                        document.getElementById("beginButton").style.display = "none";
                        document.getElementById("procentProgress").classList.add('progress-bar-animated');
                        document.getElementById("navigateButtonTop").style.display = "none";
                        document.getElementById("navigateButtonBottom").style.display = "none";
                        getProcStatus()


                    }
                    else if (responce.success == false) {
                        console.log("Ошибка процесса выгрузки!")
                        if(responce.status=="process"){
                            getProcStatus()
                        }
                    }
                }
            });

        }
function restartApp() {
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            type: "restart"
        },
        dataType: 'json',
        success: function (responce) {

        }
    });
    window.location.reload(false);
}
        function getProcStatus() {

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    type: "getProcStatus",
                    status: "process"
                },
                dataType: 'json',
                success: function (responce) {
                    postCount = Number(responce.count)+30;
                    document.getElementById("countString").innerHTML = "Количество постов на анализе: "+postCount;
                    procent = (responce.timer / responce.count)*100
                    console.log(responce);
                    document.getElementById("procentProgress").style.width = procent.toFixed()+"%";
                    if(procent==procent) {
                        document.getElementById("procentIndicator").innerHTML = procent.toFixed() + "%";
                    }
                    if(responce.finished==true)
                    {
                        console.log("готовы сгружать данные...")
                        getProcResult()
                    }
                    else{
                        getProcStatus()
                    }
                }
            });
        }
        function getProcResult() {
            $('#taskTable > tbody:last-child').empty();
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    type: "getProcResult",
                    status: "process"
                },
                dataType: 'json',
                success: function (responce) {
                    if (responce.length == "0") {
                        document.getElementById("countString").innerHTML=""
                        document.getElementById("message").innerHTML = '<div class="alert alert-danger" role="alert">Вы не подписаны на этот аккаунт!</div>'
                        document.getElementById("procentProgress").classList.remove('progress-bar-animated');
                        document.getElementById("beginButton").style.display = "block";
                        document.getElementById("procentIndicator").innerHTML = "0%";
                        document.getElementById("procentProgress").style.width = "0%";
                    }
                    else {
                        taskArray = responce;
                        if(document.getElementById("filterType").value =="rang") {
                            taskArray.sort(function (a, b) {
                                return b[0] - a[0];
                            });
                        }
                        else{
                            taskArray.forEach(function(item, key){
                                start = key -  Number(document.getElementById("HighFilter").value);
                                end = key +  Number(document.getElementById("HighFilter").value);
                                startModify = start ;
                                endModify = end ;
                                for (i = start; i < end; i++) {
                                    if(!taskArray[i]){
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
                                        countSum += taskArray[i][0];
                                        y++
                                    }
                                }
                                countSum = countSum / y ;
                                magicInt = taskArray[key][0] / countSum
                                console.log("countSum "+magicInt.toFixed(2));
                                taskArray[key][3] = magicInt.toFixed(2) ;
                            });

                            taskArray.sort(function (a, b) {
                                return b[3] - a[3];
                            });
                        }
                        content="<tr>";
                        for (i = 0; i < 10; i++) {
                            y = i + 1;
                            if (taskArray[i][3]) {
                                console.log(taskArray[i][3]);
                            }
                            content += '<td><a href="https://www.instagram.com/p/' + taskArray[i][1] + '/" target="_blank"><img width="160" height="160" src="' + taskArray[i][2] + '"></a><br>Просмотры: ' + taskArray[i][0] + '<br><small>' + taskArray[i][1] + '</small></td>';
                        if(i==4){
                            content+="</tr><tr>"
                        }
                        }
                        content+="</tr>"
                            //$('#taskTable > tbody:last-child').append('<tr><th scope="row">' + y + '</th><td>' + taskArray[i][0] + '</td><td><a href="https://www.instagram.com/p/' + taskArray[i][1] + '/" target="_blank">' + taskArray[i][1] + '</a></td><td><img width="320" height="320" src="' + taskArray[i][2] + '"></td></tr>');
                            $('#taskTable > tbody:last-child').append(content);

                        // todo how is wyis
                        document.getElementById("countString").innerHTML=""
                        document.getElementById("procentProgress").classList.add('bg-success');
                        document.getElementById("procentProgress").classList.remove('progress-bar-animated');
                        document.getElementById("beginButton").style.display = "block";
                        document.getElementById("navigateButtonTop").style.display = "block";
                        document.getElementById("navigateButtonBottom").style.display = "block";
                        document.getElementById("procentIndicator").innerHTML = "100%";
                        document.getElementById("procentProgress").style.width = "100%";

                    }
                }
            });
        }function refreshTable(type) {
            $('#taskTable > tbody:last-child').empty();
            if(refresh==0 && type=="forward"){
                refresh+=10;
            }
            else if(refresh==0 && type=="back"){

            }
            else if(refresh!==0 && type=="back"){
                refresh-=10;
            }
            else if(refresh!==0 && type=="forward"){
                refresh+=10;
            }
            console.log(refresh);
            content="<tr>";
            for (i = refresh; i < refresh+10; i++) {
                y=i+1;
                if(taskArray[i]) {
                    content += '<td><a href="https://www.instagram.com/p/' + taskArray[i][1] + '/" target="_blank"><img width="160" height="160" src="' + taskArray[i][2] + '"></a><br>Просмотры: ' + taskArray[i][0] + '<br><small>' + taskArray[i][1] + '</small></td>';
                    if(i==refresh+4){
                        content+="</tr><tr>"
                    }
                    //$('#taskTable > tbody:last-child').append('<tr><th scope="row">' + y + '</th><td>' + taskArray[i][0] + '</td><td><a href="https://www.instagram.com/p/' + taskArray[i][1] + '/" target="_blank">' + taskArray[i][1] + '</a></td><td><img width="160" height="160" src="' + taskArray[i][2] + '"></td></tr>');
                }
                else{
                    refresh-=10;
                    break;
                }
            }
            content+="</tr>"
            $('#taskTable > tbody:last-child').append(content);
        }
    </script>
    </html>
<?
}else{
    LocalRedirect("/login/");
}
?>