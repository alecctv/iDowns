<?php get_header();?>

<?php
$args = array(
    'hide_empty'               => 0
);
$categories = get_categories( $args );
//上面的代码获取所有分类
?>


<div class="banner banner-archive" <?php if(_DGA('banner_archive_img')){?> style="background-image: url(<?php echo _DGA('banner_archive_img');?>);" <?php }?>>
	<div class="container">
		<h1 class="archive-title">搜索：<?php echo wp_specialchars($s, 1);?></h1>
	</div>
</div>
<div class="main">
	<div class="container">
		<section class="serach-pro">
			<form role="search" method="get" class="search-form" action="<?php echo home_url(); ?>">
			  	<label>
			  		<span class="category-text">分类：</span>
					  <select name="cat">
					    <option value="">全部分类</option>
					    <?php foreach($categories as $category){ ?>
					      <option value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
					    <?php } ?>
					  </select>
				</lable>
				
				  <label>
					  <span class="screen-text">搜索：</span>
					  <input type="search" class="search-field" placeholder="Search&hellip;" value="" name="s" title="Search：" />
				  </label>
				  <input type="submit" class="search-submit" value="Search" />
			</form>
		</section>


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
		<?php if (!have_posts()) {?>
			<h3>很抱歉！没有找到相关内容</h3>
		<?php }?>
		<?php DGAThemes_paging();?>
		<?php DGAThemes_ad('ad_list_footer');?>
	</div>
</div>
<?php get_footer();?>