<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

    <div class="br-logo"><a href=""><span>[</span>15cek<span>]</span></a></div>
        <?
        global $USER;
        if ($USER->IsAuthorized()){ ?>
<div class="br-sideleft overflow-y-auto">
<label class="sidebar-label pd-x-15 mg-t-20">Меню</label>
        <div class="br-sideleft-menu">
<?if (!empty($arResult)):?>
<?
$previousLevel = 0;
foreach($arResult as $arItem):?>
    <a href="<?=$arItem["LINK"]?>" class="br-menu-link <?if ($arItem["SELECTED"]):?>active<?else:?><?endif?>">
        <div class="br-menu-item">
            <i class="menu-item-icon icon <?=$arItem["PARAMS"]["label"]?> tx-22"></i>
            <span class="menu-item-label"><?=$arItem["TEXT"]?></span>
        </div><!-- menu-item -->
    </a><!-- br-menu-link -->
<?endforeach;?>
<?endif;?>
        </div><!-- br-sideleft-menu -->
</div><!-- br-sideleft -->

            <?
        }else{

        }
        ?>
