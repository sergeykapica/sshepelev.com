<!DOCTYPE html>
<html>
	<head>
		<title><?$APPLICATION->ShowTitle();?></title>
		<?
			$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery-3.4.1.js');
			$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/viewportchecker.js');
            $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/popper.min.js');
			$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/bootstrap.min.js');
            $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/animate.css');
            $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/smiles.css');
            $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/bootstrap.min.css');
			$APPLICATION->ShowHead();
		?>
	</head>
	<body>
		<?
			$APPLICATION->ShowPanel();
		?>
		<div class="main-wrapper">
            <header class="main-header">
                <?$APPLICATION->IncludeComponent(
                    "my_context:header-slider",
                    "sshepelev",
                    Array()
                );?>
                <div class="header-headline-wrapper">
                    <div class="header-headline">
                        <div class="header-title"><a href="/">SShepelev</a></div>
                        <div class="header-menu">
                            <?$APPLICATION->IncludeComponent(
                                "my_context:menu", 
                                "headerTop", 
                                array(
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "CHILD_MENU_TYPE" => "left",
                                    "DELAY" => "N",
                                    "MAX_LEVEL" => "2",
                                    "MENU_CACHE_GET_VARS" => array(
                                    ),
                                    "MENU_CACHE_TIME" => "3600",
                                    "MENU_CACHE_TYPE" => "N",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "ROOT_MENU_TYPE" => "headerTop",
                                    "USE_EXT" => "N",
                                    "COMPONENT_TEMPLATE" => "headerTop",
                                    "MENU_THEME" => "blue"
                                ),
                                false
                            );?>
                        </div>
                    </div>
                </div>
            </header>
            <main class="main-content-wrapper"> 
                <div class="content-container">