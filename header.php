<!DOCTYPE HTML>
<html itemscope="itemscope" itemtype="http://schema.org/WebPage">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<meta name="apple-mobile-web-app-title" content="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
<meta http-equiv="Cache-Control" content="no-siteapp">
<title><?php wp_title( '-', true, 'right' ); ?></title>
<?php DGAThemes_keywords();DGAThemes_description();?>
<link rel="shortcut icon" href="<?php echo _DGA('favicon')?>">
<?php wp_head();?>
<!--[if lt IE 9]><script src="<?php bloginfo('template_url') ?>/static/js/html5.min.js"></script><![endif]-->
<!-- jquery -->
<script src="<?php bloginfo('template_url') ?>/static/js/jquery.min.js"></script>
<script>window._DGA = {uri: '<?php bloginfo('template_url') ?>', url:'<?php bloginfo('url');?>', roll: [<?php echo _DGA('sidebar_fixed');?>]}</script>
<?php if(_DGA('xiongzhang')){?>
<script src="//msite.baidu.com/sdk/c.js?appid=<?php echo _DGA('xiongzhang_appid');?>"></script>
<?php }?>
<script>
    $(document).ready(function() {
        NProgress.start();
        $(window).load(function() {
            NProgress.done();
        });
    });
</script>
<style>
<?php 
DGAThemes_color(); 
DGAThemes_animation(); 
echo _DGA('css');

?>
</style>
</head>
<body <?php body_class(); ?>>
  <?php if( _DGA('isloading',true) ){?>
  <div id="loading"> 
    <div id="loading-center"> 
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
    </div>
  </div>
  <?php }?>
<?php if (_DGA('is_header_sps',true) && !is_page_template( 'template/user.php' )) {
  $sps = "sps";
} else {
  $sps = "";
}?>
<header class="header <?php echo $sps;?>">

  <div class="container">
    <?php _the_logo(); ?>
    <div class="sitenav">
      <ul><?php _the_menu('main'); ?></ul>
    </div>
    <span class="sitenav-on"><i class="fa">&#xe605;</i></span>
    <span class="sitenav-mask"></span>
    <?php if( _DGA('sign_s') ){
      if( is_user_logged_in() ){
        global $current_user;
      ?>
        <div class="signuser-welcome">
           <a href="javascript:void(0)" data-toggle="modal" data-target="#globalSearch" data-backdrop="1" style=" float: left; margin-right: 20px; "><span class="nav-search-btn"><i class="fa">&#xe600;</i></span></a>
          <a class="signuser-info" href="<?php echo get_permalink(DGAThemes_page("template/user.php"));?>" title="个人中心"><?php echo get_avatar($current_user->ID,50);?><strong><?php echo $current_user->display_name ?></strong></a>
          <?php if( $current_user->roles[0] == 'administrator'|| $current_user->roles[0] == 'editor') { ?>
              <a class="signuser-logout" target="_blank" title="进入WP后台管理面板" href="<?php echo home_url("/wp-admin/index.php"); ?>">后台</a>
          <?php } ?>
          <a class="signuser-logout" href="<?php echo wp_logout_url( get_bloginfo('url') ); ?>">退出</a>
        </div>
      <?php }else{ ?>
        <div class="usersign">
           <a href="javascript:void(0)" data-toggle="modal" data-target="#globalSearch" data-backdrop="1" style=" float: left; margin-right: 20px; "><span class="nav-search-btn"><i class="fa">&#xe600;</i></span></a>
          <?php if( _DGA('isloginpop') ){ $isloginpop = 'signin-loader'; } else { $isloginpop = 'no-pop'; } ?>
          <a class="<?php echo $isloginpop ?> usersign-login" href="<?php echo get_permalink(DGAThemes_page("template/login.php"));?>">登录</a>
          <?php if( get_option('users_can_register') ){ ?><a class="<?php echo $isloginpop ?> usersign-register" href="<?php echo get_permalink(DGAThemes_page("template/login.php")); ?>?action=register">注册</a><?php } ?>
        </div>
      <?php } ?>
    <?php } ?>
  </div>
</header>