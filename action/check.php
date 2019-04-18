<?php 
require( dirname(__FILE__) . '/../../../../wp-load.php' ); 
if($_POST['action']){ 
	$action = $_POST['action'];
	$error = "1";
	if($action == 'name'){
		$sanitized_user_login = sanitize_user( $_POST['user_register'] );
		if(strlen($sanitized_user_login) < 6){
			$error = '用户名至少6位字符 ';
		}elseif ( $sanitized_user_login == '' ) {
			$error = '请输入用户名 ';
		  } elseif ( ! validate_username( $sanitized_user_login ) ) {
			$error = '此用户名包含无效字符，请输入有效的用户名 ';
			$sanitized_user_login = '';
		  } elseif ( username_exists( $sanitized_user_login ) ) {
			$error = '该用户名已被注册，请再选择一个 ';
		  }
	  
	}elseif($action == 'email'){
		$user_email = apply_filters( 'user_registration_email', $_POST['user_email'] );

		if ( $user_email == '' ) {
			$error = '请填写邮箱地址 ';
		  } elseif ( ! is_email( $user_email ) ) {
			$error = '邮箱格式不正确 ';
			$user_email = '';
		  } elseif ( email_exists( $user_email ) ) {
			$error = '该邮箱已被注册，请换一个 ';
		  }
	}

	echo $error;
}
?>
