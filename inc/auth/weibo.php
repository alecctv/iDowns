<?php
class WEIBO_LOGIN{
	function __construct(){
		session_start();
	}

	function login($appid, $callback) {
		$_SESSION['rurl'] = $_REQUEST ["rurl"];
		$_SESSION ['state'] = md5 ( uniqid ( rand (), true ) ); //CSRF protection
		$login_url = "https://api.weibo.com/oauth2/authorize?client_id=".$appid."&response_type=code&redirect_uri=".$callback."&state=".$_SESSION['state'];
		header ( "Location:$login_url" );
	}

	function callback($appid,$appkey,$path){
		if ($_REQUEST ['state'] == $_SESSION ['state']) {
			$url = "https://api.weibo.com/oauth2/access_token";
			$data = "client_id=".$appid."&client_secret=".$appkey."&grant_type=authorization_code&redirect_uri=".$path."&code=".$_REQUEST ["code"];
			$output = json_decode(do_post($url,$data));
			$_SESSION['access_token'] = $output->access_token;
			$_SESSION['uid'] = $output->uid;
		}else{
			echo ("The state does not match. You may be a victim of CSRF.");
			exit;
		}
	}

	function get_user_info() {
		$get_user_info = "https://api.weibo.com/2/users/show.json?uid=".$_SESSION['uid']."&access_token=".$_SESSION['access_token'];
		return get_url_contents ( $get_user_info );
	}

	function get_user_id() {
		$get_user_id = "https://api.weibo.com/2/account/get_uid.json?access_token=".$_SESSION['access_token'];
		return get_url_contents ( $get_user_id );
	}
	
	function sina_cb(){
		if(is_user_logged_in()){
			exit('<meta charset="UTF-8" />您已登录，请在个人中心绑定。');
		}else{
			global $wpdb;
			$uidArray = json_decode($this->get_user_id());
			if( isset($_SESSION['uid']) && $uidArray->uid == $wpdb->escape($_SESSION['uid']) && isset($_SESSION['access_token']) ){
				
				$user_ID = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE sinaid='".$uidArray->uid."'");
				if ( $user_ID > 0 ) {
					wp_set_auth_cookie($user_ID,true,false);
					wp_redirect($_SESSION['rurl']);
					exit();
				}else{
					
					$pass = wp_create_nonce(rand(10,1000));
					$str = json_decode($this->get_user_info());
					$login_name = "u".mt_rand(1000,9999).mt_rand(1000,9999).mt_rand(1000,9999).mt_rand(1000,9999);
					$username = $str->screen_name;
					$userimg = $str->avatar_large;
					$description = $str->description;

					$userdata=array(
					  'user_login' => $login_name,
					  'display_name' => $username,
					  'user_pass' => $pass,
					  'role' => get_option('default_role'),
					  'nickname' => $username,
					  'first_name' => $username,
					  'description'=> $description
					);
					$user_id = wp_insert_user( $userdata );
					if ( is_wp_error( $user_id ) ) {
						echo $user_id->get_error_message();
					}else{
						$ff = $wpdb->query("UPDATE $wpdb->users SET sinaid = '".$uidArray->uid."' WHERE ID = '$user_id'");
						if ($ff) {
							update_user_meta($user_id, 'weibo_name', $username);
							update_user_meta($user_id, 'photo', $userimg);
							wp_set_auth_cookie($user_id,true,false);
							wp_redirect($_SESSION['rurl']);
						}          
					}
					exit();
				}
			}
		}
	}

	function sina_bd(){
		if(is_user_logged_in()){
			global $wpdb;
			$uidArray = json_decode($this->get_user_id());
			if( isset($_SESSION['uid']) && $uidArray->uid == $wpdb->escape($_SESSION['uid']) && isset($_SESSION['access_token']) ){
				
				$hsauser_ID = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE sinaid='".$uidArray->uid."'");
				if($hsauser_ID){
					exit('<meta charset="UTF-8" />绑定失败，可能之前已有其他账号绑定，请先登录其他账户解绑。');
				}else{
					global $current_user;
					$userid = $current_user->ID;
					$wpdb->query("UPDATE $wpdb->users SET sinaid = '".$uidArray->uid."' WHERE ID = $userid");
					
					$str = json_decode($this->get_user_info());
					update_user_meta($userid, 'weibo_name', $str->screen_name);
					wp_redirect($_SESSION['rurl']);
					exit();
					
				}
				
			}
		}else{
			exit('<meta charset="UTF-8" />绑定失败，请先登录。');
		}
	}
	
}