var express = require('express');
var sleep = require('system-sleep');
var bodyParser = require('body-parser');
var htmlparser = require('htmlparser2');
var fs = require('fs');
json="done";
var accountName;
timer = 0;
count = 0;
filterDepth = 0;
taskArray =[];
finished = false;
var request = require('request');
var Client = require('instagram-private-api').V1;
var server = express();
server.use('/auth', bodyParser.urlencoded({ extended: false }));
server.use('/auth', bodyParser.json());
var server = express();
server.use('/public', express.static(__dirname + '/public'));
var server = express();
server.use('/css', express.static(__dirname + '/css'));
var server = express();
server.use('/include', express.static(__dirname + '/include'));
var server = express();
server.all('/auth', bodyParser.urlencoded({extended: true}),bodyParser.json(),  function(req, res){
//console.log(req.body.type)
    if(req.body.type=="status") {
        res.setHeader('Access-Control-Allow-Origin', '*');
        res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE'); // If needed
        res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type'); // If needed
        res.setHeader('Access-Control-Allow-Credentials', true);
        var storage = new Client.CookieFileStorage(__dirname + '/cookies/password.json');
        if(storage.storage.idx['i.instagram.com']) {
            if (storage.storage.idx['i.instagram.com']["/"].sessionid) {
                console.log("test")
                res.setHeader('Content-Type', 'application/json');
                res.send(JSON.stringify({
                    success: true,
                    sessionid: storage.storage.idx['i.instagram.com']["/"].sessionid.value,
                    csrftoken: storage.storage.idx['i.instagram.com']["/"].csrftoken.value,
                    ds_user: storage.storage.idx['i.instagram.com']["/"].ds_user.value
                }));
            }
            else {
                res.setHeader('Content-Type', 'application/json');
                res.send(JSON.stringify({success: false}));
                fs.writeFile("cookies/password.json", "", function (err) {
                    console.log(err)
                })
            }
        }
        else{
            res.setHeader('Content-Type', 'application/json');
            res.send(JSON.stringify({success: false}));
        }
    }
    else if(req.body.type=="logout") {
        res.setHeader('Access-Control-Allow-Origin', '*');
        res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE'); // If needed
        res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type'); // If needed
        res.setHeader('Access-Control-Allow-Credentials', true);
        res.setHeader('Content-Type', 'application/json');
        res.send(JSON.stringify({ success: true}));
        fs.writeFile("cookies/password.json", "", function (err) {
            console.log(err)
        })
    }
    else if(req.body.type=="login") {
        res.setHeader('Access-Control-Allow-Origin', '*');
        res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE'); // If needed
        res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type'); // If needed
        res.setHeader('Access-Control-Allow-Credentials', true);
        if(req.body.login && req.body.password){
            var device = new Client.Device(req.body.login);
            var storage = new Client.CookieFileStorage(__dirname + '/cookies/password.json');
            Client.Session.create(device, storage, req.body.login, req.body.password).then(session => {});
            var session = new Client.Session(device, storage);
            console.log(session)
            if (storage.storage.idx['i.instagram.com']["/"].sessionid) {
                res.setHeader('Content-Type', 'application/json');
                res.send(JSON.stringify({ success: true}));
            }
            else{
                res.setHeader('Content-Type', 'application/json');
                res.send(JSON.stringify({ success: false}));
                fs.writeFile("cookies/password.json", "", function (err) {
                    console.log(err)
                })
            }
        }
        else{
            res.setHeader('Content-Type', 'application/json');
            res.send(JSON.stringify({ success: false}));
            fs.writeFile("cookies/password.json", "", function (err) {
                console.log(err)
            })
        }

    }
    else if(req.body.type=="getProc") {
        res.setHeader('Access-Control-Allow-Origin', '*');
        res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE'); // If needed
        res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type'); // If needed
        res.setHeader('Access-Control-Allow-Credentials', true);
            feedback = function (result, timer) {
                //res.setHeader('Content-Type', 'application/json');
                //res.send(JSON.stringify({ success: true}));
            };
            if(req.body.status=="process"){
                    res.setHeader('Content-Type', 'application/json');
                    res.send(JSON.stringify({count: count, timer: timer, finished: finished}));
            }
            else if(req.body.status=="start"){
                if(req.body.accountName && req.body.filterDepth && req.body.filterType) {
                    if(timer!==0){
                        console.log("Идет процесс загрузки...")
                        res.setHeader('Content-Type', 'application/json');
                        res.send(JSON.stringify({success: false , status: "proccess"}));
                    }
                    else {
                        console.log("создаем анализ страницы для : " + req.body.accountName)
                        accountName = req.body.accountName;
                        theUrl = "https://www.instagram.com/" + req.body.accountName;
                        filterDepth = req.body.filterDepth;
                        taskResult = [];
                        request(theUrl, function (error, response, body) {
                            console.log("Подгружаем страницу для анализа скриптов...")
                            parseResponse(body, feedback, req.body.accountName);
                            //console.log(feedback)
                            res.setHeader('Content-Type', 'application/json');
                            res.send(JSON.stringify({success: true}));
                        });
                    }
                }

                }

    }
    else if(req.body.type=="restart") {
        process.exit(1);
    }
    else if(req.body.type=="getProcStatus") {
        res.setHeader('Access-Control-Allow-Origin', '*');
        res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE'); // If needed
        res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type'); // If needed
        res.setHeader('Access-Control-Allow-Credentials', true);
        sleep(500);
        res.setHeader('Content-Type', 'application/json');
        res.send(JSON.stringify({ count: count ,timer: timer , finished: finished}));
    }
    else if(req.body.type=="getProcResult") {
        res.setHeader('Access-Control-Allow-Origin', '*');
        res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE'); // If needed
        res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type'); // If needed
        res.setHeader('Access-Control-Allow-Credentials', true);
        sleep(500);
        res.setHeader('Content-Type', 'application/json');
        res.send(JSON.stringify(taskArray));
        finished = false;
        taskArray="";
        taskArray=[];
    }
else {
        res.setHeader('Access-Control-Allow-Origin', '*');
        res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE'); // If needed
        res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type'); // If needed
        res.setHeader('Access-Control-Allow-Credentials', true);
        res.setHeader('Content-Type', 'application/json');
        res.send(JSON.stringify({ success: false}));
        fs.writeFile("cookies/password.json", "", function (err) {
            console.log(err)
        })
    }

    });
server.get('/*', function(req, res){
    res.sendFile(__dirname + '/index.html');
});

var port = 8000;
server.listen(port, function() {
    console.log('server listening on port ' + port);
});

var parseResponse = function(response, feedback, accountName) {
    parser.write(response);
    parser.end();

}


var parser = new htmlparser.Parser({

    onopentag: function(name, attribs){
        if(name === "script" && attribs.src && attribs.src.includes("/ProfilePageContainer.js")){
            var storage = new Client.CookieFileStorage(__dirname + '/cookies/password.json');
            sessionid = storage.storage.idx['i.instagram.com']["/"].sessionid.value,
                csrftoken = storage.storage.idx['i.instagram.com']["/"].csrftoken.value,
                ds_user =  storage.storage.idx['i.instagram.com']["/"].ds_user.value
            console.log("Путь к скрипту с Id "+attribs.src);
            theUrlJS="https://www.instagram.com"+attribs.src;
            //console.log(theUrlJS);
            request(theUrlJS, function (error, response, body) {
                //parseResponse(body);
                queryId=body
                qString="r=e.profilePosts.byUserId.get(t))"
                qString2=",queryParams:function(e){return{id:e}}"
                qString3="pagination},queryId:"

                queryId=queryId.split(qString)
                queryId=queryId[1].split(qString2)
                queryId=queryId[0].split(qString3)
                queryId=queryId[1].replace(/^"(.+(?="$))"$/, '$1');
                console.log("Получаем id для запросов : "+queryId)
                console.log(accountName)
                optionsUserId ={
                    url: 'https://www.instagram.com/'+accountName+'/',
                    headers: {'Cookie': 'crsftoken='+csrftoken,
                        'Cookie': 'sessionid='+sessionid
                    }
                };
                request(optionsUserId, function (error, response, body) {
                    body = body.split("ing_page_id\":\"profilePage_");
                    body = body[1].split("\"");
                    pageId = body[0];
                    console.log("Получаем номер страницы : "+pageId)

                    str={"id":pageId,"first":30,"after":""};

                    variables = encodeURIComponent(JSON.stringify(str));
                    url = "https://www.instagram.com/graphql/query/?query_hash="+queryId+"&variables="+variables+""
                    // console.log(JSON.parse(url))
                    firstUrlRq="https://www.instagram.com/graphql/query/";
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
                        console.log("startGet`content...");
                        body = JSON.parse(body);
                        if(body.status=="ok") {
                            endCursor = body.data.user.edge_owner_to_timeline_media.page_info.end_cursor;
                            console.log("Кол-во постов: " + body.data.user.edge_owner_to_timeline_media.count)
                            if (filterDepth !== "0") {
                                count = filterDepth
                            }
                            else {
                                console.log("count.set unlimited")
                                count = body.data.user.edge_owner_to_timeline_media.count
                            }
                            tasks = body.data.user.edge_owner_to_timeline_media.edges;
                            taskResult = [];
                            callback = function (endCursor, taskResult) {
                                console.log(endCursor);
                                console.log("timer" + timer)
                                console.log("count" + count)
                                console.log("filterDepth" + filterDepth)
                                if (endCursor !== null && filterDepth == 0) {
                                    getTaskForeach(sessionid, csrftoken, pageId, queryId, endCursor, callback, feedback)
                                    feedback(taskResult, timer);
                                }
                               else if (endCursor !== null && timer < count) {
                                    getTaskForeach(sessionid, csrftoken, pageId, queryId, endCursor, callback, feedback)
                                    feedback(taskResult, timer);
                                }
                                else {
                                    console.log("наш результат")
                                    //taskResult.sort(function (a, b) {
                                    //    return b[0] - a[0];
                                    //});
                                    timer = 0;
                                    count = 0;
                                    filterDepth = 0;
                                    taskArray = taskResult;
                                    finished = true;
                                    console.log("Process done ...")
                                }
                            };
                            function getTaskForeach(sessionid, csrftoken, pageId, queryId, endCursor, callback, feedback) {

                                function sleep(time, callback) {
                                    var stop = new Date().getTime();
                                    while(new Date().getTime() < stop + time) {
                                        ;
                                    }
                                    callback();
                                }
                                sleep(2000, function() {
                                    // executes after one second, and blocks the thread

                                timer += 30
                                str = {"id": pageId, "first": 30, "after": endCursor};
                                variables = encodeURIComponent(JSON.stringify(str));
                                url = "https://www.instagram.com/graphql/query/?query_hash=" + queryId + "&variables=" + variables + ""
                                options = {
                                    url: url,
                                    headers: {
                                        'referer': 'https://www.instagram.com/p/BT1ynUvhvaR/?taken-by=yatsenkolesh',
                                        'origin': 'https://www.instagram.com',
                                        'user-agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36',
                                        'x-instagram-ajax': '1',
                                        'x-requested-with': 'XMLHttpRequest',
                                        'Cookie': 'crsftoken=' + csrftoken,
                                        'Cookie': 'sessionid=' + sessionid
                                    }
                                };

                                request(options, function (error, response, body) {
                                    body = JSON.parse(body);
                                    if(body.status=="ok") {
                                        tasks = body.data.user.edge_owner_to_timeline_media.edges;
                                        tasks.forEach(function (item) {
                                            // console.log(item.node.edge_media_preview_like.count)
                                            //console.log("Кол-во просмотров: "+item.node.video_view_count)
                                            if (item.node.video_view_count) {
                                                arContent = [item.node.video_view_count, item.node.shortcode, item.node.display_url, item.node.text];
                                                taskResult.push(arContent)
                                            }
                                        });
                                        /*
                                        taskResult.sort(function (a, b) {
                                            return b[0] - a[0];
                                        });
                                        */
                                        callback(body.data.user.edge_owner_to_timeline_media.page_info.end_cursor, taskResult)
                                    }
                                    else{
                                        console.log(body.status)
                                        return "err";
                                       // getTaskForeach(sessionid, csrftoken, pageId, queryId, endCursor, callback, feedback);
                                    }
                                    });

                                });

                            }

                            getTaskForeach(sessionid, csrftoken, pageId, queryId, endCursor, callback, feedback);
                            tasks.forEach(function (item) {
                                // console.log(item.node.edge_media_preview_like.count)
                                //console.log("Кол-во просмотров: "+item.node.video_view_count)
                                if (item.node.video_view_count) {
                                    arContent = [item.node.video_view_count, item.node.shortcode, item.node.display_url, item.node.text];
                                    taskResult.push(arContent)
                                }
                            });
                            //taskResult.sort(function (a, b) {
                             //   return b[0] - a[0];
                            //});
                        }
                        else{
                            console.log(body.status);
                            //console.log(endCursor)
                            return "err";
                            //getTaskForeach(sessionid, csrftoken, pageId, queryId, endCursor, callback, feedback);
                        }
                        //console.log(taskResult);
                    });
                });

            });

        }
    },
    ontext: function(text){
        //console.log("-->", text);
    },
    onclosetag: function(tagname){
        if(tagname === "script"){
            //  console.log("That's it?!");
        }
    }
}, {decodeEntities: true});