<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Локальная админ панель");
$APPLICATION->SetAdditionalCss(SITE_TEMPLATE_PATH . '/css/admin-panel.css');
?>

<div class="adminpanel-wrapper">
	<ul class="adminpanel-menu">
		<li class="adminpanel-menu-li">
			<a href="/admin-panel/control-content.php" class="adminpanel-menu-url">
				<img src="<?=SITE_TEMPLATE_PATH;?>/images/admin-panel/briefcase.png" class="adminpanel-menu-icon" />
				<div class="adminpanel-menu-text">
					Управление содержимым
				</div>
			</a>
		</li>
		<li class="adminpanel-menu-li">
			<a href="/admin-panel/control-users.php" class="adminpanel-menu-url">
				<img src="<?=SITE_TEMPLATE_PATH;?>/images/admin-panel/group.png" class="adminpanel-menu-icon" />
				<div class="adminpanel-menu-text">
					Управление пользователями
				</div>
			</a>
		</li>
	</ul>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>