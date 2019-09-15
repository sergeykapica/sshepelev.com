<html>
	<body>
		<video width="100%">
			<source src="<?=$arParams['VIDEO_URL'];?>" type="video/mp4">
			<object width="640" height="480" type="application/x-shockwave-flash" data="/local/components/my_context/videoplayer/flash/sshepelevVideoPlayer.swf">
                <param name="movie" value="/local/components/my_context/videoplayer/flash/sshepelevVideoPlayer.swf">
                <param name="flashvars" value="file=<?=$arParams['VIDEO_URL'];?>">
            </object>
		</video>
		
		<script src="/local/components/my_context/videoplayer/js/mediaelement-and-player.min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function()
			{
				$('video').mediaelementplayer({
					alwaysShowControls: false,
					videoVolume: 'horizontal',
					features: ['playpause','progress','volume','fullscreen']
				});
			});
		</script>
	</body>
</html>