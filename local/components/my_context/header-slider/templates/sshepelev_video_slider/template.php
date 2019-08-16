<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$APPLICATION->AddHeadScript('/local/components/my_context/header-slider/templates/sshepelev_video_slider/js/header-slvideo.js');
?>

<div class="header-slvideo-wrapper">
    <div id="header-slvideo">
        <ul class="header-slvideo-ul">
        </ul>
    </div>
</div>

<script type="text/javascript">
    $(window).ready(function()
    {
        
        
        function getDesiredSourcePlayer(source)
        {
            if(source.match(/youtube/) != null)
            {
                var url = source.match(/\?v=(.+)/);
                
                if(url != null)
                {
                    var container =
                    `
                    <li class="header-slvideo-li">
                        <iframe class="youtube-player" src="http://www.youtube.com/embed/` + url[1] + `?autoplay=0
                        frameborder="0"></iframe>
                        <div class="source-data">
                            <div class="source-name"></div>
                            <div class="source-date"></div>
                        </div>
                    </li>
                    `;
                    
                    return container;
                }
            }
        }
        
        var headerSlvideoUl = $('.header-slvideo-ul');
        var videoItem = $('.video-item');
        
        videoItem.each(function(item)
        {
            var currentVideoElement = videoItem.eq(0).find('.video-data');
            var html = getDesiredSourcePlayer(currentVideoElement.attr('data-video-url'));
            
            headerSlvideoUl.append(html);
        });
    });
</script>