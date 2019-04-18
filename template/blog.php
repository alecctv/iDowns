<?php 
/*
	template name: 最新文章
	description: template for yunsheji.cc iDowns theme 
*/
get_header();?>
<div class="banner"<?php if(_DGA('banner_img')){?> style="background-image: url(<?php echo _DGA('banner_img');?>);" <?php }?>>
	<div class="container">
    	<h2><?php echo _DGA('banner_title');?></h2>
        <p><?php echo _DGA('banner_desc');?></p>
        <?php if(_DGA('banner_btn')){?><a href="<?php echo _DGA('banner_link');?>" target="_blank"><?php echo _DGA('banner_btn');?></a><?php }?>
    </div>
</div>
<!-- 主体内容 -->
<div class="main">
	<div class="container">
		<div id="posts" class="posts grids waterfall clearfix">
			<?php 
			  	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$args = array(
				    'ignore_sticky_posts' => 1,
				    'paged' => $paged
				);
				query_posts($args);
				while ( have_posts() ) : the_post(); 

				switch (_DGA('home_postlist')) {
				   case "style_0":
				     get_template_part( 'content', get_post_format() );
				     break;
				   case "style_1":
				     get_template_part( 'content', 'item' );
				     break;
				}
				endwhile;
			?>
		</div>
		<?php DGAThemes_paging();  wp_reset_query();  ?>
		<div class="posts-loading"><img src="<?php echo get_stylesheet_directory_uri();?>/static/img/loading.gif"></div>
	</div>
</div>
<?php get_footer();?>