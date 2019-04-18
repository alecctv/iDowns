<aside class="sidebar">
	<?php 
		if(is_singular() && (_DGA('down_position') == 'side' || _DGA('down_position') == 'sidetop' || _DGA('down_position') == 'sidebottom')){
			$start_down=get_post_meta(get_the_ID(), 'start_down', true);
			$days=get_post_meta(get_the_ID(), 'down_days', true);
			$price=get_post_meta(get_the_ID(), 'down_price', true);
			$url=get_post_meta(get_the_ID(), 'down_url', true);
			$memberDown=get_post_meta(get_the_ID(), 'member_down',TRUE);
			$hidden=get_post_meta(get_the_ID(), 'hidden_content', true);
			$userType=getUsreMemberType();
			
			$erphp_url_front_vip = get_bloginfo('wpurl').'/wp-admin/admin.php?page=erphpdown/admin/erphp-update-vip.php';
			if(get_option('erphp_url_front_vip')){
				$erphp_url_front_vip = get_option('erphp_url_front_vip');
			}
			$erphp_url_front_login = wp_login_url();
			if(get_option('erphp_url_front_login')){
				$erphp_url_front_login = get_option('erphp_url_front_login');
			}

			if($start_down && !_DGA('is_shop_posts_box','true')){
				echo '<div class="widget widget-erphpdown">';


				if($price){
					echo '<div class="item price"><font>'.$price.'</font> <span>'.get_option("ice_name_alipay").'</span></div>';
				}else{
					if($memberDown != 4)
						echo '<div class="item price"><t>免费</t></div>';
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
									// if($days){
									// 	echo '<div class="tips">（此资源购买后'.$days.'天内可下载）</div>';
									// }
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
						echo '<a href="javascript:;" class="down signin-loader">请先登录</a>';
					}
				}else{
					if($memberDown != 4){
						echo '<a href='.constant("erphpdown").'download.php?postid='.get_the_ID().' target="_blank" class="down"><i class="dripicons dripicons-download"></i> 立即下载</a>';
					}
				}

				$down_ifnoban = get_post_meta(get_the_ID(), 'down_ifnoban', true);
				$down_ifnoge = get_post_meta(get_the_ID(), 'down_ifnoge', true);
				$down_ifnoda = get_post_meta(get_the_ID(), 'down_ifnoda', true);
				$down_ifnoyao = get_post_meta(get_the_ID(), 'down_ifnoyao', true);
				$down_timeago = DGAThemes_timeago( get_the_modified_time(get_the_time('Y-m-d G:i:s')) );
				$down_demo = get_post_meta(get_the_ID(), 'down_demo', true);
				?>
				<?php if ($down_demo) { ?>
					<a href="<?php echo $down_demo;?>" target="_blank" class="down erphp-demo" style=" margin-top: 0 !important; background: #69c15a !important; "><i class="dripicons dripicons-link-broken"></i> 演示地址</a>
				<?php }?>
				

				<table id="isa-edd-specs">
				  <tbody>
				    <tr>
				      <td>
				          <font>最近更新：</font>
				      </td>
				      <td>
				          <font><?php echo $down_timeago; ?></font>
				      </td>
				    </tr>

				    <?php if($down_ifnoban){ ?>
				    <tr>
				      <td>
				        <font>当前版本：</font>
				      </td>
				      <td>
				        <font><?php echo $down_ifnoban; ?></font>
				      </td>
				    </tr>
				    <?php } ?>

					<?php if($down_ifnoge){ ?>
				    <tr>
				      <td>
				        <font>文件格式：</font>
				      </td>
				      <td>
				        <font><?php echo $down_ifnoge; ?></font>
				      </td>
				    </tr>
				    <?php } ?>

				    <?php if($down_ifnoda){ ?>
				    <tr>
				      <td>
				        <font>文件大小：</font>
				      </td>
				      <td>
				        <font><?php echo $down_ifnoda; ?></font>
				      </td>
				    </tr>
				    <?php } ?>
				    
				    <?php if($down_ifnoyao){ ?>
				    <tr>
				      <td>
				        <font>要求：</font>
				      </td>
				      <td>
				        <font><?php echo $down_ifnoyao; ?></font>
				      </td>
				    </tr>
				    <?php } ?>
				   
				    <?php 
				    	$downtimes = get_post_meta(get_the_ID(),'down_times',true);
						if(_DGA('post_downloads')) echo '<tr> <td> <font> 下载量：</font> </td> <td> <font>'.($downtimes?$downtimes:'0').'</font> </td> </tr>';
					?>
				    
				  </tbody>
				</table>

				<?php
				if(get_option('ice_tips')) echo '<div class="tips">'.get_option('ice_tips').'</div>';
				
				if($days){
					echo '<div class="tips">（此资源购买后'.$days.'天内可下载）</div>';
				}
				echo '</div>';
			}
		}
	?>

	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_single')) : endif; ?>
			    
</aside>