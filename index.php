<?php 
	get_header();
	$paged = get_query_var('paged');
?>
<?php 
	if ( (!$paged || $paged===1) ) {
		$home_postlist= _DGA('home_header_style','style_0');
		switch ($home_postlist) {
			case "style_0":
			get_template_part( 'partials/home', 'banbtn' );
			break;
			case "style_1":
			get_template_part( 'partials/home', 'banserach' );
			break;
			case "style_2":
			get_template_part( 'partials/home', 'slide' );
			break;
		}
	}
?>

<!-- 主体内容 -->
<div class="main">
	<!-- 推荐BOX -->
	<?php 

	if ( (!$paged || $paged===1) ) {
		switch (_DGA('home_box_style','style_0')) {
			case "style_0":
			get_template_part( 'partials/home', 'boxcard' );
			break;
			case "style_1":
			get_template_part( 'partials/home', 'boxlist' );
			break;
			case "style_2":
			break;
		}
	}
		
	?>
	<!-- iS particles -->
	<?php if(_DGA('home_particles','true') && (!$paged || $paged===1) ){
		get_template_part( 'partials/home', 'particles' );
	}?>

	<div class="container">
		<?php DGAThemes_ad('ad_banner_footer','',30);?>
		<?php if(_DGA('home_cat')){?>
		<div class="cat-nav-wrap">
			<ul class="cat-nav">
				<?php echo str_replace("</ul></div>", "", preg_replace("{<div[^>]*><ul[^>]*>}", "", wp_nav_menu(array('theme_location' => 'cat', 'echo' => false)) )); ?>
			</ul>
		</div>
		<?php }?>
		<div id="posts" class="posts grids clearfix">
			<?php 
			  	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$args = array(
				    'ignore_sticky_posts' => 1,
				    'paged' => $paged
				);
				query_posts($args);
				while ( have_posts() ) : the_post(); 

				switch (_DGA('home_postlist','style_0')) {
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
		
		<div class="posts-loading"><img src="<?php echo get_stylesheet_directory_uri();?>/static/img/loading.gif"></div>
		<?php DGAThemes_ad('ad_home_footer');?>
	</div>
	<!-- 首页CMS块 -->
	<?php if( _DGA('home_cms','true') && (!$paged || $paged===1) ){ get_template_part( 'partials/home', 'cms' ); }?>
	<!-- 价格表组件 -->
	<?php if( _DGA('home_pricing','true') && (!$paged || $paged===1) ){ get_template_part( 'partials/home', 'pricing' ); }?>

	<!-- 首页按钮BOX -->
	<?php if( _DGA('home_btn','true') ){ get_template_part( 'partials/home', 'btn' ); }?>

</div>
<?php get_footer();?>