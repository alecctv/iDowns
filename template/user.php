<?php 
/*
	template name: 个人中心
	description: template for yunsheji.cc iDowns theme 
*/
if(!is_user_logged_in()){
	header("Location:".get_permalink(DGAThemes_page("template/login.php")));
}
get_header();
global $current_user;
$moneyName = get_option('ice_name_alipay');
$okMoney = erphpGetUserOkMoney();

?>


<?php 
if ($_GET['action'] == 'info' && $_GET['qqid'] == 'no') {
	global $wpdb;
	$userid = $current_user->ID;
	$sql = $wpdb->query("UPDATE $wpdb->users SET qqid='' WHERE ID = $userid");
	if ($sql) {
		echo "<script>alert('解绑QQ成功！');location.reload();</script>";
	}
}
if($_POST) {

	if($_POST['ice_alipay']){
				
			
	}

  	if($_POST['paytype']){
			$paytype=intval($_POST['paytype']);
			$doo = 1;
			
			if(isset($_POST['paytype']) && $paytype==3)
			{
				$url=get_bloginfo('url')."/wp-content/plugins/erphpdown/payment/chinabank.php?ice_money=".$wpdb->escape($_POST['ice_money']);
			}
			elseif(isset($_POST['paytype']) && $paytype==1)
			{
				$url=get_bloginfo('url')."/wp-content/plugins/erphpdown/payment/alipay.php?ice_money=".$wpdb->escape($_POST['ice_money']);
			}
			elseif(isset($_POST['paytype']) && $paytype==7)
			{
				$url=get_bloginfo('url')."/wp-content/plugins/erphpdown/payment/tenpay.php?ice_money=".$wpdb->escape($_POST['ice_money']);
			}
			elseif(isset($_POST['paytype']) && $paytype==4)
			{
				$url=get_bloginfo('url')."/wp-content/plugins/erphpdown/payment/weixin/example/weixin.php?ice_money=".$wpdb->escape($_POST['ice_money']);
			}
			elseif(isset($_POST['paytype']) && $paytype==8)
			{
				$url=get_bloginfo('url')."/wp-content/plugins/erphpdown/payment/alipay_jk.php?ice_money=".$wpdb->escape($_POST['ice_money']);
			}
			elseif(isset($_POST['paytype']) && $paytype==2)
			{
				$url=get_bloginfo('url')."/wp-content/plugins/erphpdown/payment/paypal.php?ice_money=".$wpdb->escape($_POST['ice_money']);
			}
			elseif(isset($_POST['paytype']) && $paytype==9)
		    {
		        $url=constant("erphpdown")."payment/xhpay.php?ice_money=".esc_sql($_POST['ice_money']);
		    }
		    elseif(isset($_POST['paytype']) && $paytype==10)
		    {
		        $url=constant("erphpdown")."payment/xhpay2.php?ice_money=".esc_sql($_POST['ice_money']);
		    }
		    elseif(isset($_POST['paytype']) && $paytype==11)
		    {
		        $url=constant("erphpdown")."payment/xhpay3.php?ice_money=".esc_sql($_POST['ice_money']);
		    }
		    elseif(isset($_POST['paytype']) && $paytype==12)
		    {
		        $url=constant("erphpdown")."payment/xhpay4.php?ice_money=".esc_sql($_POST['ice_money']);
		    }elseif(isset($_POST['paytype']) && $paytype==13)
		    {
		        $url=constant("erphpdown")."payment/codepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=1";
		    }elseif(isset($_POST['paytype']) && $paytype==14)
		    {
		        $url=constant("erphpdown")."payment/codepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=3";
		    }elseif(isset($_POST['paytype']) && $paytype==15)
		    {
		        $url=constant("erphpdown")."payment/codepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=2";
		    }elseif(isset($_POST['paytype']) && $paytype==16)
		    {
		        $url=constant("erphpdown")."payment/youzan.php?ice_money=".esc_sql($_POST['ice_money']);
		    }
			else{
				
			}
			if($doo) echo "<script>location.href='".$url."'</script>";
			exit;
	}
}
?>

<div class="main">
	<link rel='stylesheet' href="<?php echo get_template_directory_uri().'/static/css/user.css' ?>" type='text/css' media='all' />
	<div class="container container-user">
	  <div class="userside">
	    <div class="usertitle"> <?php echo get_avatar($current_user->ID,50);?>
	      <h2><?php echo $current_user->nickname;?></h2>
	      <?php if(getUsreMemberTypeById($current_user->ID)) echo '<span>VIP用户</span>';?>
	    </div>
	    <div class="usermenus">
	      <ul class="usermenu">
	        <li class="usermenu-charge <?php if($_GET['action'] == 'charge' || !isset($_GET['action'])) echo 'active';?>"><a href="?action=charge"><i class="dripicons dripicons-ticket"></i> 在线充值</a></li>
	        <li class="usermenu-vip <?php if($_GET['action'] == 'vip') echo 'active';?>"><a href="?action=vip"><i class="dripicons dripicons-jewel"></i> 升级 VIP</a></li>
	        <li class="usermenu-user <?php if($_GET['action'] == 'info') echo 'active';?>"><a href="?action=info"><i class="dripicons dripicons-document-edit"></i> 我的资料</a></li>
	        <li class="usermenu-history <?php if($_GET['action'] == 'history') echo 'active';?>"><a href="?action=history"><i class="dripicons dripicons-stack"></i> 充值记录</a></li>
	        <li class="usermenu-order <?php if($_GET['action'] == 'order') echo 'active';?>"><a href="?action=order"><i class="dripicons dripicons-download"></i> 下载清单</a></li>
	        <li class="usermenu-aff <?php if($_GET['action'] == 'aff') echo 'active';?>"><a href="?action=aff"><i class="dripicons dripicons-link-broken"></i> 我的推广</a></li>
	       	<li class="usermenu-outmo <?php if($_GET['action'] == 'outmo' || $_GET["action"]=='tixian') echo 'active';?>"><a href="?action=outmo"><i class="dripicons dripicons-suitcase"></i> 站内提现</a></li>
			<li class="usermenu-comments <?php if($_GET['action'] == 'comment') echo 'active';?>"><a href="?action=comment"><i class="dripicons dripicons-conversation"></i> 我的评论</a></li>
	        <li class="usermenu-password <?php if($_GET['action'] == 'password') echo 'active';?>"><a href="?action=password"><i class="dripicons dripicons-lock"></i> 修改密码</a></li>
	        <li class="usermenu-signout"><a href="<?php echo wp_logout_url(get_bloginfo("url"));?>"><i class="dripicons dripicons-exit"></i> 安全退出</a></li>
	      </ul>
	    </div>
	  </div>
	  <div class="content" id="contentframe">
	    <div class="user-main">
	      <?php if($_GET['action'] == 'vip'){ ?>
	          <!---------------------------------------------------升级会员开始-->
	          <div class="charge vip">
	                <h2>
	                    <?php 
	                    $ciphp_year_price    = get_option('ciphp_year_price');
	                    $ciphp_quarter_price = get_option('ciphp_quarter_price');
	                    $ciphp_month_price  = get_option('ciphp_month_price');
	                    $ciphp_life_price  = get_option('ciphp_life_price');
	                    $userTypeId=getUsreMemberType();
	                    if($userTypeId==7){
	                        echo "您目前是VIP包月会员";
	                    }elseif ($userTypeId==8){
	                        echo "您目前是VIP包季会员";
	                    }elseif ($userTypeId==9){
	                        echo "您目前是VIP年费会员";
	                    }elseif ($userTypeId==10){
	                        echo "您目前是VIP终身会员";
	                    }else {
	                        echo '您未购买任何VIP服务';
	                    }
	                    echo ($userTypeId>0&&$userTypeId<10) ?'&nbsp;&nbsp;&nbsp;到期时间：'.getUsreMemberTypeEndTime() :'';
	                    ?>
	                    
	                </h2>


	                <form>
	                    <div class="vip-radio">
	                        <?php if($ciphp_life_price){?><input type="radio" id="userType" name="userType" value="10" checked="checked" /> VIP 终身会员（<?php echo $ciphp_life_price.get_option('ice_name_alipay')?>）&nbsp;<?php }?>
	                        <?php if($ciphp_year_price){?><input type="radio" id="userType" name="userType" value="9" checked="checked"/> VIP 包年会员（<?php echo $ciphp_year_price.get_option('ice_name_alipay')?> ）&nbsp;<?php }?>
	                        <?php if($ciphp_quarter_price){?><input type="radio" id="userType" name="userType" value="8" checked="checked"/> VIP 包季会员（<?php echo $ciphp_quarter_price.get_option('ice_name_alipay')?> ）&nbsp;<?php }?>
	                        <?php if($ciphp_month_price){?><input type="radio" id="userType" name="userType" value="7" checked="checked"/> VIP 包月会员（<?php echo $ciphp_month_price.get_option('ice_name_alipay')?> ）&nbsp;<?php }?>
	                    </div>&nbsp;
	                    <div class="vip-btn">
	                    <?php if ($userTypeId==10) { ?>
	                    	<input type="button" disabled="disabled" value="你已经是最高级别" class="btn" style=" opacity: .5; ">
	                    <?php }else{ ?>
	                    	<input type="button" value="升级会员" class="btn" evt="user.vip.submit" onClick="return confirm('确认升级成为VIP? 已开通vip再次升级时间会自动叠加！');">
	                    <?php } ?>
	                    </div>
	                    <input type="hidden" name="action" value="user.vip">
	                </form>
	                
	                <ul class="tips">
	                    <li>【可用余额】<font color="#ff5f33"><?php echo $okMoney;?> <?php echo $moneyName;?></font>（刷新查看最新数据）；</li>
	                </ul>
	          </div>
	          <!---------------------------------------------------升级会员结束-->
	      <?php }elseif($_GET['action'] == 'history'){ ?>
	      	  <!---------------------------------------------------充值记录开始-->
	          <?php 
			  	    $totallists = $wpdb->get_var("SELECT count(*) FROM $wpdb->icemoney WHERE ice_success=1 and ice_user_id=".$current_user->ID);
					$perpage = 15;
					$pagess = ceil($totallists / $perpage);
					if (!get_query_var('paged')) {
						$paged = 1;
					}else{
						$paged = $wpdb->escape(get_query_var('paged'));
					}
					$offset = $perpage*($paged-1);
					$lists = $wpdb->get_results("SELECT * FROM $wpdb->icemoney where ice_success=1 and ice_user_id=".$current_user->ID." order by ice_time DESC limit $offset,$perpage");
			  ?>
	          <?php if($lists) {?>
	          <table class="table table-striped table-hover user-orders">
	          	  <thead>
	              	  <tr><th width="140">充值时间</th><th width="60">金额(<?php echo $moneyName;?>)</th><th width="180">方式</th><th width="180">状态</th></tr></thead>
	              <tbody>
	              <?php foreach($lists as $value){?>
	            	  <tr><td><?php echo $value->ice_time;?><br></td><td><dfn><?php echo $value->ice_money;?></dfn></td>
	                  <?php if(intval($value->ice_note)==0){echo "<td><font color=green>在线充值</font></td>\n";}elseif(intval($value->ice_note)==1){echo "<td>后台充值</td>\n";}elseif(intval($value->ice_note)==2){echo "<td><font color=blue>转账收款</font></td>\n";}elseif(intval($value->ice_note)==3){echo "<td><font color=orange>转账付款</font></td>\n";}elseif(intval($value->ice_note)==4){echo "<td><font color=orange>mycred兑换</font></td>\n";}elseif(intval($value->ice_note)==6){echo "<td><font color=orange>充值卡</font></td>\n";}else{echo '<td></td>';}?><td>成功</td></tr>
			      <?php }?>
	              </tbody>
	          </table>
	          <?php DGAThemes_custom_paging($paged,$pagess);?>
	          <div class="user-alerts">
	          	  <h4>充值常见问题：</h4>
	          	  <ul><li>付款后系统会与支付服务方进行交互读取数据，可能会导致到账延迟，一般不会超过2分钟。</li></ul>
	          </div>
	          <?php }else{?>
	          <div class="user-ordernone"><h6>暂无记录！</h6></div>
	          <?php }?>
	          <!---------------------------------------------------充值记录结束-->
	      <?php }elseif($_GET['action'] == 'order'){ ?>
	      	  <!---------------------------------------------------下载清单开始-->
	          <?php 
			  	    $totallists = $wpdb->get_var("SELECT COUNT(ice_id) FROM $wpdb->icealipay WHERE ice_success>0 and ice_user_id=".$current_user->ID);
					$perpage = 15;
					$pagess = ceil($totallists / $perpage);
					if (!get_query_var('paged')) {
						$paged = 1;
					}else{
						$paged = $wpdb->escape(get_query_var('paged'));
					}
					$offset = $perpage*($paged-1);
					$lists = $wpdb->get_results("SELECT * FROM $wpdb->icealipay where ice_success=1 and ice_user_id=$current_user->ID order by ice_time DESC limit $offset,$perpage");
			  ?>
	          <?php if($lists) {?>
	          <div class="user-orders">
	              <ul>
	              <?php foreach($lists as $value){?>
	            	  <div class="userlist-wrap">
						<div class="userlist-inside">
							<span class="userlist-title"><i class="dripicons dripicons-to-do"></i><?php echo $value->ice_num;?></span>
							<span class="userlist-notitle"><a target="_blank" href="<?php echo get_permalink($value->ice_post);?>"><?php echo get_post($value->ice_post)->post_title;?></a></span>
							<span class="userlist-title"><i class="dripicons dripicons-ticket"></i><?php echo $value->ice_price;?>（<?php echo $moneyName;?>）</span>
							<span class="userlist-title"><i class="dripicons dripicons-clock"></i><?php echo $value->ice_time;?></span>
							<span class="userlist-title-right"><a href="<?php echo get_bloginfo('wpurl').'/wp-content/plugins/erphpdown/download.php?url='.$value->ice_url;?>" target="_blank"><i class="dripicons dripicons-download"></i>下载页面</a></span>
						</div>
					</div>
			      <?php }?>
	              </ul>
	          </div>
	          <?php DGAThemes_custom_paging($paged,$pagess);?>
	          <?php }else{?>
	          <div class="user-ordernone"><h6>暂无记录！</h6></div>
	          <?php }?>
	          <!---------------------------------------------------下载清单结束-->
	      <?php }elseif($_GET['action'] == 'aff'){ ?>
	      	  <!---------------------------------------------------我的推广开始-->
	          <div class="charge">
				  <h2 style="padding-top:40px;">您的专属推广链接：<font color="#5bc0de"><?php bloginfo("url");?>/?aff=<?php echo $current_user->ID;?></font></h2>
			  </div>
	          <?php 
			  	    $totallists = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->users WHERE father_id=".$current_user->ID);
			  	    $perpage = 15;
					$pagess = ceil($totallists / $perpage);
					if (!get_query_var('paged')) {
						$paged = 1;
					}else{
						$paged = $wpdb->escape(get_query_var('paged'));
					}
					$offset = $perpage*($paged-1);
					$lists = $wpdb->get_results("SELECT ID,user_login,user_registered FROM $wpdb->users where father_id=".$current_user->ID." order by user_registered DESC limit $offset,$perpage");
			  ?>
	          <?php if($lists) {?>
	          <table class="table table-striped table-hover user-orders">
	          	  <thead>
	              	  <tr>
	          			<th width="40%">用户</th>
	                    <th width="40%">注册时间</th>
	                    <th width="20%">消费额</th>
	                  </tr>
	              </thead>
	              <tbody>
	              <?php foreach($lists as $value){?>
	            	  <tr>
	                  	<td><?php echo $value->user_login;?></td>
	                  	<td><?php echo $value->user_registered;?></td>
	                  	<td><?php $tt = $wpdb->get_var("SELECT SUM(ice_price) FROM $wpdb->icealipay WHERE ice_success>0 and ice_user_id=".$value->ID);echo $tt?$tt:"0";?></td>
	                  </tr>
			      <?php }?>
	              </tbody>
	          </table>
	          <?php DGAThemes_custom_paging($paged,$pagess);?>
	          <?php }else{?>
	          <div class="user-ordernone"><h6>暂无记录！</h6></div>
	          <?php }?>
	          <div class="user-alerts">
	            <h4>推广说明：</h4>
	            <ul>
	                <li>请勿作弊，否则封相关账户不通知； </li>
	                <li>推广链接可以是任意页面后加 <span class="label label-info">?aff=<?php echo $current_user->ID;?></span>即可；</li>
	            </ul>
	            </div>
	      <?php }elseif($_GET["action"]=='outmo'){ //站内提现开始
				$totallists = $wpdb->get_var("SELECT count(*) FROM $wpdb->iceget WHERE ice_user_id=".$current_user->ID);
				$ice_perpage = 10;
				$pages = ceil($totallists / $ice_perpage);
				$page=isset($_GET['pp']) ?intval($_GET['pp']) :1;
				$offset = $ice_perpage*($page-1);
				$lists = $wpdb->get_results("SELECT * FROM $wpdb->iceget where ice_user_id=".$current_user->ID." order by ice_time DESC limit $offset,$ice_perpage");
				?>
				<div class="alert"><p><a href="?action=tixian">有收入了？去申请提现>></a></p></div>
            	<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th width="20%">申请金额</th>
							<th width="40%">申请时间</th>
							<th width="20%">到账金额</th>
							<th width="20%">状态</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if($lists) {
								foreach($lists as $value)
								{
									$result=$value->ice_success==1?'已支付':'--';
									echo "<tr>\n";
									echo "<td>$value->ice_money</td>\n";
									echo "<td>$value->ice_time</td>\n";
									echo "<td>".sprintf("%.2f",(((100-get_option("ice_ali_money_site"))*$value->ice_money)/100))."</td>\n";
									echo "<td>$result</td>\n";
									echo "</tr>";
								}
							}
							else
							{
								echo '<tr><td colspan="4" align="center"><center><strong>没有记录！</strong></center></td></tr>';
							}
						?>
					</tbody>
				</table>
				<?php DGAThemes_custom_paging('outmo',$page,$pages);?>
			<?php }elseif($_GET["action"]=='tixian'){////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////站内提现
				$fee=get_option("ice_ali_money_site");
				$fee=isset($fee) ?$fee :100;
				$userMoney=$wpdb->get_row("select * from ".$wpdb->iceinfo." where ice_user_id=".$current_user->ID);
				
				/////////////////////////////////////////////////www.mobantu.com   82708210@qq.com
				
				$userAli=$wpdb->get_row("select * from ".$wpdb->iceget." where ice_user_id=".$current_user->ID);
			?>
				<div class="content" id="contentframe">
					<form>

						<ul class="user-meta">
							<li>
				                <label>可提现额度</label>
				            	<strong id="money"><?php echo sprintf("%.2f",$okMoney)?></strong><?php echo get_option('ice_name_alipay')?>
				            </li>
				            <li>
				                <label>手续费</label>
				            	<strong id="sxf"><?php echo get_option("ice_ali_money_site")?>%</strong>
				            </li>
				            <li>
				                <label>支付宝账号</label>
				            	 <input type="text" class="form-control" name="ice_alipay" value="<?php echo $userAli->ice_alipay;;?>">
				            </li>
				           	<li>
				                <label>支付宝姓名</label>
				                <input type="text" class="form-control" name="ice_name" value="<?php echo $userAli->ice_name;?>">
				            </li>
				            <li>
				                <label>提现金额</label>
				                <input type="number" class="form-control" name="ice_money" value="">
				            </li>

				            <li>
				                <input type="button" evt="user.tixian.submit" class="btn btn-primary" value="提交申请">
				                <input type="hidden" name="action" value="user.tixian">
				            </li>
			            </ul>

						
					</form>
				</div>

			  <!---------------------------------------------------我的推广结束-->
	      <?php }elseif($_GET['action'] == 'comment'){ ?>
	      	  <!---------------------------------------------------我的评论开始-->
	          <?php 
			  	$perpage = 10;
				if (!get_query_var('paged')) {
					$paged = 1;
				}else{
					$paged = $wpdb->escape(get_query_var('paged'));
				}
				$total_comment = $wpdb->get_var("select count(comment_ID) from $wpdb->comments where comment_approved='1' and user_id=".$current_user->ID);
				$pagess = ceil($total_comment / $perpage);
				$offset = $perpage*($paged-1);
				$results = $wpdb->get_results("select $wpdb->comments.comment_ID,$wpdb->comments.comment_post_ID,$wpdb->comments.comment_content,$wpdb->comments.comment_date,$wpdb->posts.post_title from $wpdb->comments left join $wpdb->posts on $wpdb->comments.comment_post_ID = $wpdb->posts.ID where $wpdb->comments.comment_approved='1' and $wpdb->comments.user_id=".$current_user->ID." order by $wpdb->comments.comment_date DESC limit $offset,$perpage");
				if($results){
			  ?>
	          <ul class="user-commentlist">
	            <?php foreach($results as $result){?>
	          	<li><time><?php echo $result->comment_date;?></time><p class="note"><?php echo $result->comment_content;?></p><p class="text-muted">文章：<a target="_blank" href="<?php echo get_permalink($result->comment_post_ID);?>"><?php echo $result->post_title;?></a></p></li>
	            <?php }?>
	          </ul>
	          <?php DGAThemes_custom_paging($paged,$pagess);?>
	          <?php }else{?>
	          <div class="user-ordernone"><h6>暂无评论！</h6></div>
	          <?php }?>
	          <!---------------------------------------------------我的评论结束-->
	      <?php }elseif($_GET['action'] == 'info'){ ?>
	      	  <!---------------------------------------------------我的资料开始-->
	          <?php $userMoney=$wpdb->get_row("select * from ".$wpdb->iceinfo." where ice_user_id=".$current_user->ID);?>
	          <form>
	            <ul class="user-meta">
	              <li>
	                <label>用户名</label>
	                <?php echo $current_user->user_login;?> </li>
	              </li>
	              
	              <li>
	                <label>账户</label>
	                已消费 <?php echo intval($userMoney->ice_get_money);?> , 剩余 <?php echo intval($okMoney);?>
	            	</li>
	              <li>
	                <label>昵称</label>
	                <input type="input" class="form-control" name="nickname" value="<?php echo $current_user->nickname;?>">
	              </li>
	              <li>
	                <input type="button" evt="user.data.submit" class="btn btn-primary" value="修改资料">
	                <input type="hidden" name="action" value="user.edit">
	              </li>
	            </ul>
	          </form>
	          <!-- 绑定操作 -->
				<?php if(_DGA('oauth_qq')){ ?>
		            <ul class="user-meta">
		              <li>
		                <label>社交登陆</label>
		                <?php if ($current_user->qqid) {
		                	$is_email =$current_user->user_email;
		                	$is_qq_name =get_user_meta($current_user->ID, 'qq_name',true );

		                	if (!$is_email && $is_qq_name) {
								echo '您使用QQ注册的本站，请完善邮箱信息';
		                	}else{
		                		$jb_url = home_url().'/user?action=info&qqid=no';
								echo '已绑定（'.$is_qq_name.'）<a href="'.$jb_url.'">-点击解绑</a>';
		                	}
		                	
		                }else{ 
							echo '<a href="'.home_url().'/oauth/qq?rurl='.home_url().'/user?action=info">绑定QQ账户</a>';
		                } ?>
		                
		              </li>
		            </ul>
				<?php } ?>
	          <form>
	            <ul class="user-meta">
		            <li>
		                <label>绑定邮箱</label>
		                <input type="email" class="form-control" name="email" value="<?php echo $current_user->user_email;?>">
		              </li>
		              <li>
		                <label>验证码</label>
		                <input type="text" class="form-control" name="captcha" value="" style="width:150px;display:inline-block"> <input type="button" evt="user.email.captcha.submit" class="btn btn-primary" style="display:inline-block;margin-top:10px;padding:6px 15px;" id="captcha_btn" value="获取验证码">
		              </li>
		              <li>
		                <input type="button" evt="user.email.submit" class="btn btn-primary" value="修改邮箱">
		                <input type="hidden" name="action" value="user.email">
		              </li>               
	            </ul>
	          <div class="user-alerts">
	          	  <h4>注意事项：</h4>
	          	  <ul>
	                      <li>请务必修改成你正确的邮箱地址，以便于忘记密码时用来重置密码。</li>
	                      <li>获取验证码时，邮件发送时间有时会稍长，请您耐心等待。</li>
	                 </ul>
	          </div>
	          </form>
	          <!---------------------------------------------------我的资料结束-->
	      <?php }elseif($_GET['action'] == 'password'){ ?>
	      	  <!---------------------------------------------------修改密码开始-->
	          <form>
	            <ul class="user-meta">
	              <li>
	                <label>原密码</label>
	                <input type="password" class="form-control" name="passwordold">
	              </li>
	              <li>
	                <label>新密码</label>
	                <input type="password" class="form-control" name="password">
	              </li>
	              <li>
	                <label>重复新密码</label>
	                <input type="password" class="form-control" name="password2">
	              </li>
	              <li>
	                <input type="button" evt="user.data.submit" class="btn btn-primary" value="修改密码">
	                <input type="hidden" name="action" value="user.password">
	              </li>
	            </ul>
	          </form>
	          <!---------------------------------------------------修改密码结束-->
	      <?php }else{ 
	      	
	      	?>
	          <!---------------------------------------------------在线充值开始-->
	          <div class="charge">
	            <h2>欢迎来到<?php bloginfo("name");?>！</h2>
	            <form id="charge-form" action="" method="post">
	              	<div class="item">
	              		<?php if(_DGA('recharge_price_s')){
	              			$prices = _DGA('recharge_price');
	              			if($prices){
	              				$price_arr = explode(',',$prices);
	              				echo '<div class="prices">';
	              				foreach ($price_arr as $price) {
	              					echo '<input type="radio" name="ice_money" id="ice_money'.$price.'" value="'.$price.'" checked><label for="ice_money'.$price.'" evt="price.select">'.$price.'元</label>';
	              				}
	              				echo '</div>';
	              			}
	              		?>
	              		（1 元 = <?php echo get_option('ice_proportion_alipay')?> <?php echo $moneyName;?>）
	              		<?php }else{?>
		                <input type="number" class="form-control" name="ice_money" required="" placeholder="充值金额（元），1 元 = <?php echo get_option('ice_proportion_alipay')?> <?php echo $moneyName;?>">
		            <?php }?>
		              	<input type="submit" value="在线充值" class="btn">
		            </div>
		            <div class="item">
	                    <?php if(get_option('ice_weixin_mchid')){?> 
                        <input type="radio" id="paytype4" class="paytype" checked name="paytype" value="4" onclick="checkCard()" />微信&nbsp;
                        <?php }?>
                        <?php if(get_option('ice_ali_partner')){?> 
                        <input type="radio" id="paytype1" class="paytype" checked name="paytype" value="1" onclick="checkCard()" />支付宝&nbsp;
                        <?php }?>
                        <?php if(get_option('erphpdown_tenpay_uid')){?> 
                        <input type="radio" id="paytype7" class="paytype" checked name="paytype" value="7" onclick="checkCard()" />财付通&nbsp;    
                        <?php }?> 
                        <?php if(get_option('ice_china_bank_uid')){?> 
                        <input type="radio" id="paytype3" class="paytype" checked name="paytype" value="3" onclick="checkCard()"/>银联支付&nbsp;    
                        <?php }?>
                        <?php if(get_option('erphpdown_zfbjk_uid')){?> 
                        <input type="radio" id="paytype8" class="paytype" checked name="paytype" value="8" onclick="checkCard()"/>支付宝转账自动充值&nbsp;    
                        <?php }?>
                        <?php if(get_option('erphpdown_xhpay_appid')){?> 
		                <input type="radio" id="paytype9" class="paytype" name="paytype" value="9" checked onclick="checkCard()"/>支付宝&nbsp;
		                <input type="radio" id="paytype10" class="paytype" name="paytype" value="10" checked onclick="checkCard()"/>微信&nbsp;        
		                <?php }?> 
		                <?php if(get_option('erphpdown_xhpay_appid2')){?> 
		                <input type="radio" id="paytype11" class="paytype" name="paytype" value="11" checked onclick="checkCard()"/>支付宝&nbsp;
		                <input type="radio" id="paytype12" class="paytype" name="paytype" value="12" checked onclick="checkCard()"/>微信&nbsp;        
		                <?php }?>
		                <?php if(get_option('erphpdown_codepay_appid')){?> 
		                <input type="radio" id="paytype13" class="paytype" name="paytype" value="13" checked onclick="checkCard()"/>支付宝&nbsp;
		                <input type="radio" id="paytype14" class="paytype" name="paytype" value="14" onclick="checkCard()"/>微信&nbsp;
		                <input type="radio" id="paytype15" class="paytype" name="paytype" value="15" onclick="checkCard()"/>QQ钱包&nbsp;        
		                <?php }?>
		                <?php if(get_option('erphpdown_youzan_id')){?> 
		                <input type="radio" id="paytype16" class="paytype" name="paytype" value="16" checked onclick="checkCard()"/>有赞支付&nbsp;    
		                <?php }?> 
                        <?php if(get_option('ice_payapl_api_uid')){?> 
                        <input type="radio" id="paytype2" class="paytype" checked name="paytype" value="2" onclick="checkCard()"/>PayPal($美元)汇率：
                         (<?php echo get_option('ice_payapl_api_rmb')?>)&nbsp;  
                         <?php }?> 
	                </div>
	                
	            </form>
	            <?php if(function_exists("checkDoCardResult")){?>
	            <form id="charge-form" action="" method="post">
	              	<div class="item">
		                <input type="text" class="form-control" id="erphpcard_num" name="erphpcard_num" required="" placeholder="卡号">
		            </div>
		            <div class="item">
	                    <input type="password" class="form-control" id="erphpcard_pass" name="erphpcard_pass" required="" placeholder="卡密">
	                </div>
	                <div class="item">
		              	<input type="button" evt="user.charge.card.submit" value="充值卡充值" class="btn">
		            </div>
	            </form>
	            <?php }?>
	            <ul class="tips">
	              <li>【可用余额】<font color="#ff5f33"><?php echo $okMoney;?> <?php echo $moneyName;?></font>（充值后，刷新查看最新数据）；</li>
	            </ul>
	          </div>
	          
	          <!---------------------------------------------------在线充值结束-->
	      <?php }?>
	    </div>
	    <div class="user-tips"></div>
	  </div>
	</div>
	<script src="<?php bloginfo("template_url")?>/static/js/user.js"></script>
	
</div>
<?php get_footer();?>