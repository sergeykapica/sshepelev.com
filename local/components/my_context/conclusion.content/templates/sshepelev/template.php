<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$APPLICATION->SetAdditionalCSS('/local/components/my_context/videoplayer/templates/sshepelev/style.css');
$APPLICATION->SetAdditionalCSS('/local/components/my_context/users.comments/templates/sshepelev_content/style.css');
$APPLICATION->SetAdditionalCSS('/local/components/my_context/bb-editor-light/templates/sshepelev/style.css');
$APPLICATION->SetAdditionalCSS('/local/components/my_context/content.like-system/templates/sshepelev/style.css');
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . '/css/validatorObject.css');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/validatorObject.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/messageHide.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/formateDate.js');

if(( isset($arResult['POEMS']) || isset($arResult['POEMS_EMPTY']) ))
{
    $APPLICATION->SetTitle("Стихотворения");
}
else if(( isset($arResult['VIDEO']) || isset($arResult['VIDEO_EMPTY']) ))
{
    $APPLICATION->SetTitle("Видео");
}
else if(( isset($arResult['PHOTO']) || isset($arResult['PHOTO_EMPTY']) ))
{
    $APPLICATION->SetTitle("Фотографии");
}
else
{
    $APPLICATION->SetTitle("Аудио");
}
?>

<?if(( isset($arResult['POEMS']) && count($arResult['POEMS']) > 0 ) || ( isset($arResult['VIDEO']) && count($arResult['VIDEO']) > 0 ) || ( isset($arResult['AUDIO']) && count($arResult['AUDIO']) > 0 ) || ( isset($arResult['PHOTO']) && count($arResult['PHOTO']) > 0 ) ):?>
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
                        <div class="video-data" data-video-url="<?=$video['PROPERTY_VIDEO_URL_VALUE'];?>" data-iblock-id="<?=$video['IBLOCK_ID'];?>" data-id="<?=$video['ID'];?>" data-video-date="<?=$video['DATE_ACTIVE_FROM'];?>" data-video-description="<?=$video['DETAIL_TEXT'];?>" data-video-likes="<?=$video['LIKE_SYSTEM']['LIKES'];?>" data-video-dizlikes="<?=$video['LIKE_SYSTEM']['DIZLIKES'];?>"><?=$video['NAME'];?></div>
                        <div class="video-date"><?=$video['PROPERTY_VIDEO_DURATION_VALUE'];?></div>
                    </div>
                </div>
            <?endforeach;?>
        <?elseif($arResult['PHOTO']):?>
            <?foreach($arResult['PHOTO'] as $photo):?>
                <div class="photo-item animated" style="background-image: url(<?=$photo['PROPERTY_PHOTO_VALUE'];?>);" title="<?=$photo['NAME'];?>" data-id="<?=$photo['ID'];?>" data-photo-description="<?=$photo['DETAIL_TEXT'];?>" data-src="<?=$photo['PROPERTY_PHOTO_VALUE'];?>" data-date="<?=$photo['DATE_ACTIVE_FROM'];?>" data-iblock-id="<?=$photo['IBLOCK_ID'];?>"></div>
            <?endforeach;?>
        <?else:?>
            <?foreach($arResult['AUDIO'] as $audio):?>
                <div class="audio-item">
                    <div class="audio-icon"></div>
                    <div class="audio-name" data-url="<?=$audio['PROPERTY_AUDIO_URL_VALUE'];?>"><?=$audio['NAME'];?></div>
                    <div class="audio-duration"><?=$audio['PROPERTY_AUDIO_DURATION_VALUE'];?></div>
                </div>
            <?endforeach;?>
        <?endif;?>
    </div>
    <div class="pagination">
        <?=$arResult['NAV_STRING'];?>
    </div>
    <div id="audio-player-container"></div>

    <script type="text/javascript">
        $(window).ready(function()
        {
            var contentWrapper = $('.content-wrapper');
            
            if(contentWrapper.find('.audio-item')[0] !== undefined)
            {
                contentWrapper.on('click', function(e)
                {
                    var target = $(e.target);
                    var containerForPlayer = $('#audio-player-container');
                    
                    while(!target.hasClass('audio-item'))
                    {
                        target = target.parent();
                    }
                    
                    if(target.hasClass('audio-item'))
                    {
                        var url = target.find('.audio-name').attr('data-url');
                        
                        if($('audio')[0] !== undefined)
                        {
                            resetSourceInAudioPlayer(url, containerForPlayer);
                        }
                        else
                        {
                            getAudioPlayer(url, containerForPlayer);
                        }
                    }
                });
            }
            
            function getAudioPlayer(url, containerForPlayer)
            {
                $.ajax({
                    url: '/ajax/get-local-audio-player.php?AUDIO_URL=' + url,
                    method: 'GET',
                    success: function(res)
                    {
                        if(res != false)
                        {
                            containerForPlayer.html(res);
                        }
                    }
                });
            }
            
            function resetSourceInAudioPlayer(url, containerForPlayer)
            {
                var audioElement = containerForPlayer.find('audio');
                audioElement[0].src = url;
                audioElement.find('source')[0].remove();
                
                var newSource = document.createElement('source');
                newSource.type = 'audio/mpeg';
                newSource.src = url;
                audioElement.append(newSource);
                
                audioPlayer.load();
            }
            
            var photoItem = $('.photo-item');
            
            if(photoItem[0] !== undefined)
            {
                photoItem.hover(
                function()
                {
                    $(this).addClass('flip');
                },
                function()
                {
                    $(this).removeClass('flip');
                });
            }
        });
    </script>
<?else:?>
    <div class="content-wrapper">
        <div class="comments-list-empty">
           <?if(isset($arResult['POEMS_EMPTY'])):?>
                Стихотворения отсутствуют
            <?elseif(isset($arResult['VIDEO_EMPTY'])):?>
                Видео отсутствуют
            <?elseif(isset($arResult['PHOTO_EMPTY'])):?>
                Фотографии отсутствуют
            <?else:?>
                Аудио отсутствуют
            <?endif;?>
        </div>
    </div>
<?endif;?>