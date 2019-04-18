<?php 
/*
	template name: 全宽页面
	description: template for yunsheji.cc iDowns theme 
*/
get_header();?>
<div class="main">
	<div class="container">
		<div class="content-wrap">
	    	<div class="content">
	    		<?php while (have_posts()) : the_post(); ?>
	    		<article class="single-content">
		    		<header class="article-header">
		    			<h1 class="article-title center"><?php the_title(); ?></h1>
		    		</header>
		    		<div class="article-content">
		    			<?php the_content(); ?>
		            </div>
		    		<?php endwhile;  ?>
	            </article>
	        </div>    <?php comments_template('', true); ?>
	 	</div>
	</div>
</div>
<?php get_footer();?>