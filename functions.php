<?php 
// OPTIONS
error_reporting(0);
if( is_admin() ){
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
	require_once dirname( __FILE__ ) . '/inc/options-framework.php';
	require_once dirname( __FILE__ ) . '/inc/options.php';
}
if ( !defined( 'THEME_DIR' ) ) {
	define( 'THEME_DIR', get_template_directory() );
}
if ( !defined( 'THEME_URI' ) ) {
	define( 'THEME_URI', get_template_directory_uri() );
}
$themever = wp_get_theme('Version');
define( 'THEME_VER', $themever );
require_once dirname( __FILE__ ) . '/inc/init.php';
require_once dirname( __FILE__ ) . '/inc/main.php';
require_once dirname( __FILE__ ) . '/inc/widgets.php';
require_once dirname( __FILE__ ) . '/inc/shortcodes.php';
require_once dirname( __FILE__ ) . '/inc/metabox.php';
require_once dirname( __FILE__ ) . '/inc/auth/qq.php';
require_once dirname( __FILE__ ) . '/inc/auth/weibo.php';
require_once dirname( __FILE__ ) . '/inc/auth/weixin.php';
require_once dirname( __FILE__ ) . '/inc/includes/class-theme-check.php';
require_once dirname( __FILE__ ) . '/erphpdown/mobantu.php';

/**
 * 重置缩略图的默认尺寸
 *
 */
function idowns_rest_thumbnail(){
	    update_option('thumbnail_size_w', 385);
	    update_option('thumbnail_size_h', 280);
	    update_option( 'thumbnail_crop', 1 );
}
add_action('load-themes.php', 'idowns_rest_thumbnail');

/**
 * 强制使用伪静态
 */
function idowns_force_permalink(){
    if(!get_option('permalink_structure')){
        update_option('permalink_structure', '/%post_id%.html');
        // TODO: 添加后台消息提示已更改默认固定链接，并请配置伪静态(伪静态教程等)
    }
}
add_action('load-themes.php', 'idowns_force_permalink');

// Customize your functions
// 本文件只有48行代码，如果多出来其他不明函数，请检测您的其他主题是否有木马感染！
// 
