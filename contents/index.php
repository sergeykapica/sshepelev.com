<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Содержание");
?>

<div class="content-header-wrapper">
	<div class="content-header-icon contents-page"></div>
	<div class="content-header-headline"><?=$APPLICATION->ShowTitle();?></div>
</div>
<div class="contents-wrapper">
	<ul class="contents-name-list">
		<li class="contents-name-item">
			<a class="contents-name-url" href="/contents/poems.php">
				<div class="contents-name-icon contents-poems-icon"></div>
				<div class="contents-name-text">Стихотворения</div>
			</a>
		</li>
		<li class="contents-name-item contents-item-middle">
			<a class="contents-name-url" href="/contents/video.php">
				<div class="contents-name-icon contents-video-icon"></div>
				<div class="contents-name-text">Видео</div>
			</a>
		</li>
		<li class="contents-name-item">
			<a class="contents-name-url" href="/contents/audio.php">
				<div class="contents-name-icon contents-audio-icon"></div>
				<div class="contents-name-text">Аудио</div>
			</a>
		</li>
		<li class="contents-name-item">
			<a class="contents-name-url" href="/contents/photo.php">
				<div class="contents-name-icon contents-photo-icon"></div>
				<div class="contents-name-text">Фотографии</div>
			</a>
		</li>
	</ul>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>