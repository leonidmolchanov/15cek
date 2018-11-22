// Цикл перебора всех доступных аккаунтов при помощи которых будет осуществляться поиск
accounts.forEach(function (item) {
// Условие если аккаунт помечен как главный, выбираем его по дефаулту
   if (item[5] == 1) {
        $("#accountsMenu").append('<option selected  data-item="' + item[1] + '" value="' + item[0] + '" data-csrftoken="' + item[4] + '" data-ssid="' + item[2] + '" data-id="' + item[3] + '">' + item[0] + '</option>');

    } else {
        $("#accountsMenu").append('<option  data-item="' + item[1] + '" value="' + item[0] + '" data-csrftoken="' + item[4] + '" data-ssid="' + item[2] + '" data-id="' + item[3] + '">' + item[0] + '</option>');
    }
})
// Функция начала получения постов
function getPost(data) {
    // Проверяем что введено поле имяни анализируемого аккаунта
    if ($("#accName").val()) {
        // Отправляем запрос на сервер
        ws.send(JSON.stringify({
            type: 'startLoad',
            csrftoken: $("#accountsMenu option:selected").attr('data-csrftoken'), // Забираем токен через свойство
            sessionid: $("#accountsMenu option:selected").attr('data-ssid'), // Забираем ssid через свойство
            accName: $("#accName").val(),
            count: $("#accCount").val() // Переменная которая отвечает за кол-во проходов (постов) если 0 то неограниченно
        }));
        // Показываем прелоадер
        document.getElementById("spinner").style.display = "block";
        document.getElementById("pageWindow").style.display = "none";
    }
    else {
        alert("Не введено имя аккаунта!")
    }
}
// Функция отображения контента
function showLoadContent(getPostArr) {
// Перебираем массив с постами и вставляем их в модуль отображение постов
    for (i = 0; i < 20; i++) {
        $("#postContentDiv").append('<div class="col-md ">\n' +
            '                    <div class="thumbnail ">\n' +
            '                        <a href="https://www.instagram.com/p/' + getPostArr[i][1] + '/" target="_blank"><img  height="150" src="' + getPostArr[i][2] + '" alt="Image"></a>\n' +
            '                            <p class="card-text">Просмотры:' + getPostArr[i][0] + '</p>\n' +
            '                            <p class=""><font size="1">' + getPostArr[i][1] + '</font></p>\n' +
            '                    </div>\n' +
            '            </div>')
    }
}
// Функция навигации по постам
function move(step) {
// За основу берется 1 шаг -  20 постов, если упераемся в край то останавливаемся
    if (step == 'next' && movePosition + 20 <= getPostArr.length) {
        console.log('next')
        movePosition = movePosition + 20;
        refreshLoadContent(movePosition);
    }
    else if (step == 'back' && movePosition - 20 >= 0) {
        movePosition = movePosition - 20;
        refreshLoadContent(movePosition);
    }
}
// Функция навигационного обновления контента
function refreshLoadContent(movePosition) {
    // Чистим модуль контента
    $("#postContentDiv").empty();
    // Перебираем массив с постами с заданными условиями навигации по ним.
    for (i = movePosition; i < movePosition + 20; i++) {
        // Если пост существует и мы не уперлись в края то вставляем его в модуль контента
        if (getPostArr[i]) {
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
    console.log('меняем тип фильтра...')
    if ($("#filterType option:selected").val() == "highFiler") {
        // Показываем блок выбора глубины просмотра
        document.getElementById("HighFilterDiv").style.display = "block";
    }
    else {
        document.getElementById("HighFilterDiv").style.display = "none";
    }
}
// Функция перезагрузки страницы
function reloadPage() {
    console.log('перезагружаем страницу...')
    window.location.reload(false);
}
// Функция запускает процес подписки на аккаунт
function subscriptionAccount(pageId) {
    console.log('Пошел процесс подписки...')
    ws.send(JSON.stringify({
        type: 'subscription',
        pageId: pageId,
        csrftoken: $("#accountsMenu option:selected").attr('data-csrftoken'),
        sessionid: $("#accountsMenu option:selected").attr('data-ssid')
    }));

}