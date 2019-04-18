
<div class="hero lazyload visible" style="background-image: url(<?php echo DGAThemes_thumbnail();?>)"> >
	
	<div class="hero-media">
		<div class="container">
		<div class="fluid-width-video-wrapper" style="">
			<iframe src="<?php echo _DGA('video_url_auto');?><?php echo get_post_meta($post->ID, 'header_video_id', true);?>" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen>
			</iframe>
		</div>
		</div>
	</div>
</div>
