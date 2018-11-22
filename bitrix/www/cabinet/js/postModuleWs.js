// Подкючение к серверу
ws.onopen = function() {
    console.log("Соединение установлено...");
};
// Если произошло отключение от сервера
ws.onclose = function(event) {
    console.log("соединение закрыто...");
}
// Секция взаимодействия общения клиент-сервер
ws.onmessage = function(message) {
    // Парсим ответ от сервера
    message = JSON.parse(message.data)
    // Если сервер сообщает о начале загрузки постов
    if(message.action == "loadPostModule"){
        document.getElementById('progress').innerText = "";
        console.log("Запускаем процесс загрузки постов...");
        getPostArr=[];
    }
    // Если сервер подписывает нас на аккаунт
    else if(message.action == "subscription"){
        // Если у него это получилось
        if(message.head=="OK"){
            // Чистим окно сошибкой
            $("#alert").empty();
            // Вставляем окно с информацией
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
else{
            alert("Ошибка подписки на сервер!")
        }
    }
// Начало выгрузки постов (первый пост за которым пойдет серия или не пойдет
    else if(message.action == "startSendPosts"){
        // Чистим ранее полученный контент
        $("#postContentDiv").empty()
        // Чистим ошибки
        $("#alert").empty();
        // Определяем массив куда будем складывать полученные посты или очищаем его если он не пустой.
        getPostArr=[];
        // Собираем посты в массив
        message.body.forEach(function (item){
            getPostArr.push(item)
        })
        console.log('Получена первая партия постов...')
    }
    // Дальнейший процесс выгрузки частями
    else if(message.action == "procSendPosts") {
        // Добавляем следующие посты в общий массиы
        message.body.forEach(function (item){
            getPostArr.push(item)
        })
        // Обновляем информацию о ходе выполнения
        document.getElementById('progress').innerText = message.procent+"%";
        procentLine = (message.procent / 10).toFixed()
        $("#progressLine").attr('class', 'progress-bar progress-bar-lg wd-'+procentLine *10+'p');
    }
    // Конец выгрузки
    else if(message.action == "endSendPosts") {
        // Получаем последнюю партию постов
        message.body.forEach(function (item){
            getPostArr.push(item)
        })
        console.log("Конец запроса...");
        // Скрываем лоадер показываем контент
        document.getElementById("spinner").style.display = "none";
        document.getElementById("pageWindow").style.display="block";
// Применяем фильтры к полученному контенту если по Рейтингу то:
        if($("#filterType option:selected").val() =="rang") {
            console.log("Работает фильтр Рейтинг...")
            getPostArr.sort(function (a, b) {
                return b[0] - a[0];
            });
        }
        // Применяем фильтры к полученному контенту если по Умному фильтру то:
        else if($("#filterType option:selected").val()=="highFiler")
        {
            console.log("Работает Умный фильтр ...")
            getPostArr.forEach(function(item, key){
                // Получаем параметры умного фильтра
                start = key -  Number($("#HighFilter option:selected").val());
                end = key +  Number($("#HighFilter option:selected").val());
                startModify = start ;
                endModify = end ;
                // Цикл устанавливает края, чтобы не попасть на не существующие ячейки
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
// Показываем контент
        showLoadContent(getPostArr);
    }
    // Если получили ошибку
    else if(message.action == "error") {
        console.log("Получена ошибка...");
        subscriptionContent = "";
        // Если обибка по подписке вставляем кнопку подписаться...
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
    // Если получен прогресс
    else if(message.action == "inform") {
        document.getElementById('progress').innerText = message.body;
    }
};
// Если подключение к серверу закрылось
ws.onclose = function(error){
    // Скрываем панель поиска
    document.getElementById("searchPanel").style.display="none";
    // Выводит алерт
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
