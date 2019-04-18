
<div class="main">
	<div class="container">
		<div class="content-wrap">
	    	<div class="content<?php if($nosidebar) echo ' nosidebar';?>">
	    		<?php DGAThemes_ad('ad_post_header');?>
	    		<?php while (have_posts()) : the_post(); ?>
	    		<article class="single-content">
		    		<header class="article-header">
		    			<h1 class="article-title"><?php the_title(); ?></h1>
		    			<div class="article-meta">
		    				<span class="item"><i class="dripicons dripicons-clock"></i> <?php echo get_the_date().' '.get_the_time(); ?></span>
		    				<span class="item"><i class="dripicons dripicons-view-thumb"></i> <?php the_category(' / '); ?></span>
		    				<?php if(_DGA('post_views')){?><span class="item"><i class="dripicons dripicons-preview"></i> <?php DGAThemes_views() ?></span><?php }?>
		    				<span class="item"><?php edit_post_link('[编辑]'); ?></span>
		    			</div>
		    		</header>
		    		<div class="article-content">
		    			<?php if(_DGA('down_position') == 'top' || _DGA('down_position') == 'sidetop') DGAThemes_erphpdown_box();?>
		    			<?php the_content(); ?>
		    			<?php wp_link_pages('link_before=<span>&link_after=</span>&before=<div class="article-paging">&after=</div>&next_or_number=number'); ?>
		    			<?php if(_DGA('down_position') == 'bottom' || _DGA('down_position') == 'sidebottom' || _DGA('down_position') == 'side') DGAThemes_erphpdown_box();?>
		            </div>
		    		<?php endwhile;  ?>
		            <?php if(_DGA('post_tags')) the_tags('<div class="article-tags">','','</div>'); ?>
		            <?php if(_DGA('post_share')) echo '<div class="article-shares">
				        <a href="javascript:;" data-url="'. get_the_permalink() .'" class="share-weixin" title="分享到微信"><i class="fa">&#xe60e;</i></a><a data-share="qzone" class="share-qzone" title="分享到QQ空间"><i class="fa">&#xe607;</i></a><a data-share="weibo" class="share-tsina" title="分享到新浪微博"><i class="fa">&#xe608;</i></a><a data-share="qq" class="share-sqq" title="分享到QQ好友"><i class="fa">&#xe609;</i></a><a data-share="douban" class="share-douban" title="分享到豆瓣网"><i class="fa">&#xe60b;</i></a>
				    </div>';?>
		            <?php if(_DGA('post_nav')){?>
	                <nav class="article-nav">
	                    <span class="article-nav-prev"><?php previous_post_link('上一篇<br>%link'); ?></span>
	                    <span class="article-nav-next"><?php next_post_link('下一篇<br>%link'); ?></span>
	                </nav>
	                <?php }?>
	            </article>
	            <?php DGAThemes_ad('ad_post_footer');?>
	            <?php if(_DGA('post_related')) get_template_part('module/related');?>
	            <?php comments_template('', true); ?>
	            <?php DGAThemes_ad('ad_post_comment');?>
	    	</div>
	    </div>
		<?php if(!$nosidebar) get_sidebar(); ?>
	</div>
</div>
