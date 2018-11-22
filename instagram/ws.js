var WebSocketServer = require('ws').Server,
    wss = new WebSocketServer({port: 8090});
var fetch = require('node-fetch');
var request = require('request');
var htmlparser = require('htmlparser2');
wss.on('connection', function connection(client ,req) {
    console.log("find connection from: ");
    console.log(req.url)
    sessid = req.url.split("sessid=");
    sessid = sessid[1];
    console.log(sessid)
    clients={};
    message={};
    fetch('http://15cek.ru/cabinet/api.php', {
        method: 'post',
        headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
        },
        body: "type=nodeGetUser&sessid="+sessid
    })
        .then(function(response) {
            console.log(response)
            if(response.status!==200){
                client.close();
            }
            else{
                client.sessid=sessid;
                var id = Math.random();
                message.action = "loadPostModule";
                client.send(JSON.stringify(message));

            }
        })
        .catch(function (err) {
            console.log(err)
        });


    client.on('message', function incoming(message) {
            message = JSON.parse(message)
            if (message.type == 'startLoad') {
                accountName = message.accName
                accountcount = message.count
                sessionid = message.sessionid
                csrftoken = message.csrftoken
                theUrl = "https://www.instagram.com/" + accountName;
                console.log('test');
                request(theUrl, function (error, response, body) {
                    if (error) {
                        console.log("произошла ошибка подгрузки скрипта");
                    }
                    else {
                        console.log("Подгружаем страницу для анализа скриптов...")
                        message = {};
                        message.action = "inform";
                        message.type = "loadScript";
                        message.body = "Подгрузка скриптов...";
                        client.send(JSON.stringify(message));
                        // Callback который возвращает адрес скрипта
                        callback = function (theUrlJS, error) {
                            if (error) {
                                client.send(JSON.stringify(error));
                            }
                            else {
                                // CallBack для получения queryId
                                callback = function (queryId) {
                                    if (queryId) {
                                        // Callback для получения первого запроса к постам
                                        callback = function (url, pageId) {
                                            if (url) {

                                                //Callback принимающий первый результат получения постов
                                                callback = function (taskResult, endCursor, options, count, error) {
                                                    if (error) {
                                                        client.send(JSON.stringify(error));
                                                    }
                                                    else {
                                                        // Устанавливаем счетчик запросов
                                                        message = {};
                                                        message.action = "startSendPosts";
                                                        message.count = count;
                                                        message.body = taskResult;
                                                        client.send(JSON.stringify(message));
                                                        countProc = 0;
                                                        // Условие закрытого аккаунта
                                                        if (taskResult.length !== 0) {
                                                            // Callback циклического прохода
                                                            callback = function (endCursor, taskResult, count) {



                                                                // функция задержки запросов
                                                                function sleep(time, callback) {
                                                                    var stop = new Date().getTime();
                                                                    while (new Date().getTime() < stop + time) {
                                                                        ;
                                                                    }
                                                                    callback();
                                                                }


                                                                countProc++;
                                                                // Условие если больше нет постов
                                                                if (endCursor !== null) {
                                                                    if (accountcount !== 0 && countProc == accountcount - 1) {
                                                                        console.log("Конец запроса")

                                                                        message = {};
                                                                        message.action = "endSendPosts";
                                                                        message.body = taskResult;
                                                                        client.send(JSON.stringify(message));
                                                                    }
                                                                    else {
                                                                        if (accountcount == 0) {
                                                                            message = {};
                                                                            message.action = "procSendPosts";
                                                                            message.body = taskResult;
                                                                            message.procent = (((countProc + 1) / (count / 30).toFixed()) * 100).toFixed();
                                                                            client.send(JSON.stringify(message));
                                                                        }
                                                                        else {
                                                                            message = {};
                                                                            message.action = "procSendPosts";
                                                                            message.body = taskResult;
                                                                            message.procent = (((countProc + 1) / accountcount) * 100).toFixed();
                                                                            client.send(JSON.stringify(message));
                                                                        }
                                                                        console.log(countProc)
                                                                        console.log(accountcount)
                                                                        sleep(2000, function () {
                                                                            getPageWhile(endCursor, sessionid, csrftoken, callback, pageId);
                                                                        });
                                                                    }
                                                                }
                                                                else {
                                                                    console.log("Конец запроса")
                                                                    message = {};
                                                                    message.action = "endSendPosts";
                                                                    message.body = taskResult;
                                                                    client.send(JSON.stringify(message));
                                                                }
                                                            }
                                                            // Циклический процесс запросов
                                                            getPageWhile(endCursor, sessionid, csrftoken, callback, pageId);
                                                        }
                                                        else {
                                                            console.log("Закрытый аккаунт")
                                                            message = {};
                                                            message.pageId = pageId;
                                                            message.action = "error";
                                                            message.type = "closeAccount";
                                                            message.head = "Ошибка закрытый аккаунт!";
                                                            message.body = "Вы не подписаны на данный канал.";
                                                            client.send(JSON.stringify(message));
                                                        }
                                                    }
                                                };
                                                // Начинаем первый запрос постов...
                                                getRequest(url, sessionid, csrftoken, queryId, callback, client);
                                            }
                                            else {
                                                console.log("Ошибка получения url первого запроса");
                                            }
                                        }
                                        getFirstPage(sessionid, csrftoken, queryId, callback)
                                    }
                                    else {
                                        console.log("не получен queryID")
                                    }
                                }
                                // парсим queryId
                                parseQueryId(theUrlJS, callback)
                            }
                        }
                        try {
                            if (body == "Oops, an error occurred.") {
                                console.log("parser error...")
                            } else {
                                parser.write(body, callback)
                                parser.end();
                            }
                        }
                        catch (e) {
                            console.log(e);
                        }
                    }
                });
            }

            else if(message.type == 'subscription') {
                // console.log(message)
                url = 'https://www.instagram.com/web/friendships/' + message.pageId + '/follow/';



                fetch(url, {
                    "credentials": "include",
                    "headers": {
                        "Cookie": "sessionid=" + message.sessionid,
                        "accept": "*/*",
                        "accept-language": "ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7",
                        "content-type": "application/x-www-form-urlencoded",
                        "x-csrftoken": message.csrftoken,
                        "x-instagram-ajax": "1",
                        "x-requested-with": "XMLHttpRequest"
                    },
                    "referrer": "https://www.instagram.com/2broza/",
                    "referrerPolicy": "no-referrer-when-downgrade",
                    "body": null, "method": "POST",
                    "mode": "cors"
                })
                    .then(
                        function (response) {

                            message = {};
                            message.action = "subscription";
                            message.type = "subscription";
                            message.head = "OK";
                            message.body = JSON.stringify(response);
                            client.send(JSON.stringify(message));
                        }
                    )
                    .catch(function (err) {
                        message = {};
                        message.action = "subscription";
                        message.type = "subscription";
                        message.head = "err";
                        client.send(JSON.stringify(message));
                    });


            }
        }

    );

});
// Парсер для адреса скрипта JS где хранится queryID
var parser = new htmlparser.Parser({
    onopentag: function (name, attribs) {
        if (name === "script" && attribs.src && attribs.src.includes("/ProfilePageContainer.js")) {
            theUrlJS = "https://www.instagram.com" + attribs.src;
            // Callback который возвращает адрес скрипт
            callback(theUrlJS)
        }


    },
    ontext: function(text){
        if(text === "Sorry, something went wrong."){
            console.log("parse err")
            message={};
            message.action = "error";
            message.type = "parse";
            message.head = "Ошибка парсера!";
            message.body = "Скорее всего введено не существующее имя аккаунта.";
            callback(false , message);
        }
        else if(text === "Sorry, this page isn&#39;t available."){
            console.log("parse err")
            message={};
            message.action = "error";
            message.type = "parse";
            message.head = "Ошибка парсера!";
            message.body = "Скорее всего введено не существующее имя аккаунта.";
            callback(false , message);
        }
        console.log(text)
    }
});

// Парсинг QueryId
function parseQueryId(theUrlJS, callback) {
    console.log("запуск парсинга")
    request(theUrlJS, function (error, response, body) {
if (error){
    console.log("Ошибка подгрузки скрипта для парса queryId")

} else {
    queryId = body
    qString = "r=e.profilePosts.byUserId.get(t))"
    qString2 = ",queryParams:function(e){return{id:e}}"
    qString3 = "pagination},queryId:"

    queryId = queryId.split(qString)
    queryId = queryId[1].split(qString2)
    queryId = queryId[0].split(qString3)
    queryId = queryId[1].replace(/^"(.+(?="$))"$/, '$1');
    callback(queryId)
}
    })
};
// Функция получения хеша первой страницы
function getFirstPage(sessionid, csrftoken, queryId, callback) {
    optionsUserId ={
        url: 'https://www.instagram.com/'+accountName,
        headers: {'Cookie': 'crsftoken='+csrftoken,
            'Cookie': 'sessionid='+sessionid
        }
    };
    request(optionsUserId, function (error, response, body) {
        try {
            body = body.split("ing_page_id\":\"profilePage_");
            body = body[1].split("\"");
            // Получаем номер страницы
            pageId = body[0];
// Формируем стартовую строчку
            str = {"id": pageId, "first": 30, "after": ""};
            variables = encodeURIComponent(JSON.stringify(str));
            // Формируем url запроса
            url = "https://www.instagram.com/graphql/query/?query_hash=" + queryId + "&variables=" + variables + "";
            callback(url, pageId);
        }
        catch (e) {
            console.log(e)
           console.log("Видимо не правильно введен аккаунт")
        }
    })
}

// Функция получения постов
function getRequest(url, sessionid, csrftoken, queryId, callback, client) {
    console.log("делаем первый запрос");
    message = {};
    message.action = "inform";
    message.type = "loadFirstReq";
    message.body = "Делаем первый запрос ...";
    client.send(JSON.stringify(message));
    options ={
        'referer': 'https://www.instagram.com/p/BT1ynUvhvaR/?taken-by=yatsenkolesh',
        'origin': 'https://www.instagram.com',
        'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36',
        'x-instagram-ajax': '1',
        'x-requested-with': 'XMLHttpRequest',
        url: url,
        headers: {'Cookie': 'crsftoken='+csrftoken,
            'Cookie': 'sessionid='+sessionid
        }
    };


    request(options, function (error, response, body) {
        if(error){
            console.log("Ошибка начала загрузки постов")
        }
        else {
            try {
                body = JSON.parse(body);
                if (body.status == "ok") {
                    endCursor = body.data.user.edge_owner_to_timeline_media.page_info.end_cursor;
                    console.log(endCursor);
                    count = body.data.user.edge_owner_to_timeline_media.count;
                    tasks = body.data.user.edge_owner_to_timeline_media.edges;
                    taskResult = [];
                    tasks.forEach(function (item) {
                        // console.log(item.node.edge_media_preview_like.count)
                        //console.log("Кол-во просмотров: "+item.node.video_view_count)
                        if (item.node.video_view_count) {
                            arContent = [item.node.video_view_count, item.node.shortcode, item.node.display_url];
                            taskResult.push(arContent)
                        }

                    });

                }
                // Callback возврата результатов...
                callback(taskResult, endCursor, options, count);
            }
            catch (e) {
                console.log("Проблемы с ssid!")
                message={};
                message.action = "error";
                message.type = "ssid";
                message.head = "Ошибка ssid";
                message.body = "Либо не верный ssid, либо он попал в блокировку. Необходимо сменить настройки аккаунта...";
                callback(false, false, false, false, message)
            }
            }
    });
};
// Цикл получения постов
function getPageWhile(endCursor, sessionid, csrftoken, callback, pageId) {
    str = {"id": pageId, "first": 30, "after": endCursor};
    variables = encodeURIComponent(JSON.stringify(str));
    url = "https://www.instagram.com/graphql/query/?query_hash="+queryId+"&variables="+variables+""
    // console.log(JSON.parse(url))
    options ={
        'referer': 'https://www.instagram.com/p/BT1ynUvhvaR/?taken-by=yatsenkolesh',
        'origin': 'https://www.instagram.com',
        'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36',
        'x-instagram-ajax': '1',
        'x-requested-with': 'XMLHttpRequest',
        url: url,
        headers: {'Cookie': 'crsftoken='+csrftoken,
            'Cookie': 'sessionid='+sessionid
        }
    };
    taskResult=[];
    request(options, function (error, response, body) {
        try {
            body = JSON.parse(body);

            if (body.status == "ok") {
                tasks = body.data.user.edge_owner_to_timeline_media.edges;
                count = body.data.user.edge_owner_to_timeline_media.count;
                endCursor = body.data.user.edge_owner_to_timeline_media.page_info.end_cursor;
                tasks.forEach(function (item) {
                    if (item.node.video_view_count) {
                        arContent = [item.node.video_view_count, item.node.shortcode, item.node.display_url, item.node.text];
                        taskResult.push(arContent)
                    }
                });
                callback(endCursor, taskResult, count)
            }
        }
        catch (err) {
            console.log(err)
            console.log("видимо загрузка завершилась...")
        }
    });
    }