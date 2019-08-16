<?php
$arUrlRewrite=array (
  1 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
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
  7 => 
  array (
    'CONDITION' => '#^/handlers/add-comment-handler.php#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/local/php_interface/include_files/WebFormHandlers/add-comment-handler.php',
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
