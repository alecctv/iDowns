<?php 
/*
	template name: 页面+左侧导航菜单
	description: template for yunsheji.cc iDowns theme 
*/
get_header();?>
<div class="main">
	<div class="container">
		<div class="content-wrap">
	    	<div class="content">

	    		<aside class="page-left-menu widget">
	    			<ul>
	    				<?php echo str_replace("</ul></div>", "", preg_replace("{<div[^>]*><ul[^>]*>}", "", wp_nav_menu(array('theme_location' => 'pagemenu', 'echo' => false)) )); ?>
	    			</ul>
	    		</aside>

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