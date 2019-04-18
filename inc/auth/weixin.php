<?php 
session_start();
class WEIXIN_LOGIN{

	function login($appid,$appkey,$code){
		if($_REQUEST ['state'] == 'MBT_weixin_login'){
		
			$token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appkey."&code=".$code."&grant_type=authorization_code";
			$response = get_url_contents ( $token_url );
			$msg = json_decode ( $response );
			if (isset ( $msg->errcode )) {
				echo "<h3>error:</h3>" . $msg->errcode;
				echo "<h3>msg  :</h3>" . $msg->errmsg;
				exit ();
			}else{
				
				$_SESSION ['weixin_access_token'] = $msg->access_token;
				$_SESSION ['weixin_open_id'] = $msg->openid;
			}
		}else{
			echo ("The state does not match. You may be a victim of CSRF.");
			exit;
		}
	}
	
	function weixin_cb(){
		if(is_user_logged_in()){
			exit('<meta charset="UTF-8" />您已登录，请在个人中心绑定。');
		}else{
			global $wpdb;
			if(isset($_SESSION ['weixin_open_id'])){
				
				$user_ID = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE weixinid='".$wpdb->escape($_SESSION['weixin_open_id'])."'");
				if($user_ID){
					wp_set_auth_cookie($user_ID,true,false);
					wp_redirect(get_bloginfo('url'));
					exit();
				}else{
				
					$uinfo = $this->wx_oauth2_get_user_info($_SESSION ['weixin_access_token'],$_SESSION ['weixin_open_id']);
					$pass = wp_create_nonce(rand(10,1000));
					$login_name = "u".mt_rand(1000,9999).mt_rand(1000,9999).mt_rand(1000,9999).mt_rand(1000,9999);
					$username = $uinfo->nickname;
					$userdata=array(
					  'user_login' => $login_name,
					  'display_name' => $username,
					  'nickname' => $username,
					  'user_pass' => $pass,
					  'role' => get_option('default_role'),
					  'first_name' => $username
					);
					$user_id = wp_insert_user( $userdata );
					if ( is_wp_error( $user_id ) ) {
						echo $user_id->get_error_message();
					}else{
		
						$ff = $wpdb->query("UPDATE $wpdb->users SET weixinid = '".$wpdb->escape($_SESSION['weixin_open_id'])."' WHERE ID = '$user_id'");
						if($ff){
							update_user_meta($user_id, 'photo', $uinfo->headimgurl);
							update_user_meta($user_id, 'weixin_name', $username);
							wp_set_auth_cookie($user_id,true,false);
							wp_redirect(get_bloginfo('url'));
						}
			   
					}
					exit();
				}
				
			}
		}
	}

	function weixin_bd(){
		if(is_user_logged_in()){
			global $wpdb;
			if(isset($_SESSION ['weixin_open_id'])){
				
				$hsauser_ID = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE weixinid='".$wpdb->escape($_SESSION['weixin_open_id'])."'");
				if($hsauser_ID){
					exit('<meta charset="UTF-8" />绑定失败，可能之前已有其他账号绑定，请先登录其他账户解绑。');
				}else{
					global $current_user;
					$userid = $current_user->ID;
					$uinfo = $this->wx_oauth2_get_user_info($_SESSION ['weixin_access_token'],$_SESSION ['weixin_open_id']);
					
					$wpdb->query("UPDATE $wpdb->users SET weixinid = '".$wpdb->escape($_SESSION['weixin_open_id'])."' WHERE ID = $userid");
					update_user_meta($userid, 'weixin_name', $uinfo->nickname);
					wp_redirect(get_permalink(DGAThemes_page("template/user.php")).'?action=info');
				}

			}
		}else{
			exit('<meta charset="UTF-8" />绑定失败，请先登录。');
		}
	}
	
	
	function wx_oauth2_get_user_info($access_token, $openid){
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
		$res = get_url_contents($url);
		return json_decode($res);
	}

}
