<!-- 顶部BOX -->
<section id="team" class="team-area ptb-150">
	<div class="container">
		<div class="mo-postlists">
			<ul>
			<?php
                $CmscatID = _DGA('home_cms_categories');
                $CmsNum = _DGA('home_cms_postnum');
                query_posts("cat='$CmscatID'&posts_per_page=$CmsNum "); 
                while(have_posts()): the_post();
            ?>
				<li>
	                <a class="boxlist-img" href="<?php the_permalink();?>" title="<?php the_title();?>"><img src="<?php echo DGAThemes_thumbnail();?>" alt="<?php the_title();?>"></a>
		                <h2><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a></h2>
		                <div class="desc"><?php echo _get_excerpt($limit=45, $after='...'); ?></div>
		                <footer>
		                <span><time><i class="dripicons dripicons-clock"></i> <?php echo DGAThemes_timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ) ?></time></span>
		                <span><i class="dripicons dripicons-preview"></i> <?php DGAThemes_views();?></span>
		                <?php 
					      $start_down=get_post_meta(get_the_ID(), 'start_down', true);
					      $price=get_post_meta(get_the_ID(), 'down_price', true);
					      $memberDown=get_post_meta(get_the_ID(), 'member_down',TRUE);
					      if($start_down && !_DGA('post_price')){
					        echo '<span>';
					        if($memberDown == '4') echo '<i class="dripicons dripicons-ticket"></i> VIP专享';
					        elseif($price) echo '<i class="dripicons dripicons-ticket"></i> '.$price.' '.get_option("ice_name_alipay");
					        else echo '<i class="dripicons dripicons-ticket"></i> 免费';
					        echo '</span>';
					      }
					    ?>
		            	</footer>
	            </li>

	        <?php endwhile; wp_reset_query();  ?>
			</ul>
		</div>
	</div>
</section>