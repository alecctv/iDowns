
<div class="main">
	<section class="new-shop-header">
		<div class="container">
			
			<div class="shop-header-box">
				<div class="shop-header-info">
					<div class="thumb left">
						<img src="<?php echo DGAThemes_thumbnail();?>" class="thumb" alt="<?php the_title();?>">
					</div>
					<div class="meta right">
						<div class="title"><h1><?php the_title(); ?></h1></div>
						<div class="dess">
							<span class="item"><i class="dripicons dripicons-clock"></i> <?php echo get_the_date().' '.get_the_time(); ?></span>
		    				<span class="item"><i class="dripicons dripicons-view-thumb"></i> <?php the_category(' / '); ?></span>
		    				<?php if(_DGA('post_views')){?><span class="item"><i class="dripicons dripicons-preview"></i> <?php DGAThemes_views() ?></span><?php }?>
		    				<span class="item"><?php edit_post_link('[编辑]'); ?></span>
						</div>
						<div class="tagcc">
							<?php if(_DGA('post_tags')) the_tags('<div class="article-tags">','','</div>'); ?>
						</div>


						<?php 
						if(is_singular()){
							$start_down=get_post_meta(get_the_ID(), 'start_down', true);
							$days=get_post_meta(get_the_ID(), 'down_days', true);
							$price=get_post_meta(get_the_ID(), 'down_price', true);
							$url=get_post_meta(get_the_ID(), 'down_url', true);
							$memberDown=get_post_meta(get_the_ID(), 'member_down',true);
							$hidden=get_post_meta(get_the_ID(), 'hidden_content', true);
							$start_down=get_post_meta(get_the_ID(), 'start_down', true);
							$down_demo = get_post_meta(get_the_ID(), 'down_demo', true);
							$userType=getUsreMemberType();
							
							$erphp_url_front_vip = get_bloginfo('wpurl').'/wp-admin/admin.php?page=erphpdown/admin/erphp-update-vip.php';
							if(get_option('erphp_url_front_vip')){
								$erphp_url_front_vip = get_option('erphp_url_front_vip');
							}
							$erphp_url_front_login = wp_login_url();
							if(get_option('erphp_url_front_login')){
								$erphp_url_front_login = get_option('erphp_url_front_login');
							}

							if($start_down){
								if($days){
									$isdaystxt = '此资源购买后'.$days.'天内可下载';
								}
								if($price){
									echo '<div class="des"><span class="buy">'.$price.'<i> '.get_option("ice_name_alipay").'</i></span></div>';
								}else{
									if($memberDown != 4)
										echo '<div class="des"><span class="buy"><i>免费</i></span></div>';
								}
								
								if($price || $memberDown == 4){
									if(is_user_logged_in()){
										$user_info=wp_get_current_user();
										$down_info=$wpdb->get_row("select * from ".$wpdb->icealipay." where ice_post='".get_the_ID()."' and ice_success=1 and ice_user_id=".$user_info->ID." order by ice_time desc");
										if($days > 0){
											$lastDownDate = date('Y-m-d H:i:s',strtotime('+'.$days.' day',strtotime($down_info->ice_time)));
											$nowDate = date('Y-m-d H:i:s');
											if(strtotime($nowDate) > strtotime($lastDownDate)){
												$down_info = null;
											}
										}
										if(!$userType){
											$vip = '<a href="'.$erphp_url_front_vip.'" target="_blank">升级VIP</a>';
										}
										if($memberDown==3){
											echo '<div class="item vip"><t>VIP优惠：</t>免费'.$vip.'</div>';
										}elseif($memberDown==2){
											echo '<div class="item vip"><t>VIP优惠：</t>5 折'.$vip.'</div>';
										}elseif($memberDown==5){
											echo '<div class="item vip"><t>VIP优惠：</t>8 折'.$vip.'</div>';
										}elseif($memberDown==6){
											echo '<div class="item vip"><t>VIP优惠：</t>包年VIP免费'.$vip.'</div>';
										}elseif($memberDown==7){
											echo '<div class="item vip"><t>VIP优惠：</t>终身VIP免费'.$vip.'</div>';
										}

										if($memberDown==4 && !$userType){
											echo '<div class="item vip vip-only">此资源仅对VIP开放'.$vip.'</div>';
										}else{
											echo '<div class="btns">';
											if($down_info){
												echo '<a href='.constant("erphpdown").'download.php?url='.$down_info->ice_url.' target="_blank" class="a down"><i class="dripicons dripicons-download"></i> 已购买，立即下载</a>';
											}else{
												if ($memberDown==6 && ($userType == 9 || $userType == 10)){
													echo '<a href='.constant("erphpdown").'download.php?postid='.get_the_ID().' target="_blank" class="a down"><i class="dripicons dripicons-download"></i> 立即下载</a>';
												}elseif ($memberDown==7 && $userType == 10){
													echo '<a href='.constant("erphpdown").'download.php?postid='.get_the_ID().' target="_blank" class="a down"><i class="dripicons dripicons-download"></i> 立即下载</a>';
												}elseif( ($memberDown==3 || $memberDown==4) && $userType){
													echo '<a href='.constant("erphpdown").'download.php?postid='.get_the_ID().' target="_blank" class="a down"><i class="dripicons dripicons-download"></i> 立即下载</a>';
												}else{
													echo '<a href='.constant("erphpdown").'icealipay-pay-center.php?postid='.get_the_ID().' class="a down erphp-box"><i class="dripicons dripicons-download"></i> 立即购买</a>';
												}
												
											}
										}
									}else{
										if($memberDown==3){
											echo '<div class="item vip"><t>VIP优惠：</t>免费'.$vip.'</div>';
										}elseif($memberDown==2){
											echo '<div class="item vip"><t>VIP优惠：</t>5 折'.$vip.'</div>';
										}elseif($memberDown==5){
											echo '<div class="item vip"><t>VIP优惠：</t>8 折'.$vip.'</div>';
										}elseif($memberDown==6){
											echo '<div class="item vip"><t>VIP优惠：</t>包年VIP免费'.$vip.'</div>';
										}elseif($memberDown==7){
											echo '<div class="item vip"><t>VIP优惠：</t>终身VIP免费'.$vip.'</div>';
										}elseif($memberDown==4){
											echo '<div class="item vip vip-only">此资源仅对VIP开放'.$vip.'</div>';
										}
										echo '<div class="btns">';
										echo '<a href="javascript:;" class="a down signin-loader">请先登录</a>';
										
									}
								}else{
									if($memberDown != 4){
										echo '<div class="btns">';
										echo '<a href='.constant("erphpdown").'download.php?postid='.get_the_ID().' target="_blank" class="a down"><i class="dripicons dripicons-download"></i> 立即下载</a>';
										
									}
								}


								?>
								<?php if ($down_demo) { echo '<a href="'.$down_demo.'" target="_blank" class="b down erphp-demo" ><i class="dripicons dripicons-link-broken"></i> 演示地址</a>';}
									echo '</div>';
								?>
								

								<?php
								
								
							}
						}
					?>
					</div>
				</div>
			</div>

		</div>
	</section>

	<div class="container">
		<div class="content-wrap">
	    	<div class="content<?php if($nosidebar) echo ' nosidebar';?>">
	    		<?php DGAThemes_ad('ad_post_header');?>
	    		<?php while (have_posts()) : the_post(); ?>
	    		<article class="single-content">
		    		
		    		<div class="article-content">
		    			<?php the_content(); ?>
		    			<?php wp_link_pages('link_before=<span>&link_after=</span>&before=<div class="article-paging">&after=</div>&next_or_number=number'); ?>
		    			<?php if(_DGA('down_position') == 'bottom' || _DGA('down_position') == 'sidebottom' || _DGA('down_position') == 'side') DGAThemes_erphpdown_box();?>
		            </div>
		    		<?php endwhile;  ?>
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