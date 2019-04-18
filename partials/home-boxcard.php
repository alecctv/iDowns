<!-- 顶部BOX -->
<section id="team" class="team-area ptb-150">
	<div class="container">
		<div class="row">
			<ul class="home_list">
            <?php
                $CmscatID = _DGA('home_cms_categories');
                $CmsNum = _DGA('home_cms_postnum');
                query_posts("cat='$CmscatID'&posts_per_page=$CmsNum "); 
                while(have_posts()): the_post();
            ?>
                <!-- post->>li -->
                <li class="min-height equal">
				    <div class="edd_feat_image_index">
				        <img src="<?php echo DGAThemes_thumbnail();?>"
				        class="home-box-img" alt="<?php the_title();?>">
				        <div class="caption" onclick="">
				            <p><?php the_title();?></p>
				            <?php 
				            	$pricename = get_option("ice_name_alipay");
            					$price = get_post_meta(get_the_ID(), 'down_price', true);
								if ($price) {
			            			echo $price.'<p class="EDD_Price1"><span class="edd_price">'.$pricename.'</span></p>';
			            		}
			            	?>
				            <a class="more-link-hidden" href="<?php the_permalink();?>">详情
				            </a>
				            <div class="thumb_author_details">
				                <div class="EDD-Author">
				                    <p>
				                        By:&nbsp;<?php the_author(); ?>
				                    </p>
				                </div>
				            </div>
				        </div>
				        <div class="EDD-thumb-details">
				            <span class="more-link edd" href="<?php the_permalink();?>"><?php the_title();?></span>
				            <?php 
				            	$pricename = get_option("ice_name_alipay");
            					$price = get_post_meta(get_the_ID(), 'down_price', true);
								if ($price) {
			            			echo '<span class="edd_price">'.$price.$pricename.'</span></p>';
			            		}
			            	?>
				        </div>
				    </div>
				</li>
            <?php endwhile; wp_reset_query();  ?>
		</ul>
		</div>
	</div>
</section>