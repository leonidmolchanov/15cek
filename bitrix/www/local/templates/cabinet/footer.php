<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
</div><!-- d-flex -->

</div><!-- br-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->
<?
use Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/lib/jquery/jquery.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/lib/popper.js/popper.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/lib/bootstrap/bootstrap.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/lib/moment/moment.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/lib/jquery-ui/jquery-ui.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/lib/jquery-switchbutton/jquery.switchButton.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/lib/peity/jquery.peity.js");
//Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/lib/chartist/chartist.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/lib/jquery.sparkline.bower/jquery.sparkline.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/lib/d3/d3.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/lib/rickshaw/rickshaw.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/bracket.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/ResizeSensor.js");
//Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/dashboard.js");

?>
<script>
    $(function(){
        'use strict'
        $(window).resize(function(){
            minimizeMenu();
        });

        minimizeMenu();

        function minimizeMenu() {
            if(window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1299px)').matches) {
                // show only the icons and hide left menu label by default
                $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
                $('body').addClass('collapsed-menu');
                $('.show-sub + .br-menu-sub').slideUp();
            } else if(window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) {
                $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
                $('body').removeClass('collapsed-menu');
                $('.show-sub + .br-menu-sub').slideDown();
            }
        }
    });
</script>
</body>
</html>