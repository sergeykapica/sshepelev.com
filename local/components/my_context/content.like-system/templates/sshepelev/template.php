<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<div class="like-container-box">
    <div class="container-box-like">
        <?if(isset($arResult['LIKE_SYSTEM']['CURRENT_LIKE']) && $arResult['LIKE_SYSTEM']['CURRENT_LIKE'] == 'like'):?>
            <div class="box-like-icon like-system-active"></div>
        <?else:?>
            <div class="box-like-icon"></div>
        <?endif;?>
        <div class="box-like-value"><?=$arResult['LIKE_SYSTEM']['LIKES'];?></div>
    </div>
    <div class="container-box-dizlike">
        <?if(isset($arResult['LIKE_SYSTEM']['CURRENT_LIKE']) && $arResult['LIKE_SYSTEM']['CURRENT_LIKE'] == 'dizlike'):?>
            <div class="box-dizlike-icon dizlike-system-active"></div>
        <?else:?>
            <div class="box-dizlike-icon"></div>
        <?endif;?>
        <div class="box-dizlike-value"><?=$arResult['LIKE_SYSTEM']['DIZLIKES'];?></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
        function setLike(type, likeContainer)
        {
            $.ajax({
                url: '/actions/set-likes.php?type=' + type + '&IBLOCK_ELEMENT=<?=$arParams['IBLOCK_ID'];?>&ELEMENT_IBLOCK_ID=<?=$arParams['ELEMENT_IBLOCK_ID'];?>&LIKES_IBLOCK_ID=<?=$arParams['LIKES_IBLOCK_ID'];?>',
                method: 'GET',
                success: function(res)
                {
                    if(res != false)
                    {
                        if(type == 'like')
                        {
                            var likeActive = likeContainer.parent().find('.dizlike-system-active');
                            
                            if(likeActive[0] !== undefined)
                            {
                                likeActive.removeClass('dizlike-system-active');
                                var likeActiveValue = likeActive.parent().find('.box-dizlike-value');
                                likeActiveValue.text(( parseInt(likeActiveValue.text()) - 1 ));
                            }
                            
                            var icon = likeContainer.find('.box-like-icon');
                            var value = likeContainer.find('.box-like-value');
                            
                            icon.addClass('like-system-active');
                            value.text(( parseInt(value.text()) + 1 ));
                        }
                        else
                        {
                            var likeActive = likeContainer.parent().find('.like-system-active');
                            
                            if(likeActive[0] !== undefined)
                            {
                                likeActive.removeClass('like-system-active');
                                var likeActiveValue = likeActive.parent().find('.box-like-value');
                                likeActiveValue.text(( parseInt(likeActiveValue.text()) - 1 ));
                            }
                            
                            var icon = likeContainer.find('.box-dizlike-icon');
                            var value = likeContainer.find('.box-dizlike-value');
                            
                            icon.addClass('dizlike-system-active');
                            value.text(( parseInt(value.text()) + 1 ));
                        }
                    }
                }
            });
        }
        
        var likeContainerBox = $('.like-container-box');
        
        likeContainerBox.on('click', function(e)
        {
            var target = $(e.target);
            
            while(!target.hasClass('container-box-like') && !target.hasClass('container-box-dizlike'))
            {
                target = target.parent();
            }
            
            if(target.hasClass('container-box-like'))
            {
                setLike('like', target);
            }
            else
            {
                setLike('dizlike', target);
            }
        });
    });
</script>