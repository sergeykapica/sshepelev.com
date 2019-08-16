<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<?if(( isset($arResult['POEMS']) && count($arResult['POEMS']) > 0 ) || ( isset($arResult['VIDEO']) && count($arResult['VIDEO']) > 0 ) || ( isset($arResult['AUDIO']) && count($arResult['AUDIO']) > 0 ) ):?>
    <div class="content-wrapper">
        <?if(isset($arResult['POEMS'])):?>
            <?foreach($arResult['POEMS'] as $poem):?>
                <article class="poem-item">
                    <div class="poem-name"><?=$poem['NAME'];?></div>
                    <div class="poem-text"><?=$poem['PROPERTY_POEM_TEXT_VALUE']['TEXT'];?></div>
                    <div class="poem-data-wrapper">
                        <div class="poem-data">
                            <div class="data-user-icon" style="background-image: url(<?=( isset($poem['USER_DATA']) ? $poem['USER_DATA']['PERSONAL_PHOTO'] : '' );?>);"></div>
                            <div class="data-user-data">
                                <a href="/about/" class="user-data-initials"><?=( isset($poem['USER_DATA']) ? $poem['USER_DATA']['NAME'] . ' ' . $poem['USER_DATA']['LAST_NAME'] : '' );?></a>
                                <div class="user-data-date"><?=$poem['DATE_ACTIVE_FROM'];?></div>
                            </div>
                        </div>
                    </div>
                </article>
            <?endforeach;?>
        <?elseif($arResult['VIDEO']):?>
            <?foreach($arResult['VIDEO'] as $video):?>
                <div class="video-item" style="background-image: url(<?=$video['PROPERTY_VIDEO_PREVIEW_VALUE'];?>);">
                    <div class="video-click">
                        <div class="video-data" data-video-url="<?=$video['PROPERTY_VIDEO_URL_VALUE'];?>"><?=$video['NAME'];?></div>
                        <div class="video-date"><?=$video['PROPERTY_VIDEO_DURATION_VALUE'];?></div>
                    </div>
                </div>
            <?endforeach;?>
        <?else:?>

        <?endif;?>
    </div>
    <div class="pagination">
        <?=$arResult['NAV_STRING'];?>
    </div>
<?else:?>
    <div class="content-wrapper">
        <div class="comments-list-empty">
           <?if(isset($arResult['POEMS'])):?>
                Стихотворения отсутствуют
            <?elseif(isset($arResult['VIDEO'])):?>
                Видео отсутствуют
            <?else:?>
                Аудио отсутствуют
            <?endif;?>
        </div>
    </div>
<?endif;?>