<?php 

add_theme_support( 'post-formats', array( 'video', 'gallery') );

/*
是否启用压缩网站源码
*/

if(_DGA('iswebgizp',true)){
  function wp_compress_html(){
      function wp_compress_html_main ($buffer){
          $initial=strlen($buffer);
          $buffer=explode("<!--wp-compress-html-->", $buffer);
          $count=count ($buffer);
          for ($i = 0; $i <= $count; $i++){
              if (stristr($buffer[$i], '<!--wp-compress-html no compression-->')) {
                  $buffer[$i]=(str_replace("<!--wp-compress-html no compression-->", " ", $buffer[$i]));
              } else {
                  $buffer[$i]=(str_replace("\t", " ", $buffer[$i]));
                  $buffer[$i]=(str_replace("\n\n", "\n", $buffer[$i]));
                  $buffer[$i]=(str_replace("\n", "", $buffer[$i]));
                  $buffer[$i]=(str_replace("\r", "", $buffer[$i]));
                  while (stristr($buffer[$i], '  ')) {
                      $buffer[$i]=(str_replace("  ", " ", $buffer[$i]));
                  }
              }
              $buffer_out.=$buffer[$i];
          }
          $final=strlen($buffer_out);   
          $savings=($initial-$final)/$initial*100;   
          $savings=round($savings, 2);   
          $buffer_out.="\n<!--压缩前的大小: $initial bytes; 压缩后的大小: $final bytes; 节约：$savings% -->";   
      return $buffer_out;
  }
  ob_start("wp_compress_html_main");
  }
  add_action('get_header', 'wp_compress_html');
}



//移除 WP_Head 无关紧要的代码
if(_DGA('remove_head_links',true)){
  remove_action( 'wp_head', 'wp_generator');          //删除 head 中的 WP 版本号
  foreach (['rss2_head', 'commentsrss2_head', 'rss_head', 'rdf_header', 'atom_head', 'comments_atom_head', 'opml_head', 'app_head'] as $action) {
    remove_action( $action, 'the_generator' );
  }

  remove_action( 'wp_head', 'rsd_link' );           //删除 head 中的 RSD LINK
  remove_action( 'wp_head', 'wlwmanifest_link' );       //删除 head 中的 Windows Live Writer 的适配器？ 

  remove_action( 'wp_head', 'feed_links_extra', 3 );        //删除 head 中的 Feed 相关的link
  //remove_action( 'wp_head', 'feed_links', 2 );  

  remove_action( 'wp_head', 'index_rel_link' );       //删除 head 中首页，上级，开始，相连的日志链接
  remove_action( 'wp_head', 'parent_post_rel_link', 10); 
  remove_action( 'wp_head', 'start_post_rel_link', 10); 
  remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10);

  remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );  //删除 head 中的 shortlink
  remove_action( 'wp_head', 'rest_output_link_wp_head', 10);  // 删除头部输出 WP RSET API 地址

  remove_action( 'template_redirect', 'wp_shortlink_header', 11);   //禁止短链接 Header 标签。  
  remove_action( 'template_redirect', 'rest_output_link_header', 11); // 禁止输出 Header Link 标签。
}

//禁用日志修订功能
if(_DGA('diable_revision',true)){
  define('WP_POST_REVISIONS', false);
  remove_action('pre_post_update', 'wp_save_post_revision' );

  // 自动保存设置为10个小时
  define('AUTOSAVE_INTERVAL', 36000 ); 
}


//移除 admin bar
if(_DGA('remove_admin_bar',true)){
  add_filter('show_admin_bar', '__return_false');
}

//禁用 XML-RPC 接口
if(_DGA('disable_xml_rpc',true)){
  add_filter( 'xmlrpc_enabled', '__return_false' );
  remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
}


if(_DGA('disable_trackbacks',true)){
  //彻底关闭 pingback
  add_filter('xmlrpc_methods',function($methods){
    $methods['pingback.ping'] = '__return_false';
    $methods['pingback.extensions.getPingbacks'] = '__return_false';
    return $methods;
  });

  //禁用 pingbacks, enclosures, trackbacks 
  remove_action( 'do_pings', 'do_all_pings', 10 );

  //去掉 _encloseme 和 do_ping 操作。
  remove_action( 'publish_post','_publish_post_hook',5 );
}


//前台不加载语言包
if(_DGA('locale',true)){
  
  $wpjam_locale = get_locale();

  add_filter('language_attributes',function ($language_attributes) use($wpjam_locale){

    if ( function_exists( 'is_rtl' ) && is_rtl() )
      $attributes[] = 'dir="rtl"';

    if($wpjam_locale){
      if (get_option('html_type') == 'text/html')
        $attributes[] = 'lang="'.$wpjam_locale.'"';

      if(get_option('html_type') != 'text/html')
        $attributes[] = 'xml:lang="'.$wpjam_locale.'"';
    }

    return implode(' ', $attributes);
  });

  add_filter('locale', function($locale) { return (is_admin()) ? 'zh_CN' : 'en_US'; });
}



// 屏蔽 Emoji
if(_DGA('disable_emoji',true)){  
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script');
  remove_action( 'admin_print_styles',  'print_emoji_styles');

  remove_action( 'wp_head',       'print_emoji_detection_script', 7);
  remove_action( 'wp_print_styles',   'print_emoji_styles');

  remove_action('embed_head',       'print_emoji_detection_script');

  remove_filter( 'the_content_feed',    'wp_staticize_emoji');
  remove_filter( 'comment_text_rss',    'wp_staticize_emoji');
  remove_filter( 'wp_mail',       'wp_staticize_emoji_for_email');

  add_filter( 'tiny_mce_plugins', function ($plugins){ return array_diff( $plugins, array('wpemoji') ); });
  
  add_filter( 'emoji_svg_url', '__return_false' );
}


// 屏蔽 REST API
if(_DGA('disable_rest_api',true)){
  remove_action( 'init',          'rest_api_init' );
  remove_action( 'rest_api_init', 'rest_api_default_filters', 10 );
  remove_action( 'parse_request', 'rest_api_loaded' );

  add_filter('rest_enabled', '__return_false');
  add_filter('rest_jsonp_enabled', '__return_false');

  // 移除头部 wp-json 标签和 HTTP header 中的 link 
  remove_action('wp_head', 'rest_output_link_wp_head', 10 );
  remove_action('template_redirect', 'rest_output_link_header', 11 );


  remove_action( 'xmlrpc_rsd_apis',            'rest_output_rsd' );

  remove_action( 'auth_cookie_malformed',      'rest_cookie_collect_status' );
  remove_action( 'auth_cookie_expired',        'rest_cookie_collect_status' );
  remove_action( 'auth_cookie_bad_username',   'rest_cookie_collect_status' );
  remove_action( 'auth_cookie_bad_hash',       'rest_cookie_collect_status' );
  remove_action( 'auth_cookie_valid',          'rest_cookie_collect_status' );
  remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );
}


/**
 * open-sans delete
 */
function remove_open_sans() {
    wp_deregister_style( 'open-sans' );
    wp_register_style( 'open-sans', false );
    wp_enqueue_style('open-sans', '');
}
add_action( 'init', 'remove_open_sans' );

/**
 * Disable embeds
 */
if ( !function_exists( 'disable_embeds_init' ) ) :
    function disable_embeds_init(){
        global $wp;
        $wp->public_query_vars = array_diff($wp->public_query_vars, array('embed'));
        remove_action('rest_api_init', 'wp_oembed_register_route');
        add_filter('embed_oembed_discover', '__return_false');
        remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
        add_filter('tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin');
        add_filter('rewrite_rules_array', 'disable_embeds_rewrites');
    }
    add_action('init', 'disable_embeds_init', 9999);

    function disable_embeds_tiny_mce_plugin($plugins){
        return array_diff($plugins, array('wpembed'));
    }
    function disable_embeds_rewrites($rules){
        foreach ($rules as $rule => $rewrite) {
            if (false !== strpos($rewrite, 'embed=true')) {
                unset($rules[$rule]);
            }
        }
        return $rules;
    }
    function disable_embeds_remove_rewrite_rules(){
        add_filter('rewrite_rules_array', 'disable_embeds_rewrites');
        flush_rewrite_rules();
    }
    register_activation_hook(__FILE__, 'disable_embeds_remove_rewrite_rules');

    function disable_embeds_flush_rewrite_rules(){
        remove_filter('rewrite_rules_array', 'disable_embeds_rewrites');
        flush_rewrite_rules();
    }
    register_deactivation_hook(__FILE__, 'disable_embeds_flush_rewrite_rules');
endif;

/**
 * add theme thumbnail
 */
if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
}

add_filter( 'pre_option_link_manager_enabled', '__return_true' );




/**
 * get theme option         
 */
$current_theme = wp_get_theme();
function _DGA( $name, $default = false ) {
    global $current_theme;
    $option_name = 'iDowns';
    $options = get_option( $option_name );
    if ( isset( $options[$name] ) ) {
        return $options[$name];
    }
    return $default;
}


add_filter('mce_buttons','DGAThemes_add_next_page_button');
function DGAThemes_add_next_page_button($mce_buttons) {
  $pos = array_search('wp_more',$mce_buttons,true);
  if ($pos !== false) {
    $tmp_buttons = array_slice($mce_buttons, 0, $pos+1);
    $tmp_buttons[] = 'wp_page';
    $mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));
  }
  return $mce_buttons;
}

function DGAThemes_del_tags($str){
  return trim(strip_tags($str));
}
add_filter('category_description', 'DGAThemes_del_tags');

add_filter( 'login_headerurl', 'DGAThemes_login_logo_url' );
function DGAThemes_login_logo_url($url) {
  return home_url();
}

function DGAThemes_login_logo_url_title() {
    return get_bloginfo("name");
}
add_filter( 'login_headertitle', 'DGAThemes_login_logo_url_title' );

function DGAThemes_login_logo() { 
?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo _DGA('logo_login');?>);
            background-size: auto;
            width:300px;
        }
            
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'DGAThemes_login_logo' );

function do_post($url, $data) {
  $ch = curl_init ();
  curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
  curl_setopt ( $ch, CURLOPT_POST, TRUE );
  curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
  curl_setopt ( $ch, CURLOPT_URL, $url );
  curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  $ret = curl_exec ( $ch );
  curl_close ( $ch );
  return $ret;
}

function get_url_contents($url) {
  $ch = curl_init ();
  curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt ( $ch, CURLOPT_URL, $url );
  $result = curl_exec ( $ch );
  curl_close ( $ch );
  return $result;
}

