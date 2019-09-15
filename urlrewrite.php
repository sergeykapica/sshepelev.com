<?php
$arUrlRewrite=array (
  10 => 
  array (
    'CONDITION' => '#^/handlers/send-forgotten-password.php#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/local/php_interface/include_files/WebFormHandlers/send-forgotten-password.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  7 => 
  array (
    'CONDITION' => '#^/handlers/add-comment-handler.php#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/local/php_interface/include_files/WebFormHandlers/add-comment-handler.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^\\/?\\/mobileapp/jn\\/(.*)\\/.*#',
    'RULE' => 'componentName=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/mobileapp/jn.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^/news/detail-news/(.+)#',
    'RULE' => 'NEWS_CODE=$1',
    'ID' => '',
    'PATH' => '/news/detail-news.php',
    'SORT' => 100,
  ),
  9 => 
  array (
    'CONDITION' => '#^/actions/set-likes.php#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/local/php_interface/include_files/SiteActions/set-likes.php',
    'SORT' => 100,
  ),
  10 => 
  array (
    'CONDITION' => '#^/admin-panel/content-detail/(.+)/(.+)/(.+)#',
    'RULE' => 'IBLOCK_CODE=$1&SECTION_CODE=$2&ELEMENT_CODE=$3',
    'ID' => '',
    'PATH' => '/admin-panel/content-detail.php',
    'SORT' => 100,
  ),
  11 => 
  array (
    'CONDITION' => '#^/admin-panel/content-detail/(.+)/(.+)#',
    'RULE' => 'IBLOCK_CODE=$1&ELEMENT_CODE=$2',
    'ID' => '',
    'PATH' => '/admin-panel/content-detail.php',
    'SORT' => 100,
  ),
  12 => 
  array (
    'CONDITION' => '#^/handlers/admin-panel/content-action#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/local/php_interface/include_files/WebFormHandlers/admin_panel/content-action.php',
    'SORT' => 100,
  ),
  13 => 
  array (
    'CONDITION' => '#^/admin-panel/content-add/(.+)#',
    'RULE' => 'IBLOCK_CODE=$1',
    'ID' => '',
    'PATH' => '/admin-panel/content-add.php',
    'SORT' => 100,
  ),
  8 => 
  array (
    'CONDITION' => '#^/contents/(.+)/(.+)#',
    'RULE' => 'IBLOCK_CODE=$1&SECTION_CODE=$2',
    'ID' => '',
    'PATH' => '/local/components/my_context/catalog.section.list/get-content-list.php',
    'SORT' => 100,
  ),
  2 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  0 => 
  array (
    'CONDITION' => '#^/stssync/calendar/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/calendar/index.php',
    'SORT' => 100,
  ),
  4 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
);
