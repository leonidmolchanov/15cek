<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
require("include/settings.php");
CModule::IncludeModule('iblock');
?>
    <!-- SMALL MODAL -->
    <div id="modalchange" class="modal fade">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-x-20">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Предупреждение</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pd-20">
                    <p class="mg-b-5">Вы уверены что хотите изменить настройки аккаунта?</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" onclick="changeAccount()"
                            class="btn btn-warning tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Да
                    </button>
                    <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"
                            data-dismiss="modal">Нет
                    </button>
                </div>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->
    <!-- SMALL MODAL -->
    <div id="modaldelete" class="modal fade">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content bd-0 tx-14">
                <div class="modal-header pd-x-20">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Предупреждение</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pd-20">
                    <p class="mg-b-5">Вы уверены что хотите удалить аккаунт?</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" onclick="deleteAccount()"
                            class="btn btn-warning tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Да
                    </button>
                    <button type="button" class="btn btn-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"
                            data-dismiss="modal">Нет
                    </button>
                </div>
            </div>
        </div><!-- modal-dialog -->
    </div><!-- modal -->
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-pagebody">
    <div class="br-section-wrapper">
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Добавление аккаунта</h6>
        <p class="mg-b-25 mg-lg-b-50">Создаем аккаунт в системе</p>
        <div class="row">
            <div class="col-lg">
                <input class="form-control" id="addAccountName" placeholder="Имя аккаунта" type="text">
                <div class="mg-t-10"></div>
                <textarea rows="3" class="form-control" id="addAccountSsid" placeholder="SSID"></textarea>
                <div class="mg-t-10"></div>
                <textarea rows="3" class="form-control" id="addAccountCsrftocken" placeholder="csrftocken"></textarea>
            </div><!-- col -->
            <div class="col-lg">
                <a href="#" onclick="addAccount()"
                   class="btn btn-success tx-11  tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Добавить</a>
            </div>
        </div><!-- row -->
        <script>
            // Массив для аккаунтов
            accounts = [];
            // Массив для id аккаунтов
            accountsArr = [];
        </script>
        <?
        // Переменная в которую запишем главный аккаунт
        $mainAcc;
        if (CModule::IncludeModule("iblock")):
            // Параметры выборки полей
            $arSelect = Array("ID", "NAME", "PROPERTY_SSID", "PROPERTY_ID", "PROPERTY_CSRFTOKEN", "PROPERTY_MAIN");
            // ID инфоблока где хранятся аккаунты задается в setting.php
            $arFilter = Array("IBLOCK_ID" => $IBLOCK_ID);
            // Запрос
            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
            $i = 0;
            // Цикл перебора результатов
            while ($ob = $res->GetNextElement()) {
                $arFields = $ob->GetFields();
                // Проверка что аккаунты привязаны к пользователю
                if ($arFields['PROPERTY_ID_VALUE'] == $USER->GetId()) {
                    ?>
                    <script>
                        // Создаем массивы в Js
                        accounts.push(["<?=$arFields['NAME']?>", "<?=$i?>", "<?=$arFields['PROPERTY_SSID_VALUE']?>", "<?=$arFields['ID']?>", "<?=$arFields['PROPERTY_CSRFTOKEN_VALUE']?>", "<?=$arFields['PROPERTY_MAIN_VALUE']?>"]);
                        accountsArr.push("<?=$arFields['ID']?>");
                    </script>
                    <?
                    // Выводит главный аккаунт
                    if ($arFields['PROPERTY_MAIN_VALUE'] == 1) {
                        $mainAcc = $arFields['NAME'];
                    }

                }
                $i++;
            }
        endif;
        ?>
        <p class="mg-b-25 mg-lg-b-50"></p>
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Аккаунт по умолчанию</h6>
        <p class="">Аккаунт, который будет использоваться в запросах по умолчанию</p>
        <p class=""><?= $mainAcc ?></p>
        <div class="row">
            <div class="col-lg">
                <select class="form-control select2 select2-hidden-accessible" id="accountsMenuDefault"
                        aria-hidden="true">
                </select>
            </div><!-- col -->
            <div class="col-lg">
                <a href="#" onclick="setDefaultAccount()"
                   class="btn btn-success tx-11  tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Установить</a>
            </div>
        </div><!-- row -->
        <p class="mg-b-25 mg-lg-b-50"></p>
        <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Настройки созданных аккаунтов</h6>
        <p class="mg-b-25 mg-lg-b-50"></p>
        <div class="row">
            <div class="col-lg">
                <div class="pd-5 bd rounded">
                    <ul id="accountsMenu" class="nav nav-gray-600 flex-column" role="tablist">
                    </ul>
                </div>
            </div>
            <div class="col-lg" id="accountDiv">

                <input class="form-control" id="accountNameShow" placeholder="name" type="text">
                <div class="mg-t-10"></div>
                <textarea rows="3" class="form-control" id="accountSSIDShow" placeholder="SSID"></textarea>
                <div class="mg-t-10"></div>
                <textarea rows="3" class="form-control" id="accountCsrftockenShow" placeholder="csrftocken"></textarea>
                <p class="mg-b-10 mg-lg-b-10"></p>
                <a href="" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"
                   data-toggle="modal" data-target="#modalchange">Изменить</a>
                <a href="" class="btn btn-warning tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"
                   data-toggle="modal" data-target="#modaldelete">Удалить</a>
            </div><!-- row -->
        </div>
    </div>
    <script>
        // Скрываем блое с аккаунтами
        document.getElementById("accountDiv").style.display = "none";
        // Создаем меню выбора аккаунтов
        accounts.forEach(function (item) {
            $("#accountsMenu").append('<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#" data-item="' + item[1] + '" data-csrftocken="' + item[4] + '" data-name="' + item[0] + '" data-ssid="' + item[2] + '" data-id="' + item[3] + '" onClick="changeContentAccountWindows(this)" role="tab">' + item[0] + '</a></li>');
            $("#accountsMenuDefault").append('<option data-item="' + item[1] + '" data-csrftocken="' + item[4] + '" data-name="' + item[0] + '" data-ssid="' + item[2] + '" data-id="' + item[3] + '">' + item[0] + '</option>');
        })

        // Функция смены визуализации выбранного аккаунта
        function changeContentAccountWindows(data) {
            console.log($(data).attr('data-item'));
            document.getElementById("accountDiv").style.display = "block";
            $("#accountNameShow").attr('value', $(data).attr('data-name'));
            $("#accountNameShow").attr('data-id', $(data).attr('data-id'));
            $("#accountSSIDShow").val($(data).attr('data-ssid'));
            $("#accountCsrftockenShow").val($(data).attr('data-csrftocken'));
        };

        // Функция удаления аккаунта
        function deleteAccount() {
            blockId = $("#accountNameShow").attr('data-id');
            if (blockId) {
                console.log(blockId)
                fetch('api.php', {
                    method: 'post',
                    headers: {
                        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                    },
                    body: "<?=bitrix_sessid_get()?>&type=delete&blockId=" + blockId + "&accId=<?=$USER->GetId()?>"
                })
                    .then(function (response) {
                        window.location.reload(false);
                    })
                    .catch(function (err) {
                        console.log(err)
                    });
            }
        }
// Функция добавления аккаунта
        function addAccount() {
            accName = $("#addAccountName").val();
            accSsid = $("#addAccountSsid").val();
            accCsrftocken = $("#addAccountCsrftocken").val();
            if (accName && accSsid && accCsrftocken) {
                fetch('api.php', {
                    method: 'post',
                    headers: {
                        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                    },
                    body: "<?=bitrix_sessid_get()?>&type=add&accName=" + accName + "&accSsid=" + accSsid + "&accCsrftocken=" + accCsrftocken + "&accId=<?=$USER->GetId()?>"
                })
                    .then(function (response) {
                        window.location.reload(false);
                    })
                    .catch(function (err) {
                        console.log(err)
                    });
            }
            else {
                alert("Не введены имя аккаунта или ssid!")
            }
        }
        // Функция установки аккаунта по умолчанию
        function setDefaultAccount() {
            blockId = $("#accountsMenuDefault option:selected").attr('data-id');
            accountsArr = JSON.stringify(accountsArr);

            fetch('api.php', {
                method: 'post',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                },
                body: "<?=bitrix_sessid_get()?>&type=setDefaultAcc&blockId=" + blockId + "&accountsArr=" + accountsArr + "&accId=<?=$USER->GetId()?>"
            })
                .then(function (response) {
                    // console.log(response)
                    window.location.reload(false);
                })
                .catch(function (err) {
                    console.log(err)
                });
        }
        // Функция смены настроек аккаунта
        function changeAccount() {
            accName = $("#accountNameShow").val();
            accSsid = $("#accountSSIDShow").val();
            blockId = $("#accountNameShow").attr('data-id');
            accCsrftocken = $("#accountCsrftockenShow").val();
            if (accName && accSsid && blockId && accCsrftocken) {
                fetch('api.php', {
                    method: 'post',
                    headers: {
                        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
                    },
                    body: "<?=bitrix_sessid_get()?>&type=change&blockId=" + blockId + "&accName=" + accName + "&accCsrftocken=" + accCsrftocken + "&accSsid=" + accSsid + "&accId=<?=$USER->GetId()?>"
                })
                    .then(function (response) {
                        console.log(response)
                        window.location.reload(false);
                    })
                    // .then(function(user) {
                    //     alert(user.name); // iliakan
                    // })
                    .catch(function (err) {
                        console.log(err)
                    });
            }
            else {
                alert("Не введены имя аккаунта или ssid!")
            }
        }
    </script>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>