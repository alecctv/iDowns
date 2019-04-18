<?php 
session_start();
require( dirname(__FILE__) . '/../../../../wp-load.php' );
global $wpdb;
if ( is_user_logged_in() ) { 
	global $current_user; 
	get_currentuserinfo();
	$uid = $current_user->ID;
	
	if($_POST['action']=='user.edit'){
		
		$userdata = array();
		$userdata['ID'] = $uid;
		$userdata['nickname'] = str_replace(array('<','>','&','"','\'','#','^','*','_','+','$','?','!'), '', $wpdb->escape(trim($_POST['nickname'])) );
		wp_update_user($userdata);
		update_user_meta($uid, 'qq', $wpdb->escape(trim($_POST['qq'])) );
		$error = 0;	

		$arr=array(
			"error"=>$error, 
			"msg"=>$msg
		); 
		$jarr=json_encode($arr); 
		echo $jarr;
	}elseif($_POST['action']=='user.email'){
		$user_email = apply_filters( 'user_registration_email', $wpdb->escape(trim($_POST['email'])) );
		$error = 0;$msg = '';
		if ( $user_email == '' ) {
			$error = 1;
			$msg = '邮箱不能为空';
		} elseif ( $user_email == $current_user->user_email) {
			$error = 1;
			$msg = '请输入一个新邮箱账号';
		}elseif ( email_exists( $user_email ) && $user_email != $current_user->user_email) {
			$error = 1;
			$msg = '邮箱已被使用';
		}else{
			if(empty($_POST['captcha']) || empty($_SESSION['MBT_email_captcha']) || trim(strtolower($_POST['captcha'])) != $_SESSION['MBT_email_captcha']){
				$error = 1;
				$msg .= '验证码错误 ';
			}elseif($_SESSION['MBT_email_new'] != $user_email){
				$error = 1;
				$msg = '邮箱与验证码不对应';
			}else{
				unset($_SESSION['MBT_email_captcha']);
				unset($_SESSION['MBT_email_new']);
				$userdata = array();
				$userdata['ID'] = $uid;
				$userdata['user_email'] = $user_email;
				wp_update_user($userdata);
				$error = 0;	
			}
		}
		
		$arr=array(
			"error"=>$error, 
			"msg"=>$msg
		); 
		$jarr=json_encode($arr); 
		echo $jarr;
	}elseif($_POST['action']=='user.email.captcha'){
		$user_email = apply_filters( 'user_registration_email', $wpdb->escape(trim($_POST['email'])) );
		$error = 0;$msg = '';
		if ( $user_email == '' ) {
			$error = 1;
			$msg = '邮箱不能为空';
		} elseif ( $user_email == $current_user->user_email) {
			$error = 1;
			$msg = '请输入一个新邮箱账号';
		} elseif ( email_exists( $user_email ) && $user_email != $current_user->user_email) {
			$error = 1;
			$msg = '邮箱已被使用';
		}else{
			
			$originalcode = '0,1,2,3,4,5,6,7,8,9';
			$originalcode = explode(',',$originalcode);
			$countdistrub = 10;
			$_dscode = "";
			$counts=6;
			for($j=0;$j<$counts;$j++){
				$dscode = $originalcode[rand(0,$countdistrub-1)];
				$_dscode.=$dscode;
			}
			session_start();
			$_SESSION['MBT_email_captcha']=strtolower($_dscode);
			$_SESSION['MBT_email_new']=$user_email;
			$message .= '验证码：'.$_dscode;   
			wp_mail($user_email, '验证码-修改邮箱-'.get_bloginfo('name'), $message);    
			$error = 0;	
		}
		
		$arr=array(
			"error"=>$error, 
			"msg"=>$msg
		); 
		$jarr=json_encode($arr); 
		echo $jarr;
	}elseif($_POST['action']=='user.password'){
		$error = 0;$msg = '';
		$username = $wpdb->escape(wp_get_current_user()->user_login);   
    	$password = $wpdb->escape($_POST['passwordold']); 
		$login_data = array();
		$login_data['user_login'] = $username;   
		$login_data['user_password'] = $password;   
		$user_verify = wp_signon( $login_data, false );  
		if ( is_wp_error($user_verify) ) {    
			$error = 1;$msg = '原密码错误';   
		}else{
			$userdata = array();
			$userdata['ID'] = wp_get_current_user()->ID;
			$userdata['user_pass'] = $_POST['password'];
			wp_update_user($userdata);
		}
		$arr=array(
			"error"=>$error, 
			"msg"=>$msg
		); 
		$jarr=json_encode($arr); 
		echo $jarr; 
	}elseif($_POST['action']=='user.vip'){
		$error = 0;$msg = '';
		$userType=isset($_POST['userType']) && is_numeric($_POST['userType']) ?intval($_POST['userType']) :0;
		
		if($userType >6 && $userType < 11){
			$okMoney=erphpGetUserOkMoney();
			$priceArr=array('7'=>'ciphp_month_price','8'=>'ciphp_quarter_price','9'=>'ciphp_year_price','10'=>'ciphp_life_price');
			$priceType=$priceArr[$userType];
			$price=get_option($priceType);
			if(empty($price) || $price == ''){
				$error = 1;$msg = '会员价格错误';
			}elseif($okMoney < $price){
				$error = 1;$msg = '余额不足';
			}elseif($okMoney >=$price){
				if(erphpSetUserMoneyXiaoFei($price)){
					if(userPayMemberSetData($userType)){
						addVipLog($price, $userType);
					}else{
						$error = 1;$msg = '升级失败';
					}
				}else{
					$error = 1;$msg = '升级失败';
				}
			}else{
				$error = 1;$msg = '升级失败';
			}
			
			$arr=array(
				"error"=>$error, 
				"msg"=>$msg
			); 
		}else{
			$error = 1;$msg = '升级失败';
			$arr=array(
				"error"=>$error, 
				"msg"=>$msg
			);
		}
		
		$jarr=json_encode($arr); 
		echo $jarr; 
	}elseif($_POST['action']== 'user.charge.card'){
		$error = 0;$msg = '';
		$num = $wpdb->escape($_POST['num']);
		$pass = $wpdb->escape($_POST['pass']);
		$result = checkDoCardResult($num,$pass);
		if($result == '5'){
			$error = 1;
			$msg = '充值卡不存在！';
		}elseif($result == '0'){
			$error = 1;
			$msg = '充值卡已被使用！';
		}elseif($result == '2'){
			$error = 1;
			$msg = '充值卡密码错误！';
		}elseif($result == '1'){
			
		}else{
			$error = 1;
			$msg = '系统错误，请稍后重试！';
		}
		$arr=array(
				"error"=>$error, 
				"msg"=>$msg
			);

		$jarr=json_encode($arr); 
		echo $jarr; 
	}elseif($_POST['action'] == 'user.tixian'){
		$fee=get_option("ice_ali_money_site");
			$fee=isset($fee) ?$fee :100;
			$userMoney=$wpdb->get_row("select * from ".$wpdb->iceinfo." where ice_user_id=".$current_user->ID);
			/////////////////////////////////////////////////www.mobantu.com   82708210@qq.com
			$okMoney = erphpGetUserOkMoney();

			$ice_alipay = $wpdb->escape($_POST['ice_alipay']);
			$ice_name   = $wpdb->escape($_POST['ice_name']);
			$ice_money  = isset($_POST['ice_money']) && is_numeric($_POST['ice_money']) ?$_POST['ice_money'] :0;
			$ice_money = $wpdb->escape($ice_money);

			
			if($ice_money<get_option("ice_ali_money_limit"))
			{
				$error = 1;
				$msg = '提现金额至少得满'.get_option("ice_ali_money_limit").get_option("ice_name_alipay").'';
			}
			elseif(empty($ice_name) || empty($ice_alipay))
			{
				$error = 1;
				$msg = '请输入支付宝帐号和姓名';
			}
			elseif($ice_money > $okMoney)
			{
				$error = 1;
				$msg = '提现金额大于可提现金额'.$okMoney;
			}
			else
			{
		
				$sql="insert into ".$wpdb->iceget."(ice_money,ice_user_id,ice_time,ice_success,ice_success_time,ice_note,ice_name,ice_alipay)values
					('".$ice_money."','".$current_user->ID."','".date("Y-m-d H:i:s")."',0,'".date("Y-m-d H:i:s")."','','$ice_name','$ice_alipay')";
				if($wpdb->query($sql))
				{
					addUserMoney($current_user->ID, '-'.$ice_money);
					$error = 0;
					$msg = '申请成功，等待管理员处理！';
				}
				else
				{
					$error = 1;
					$msg = '系统错误，请稍后重试！';
				}
			}

			$arr=array(
			"error"=>$error, 
			"msg"=>$msg
			); 
			$jarr=json_encode($arr); 
			echo $jarr;
	}
}
?>