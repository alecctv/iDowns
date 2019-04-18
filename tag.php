<?php get_header();?>
<div class="banner banner-archive" <?php if(_DGA('banner_archive_img')){?> style="background-image: url(<?php echo _DGA('banner_archive_img');?>);" <?php }?>>
	<div class="container">
		<h1 class="archive-title"><?php single_tag_title() ?></h1>
		<p class="archive-desc"><?php echo trim(strip_tags(tag_description()));?></p>
	</div>
</div>
<div class="main">
	<div class="container">
		<?php DGAThemes_ad('ad_list_header');?>
		<div id="posts" class="posts grids <?php if(_DGA('waterfall')) echo 'waterfall';?> clearfix">
			<?php 
				while ( have_posts() ) : the_post(); 
				switch (_DGA('home_postlist')) {
				   case "style_0":
				     get_template_part( 'content', get_post_format() );
				     break;
				   case "style_1":
				     get_template_part( 'content', 'item' );
				     break;
				}
				endwhile; wp_reset_query(); 
			?>
		</div>
		<?php DGAThemes_paging();?>
		<?php DGAThemes_ad('ad_list_footer');?>
	</div>
</div>
<?php get_footer();?>