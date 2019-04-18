<?php get_header();?>
<div class="main">
	<div class="container">
		<div class="content-wrap">
	    	<div class="content">
	    		<?php while (have_posts()) : the_post(); ?>
	    		<article class="single-content">
		    		<header class="article-header">
		    			<h1 class="article-title"><?php the_title(); ?></h1>
		    		</header>
		    		<div class="article-content">
		    			<?php the_content(); ?>
		            </div>
		    		<?php endwhile;  ?>
	            </article>
	            <?php comments_template('', true); ?>
	    	</div>
	    </div>
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer();?>