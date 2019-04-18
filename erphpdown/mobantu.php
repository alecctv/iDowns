<?php
//by yunsheji.cc
function DGAThemes_erphpdown_box(){
	global $post, $wpdb;
	$start_down=get_post_meta(get_the_ID(), 'start_down', true);
	$days=get_post_meta(get_the_ID(), 'down_days', true);
	$price=get_post_meta(get_the_ID(), 'down_price', true);
	$url=get_post_meta(get_the_ID(), 'down_url', true);
	$memberDown=get_post_meta(get_the_ID(), 'member_down',TRUE);
	$hidden=get_post_meta(get_the_ID(), 'hidden_content', true);
	$nosidebar = get_post_meta(get_the_ID(),'nosidebar',true);
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
		if($nosidebar || _DGA('down_position') == 'top' || _DGA('down_position') == 'sidetop' || _DGA('down_position') == 'bottom' || _DGA('down_position') == 'sidebottom') echo '<style>.erphpdown-box{display:block;}</style>';
		echo '<div class="erphpdown-box">';
		if($price){
			echo '<div class="item price"><t>下载价格：</t><span>'.$price.'</span> '.get_option("ice_name_alipay").'</div>';
		}else{
			if($memberDown != 4)
				echo '<div class="item price"><t>下载价格：</t><span>免费</span></div>';
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
					echo '<div class="item vip vip-only">此资源仅对VIP开放下载'.$vip.'</div>';
				}else{
					if($down_info){
						echo '<a href='.constant("erphpdown").'download.php?url='.$down_info->ice_url.' target="_blank" class="down"><i class="dripicons dripicons-download"></i> 已购买，立即下载</a>';
					}else{
						if ($memberDown==6 && ($userType == 9 || $userType == 10)){
							echo '<a href='.constant("erphpdown").'download.php?postid='.get_the_ID().' target="_blank" class="down"><i class="dripicons dripicons-download"></i> 立即下载</a>';
						}elseif ($memberDown==7 && $userType == 10){
							echo '<a href='.constant("erphpdown").'download.php?postid='.get_the_ID().' target="_blank" class="down"><i class="dripicons dripicons-download"></i> 立即下载</a>';
						}elseif( ($memberDown==3 || $memberDown==4) && $userType){
							echo '<a href='.constant("erphpdown").'download.php?postid='.get_the_ID().' target="_blank" class="down"><i class="dripicons dripicons-download"></i> 立即下载</a>';
						}else{
							echo '<a href='.constant("erphpdown").'icealipay-pay-center.php?postid='.get_the_ID().' class="down erphp-box"><i class="dripicons dripicons-download"></i> 立即购买</a>';
							if($days){
								echo '<div class="tips">（此资源购买后'.$days.'天内可下载）</div>';
							}
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
					echo '<div class="item vip vip-only">此资源仅对VIP开放下载'.$vip.'</div>';
				}
				echo '<a href="javascript:;" class="down signin-loader">请先登录</a>';
			}
		}else{
			if($memberDown != 4){
				echo '<a href='.constant("erphpdown").'download.php?postid='.get_the_ID().' target="_blank" class="down"><i class="dripicons dripicons-download"></i> 立即下载</a>';
			}
		}
		$downtimes = get_post_meta(get_the_ID(),'down_times',true);
		if(_DGA('post_downloads')) echo '<div class="meta">下载量：'.($downtimes?$downtimes:'0').'</div>';
		if(get_option('ice_tips')) echo '<div class="item tips2"><t>下载说明：</t>'.get_option('ice_tips').'</div>';
		echo '</div>';
	}
}


function DGAThemes_erphpdown_download($msg,$pid){
	get_header();
?>
	<link rel="stylesheet" href="<?php echo constant("erphpdown"); ?>static/erphpdown.css" type="text/css" />
	<div class="main">
		<div class="container">
			<div class="content-wrap" style="margin-bottom: 10px;text-align: center;">
		    	<div class="content" style="display: inline-block;min-width: 480px;">
		    		<article class="single-content">
			    		<div class="article-content">
			    			<div class="erphpdown-msg">
			    				<div class="title"><span>资源名称</span></div>
                				<p><a href="<?php the_permalink($pid);?>" target="_blank"><?php echo get_the_title($pid);?></a></p>
			    				<?php echo $msg; ?>
			    			</div>
			    			<?php if(_DGA('ad_erphpdown_s')){?>
			    			<div class="erphpdown-ad"><?php echo _DGA('ad_erphpdown');?></div>
			    			<?php }?>
			            </div>
		            </article>
		    	</div>
		    </div>
		</div>
	</div>
<?php
	get_footer();
	exit;
}


function getUserBuyTrue($uid,$pid){
	global $wpdb;
	$days=get_post_meta($pid, 'down_days', true);
	$down_info=$wpdb->get_row("select * from ".$wpdb->icealipay." where ice_post='".$pid."' and ice_success=1 and ice_user_id=".$uid." order by ice_time desc");
	if($days > 0){
		$lastDownDate = date('Y-m-d H:i:s',strtotime('+'.$days.' day',strtotime($down_info->ice_time)));
		$nowDate = date('Y-m-d H:i:s');
		if(strtotime($nowDate) > strtotime($lastDownDate)){
			$down_info = null;
		}
	}
	if($down_info) 
		return true;
	return false;
}