<?php 
/**
 * template name: 热门标签
 * description: template for yunsheji.cc iDowns theme 
 */

get_header();
?>

<div class="banner banner-archive" <?php if(_DGA('banner_archive_img')){?> style="background-image: url(<?php echo _DGA('banner_archive_img');?>);" <?php }?>>
	<div class="container">
		<h1 class="archive-title"><?php the_title() ?></h1>
		<p class="archive-desc">显示前50热门标签</p>
	</div>
</div>

<div class="main">
	<div class="container">
		<div class="content-wrap">
	    	<div class="content">
				<div class="tagslist">
					<ul>
						<?php 
							$tagslist = get_tags('orderby=count&order=DESC&number=50');
							foreach($tagslist as $tag) {
								echo '<li><a class="name" href="'.get_tag_link($tag).'">'. $tag->name .'</a><small>&times;'. $tag->count .'</small>'; 

								$posts = get_posts( "tag_id=". $tag->term_id ."&numberposts=1" );
								foreach( $posts as $post ) {
									setup_postdata( $post );
									echo '<p><a class="tit" href="'.get_permalink().'">'.get_the_title().'</a></p>';
								}

								echo '</li>';
							} 
					
						?>
					</ul>
				</div>
		   	</div>
	    </div>
	</div>
</div>
<?php get_footer(); ?>