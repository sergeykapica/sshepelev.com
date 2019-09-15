<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$APPLICATION->SetAdditionalCss(SITE_TEMPLATE_PATH . '/css/validatorObject.css');
?>

<?if(!isset($arParams['GET_ONLY_CONTENT'])):?>
    <div class="control-content-wrapper">
        <div class="control-content-head">
            <div class="content-head-left">
                <?if(count($arResult['CIBLOCKS']) > 0):?>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle control-content-select" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Развернуть список
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <?foreach($arResult['CIBLOCKS'] as $cIBlock):?>
                                <button class="dropdown-item" type="button" data-iblock-id="<?=$cIBlock['ID'];?>">
                                    <div class="dropdown-icon <?=$cIBlock['CLASS_TO_ICON'];?>"></div>
                                    <span><?=$cIBlock['NAME'];?></span>
                                </button>
                            <?endforeach;?>
                        </div>
                    </div>
                <?endif;?>
            </div>
            <div class="content-head-right">
                <div class="content-search-wrapper">
                    <div class="content-search-icon"></div>
                    <form action="" method="get" id="search-form">
                        <input type="text" name="CONTENT_SEARCH" class="admin-panel-input admin-panel-search" />
                    </form>
                </div>
            </div>
        </div>
        <div class="control-content-content">
            
        </div>
    </div>

    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH;?>/js/input-placeholder.js"></script>

    <script type="text/javascript">
        $(window).ready(function()
        {
            $('.dropdown-toggle').dropdown();

            setPlaceholderToInput($('.admin-panel-search'), 'Введите слово для поиска');

            var searchForm = $('#search-form');

            searchForm.on('submit', function()
            {

            });

            var contentSearchIcon = $('.content-search-icon');

            contentSearchIcon.on('click', function()
            {
                searchForm.submit();
            });

            var dropdownMenu = $('.dropdown-menu');
            var controlContentContent = $('.control-content-content');

            dropdownMenu.on('click', function(e)
            {
                var target = $(e.target);
                
                while(!target.hasClass('dropdown-item'))
                {
                    target = target.parent();
                }
                
                if(target.hasClass('dropdown-item'))
                {
                    var iblockID = target.attr('data-iblock-id');

                    $.ajax({
                        url: '/admin-panel/ajax/control-content.php?IBLOCK_ID=' + iblockID,
                        method: 'GET',
                        success: function(res)
                        {
                            controlContentContent.html(res);
                        }
                    });
                }
            });
            
            controlContentContent.on('click', function(e)
            {
                var target = $(e.target);
                
                if(target.hasClass('styled-remove-button'))
                {
                    var checkBoxes = $('.styled-checkbox-input');
                    var elementsData = [];
                    
                    checkBoxes.each(function(i)
                    {
                        var currentCheckBox = checkBoxes.eq(i);
                        
                        if(currentCheckBox.prop('checked'))
                        {
                            currentCheckBox.addClass('checked-to-delete');
                            
                            elementsData.push({
                                elementType: currentCheckBox.attr('data-type-element'),
                                elementValue: currentCheckBox.val()
                            });
                        }
                    });
                    
                    if(elementsData.length > 0)
                    {
                        $.ajax({
                            url: '/admin-panel/ajax/delete-content.php',
                            method: 'POST',
                            data: 'ELEMENTS_DATA=' + JSON.stringify(elementsData),
                            success: function(res)
                            {
                                $iblockID = '<?=$arParams["IBLOCK_TO_LOAD"];?>';
                                
                                var errorMessage = controlContentContent.find('.answer-error');
                                        
                                if(errorMessage[0] !== undefined)
                                {
                                    errorMessage.remove();
                                }
                                
                                if(res == true)
                                {
                                    var checkedBox = $('.checked-to-delete');
                                    
                                    checkedBox.each(function(i)
                                    {
                                        var currentCheckedBox = checkedBox.eq(i);
                                        
                                        while(!currentCheckedBox.hasClass('content-table-tr'))
                                        {
                                            currentCheckedBox = currentCheckedBox.parent();
                                        }
                                        
                                        currentCheckedBox.remove();
                                        
                                        var contentTableBody = $('.content-table-body');
                                        
                                        if(contentTableBody.children().length <= 0)
                                        {
                                            if($iblockID == 1)
                                            {
                                                var message = '<div class="control-content-empty"><?=GetMessage("NEWS_EMPTY");?></div>';
                                            }
                                            
                                            contentTableBody.html(message);
                                        }
                                    });
                                }
                                else
                                {
                                    if($iblockID == 1)
                                    {
                                        var message = '<div class="answer-error"><?=GetMessage("NEWS_DELETE_ERROR");?></div>';
                                    }
                                        
                                    controlContentContent.append(message);
                                }
                            }
                        });
                    }
                }
            });
        });
    </script>
<?else:?>
    <div class="control-content-wrapper">
        <?if(!isset($_GET['AJAX_MODE'])):?>
            <div class="control-content-insert">
                <?if(count($arResult['SECTION_LIST']) > 0):?>
                <?// Get sections of IBlock ?>
                    <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-news">
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-comments">
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-poems">
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-video">
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-audio">
                    <?else:?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-photos">
                    <?endif;?>
                        <thead class="content-table-head">
                            <tr class="content-table-tr content-table-head">
                                <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                                    <td class="content-table-td content-table-news table-news-first table-td-separator"><?=GetMessage('NEWS_NAME');?></td>
                                    <td class="content-table-td content-table-news table-news-first table-td-separator"><?=GetMessage('NEWS_DATE');?></td>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                                    <td class="content-table-td content-table-comments table-comments-first table-td-separator"><?=GetMessage('COMMENT_NAME');?></td>
                                    <td class="content-table-td content-table-comments table-comments-first table-td-separator"><?=GetMessage('COMMENT_DATE');?></td>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                                    <td class="content-table-td content-table-poems table-poems-first table-td-separator"><?=GetMessage('POEMS_NAME');?></td>
                                    <td class="content-table-td content-table-poems table-poems-first table-td-separator"><?=GetMessage('POEMS_DATE');?></td>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                                    <td class="content-table-td content-table-video table-video-first table-td-separator"><?=GetMessage('VIDEO_NAME');?></td>
                                    <td class="content-table-td content-table-video table-video-first table-td-separator"><?=GetMessage('VIDEO_DURATION');?></td>
                                    <td class="content-table-td content-table-video table-video-first table-td-separator"><?=GetMessage('VIDEO_DATE');?></td>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                                    <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=GetMessage('AUDIO_NAME');?></td>
                                    <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=GetMessage('AUDIO_DURATION');?></td>
                                    <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=GetMessage('AUDIO_DATE');?></td>
                                <?else:?>
                                    <td class="content-table-td content-table-photos table-photos-first table-td-separator"><?=GetMessage('PHOTOS_NAME');?></td>
                                    <td class="content-table-td content-table-photos table-photos-first table-td-separator"><?=GetMessage('PHOTOS_DATE');?></td>
                                <?endif;?>
                            </tr>
                        </thead>
                        <tbody class="content-table-body">
                            <?foreach($arResult['SECTION_LIST'] as $identifierOfSection => $section):?>
                                <tr class="content-table-tr">
                                    <td class="content-table-td table-td-checkbox">
                                        <div class="styled-checkbox-wrapper">
                                            <label>
                                                <input type="checkbox" value="<?=$section['ID'];?>" data-type-element="section" class="styled-checkbox-input" />
                                                <div class="styled-checkbox-field"></div>
                                            </label>
                                        </div>
                                    </td>
                                    <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                                        <td class="content-table-td content-table-news table-news-first table-td-separator"><?=$section['NAME'];?></td>
                                        <td class="content-table-td content-table-news"><?=$section['DATE_CREATE'];?></td>
                                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                                        <td class="content-table-td content-table-comments table-comments-first table-td-separator"><?=$section['NAME'];?></td>
                                        <td class="content-table-td content-table-comments table-comments-first table-td-separator"><?=$section['DATE_CREATE'];?></td>
                                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                                        <td class="content-table-td content-table-poems table-poems-first table-td-separator"><?=$section['NAME'];?></td>
                                        <td class="content-table-td content-table-poems table-poems-first table-td-separator"><?=$section['DATE_CREATE'];?></td>
                                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                                        <td class="content-table-td content-table-video table-video-first table-td-separator"><?=$section['NAME'];?></td>
                                        <td class="content-table-td content-table-video table-video-first table-td-separator"></td>
                                        <td class="content-table-td content-table-video table-video-first table-td-separator"><?=$section['DATE_CREATE'];?></td>
                                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                                        <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=$section['NAME'];?></td>
                                        <td class="content-table-td content-table-audio table-audio-first table-td-separator"></td>
                                        <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=$section['DATE_CREATE'];?></td>
                                    <?else:?>
                                        <td class="content-table-td content-table-photos table-photos-first table-td-separator"><?=$section['NAME'];?></td>
                                        <td class="content-table-td content-table-photos table-photos-first table-td-separator"><?=$section['DATE_CREATE'];?></td>
                                    <?endif;?>
                                    <td class="content-table-td table-remove-button">
                                        <button class="styled-remove-button"></button>
                                    </td>
                                    <td class="content-table-td table-section">
                                        <?if(count($section['SECTION_ELEMENTS']) > 0):?>
                                            <div class="section-elements-<?=$section['CODE'];?>">
                                                <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                                                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-news">
                                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                                                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-comments">
                                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                                                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-poems">
                                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                                                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-video">
                                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                                                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-audio">
                                                <?else:?>
                                                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-photos">
                                                <?endif;?>
                                                    <tbody class="content-table-body">
                                                        <?foreach($section['SECTION_ELEMENTS'] as $element):?>
                                                            <tr class="content-table-tr">
                                                                <td class="content-table-td table-td-checkbox">
                                                                    <div class="styled-checkbox-wrapper">
                                                                        <label>
                                                                            <input type="checkbox" value="<?=$element['ID'];?>" data-type-element="element" class="styled-checkbox-input" />
                                                                            <div class="styled-checkbox-field"></div>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                                                                    <td class="content-table-td content-table-news table-news-first table-td-separator"><?=$element['NAME'];?></td>
                                                                    <td class="content-table-td content-table-news"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                                                                    <td class="content-table-td content-table-comments table-comments-first table-td-separator"><?=$element['NAME'];?></td>
                                                                    <td class="content-table-td content-table-comments"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                                                                    <td class="content-table-td content-table-poems table-poems-first table-td-separator"><?=$element['NAME'];?></td>
                                                                    <td class="content-table-td content-table-poems"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                                                                    <td class="content-table-td content-table-video table-video-first table-td-separator"><?=$element['NAME'];?></td>
                                                                    <td class="content-table-td content-table-video"><?=$element['PROPERTY_VIDEO_DURATION_VALUE'];?></td>
                                                                    <td class="content-table-td content-table-video"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                                                                    <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=$element['NAME'];?></td>
                                                                    <td class="content-table-td content-table-audio"><?=$element['PROPERTY_AUDIO_DURATION_VALUE'];?></td>
                                                                    <td class="content-table-td content-table-video"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                                                <?else:?>
                                                                    <td class="content-table-td content-table-photos table-photos-first table-td-separator"><?=$element['NAME'];?></td>
                                                                    <td class="content-table-td content-table-photos"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                                                <?endif;?>
                                                                <td class="content-table-td table-remove-button">
                                                                    <button class="styled-remove-button"></button>
                                                                </td>
                                                                <td class="content-table-td table-url">
                                                                    <a href="/admin-panel/content-detail/<?=$element['IBLOCK_CODE'];?>/<?=$section['CODE'];?>/<?=$element['CODE'];?>" class="table-link"></a>
                                                                </td>
                                                            </tr>
                                                        <?endforeach;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="pagination pagination-<?=$section['CODE'];?>">
                                                <?=$section['ELEMENTS_FROM_SECTION_NAV_STRING'];?>
                                            </div>

                                            <? // pagination for section elements ?>

                                            <script type="text/javascript">
                                                $(document).ready(function()
                                                {
                                                    var sectionElementsContainer = $('.section-elements-<?=$section['CODE'];?>'); 
                                                    var pagination = sectionElementsContainer.parent().find('.pagination-<?=$section['CODE'];?>');

                                                    pagination.on('click', function(e)
                                                    {
                                                        var target = $(e.target);

                                                        if(target[0].nodeName == 'A')
                                                        {
                                                            $.ajax({
                                                                url: target.attr('href') + '&AJAX_MODE=1&SECTION_ID=<?=$section['ID'];?>',
                                                                method: 'GET',
                                                                dataType: 'json',
                                                                success: function(res)
                                                                {
                                                                    if(res != false)
                                                                    {
                                                                        sectionElementsContainer.html(res.content);
                                                                        pagination.html(res.pagination);
                                                                    }
                                                                }
                                                            });
                                                        }

                                                        return false;
                                                    });
                                                });
                                            </script>
                                        <?else:?>
                                            <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                                                <div class="control-content-empty"><?=GetMessage('NEWS_EMPTY');?></div>
                                            <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                                                <div class="control-content-empty"><?=GetMessage('COMMENT_EMPTY');?></div>
                                            <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                                                <div class="control-content-empty"><?=GetMessage('POEMS_EMPTY');?></div>
                                            <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                                                <div class="control-content-empty"><?=GetMessage('VIDEO_EMPTY');?></div>
                                            <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                                                <div class="control-content-empty"><?=GetMessage('AUDIO_EMPTY');?></div>
                                            <?else:?>
                                                <div class="control-content-empty"><?=GetMessage('PHOTOS_EMPTY');?></div>
                                            <?endif;?>
                                        <?endif;?>
                                    </td>
                                </tr>
                            <?endforeach;?>
                        </tbody>
                    </table>
                <?elseif(count($arResult['IBLOCK_ELEMENTS']) > 0):?>                            
                    <?// Get elements of IBlock ?>
                    <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-news">
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-comments">
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-poems">
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-video">
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-audio">
                    <?else:?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-photos">
                    <?endif;?>
                        <thead class="content-table-head">
                            <tr class="content-table-tr content-table-head">
                                <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                                    <td class="content-table-td content-table-news table-news-first table-td-separator"><?=GetMessage('NEWS_NAME');?></td>
                                    <td class="content-table-td content-table-news table-news-first table-td-separator"><?=GetMessage('NEWS_DATE');?></td>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                                    <td class="content-table-td content-table-comments table-comments-first table-td-separator"><?=GetMessage('COMMENT_NAME');?></td>
                                    <td class="content-table-td content-table-comments table-comments-first table-td-separator"><?=GetMessage('COMMENT_DATE');?></td>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                                    <td class="content-table-td content-table-poems table-poems-first table-td-separator"><?=GetMessage('POEMS_NAME');?></td>
                                    <td class="content-table-td content-table-poems table-poems-first table-td-separator"><?=GetMessage('POEMS_DATE');?></td>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                                    <td class="content-table-td content-table-video table-video-first table-td-separator"><?=GetMessage('VIDEO_NAME');?></td>
                                    <td class="content-table-td content-table-video table-video-first table-td-separator"><?=GetMessage('VIDEO_DURATION');?></td>
                                    <td class="content-table-td content-table-video table-video-first table-td-separator"><?=GetMessage('VIDEO_DATE');?></td>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                                    <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=GetMessage('AUDIO_NAME');?></td>
                                    <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=GetMessage('AUDIO_DURATION');?></td>
                                    <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=GetMessage('AUDIO_DATE');?></td>
                                <?else:?>
                                    <td class="content-table-td content-table-photos table-photos-first table-td-separator"><?=GetMessage('PHOTOS_NAME');?></td>
                                    <td class="content-table-td content-table-photos table-photos-first table-td-separator"><?=GetMessage('PHOTOS_DATE');?></td>
                                <?endif;?>
                            </tr>
                        </thead>
                        <tbody class="content-table-body">
                            <?foreach($arResult['IBLOCK_ELEMENTS'] as $element):?>
                                <tr class="content-table-tr">
                                    <td class="content-table-td table-td-checkbox">
                                        <div class="styled-checkbox-wrapper">
                                            <label>
                                                <input type="checkbox" value="<?=$element['ID'];?>" data-type-element="element" class="styled-checkbox-input" />
                                                <div class="styled-checkbox-field"></div>
                                            </label>
                                        </div>
                                    </td>
                                    <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                                        <td class="content-table-td content-table-news table-news-first table-td-separator"><?=$element['NAME'];?></td>
                                        <td class="content-table-td content-table-news"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                                        <td class="content-table-td content-table-comments table-comments-first table-td-separator"><?=$element['NAME'];?></td>
                                        <td class="content-table-td content-table-comments"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                                        <td class="content-table-td content-table-poems table-poems-first table-td-separator"><?=$element['NAME'];?></td>
                                        <td class="content-table-td content-table-poems"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                                        <td class="content-table-td content-table-video table-video-first table-td-separator"><?=$element['NAME'];?></td>
                                        <td class="content-table-td content-table-video"><?=$element['PROPERTY_VIDEO_DURATION_VALUE'];?></td>
                                        <td class="content-table-td content-table-video"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                                        <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=$element['NAME'];?></td>
                                        <td class="content-table-td content-table-audio"><?=$element['PROPERTY_AUDIO_DURATION_VALUE'];?></td>
                                        <td class="content-table-td content-table-video"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                    <?else:?>
                                        <td class="content-table-td content-table-photos table-photos-first table-td-separator"><?=$element['NAME'];?></td>
                                        <td class="content-table-td content-table-photos"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                    <?endif;?>
                                    <td class="content-table-td table-remove-button">
                                        <button class="styled-remove-button"></button>
                                    </td>
                                    <td class="content-table-td table-url">
                                        <a href="/admin-panel/content-detail/<?=$element['IBLOCK_CODE'];?>/<?=$element['CODE'];?>" class="table-link"></a>
                                    </td>
                                </tr>
                            <?endforeach;?>
                        </tbody>
                    </table>
                <?else:?>
                    <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                        <div class="control-content-empty"><?=GetMessage('NEWS_EMPTY');?></div>
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                        <div class="control-content-empty"><?=GetMessage('COMMENT_EMPTY');?></div>
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                        <div class="control-content-empty"><?=GetMessage('POEMS_EMPTY');?></div>
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                        <div class="control-content-empty"><?=GetMessage('VIDEO_EMPTY');?></div>
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                        <div class="control-content-empty"><?=GetMessage('AUDIO_EMPTY');?></div>
                    <?else:?>
                        <div class="control-content-empty"><?=GetMessage('PHOTOS_EMPTY');?></div>
                    <?endif;?>
                <?endif;?>
            </div>
        
            <div class="pagination pagination-our">
                <?if(isset($arResult['SECTION_NAV_STRING'])):?>
                    <?=$arResult['SECTION_NAV_STRING'];?>
                <?else:?>
                    <?=$arResult['IBLOCK_NAV_STRING'];?>
                <?endif;?>
            </div>
                            
            <div id="add-content-wrapper">
                <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                    <a href="/admin-panel/content-add/<?=$arParams['IBLOCK_CODE'];?>" id="add-content-button" class="animated"><?=GetMessage('ADD_CONTENT_NEWS');?></a>
                <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                    <a href="/admin-panel/content-add/<?=$arParams['IBLOCK_CODE'];?>" id="add-content-button" class="animated"><?=GetMessage('ADD_CONTENT_COMMENTS');?></a>
                <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                    <a href="/admin-panel/content-add/<?=$arParams['IBLOCK_CODE'];?>" id="add-content-button" class="animated"><?=GetMessage('ADD_CONTENT_POEMS');?></a>
                <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                    <a href="/admin-panel/content-add/<?=$arParams['IBLOCK_CODE'];?>" id="add-content-button" class="animated"><?=GetMessage('ADD_CONTENT_VIDEO');?></a>
                <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                    <a href="/admin-panel/content-add/<?=$arParams['IBLOCK_CODE'];?>" id="add-content-button" class="animated"><?=GetMessage('ADD_CONTENT_AUDIO');?></a>
                <?else:?>
                    <a href="/admin-panel/content-add/<?=$arParams['IBLOCK_CODE'];?>" id="add-content-button" class="animated"><?=GetMessage('ADD_CONTENT_PHOTOS');?></a>
                <?endif;?>
            </div>
        
            <?// ajax pagination?>
        
            <script type="text/javascript">
                $(window).ready(function()
                {
                    var controlContentContent = $('.control-content-insert');
                    var pagination = $('.pagination-our');
                    
                    pagination.on('click', function(e)
                    {
                        var th = $(this);
                        var target = $(e.target);
                        
                        if(target[0].nodeName == 'A')
                        {
                            $.ajax({
                                url: target.attr('href') + '&AJAX_MODE=1',
                                method: 'GET',
                                dataType: 'json',
                                success: function(res)
                                {
                                    if(res != false)
                                    {
                                        controlContentContent.html(res.content);
                                        pagination.html(res.pagination);
                                    }
                                }
                            });
                        }

                        return false;
                    });
                    
                    var addContentButton = $('#add-content-button');
                    
                    addContentButton.hover(
                    function()
                    {
                        $(this).addClass('heartBeat');
                    },
                    function()
                    {
                        $(this).removeClass('heartBeat');
                    }
                    );
                });
            </script>
        <?else:?>
            <?
            ob_clean();
            ob_start();
            ?>
        
            <?if(count($arResult['SECTION_LIST']) > 0 || count($arResult['SECTION_ELEMENTS']) > 0):?>
                <?if(!isset($_GET['SECTION_ID'])):?>
                    <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-news">
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-comments">
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-poems">
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-video">
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-audio">
                    <?else:?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-photos">
                    <?endif;?>
                        <thead class="content-table-head">
                            <tr class="content-table-tr content-table-head">
                                <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                                    <td class="content-table-td content-table-news table-news-first table-td-separator"><?=GetMessage('NEWS_NAME');?></td>
                                    <td class="content-table-td content-table-news table-news-first table-td-separator"><?=GetMessage('NEWS_DATE');?></td>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                                    <td class="content-table-td content-table-comments table-comments-first table-td-separator"><?=GetMessage('COMMENT_NAME');?></td>
                                    <td class="content-table-td content-table-comments table-comments-first table-td-separator"><?=GetMessage('COMMENT_DATE');?></td>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                                    <td class="content-table-td content-table-poems table-poems-first table-td-separator"><?=GetMessage('POEMS_NAME');?></td>
                                    <td class="content-table-td content-table-poems table-poems-first table-td-separator"><?=GetMessage('POEMS_DATE');?></td>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                                    <td class="content-table-td content-table-video table-video-first table-td-separator"><?=GetMessage('VIDEO_NAME');?></td>
                                    <td class="content-table-td content-table-video table-video-first table-td-separator"><?=GetMessage('VIDEO_DURATION');?></td>
                                    <td class="content-table-td content-table-video table-video-first table-td-separator"><?=GetMessage('VIDEO_DATE');?></td>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                                    <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=GetMessage('AUDIO_NAME');?></td>
                                    <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=GetMessage('AUDIO_DURATION');?></td>
                                    <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=GetMessage('AUDIO_DATE');?></td>
                                <?else:?>
                                    <td class="content-table-td content-table-photos table-photos-first table-td-separator"><?=GetMessage('PHOTOS_NAME');?></td>
                                    <td class="content-table-td content-table-photos table-photos-first table-td-separator"><?=GetMessage('PHOTOS_DATE');?></td>
                                <?endif;?>
                            </tr>
                        </thead>
                        <tbody class="content-table-body">
                            <?foreach($arResult['SECTION_LIST'] as $identifierOfSection => $section):?>
                                <tr class="content-table-tr">
                                    <td class="content-table-td table-td-checkbox">
                                        <div class="styled-checkbox-wrapper">
                                            <label>
                                                <input type="checkbox" value="<?=$section['ID'];?>" class="styled-checkbox-input" />
                                                <div class="styled-checkbox-field"></div>
                                            </label>
                                        </div>
                                    </td>
                                    <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                                        <td class="content-table-td content-table-news table-news-first table-td-separator"><?=$section['NAME'];?></td>
                                        <td class="content-table-td content-table-news"><?=$section['DATE_CREATE'];?></td>
                                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                                        <td class="content-table-td content-table-comments table-comments-first table-td-separator"><?=$section['NAME'];?></td>
                                        <td class="content-table-td content-table-comments table-comments-first table-td-separator"><?=$section['DATE_CREATE'];?></td>
                                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                                        <td class="content-table-td content-table-poems table-poems-first table-td-separator"><?=$section['NAME'];?></td>
                                        <td class="content-table-td content-table-poems table-poems-first table-td-separator"><?=$section['DATE_CREATE'];?></td>
                                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                                        <td class="content-table-td content-table-video table-video-first table-td-separator"><?=$section['NAME'];?></td>
                                        <td class="content-table-td content-table-video table-video-first table-td-separator"></td>
                                        <td class="content-table-td content-table-video table-video-first table-td-separator"><?=$section['DATE_CREATE'];?></td>
                                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                                        <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=$section['NAME'];?></td>
                                        <td class="content-table-td content-table-audio table-audio-first table-td-separator"></td>
                                        <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=$section['DATE_CREATE'];?></td>
                                    <?else:?>
                                        <td class="content-table-td content-table-photos table-photos-first table-td-separator"><?=$section['NAME'];?></td>
                                        <td class="content-table-td content-table-photos table-photos-first table-td-separator"><?=$section['DATE_CREATE'];?></td>
                                    <?endif;?>
                                    <td class="content-table-td table-remove-button">
                                        <button class="styled-remove-button"></button>
                                    </td>
                                    <td class="content-table-td table-section">
                                        <?if(count($section['SECTION_ELEMENTS']) > 0):?>
                                            <div class="section-elements-<?=$section['CODE'];?>">
                                                <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                                                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-news">
                                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                                                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-comments">
                                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                                                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-poems">
                                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                                                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-video">
                                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                                                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-audio">
                                                <?else:?>
                                                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-photos">
                                                <?endif;?>
                                                    <tbody class="content-table-body">
                                                        <?foreach($section['SECTION_ELEMENTS'] as $element):?>
                                                            <tr class="content-table-tr">
                                                                <td class="content-table-td table-td-checkbox">
                                                                    <div class="styled-checkbox-wrapper">
                                                                        <label>
                                                                            <input type="checkbox" value="<?=$element['ID'];?>" class="styled-checkbox-input" />
                                                                            <div class="styled-checkbox-field"></div>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                                                                    <td class="content-table-td content-table-news table-news-first table-td-separator"><?=$element['NAME'];?></td>
                                                                    <td class="content-table-td content-table-news"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                                                                    <td class="content-table-td content-table-comments table-comments-first table-td-separator"><?=$element['NAME'];?></td>
                                                                    <td class="content-table-td content-table-comments"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                                                                    <td class="content-table-td content-table-poems table-poems-first table-td-separator"><?=$element['NAME'];?></td>
                                                                    <td class="content-table-td content-table-poems"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                                                                    <td class="content-table-td content-table-video table-video-first table-td-separator"><?=$element['NAME'];?></td>
                                                                    <td class="content-table-td content-table-video"><?=$element['PROPERTY_VIDEO_DURATION_VALUE'];?></td>
                                                                    <td class="content-table-td content-table-video"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                                                                    <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=$element['NAME'];?></td>
                                                                    <td class="content-table-td content-table-audio"><?=$element['PROPERTY_AUDIO_DURATION_VALUE'];?></td>
                                                                    <td class="content-table-td content-table-video"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                                                <?else:?>
                                                                    <td class="content-table-td content-table-photos table-photos-first table-td-separator"><?=$element['NAME'];?></td>
                                                                    <td class="content-table-td content-table-photos"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                                                <?endif;?>
                                                                <td class="content-table-td table-remove-button">
                                                                    <button class="styled-remove-button"></button>
                                                                </td>
                                                                <td class="content-table-td table-url">
                                                                    <a href="/admin-panel/content-detail/<?=$element['IBLOCK_CODE'];?>/<?=$section['CODE'];?>/<?=$element['CODE'];?>" class="table-link"></a>
                                                                </td>
                                                            </tr>
                                                        <?endforeach;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="pagination pagination-<?=$section['CODE'];?>">
                                                <?=$section['ELEMENTS_FROM_SECTION_NAV_STRING'];?>
                                            </div>

                                            <? // pagination for section elements ?>

                                            <script type="text/javascript">
                                                $(document).ready(function()
                                                {
                                                    var sectionElementsContainer = $('.section-elements-<?=$section['CODE'];?>'); 
                                                    var pagination = sectionElementsContainer.parent().find('.pagination-<?=$section['CODE'];?>');

                                                    pagination.on('click', function(e)
                                                    {
                                                        var target = $(e.target);
                                                        var th = $(this);

                                                        if(target[0].nodeName == 'A')
                                                        {
                                                            $.ajax({
                                                                url: target.attr('href') + '&AJAX_MODE=1&SECTION_ID=<?=$section['ID'];?>',
                                                                method: 'GET',
                                                                dataType: 'json',
                                                                success: function(res)
                                                                {
                                                                    if(res != false)
                                                                    {
                                                                        sectionElementsContainer.html(res.content);
                                                                        pagination.html(res.pagination);
                                                                    }
                                                                }
                                                            });
                                                        }

                                                        return false;
                                                    });
                                                });
                                            </script>
                                        <?else:?>
                                            <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                                                <div class="control-content-empty"><?=GetMessage('NEWS_EMPTY');?></div>
                                            <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                                                <div class="control-content-empty"><?=GetMessage('COMMENT_EMPTY');?></div>
                                            <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                                                <div class="control-content-empty"><?=GetMessage('POEMS_EMPTY');?></div>
                                            <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                                                <div class="control-content-empty"><?=GetMessage('VIDEO_EMPTY');?></div>
                                            <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                                                <div class="control-content-empty"><?=GetMessage('AUDIO_EMPTY');?></div>
                                            <?else:?>
                                                <div class="control-content-empty"><?=GetMessage('PHOTOS_EMPTY');?></div>
                                            <?endif;?>
                                        <?endif;?>
                                    </td>
                                </tr>
                            <?endforeach;?>
                        </tbody>
                    </table>
                <?else:?>
                    <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-news">
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-comments">
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-poems">
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-video">
                    <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-audio">
                    <?else:?>
                        <table cellspacing="0" cellpadding="0" class="control-content-table control-content-photos">
                    <?endif;?>
                        <tbody class="content-table-body">
                            <?if(count($arResult['SECTION_ELEMENTS']) > 0):?>
                                <?foreach($arResult['SECTION_ELEMENTS'] as $identifierOfElement => $element):?>
                                    <tr class="content-table-tr">
                                        <td class="content-table-td table-td-checkbox">
                                            <div class="styled-checkbox-wrapper">
                                                <label>
                                                    <input type="checkbox" value="<?=$element['ID'];?>" class="styled-checkbox-input" />
                                                    <div class="styled-checkbox-field"></div>
                                                </label>
                                            </div>
                                        </td>
                                        <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                                            <td class="content-table-td content-table-news table-news-first table-td-separator"><?=$element['NAME'];?></td>
                                            <td class="content-table-td content-table-news"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                        <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                                            <td class="content-table-td content-table-comments table-comments-first table-td-separator"><?=$element['NAME'];?></td>
                                            <td class="content-table-td content-table-comments"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                        <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                                            <td class="content-table-td content-table-poems table-poems-first table-td-separator"><?=$element['NAME'];?></td>
                                            <td class="content-table-td content-table-poems"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                        <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                                            <td class="content-table-td content-table-video table-video-first table-td-separator"><?=$element['NAME'];?></td>
                                            <td class="content-table-td content-table-video"><?=$element['PROPERTY_VIDEO_DURATION_VALUE'];?></td>
                                            <td class="content-table-td content-table-video"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                        <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                                            <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=$element['NAME'];?></td>
                                            <td class="content-table-td content-table-audio"><?=$element['PROPERTY_AUDIO_DURATION_VALUE'];?></td>
                                            <td class="content-table-td content-table-video"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                        <?else:?>
                                            <td class="content-table-td content-table-photos table-photos-first table-td-separator"><?=$element['NAME'];?></td>
                                            <td class="content-table-td content-table-photos"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                        <?endif;?>
                                        <td class="content-table-td table-remove-button">
                                            <button class="styled-remove-button"></button>
                                        </td>
                                        <td class="content-table-td table-url">
                                            <a href="/admin-panel/content-detail/<?=$element['IBLOCK_CODE'];?>/<?=$arResult['SECTION_CODE'];?>/<?=$element['CODE'];?>" class="table-link"></a>
                                        </td>
                                    </tr>
                                <?endforeach;?>
                            <?else:?>
                                <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                                    <div class="control-content-empty"><?=GetMessage('NEWS_EMPTY');?></div>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                                    <div class="control-content-empty"><?=GetMessage('COMMENT_EMPTY');?></div>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                                    <div class="control-content-empty"><?=GetMessage('POEMS_EMPTY');?></div>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                                    <div class="control-content-empty"><?=GetMessage('VIDEO_EMPTY');?></div>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                                    <div class="control-content-empty"><?=GetMessage('AUDIO_EMPTY');?></div>
                                <?else:?>
                                    <div class="control-content-empty"><?=GetMessage('PHOTOS_EMPTY');?></div>
                                <?endif;?>
                            <?endif;?>
                        </tbody>
                    </table>
                <?endif;?>
            <?elseif(count($arResult['IBLOCK_ELEMENTS']) > 0):?>                            
                <?// Get elements of IBlock ?>
                <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-news">
                <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-comments">
                <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-poems">
                <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-video">
                <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-audio">
                <?else:?>
                    <table cellspacing="0" cellpadding="0" class="control-content-table control-content-photos">
                <?endif;?>
                    <thead class="content-table-head">
                        <tr class="content-table-tr content-table-head">
                            <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                                <td class="content-table-td content-table-news table-news-first table-td-separator"><?=GetMessage('NEWS_NAME');?></td>
                                <td class="content-table-td content-table-news table-news-first table-td-separator"><?=GetMessage('NEWS_DATE');?></td>
                            <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                                <td class="content-table-td content-table-comments table-comments-first table-td-separator"><?=GetMessage('COMMENT_NAME');?></td>
                                <td class="content-table-td content-table-comments table-comments-first table-td-separator"><?=GetMessage('COMMENT_DATE');?></td>
                            <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                                <td class="content-table-td content-table-poems table-poems-first table-td-separator"><?=GetMessage('POEMS_NAME');?></td>
                                <td class="content-table-td content-table-poems table-poems-first table-td-separator"><?=GetMessage('POEMS_DATE');?></td>
                            <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                                <td class="content-table-td content-table-video table-video-first table-td-separator"><?=GetMessage('VIDEO_NAME');?></td>
                                <td class="content-table-td content-table-video table-video-first table-td-separator"><?=GetMessage('VIDEO_DURATION');?></td>
                                <td class="content-table-td content-table-video table-video-first table-td-separator"><?=GetMessage('VIDEO_DATE');?></td>
                            <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                                <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=GetMessage('AUDIO_NAME');?></td>
                                <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=GetMessage('AUDIO_DURATION');?></td>
                                <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=GetMessage('AUDIO_DATE');?></td>
                            <?else:?>
                                <td class="content-table-td content-table-photos table-photos-first table-td-separator"><?=GetMessage('PHOTOS_NAME');?></td>
                                <td class="content-table-td content-table-photos table-photos-first table-td-separator"><?=GetMessage('PHOTOS_DATE');?></td>
                            <?endif;?>
                        </tr>
                    </thead>
                    <tbody class="content-table-body">
                        <?foreach($arResult['IBLOCK_ELEMENTS'] as $element):?>
                            <tr class="content-table-tr">
                                <td class="content-table-td table-td-checkbox">
                                    <div class="styled-checkbox-wrapper">
                                        <label>
                                            <input type="checkbox" value="<?=$element['ID'];?>" data-type-element="element" class="styled-checkbox-input" />
                                            <div class="styled-checkbox-field"></div>
                                        </label>
                                    </div>
                                </td>
                                <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                                    <td class="content-table-td content-table-news table-news-first table-td-separator"><?=$element['NAME'];?></td>
                                    <td class="content-table-td content-table-news"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                                    <td class="content-table-td content-table-comments table-comments-first table-td-separator"><?=$element['NAME'];?></td>
                                    <td class="content-table-td content-table-comments"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                                    <td class="content-table-td content-table-poems table-poems-first table-td-separator"><?=$element['NAME'];?></td>
                                    <td class="content-table-td content-table-poems"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                                    <td class="content-table-td content-table-video table-video-first table-td-separator"><?=$element['NAME'];?></td>
                                    <td class="content-table-td content-table-video"><?=$element['PROPERTY_VIDEO_DURATION_VALUE'];?></td>
                                    <td class="content-table-td content-table-video"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                                    <td class="content-table-td content-table-audio table-audio-first table-td-separator"><?=$element['NAME'];?></td>
                                    <td class="content-table-td content-table-audio"><?=$element['PROPERTY_AUDIO_DURATION_VALUE'];?></td>
                                    <td class="content-table-td content-table-video"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                <?else:?>
                                    <td class="content-table-td content-table-photos table-photos-first table-td-separator"><?=$element['NAME'];?></td>
                                    <td class="content-table-td content-table-photos"><?=$element['DATE_ACTIVE_FROM'];?></td>
                                <?endif;?>
                                <td class="content-table-td table-remove-button">
                                    <button class="styled-remove-button"></button>
                                </td>
                                <td class="content-table-td table-url">
                                    <a href="/admin-panel/content-detail/<?=$element['IBLOCK_CODE'];?>/<?=$element['CODE'];?>" class="table-link"></a>
                                </td>
                            </tr>
                        <?endforeach;?>
                    </tbody>
                </table>
            <?else:?>
                <?if($arParams['IBLOCK_TO_LOAD'] == 1):?>
                    <div class="control-content-empty"><?=GetMessage('NEWS_EMPTY');?></div>
                <?elseif($arParams['IBLOCK_TO_LOAD'] == 2 || $arParams['IBLOCK_TO_LOAD'] == 6):?>
                    <div class="control-content-empty"><?=GetMessage('COMMENT_EMPTY');?></div>
                <?elseif($arParams['IBLOCK_TO_LOAD'] == 3):?>
                    <div class="control-content-empty"><?=GetMessage('POEMS_EMPTY');?></div>
                <?elseif($arParams['IBLOCK_TO_LOAD'] == 4):?>
                    <div class="control-content-empty"><?=GetMessage('VIDEO_EMPTY');?></div>
                <?elseif($arParams['IBLOCK_TO_LOAD'] == 5):?>
                    <div class="control-content-empty"><?=GetMessage('AUDIO_EMPTY');?></div>
                <?else:?>
                    <div class="control-content-empty"><?=GetMessage('PHOTOS_EMPTY');?></div>
                <?endif;?>
            <?endif;?>
        
            <?
            $content = ob_get_contents();
            ob_clean();
        
            if(!isset($arResult['ELEMENTS_FROM_SECTION_NAV_STRING']))
            {
                $pagination = ( isset($arResult['SECTION_NAV_STRING']) ? $arResult['SECTION_NAV_STRING'] : $arResult['IBLOCK_NAV_STRING'] );
                
                echo json_encode(
                    array(
                        'content' => $content,
                        'pagination' => $pagination
                    )
                );
            }
            else
            {
                $pagination = ( isset($arResult['ELEMENTS_FROM_SECTION_NAV_STRING']) ? $arResult['ELEMENTS_FROM_SECTION_NAV_STRING'] : $arResult['IBLOCK_NAV_STRING'] );
                
                 echo json_encode(
                    array(
                        'content' => $content,
                        'pagination' => $pagination
                    )
                );
            }
        
            die();
            ?>
        <?endif;?>
    </div>
<?endif;?>
