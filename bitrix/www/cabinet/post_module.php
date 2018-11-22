<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
require("include/settings.php");
// Проверяем авторизацию
if ($USER->IsAuthorized()) { ?>
    <script>
        // Создаем пустой массив для дальнейшего перебора подключенных аккаунтов из php в JS
        accounts = [];
    </script>
    <?
    // Подключаем модуль инфоблоков
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
            // Условие что запись аккаунта пренадлежит пользователю
            if ($arFields['PROPERTY_ID_VALUE'] == $USER->GetId()) {
                ?>
                <script>
                    // Формируем массив с аккаунтами
                    accounts.push(["<?=$arFields['NAME']?>", "<?=$i?>", "<?=$arFields['PROPERTY_SSID_VALUE']?>", "<?=$arFields['ID']?>", "<?=$arFields['PROPERTY_CSRFTOKEN_VALUE']?>", "<?=$arFields['PROPERTY_MAIN_VALUE']?>"]);
                </script>
                <?
            }
            $i++;
        }
    endif;
    ?>
    <!--    Блок предварительной загрузки-->
    <div class="" id="spinner">
        <div class="d-flex  ht-300 pos-relative align-items-center">
            <img src="<?= SITE_TEMPLATE_PATH ?>/img/loading.gif" alt="Загрузка">
        </div>
        <div class="d-flex  ht-200 pos-relative align-items-center">
            <div class="progress-bar progress-bar-lg wd-100p" role="progressbar" id="progressLine" aria-valuenow="0"
                 aria-valuemin="0" aria-valuemax="100"><span id="progress"></span></div>
        </div>
        <div class="row">
            <button type="button" onclick="reloadPage()"
                    class="btn btn-success tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Остановить
            </button>
        </div>
    </div>
<!--Главный блок-->
    <div class="br-pagebody" id="pageWindow">
        <div class="br-section-wrapper">
<!--Блок ошибок-->
            <div class="row" id="alert"></div>
<!--            Форма запроса постов-->
            <form>
                <div class="row" id="searchPanel">
                    <div class="col-lg">
                        Имя аккаунта:<input class="form-control mr-sm-2 my-sm-0" id="accName" placeholder="Имя аккаунта"
                                            type="text">
                    </div><!-- col -->
                    <div class="col-lg mg-t-10 mg-lg-t-0">
                        Глубина просмотра:<select class="form-control mr-sm-2 my-sm-0" id="accCount">
                            <option value="0">Неограничено</option>
                            <option selected value="2">60</option>
                            <option value="3">90</option>
                            <option value="4">120</option>
                            <option value="5">150</option>
                            <option value="6">180</option>
                        </select>
                    </div><!-- col -->
                    <div class="col-lg mg-t-10 mg-lg-t-0">
                        Тип фильтра:<select onchange="changeFilterType()" class="form-control mr-sm-2 my-sm-0"
                                            id="filterType">
                            <option selected="" value="rang">По рейтингу</option>
                            <option value="highFiler">Умный фильтр</option>
                        </select>
                    </div><!-- col -->
                    <div class="col-lg mg-t-10 mg-lg-t-0" id="HighFilterDiv"> Шаг:
                        <select id="HighFilter" class="form-control mr-sm-2 my-sm-0" name="highFilterInterval">
                            <option value="5">5</option>
                            <option selected value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                    <div class="col-lg mg-t-10 mg-lg-t-0">
                        запрос от:<select id="accountsMenu" class="form-control mr-sm-2 my-sm-0">
                        </select>
                    </div><!-- col -->
                    <div class="col-lg mg-t-10 mg-lg-t-0">
                        <br>
                        <button type="button" onclick="getPost(this.form)"
                                class="btn btn-success tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Запросить
                        </button>
                    </div>
                </div>
            </form>
            <div class="row mg-t-10 mg-b-10">
                <div class="col-lg">
                    <button type="button" onclick="move('back')"
                            class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Назад
                    </button>
                </div>
                <div class="col-lg">
                    <button type="button" onclick="move('next')"
                            class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Вперед
                    </button>
                </div>
            </div>
<!--            Блок в который складываем посты-->
            <div class="row" id="postContentDiv"></div>
        </div>
    </div>
    <script>
        // Подключаемся к серверу ws node.js
        ws = new WebSocket('ws://15cek.ru:8090/<?=bitrix_sessid_get()?>');
        // Скрываем вспомогательные блоки
        document.getElementById("spinner").style.display = "none";
        document.getElementById("HighFilterDiv").style.display = "none";
        // Переменная куда будут складываться найденные посты
        getPostArr = [];
        // Переменная навигации по страницам результата поиска
        movePosition = 0;
    </script>
<!--    Подключаем библиотеку взаимодействия с ws-->
    <script src="js/postModuleWs.js"></script>
<!--    Подключаем библиотеку с набором функций-->
    <script src="js/postModuleFn.js"></script>
<? } ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>