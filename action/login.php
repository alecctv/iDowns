<?php 
require( dirname(__FILE__) . '/../../../../wp-load.php' ); 
if($_POST['action']){ 
	$action = $_POST['action'];
	if($action == 'mobantu_login'){
		$username = $wpdb->escape($_POST['log']);   
    	$password = $wpdb->escape($_POST['pwd']);   
		$login_data = array();   
		$login_data['user_login'] = $username;   
		$login_data['user_password'] = $password;   
		$login_data['remember'] = true;   
		$user_verify = wp_signon( $login_data, false );  
		if ( is_wp_error($user_verify) ) {    
			echo "0";   
		} else {    
			echo "1";
		}  
	}elseif($action == 'mobantu_register'){
		$sanitized_user_login = sanitize_user( $_POST['user_register'] );
    	$user_email = apply_filters( 'user_registration_email', $_POST['user_email'] );
		
		if ( $sanitized_user_login == '' ) {
			$error .= '请输入用户名 ';
		  } elseif ( ! validate_username( $sanitized_user_login ) ) {
			$error .= '此用户名包含无效字符，请输入有效的用户名 ';
			$sanitized_user_login = '';
		  } elseif ( username_exists( $sanitized_user_login ) ) {
			$error .= '该用户名已被注册 ';
		  }
		
		  if ( $user_email == '' ) {
			$error .= '请填写电子邮件地址 ';
		  } elseif ( ! is_email( $user_email ) ) {
			$error .= '电子邮件地址不正确 ';
			$user_email = '';
		  } elseif ( email_exists( $user_email ) ) {
			$error .= '该电子邮件地址已经被注册 ';
		  }
		  
		  if($_POST['password'] == '') $error .= '请输入密码 ';
		  elseif(strlen($_POST['password']) < 6) $error .= '密码长度不得小于6位 ';
		  
		  if(empty($_POST['captcha']) || empty($_SESSION['MBT_modown_captcha']) || trim(strtolower($_POST['captcha'])) != $_SESSION['MBT_modown_captcha']){
		  	  $error .= '验证码错误 ';
		  }

		  if(_DGA('captcha') == 'email'){
			  if($_SESSION['MBT_modown_captcha_email'] != $user_email){
			  	  $error .= '验证码与邮箱不对应 ';
			  }
		  }
		  
		  if($error){ echo $error;}
		  else{
		  	unset($_SESSION['MBT_modown_captcha']);
			unset($_SESSION['MBT_modown_captcha_email']);
		  	//$new_password = wp_generate_password(7, false); //生成7位随机密码   
		  	$new_password = $_POST['password'];
		  	$userdata=array(
			  'ID' => '',
			  'user_login' => $sanitized_user_login,
			  'user_pass' => $new_password,
			  'user_email' => $user_email,
			  'role' => get_option('default_role'),
			);
			$user_id = wp_insert_user( $userdata );
			if ( is_wp_error( $user_id ) ) {
				echo "系统超时，请稍后重试";
			}else{
				wp_set_auth_cookie($user_id,true,false);
				//wp_set_password( $new_password, $user_id ); 
				/*$message = __('注册成功！') . "\r\n\r\n";   
				$message .= sprintf(__('用户名: %s'), $sanitized_user_login) . "\r\n\r\n";   
				$message .= sprintf(__('密码: %s'), $new_password) . "\r\n\r\n";   
				wp_mail($user_email, '注册成功-'.get_bloginfo('name'), $message);    */
				echo "1";
			}
		  }
	}elseif($action == 'password'){
		$passname = $wpdb->escape($_POST['passname']);
		$user_login = '';
		$user_email = '';
		if(!is_email($passname)) {
			$user_login = $passname;
			if(!username_exists( $user_login )){
				$error = "用户名不存在";
			}else{
				$user_data = get_userdatabylogin($passname);
				$user_email = $user_data->user_email;
				if(empty($user_email)){
					$error = "用户未设定邮箱";
				}
			}
		}else{
			$user_email = $passname;
			if(!email_exists( $user_email )){
				$error = "邮箱不存在";
			}else{
				$user_data = get_user_by_email($passname);
				$user_login = $user_data->user_login;
			}
		}
		
		
		
		if($error){ echo $error;}
		else{
			$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login)); 
			if(empty($key)) {
				$key = wp_generate_password(20, false); 
				$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login)); 
			}   
			   
			
			$verify_url = get_permalink(DGAThemes_page('template/login.php')) . "?action=reset_password&key=".md5('dga'.$key)."&login=" . rawurlencode($user_login); 
			
			
			$subject = '[' . get_option('blogname') . '] 重置密码';
			$message = '<table cellpadding="0" cellspacing="0" align="center" style="text-align:left;font-family:Microsoft Yahei,arial;" width="742"><tbody><tr><td><table cellpadding="0" cellspacing="0" style="text-align:left;border:1px solid #000;color:#fff;font-size:18px;" width="740"><tbody><tr height="45" style="background-color:#000;"><td style="padding-left:15px;font-family:Microsoft Yahei,arial;font-size:24px;">'.get_bloginfo("name").' </td></tr></tbody></table><table cellpadding="0" cellspacing="0" style="text-align:left;border:1px solid #f0f0f0;border-top:none;color:#585858;background-color:#fafafa;font-size:14px;" width="740"><tbody><tr height="25"><td></td></tr><tr height="40"><td style="padding-left:25px;padding-right:25px;font-size:18px;font-family:Microsoft Yahei,arial;"> 尊敬的'.$user_login.'： </td></tr><tr height="15"><td></td></tr><tr height="30"><td style="padding-left:55px;padding-right:55px;font-family:Microsoft Yahei,arial;font-size:14px;line-height:20px;">您刚刚发起了重置密码请求，请点击下面的链接重置密码： </td></tr><tr height="15"><td></td></tr><tr height="30"><td style="padding-left:55px;padding-right:55px;font-family:Microsoft Yahei,arial;font-size:14px;line-height:20px;"><a href="'.$verify_url.'" target="_blank">'.$verify_url.'</a> </td></tr><tr height="15"><td></td></tr><tr height="30"><td style="padding-left:55px;padding-right:55px;font-family:Microsoft Yahei,arial;font-size:14px;line-height:20px;"> 如果不是您本人操作，请忽略此邮件。</td></tr><tr height="20"><td></td></tr><tr><td style="padding-left:55px;padding-right:55px;font-family:Microsoft Yahei,arial;font-size:14px;"> 此致<br>'.get_bloginfo("name").'</td></tr><tr height="50"><td></td></tr></tbody></table><table cellpadding="0" cellspacing="0" style="color:#969696;font-size:12px;vertical-align:middle;text-align:center;" width="740"><tbody><tr height="5"><td></td></tr><tr height="20"><td width="680" style="text-align:left;font-family:Microsoft Yahei,arial"> '.date("Y").' <span>©</span> <a href="'.get_bloginfo("url").'" target="_blank" style="text-decoration:none;color:#969696;padding-left:5px;" title="'.get_bloginfo("name").'">'.get_bloginfo("url").'</a> </td><td width="30" style="text-align:right;font-family:Microsoft Yahei,arial"></td><td width="30" style="text-align:right;font-family:Microsoft Yahei,arial"></td></tr></tbody></table></td></tr></tbody></table>';   
			$from = 'From: "' . get_option('blogname') . '"';
			$headers = $from . '' . "\n" . 'Content-Type: text/html; charset=' . get_option('blog_charset') . "\n";
			
			
			if ( $message && !wp_mail($user_email, $subject, $message, $headers) ) {   
		       	echo "1";
		        exit();   
		    } else {   
		        echo "邮件发送失败，请稍后重试";
		        exit();   
		    }
		}
		
		
	}elseif($action == 'reset'){
		$reset_key = $_POST['key']; 
		$user_login = $_POST['username']; 
		$newpass = $_POST['resetpass']; 
		$user_data = $wpdb->get_row($wpdb->prepare("SELECT ID, user_login, user_email, user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));   
		$user_login = $user_data->user_login;   
		$user_email = $user_data->user_email;   
		if(!empty($reset_key) && !empty($user_data) && md5('dga'.$user_data->user_activation_key) == $reset_key) {  
			wp_set_password( $newpass, $user_data->ID ); 
			$key = wp_generate_password(20, false); 
			$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login)); 
 
			$verify_url = get_permalink(DGAThemes_page('template/login.php'));   
			
			$subject = '[' . get_option('blogname') . '] 密码修改成功';
			$message = '<table cellpadding="0" cellspacing="0" align="center" style="text-align:left;font-family:Microsoft Yahei,arial;" width="742"><tbody><tr><td><table cellpadding="0" cellspacing="0" style="text-align:left;border:1px solid #000;color:#fff;font-size:18px;" width="740"><tbody><tr height="45" style="background-color:#000;"><td style="padding-left:15px;font-family:Microsoft Yahei,arial;font-size:24px;">'.get_bloginfo("name").' </td></tr></tbody></table><table cellpadding="0" cellspacing="0" style="text-align:left;border:1px solid #f0f0f0;border-top:none;color:#585858;background-color:#fafafa;font-size:14px;" width="740"><tbody><tr height="25"><td></td></tr><tr height="40"><td style="padding-left:25px;padding-right:25px;font-size:18px;font-family:Microsoft Yahei,arial;"> 尊敬的'.$user_login.'： </td></tr><tr height="15"><td></td></tr><tr height="30"><td style="padding-left:55px;padding-right:55px;font-family:Microsoft Yahei,arial;font-size:14px;line-height:20px;"> 您的密码修改成功，用户名：'.$user_login.'&nbsp;&nbsp;&nbsp;&nbsp;新密码：'.$newpass.'</td></tr><tr height="15"><td></td></tr><tr height="30"><td style="padding-left:55px;padding-right:55px;font-family:Microsoft Yahei,arial;font-size:14px;line-height:20px;">请牢记密码，您可以点击下面的链接登录： </td></tr><tr height="15"><td></td></tr><tr height="30"><td style="padding-left:55px;padding-right:55px;font-family:Microsoft Yahei,arial;font-size:14px;line-height:20px;"><a href="'.$verify_url.'" target="_blank">'.$verify_url.'</a> </td></tr><tr height="20"><td></td></tr><tr><td style="padding-left:55px;padding-right:55px;font-family:Microsoft Yahei,arial;font-size:14px;"> 此致<br>'.get_bloginfo("name").'</td></tr><tr height="50"><td></td></tr></tbody></table><table cellpadding="0" cellspacing="0" style="color:#969696;font-size:12px;vertical-align:middle;text-align:center;" width="740"><tbody><tr height="5"><td></td></tr><tr height="20"><td width="680" style="text-align:left;font-family:Microsoft Yahei,arial"> '.date("Y").' <span>©</span> <a href="'.get_bloginfo("url").'" target="_blank" style="text-decoration:none;color:#969696;padding-left:5px;" title="'.get_bloginfo("name").'">'.get_bloginfo("url").'</a> </td><td width="30" style="text-align:right;font-family:Microsoft Yahei,arial"></td><td width="30" style="text-align:right;font-family:Microsoft Yahei,arial"></td></tr></tbody></table></td></tr></tbody></table>';   
			$from = 'From: "' . get_option('blogname') . '"';
			$headers = $from . '' . "\n" . 'Content-Type: text/html; charset=' . get_option('blog_charset') . "\n";
			wp_mail($user_email, $subject, $message, $headers);
			
			
			echo "1";
		}else{
			echo "非法请求";
		}
	}
	
}
?>
