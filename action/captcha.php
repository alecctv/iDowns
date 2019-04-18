<?php
session_start();
require_once(dirname(__FILE__)."/../../../../wp-load.php");
if($_POST['action'] == 'mobantu_captcha' && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	
	$user_email = apply_filters( 'user_registration_email', $_POST['email'] );
	$user_email = $wpdb->escape(trim($user_email));
	
	if ( email_exists( $user_email ) ){
		echo "2";
	}else{
		sessioncode($user_email);
		echo "1";
	}
}

function sessioncode($email){
	$originalcode = '0,1,2,3,4,5,6,7,8,9';
	$originalcode = explode(',',$originalcode);
	$countdistrub = 10;
	$_dscode = "";
	$counts=6;
	for($j=0;$j<$counts;$j++){
		$dscode = $originalcode[rand(0,$countdistrub-1)];
		$_dscode.=$dscode;
	}
	
	$_SESSION['MBT_modown_captcha']=strtolower($_dscode);
	$_SESSION['MBT_modown_captcha_email']=$email;
	$message .= '验证码：'.$_dscode;   
	wp_mail($email, '验证码-'.get_bloginfo('name'), $message);    
}

?>