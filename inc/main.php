<?php 
/**
 * THEME INIT
 */

//搜索结果排除某些分类的文章
function sing_search_filter_category( $query) {
  if ( !$query->is_admin && $query->is_search) {
    if ( isset($_REQUEST['s']) && isset($_REQUEST['cat']) ){ //若为搜索页面，且有cat值传入
      $desired_cat = $_REQUEST['cat']; //要搜索的分类
      $query->set('cat',$desired_cat); //分类的ID，前面加负号表示排除；如果直接写ID，则表示只在该ID中搜索
    }
  } 
  return $query;
}
add_filter('pre_get_posts','sing_search_filter_category');


//搜索结果排除所有页面
 function search_filter_page($query) {
      if ($query->is_search) {
               $query->set('post_type', 'post');
    }
    return $query;
 }
add_filter('pre_get_posts','search_filter_page');


//百度主动推送
if (_DGA('baidu_sitemap_api',false)) {
    function Baidu_Submit($post_ID) {
        if (get_post_meta($post_ID, 'git_baidu_submit', true) == 1) return;
        $url = get_permalink($post_ID);
        $api = _DGA('baidu_sitemap_api_url');
        $request = new WP_Http;
        $result = $request->request($api, array(
            'method' => 'POST',
            'body' => $url,
            'headers' => 'Content-Type: text/plain'
        ));
        $result = json_decode($result['body'], true);
        if (array_key_exists('success', $result)) {
            add_post_meta($post_ID, 'idowns_baidu_submit', 1, true);
        }
    }
    add_action('publish_post', 'Baidu_Submit', 0);
}

/**
* 修复WordPress找回密码提示“抱歉，该key似乎无效”问题
*/
function reset_password_message( $message, $key ) {
    if ( strpos($_POST['user_login'], '@') ) {
    $user_data = get_user_by('email', trim($_POST['user_login']));
} else {
    $login = trim($_POST['user_login']);
    $user_data = get_user_by('login', $login);
}
    $user_login = $user_data->user_login;
    $msg = __('有人要求重设如下帐号的密码：'). "\r\n\r\n";
    $msg .= network_site_url() . "\r\n\r\n";
    $msg .= sprintf(__('用户名：%s'), $user_login) . "\r\n\r\n";
    $msg .= __('若这不是您本人要求的，请忽略本邮件，一切如常。') . "\r\n\r\n";
    $msg .= __('要重置您的密码，请打开下面的链接：'). "\r\n\r\n";
    $msg .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') ;
    return $msg;
}
add_filter('retrieve_password_message', reset_password_message, null, 2);


/**
 * menu
 */
function _the_menu($location = 'main') {
    echo str_replace("</ul></div>", "", preg_replace("/<div[^>]*><ul[^>]*>/", "", wp_nav_menu(array('theme_location' => $location, 'echo' => false))));
}


/**
 * logo
 */
function _the_logo() {
    $tag = is_home() ? 'h1' : 'div';
    $src = _DGA('logo');
    if( wp_is_mobile() && _DGA('logo_src_m') ){
        $src = _DGA('logo_src_m');
    }
    echo '<' . $tag . ' class="logo"><a href="' . get_bloginfo('url') . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"><img src="'.$src.'"><span>' . get_bloginfo('name') . '</span></a></' . $tag . '>';
}

/**
 * Mail smtp setting
 */

function mail_smtp( $phpmailer ) {
    if(_DGA('mail_smtps') == 1){
        $phpmailer->IsSMTP();
        $mail_name = _DGA('mail_name');
        $mail_host = _DGA('mail_host');
        $mail_port = _DGA('mail_port');
        $mail_username = _DGA('mail_username');
        $mail_passwd = _DGA('mail_passwd');
        $mail_smtpsecure = _DGA('mail_smtpsecure');
        $phpmailer->FromName = $mail_name ? $mail_name : 'idowns'; 
        $phpmailer->Host = $mail_host ? $mail_host : 'smtp.qq.com';
        $phpmailer->Port = $mail_port ? $mail_port : '465';
        $phpmailer->Username = $mail_username ? $mail_username : '88888888@qq.com';
        $phpmailer->Password = $mail_passwd ? $mail_passwd : '123456789';
        $phpmailer->From = $mail_username ? $mail_username : '88888888@qq.com';
        $phpmailer->SMTPAuth = _DGA('mail_smtpauth')==1 ? true : false ;
        $phpmailer->SMTPSecure = $mail_smtpsecure ? $mail_smtpsecure : 'ssl';
        
    }
}
add_action('phpmailer_init', 'mail_smtp');

add_action('after_switch_theme', 'DGAheme_active_theme');
function DGAheme_active_theme($oldthemename){
  global $pagenow;
  global $wpdb;
  $var = $wpdb->query("SELECT qqid FROM $wpdb->users");
  if(!$var){
    $wpdb->query("ALTER TABLE $wpdb->users ADD qqid varchar(100)");
  }
  $var1 = $wpdb->query("SELECT sinaid FROM $wpdb->users");
  if(!$var1){
   $wpdb->query("ALTER TABLE $wpdb->users ADD sinaid varchar(100)");
  }
  $var2 = $wpdb->query("SELECT weixinid FROM $wpdb->users");
  if(!$var2){
   $wpdb->query("ALTER TABLE $wpdb->users ADD weixinid varchar(100)");
  }



  $init_pages = array(
      'template/waterfall.php' => array( '最新文章', 'blog' ),
      'template/tgas.php' => array( '热门标签', 'tgas' ),
      'template/user.php' => array( '个人中心', 'user' ),
      'template/login.php' => array( '登录', 'login' ),
      
  );
  foreach ($init_pages as $template => $item) {
      $one_page = array(
          'post_title'  => $item[0],
          'post_name'   => $item[1],
          'post_status' => 'publish',
          'post_type'   => 'page',
          'post_author' => 1
      );
      $one_page_check = get_page_by_title( $item[0] );
      if(!isset($one_page_check->ID)){
          $one_page_id = wp_insert_post($one_page);
          update_post_meta($one_page_id, '_wp_page_template', $template);
      }
  }

  if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
    wp_redirect( admin_url( "themes.php?page=options-framework" ) );
    exit;
  }
}


//管理后台添加按钮
function idowns_custom_adminbar_menu($meta = TRUE) {
    global $wp_admin_bar;
    if (!is_user_logged_in()) {
        return;
    }
    if (!is_super_admin() || !is_admin_bar_showing()) {
        return;
    }
    $wp_admin_bar->add_menu(array(
        'id' => 'themeset',
        'title' => '主题选项', /* 设置链接名 */
        'href' => admin_url("themes.php?page=options-framework")
    ));
}
add_action('admin_bar_menu', 'idowns_custom_adminbar_menu', 100);



function custom_toolbar_link($wp_admin_bar) {
    $args = array(
    'id' => 'themeset',
    'title' => '主题选项',
     'href' => admin_url("themes.php?page=options-framework"),
     'meta' => array('class' => 'gmail', 'title' => '主题选项')
   );
  $wp_admin_bar->add_node($args);
  if (!theme_check_active()) {
    $wp_admin_bar->add_menu(array(
        'id' => 'bar_update',
        'title' => '未授权', /* 设置链接名 */
        'href' => admin_url("themes.php?page=options-framework")
    ));
  }
  
}
add_action('admin_bar_menu', 'custom_toolbar_link', 999);

//禁止代码标点转换
remove_filter('the_content', 'wptexturize');

function DGAThemes_scripts() {
    $static_url = get_bloginfo('template_url');
    wp_enqueue_style('DGA-main', $static_url .'/static/css/main.css', array(), THEME_VER, 'screen');
    // wp_enqueue_style('animate', $static_url .'/static/css/animate.min.css', array(), THEME_VER, 'screen'); //动画css
    wp_deregister_script( 'jquery' );
    wp_deregister_script( 'l10n' ); 
    wp_enqueue_script( 'lib', $static_url . '/static/js/lib.js', false, THEME_VER, true);
    wp_enqueue_script( 'main', $static_url . '/static/js/main.js', false, THEME_VER, true);

    if (is_single()) {
    wp_enqueue_style('fancybox', $static_url .'/static/fancybox/jquery.fancybox.min.css', array(), THEME_VER, 'screen');
    wp_enqueue_script( 'fancybox3', $static_url . '/static/fancybox/jquery.fancybox.min.js', false, THEME_VER, true);
  	}
  	if (_DGA('is_sidebar_top',true)) {
  		if (is_single() || is_page_template( 'template/page-left-menu.php' )) {
  			wp_enqueue_script( 'stickysidebar', $static_url . '/static/js/theia-sticky-sidebar.min.js', false, THEME_VER, true);
  		}
    }

}
add_action('wp_enqueue_scripts', 'DGAThemes_scripts');

if (function_exists('register_nav_menus')){
    register_nav_menus( array(
        'main' => __('网站顶部主导航'),
        'cat' => __('首页分类导航(ajax按钮获取文章)'),
        'pagemenu' => __('页面导航(当页面模板为“页面+左侧导航菜单”时显示)')
    ));
}

if (function_exists('register_sidebar')){
  register_sidebar(array(
    'name'          => '文章侧栏',
    'id'            => 'widget_single',
    'before_widget' => '<div class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ));
  register_sidebar(array(
    'name'          => '底部小工具',
    'id'            => 'widget_bottom',
    'before_widget' => '<div class="footer-widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ));
}

if ( is_admin() && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) ) {
  $current_user = wp_get_current_user();
  if($current_user->roles[0] == get_option('default_role')) {
    wp_safe_redirect( get_permalink(DGAThemes_page('template/user.php')) );
    exit();
  }
}


function _the_theme_thumb(){
    $dir = get_bloginfo('template_directory');
    return $dir . '/static/img/thumbnail.png';
}

// 缩略图优化 2018.10.10

function DGAThemes_thumbnail($themethumb=true, $size='thumbnail') { 
    if ( has_post_thumbnail() ) {
        $thumb_id = get_post_thumbnail_id(get_the_ID());
        $thumb = wp_get_attachment_image_src($thumb_id, $size);
        return $thumb[0];
    } elseif( _DGA('thumb_postfirstimg_s') ){
        global $post;
        $content = $post->post_content;  
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);  
        $images = $strResult[1];
        if ($images) {
           foreach($images as $src){
              return $src;
          }
        }else{
          return $themethumb ? _the_theme_thumb() : '';
        }
        
    } else {       
        return $themethumb ? _the_theme_thumb() : '';
    }
}


/**
 *第一张图片自动缩略图 支持外链 
 */
if( _DGA('set_postthumbnail') && !function_exists('_set_postthumbnail') ){
    function _set_postthumbnail() {
        global $post;
        if( empty($post) ) return;
        $already_has_thumb = has_post_thumbnail($post->ID);
        if (!$already_has_thumb){
            $attached_image = get_children("post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1");
            if ($attached_image){
                foreach ($attached_image as $attachment_id => $attachment) {
                    set_post_thumbnail($post->ID, $attachment_id);
                }
            }
        }
    }

    // add_action('the_post', '_set_postthumbnail');
    add_action('save_post', '_set_postthumbnail');
    add_action('draft_to_publish', '_set_postthumbnail');
    add_action('new_to_publish', '_set_postthumbnail');
    add_action('pending_to_publish', '_set_postthumbnail');
    add_action('future_to_publish', '_set_postthumbnail');
}


// function DGAThemes_thumbnail($themethumb=true, $size='thumbnail') { 
//     if ( has_post_thumbnail() ) {
//         $thumb_id = get_post_thumbnail_id(get_the_ID());
//         $thumb = wp_get_attachment_image_src($thumb_id, $size);
//         return $thumb[0];
//     } elseif( _DGA('set_postthumbnail') ){
//         global $post, $posts; 
//         $first_img = '';
//         ob_start();
//         ob_end_clean();
//         $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
//         //获取文章中第一张图片的路径并输出
//         $first_img = $matches [1] [0];
//         //如果文章无图片，获取自定义图片
//         if(empty($first_img)){ //Defines a default image
//           $first_img = _the_theme_thumb();
//         }
//         return $first_img;
//     } else {       
//         return $themethumb ? _the_theme_thumb() : '';
//     }
// }


function DGAThemes_thumbnail_full(){
    if ( has_post_thumbnail() ) {
        $thumb_id = get_post_thumbnail_id(get_the_ID());
        $thumb = wp_get_attachment_image_src($thumb_id, 'full');
        return $thumb[0];
    } else {       
        return $themethumb ? _the_theme_thumb() : '';
    }
}

// 文章摘要
function _str_cut($str ,$start , $width ,$trimmarker ){
    $output = preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$start.'}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$width.'}).*/s','\1',$str);
    return $output.$trimmarker;
}

function _get_excerpt($limit=200, $after=''){
    $excerpt = get_the_excerpt();
    if ( mb_strlen( $excerpt ) > $limit ) {
        return _str_cut(strip_tags($excerpt), 0, $limit, $after);
    }else{
        return $excerpt;
    }
}

function _excerpt_length( $length ) {
    return 200;
}
add_filter( 'excerpt_length', '_excerpt_length' );


function DGAThemes_paging() {
    $p = 2;
    if ( is_singular() ) return;
    global $wp_query, $paged;
    $max_page = $wp_query->max_num_pages;
    if ( $max_page == 1 ) return; 
    echo '<div class="pagination"><ul>';
    if ( empty( $paged ) ) $paged = 1;
    // echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; 
    echo '<li class="prev-page">'; previous_posts_link('上一页'); echo '</li>';

    if ( $paged > $p + 1 ) p_link( 1, '<li>第一页</li>' );
    if ( $paged > $p + 2 ) echo "<li><span>···</span></li>";
    for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { 
        if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<li class=\"active\"><span>{$i}</span></li>" : p_link( $i );
    }
    if ( $paged < $max_page - $p - 1 ) echo "<li><span> ... </span></li>";
    if ( $paged < $max_page - $p ) p_link( $max_page, '&raquo;' );
    echo '<li class="next-page">'; next_posts_link('下一页'); echo '</li>';
    echo '<li><span>共 '.$max_page.' 页</span></li>';
    echo '</ul></div>';
}

function DGAThemes_custom_paging($paged,$max_page) {
    $p = 2;
    global $wp_query;
    if ( $max_page == 1 ) return; 
    echo '<div class="pagination"><ul>';
    if ( empty( $paged ) ) $paged = 1;
    // echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; 
    echo '<li class="prev-page">'; previous_posts_link('上一页'); echo '</li>';

    if ( $paged > $p + 1 ) p_link( 1, '<li>第一页</li>' );
    if ( $paged > $p + 2 ) echo "<li><span>···</span></li>";
    for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { 
        if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<li class=\"active\"><span>{$i}</span></li>" : p_link( $i );
    }
    if ( $paged < $max_page - $p - 1 ) echo "<li><span> ... </span></li>";
    if ( $paged < $max_page - $p ) p_link( $max_page, '&raquo;' );
    echo '<li class="next-page">'; next_posts_link('下一页'); echo '</li>';
    echo '<li><span>共 '.$max_page.' 页</span></li>';
    echo '</ul></div>';
}

function p_link( $i, $title = '' ) {
    if ( $title == '' ) $title = "第 {$i} 页";
    echo "<li><a href='", esc_html( get_pagenum_link( $i ) ), "'>{$i}</a></li>";
}
function p_curr_link( $i) {
    echo '<li><span class="page-numbers current">'.$i.'</span></li>';
}

function DGAThemes_timeago( $ptime ) {
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if($etime < 1) return '刚刚';
  if($etime > 30 * 24 * 60 * 60) return date('Y-m-d', $ptime);
    $interval = array (
        12 * 30 * 24 * 60 * 60  =>  '年前',
        30 * 24 * 60 * 60       =>  '月前',
        7 * 24 * 60 * 60        =>  '周前',
        24 * 60 * 60            =>  '天前',
        60 * 60                 =>  '小时前',
        60                      =>  '分钟前',
        1                       =>  '秒前'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}

if ( ! function_exists( 'DGAThemes_views' ) ) :
function DGAThemes_record_visitors(){
    if (is_singular()) {
      global $post;
      $post_ID = $post->ID;
      if($post_ID) {
          $post_views = (int)get_post_meta($post_ID, 'views', true);
          if(!update_post_meta($post_ID, 'views', ($post_views+1))){
            add_post_meta($post_ID, 'views', 1, true);
          }
      }
    }
}
add_action('wp_head', 'DGAThemes_record_visitors');  

function DGAThemes_views($echo = true, $after=''){
  global $post;
  $post_ID = $post->ID;
  $views = (int)get_post_meta($post_ID, 'views', true);
  if($echo)
    echo $views, $after;
  else
    return $views.$after;
}
endif;


function DGAThemes_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() )
		return $title;
	$title .= get_bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( '第%s页', 'mobantu' ), max( $paged, $page ) );
	return $title;
}
add_filter( 'wp_title', 'DGAThemes_wp_title', 10, 2 );

function DGAThemes_keywords() {
  global $s, $post;
  $keywords = '';
  if ( is_single() ) {
	if ( get_the_tags( $post->ID ) ) {
	  foreach ( get_the_tags( $post->ID ) as $tag ) $keywords .= $tag->name . ', ';
	}
	foreach ( get_the_category( $post->ID ) as $category ) $keywords .= $category->cat_name . ', ';
	$keywords = substr_replace( $keywords , '' , -2);
  } elseif ( is_home () || is_front_page())    { $keywords = _DGA('keywords');
  } elseif ( is_tag() )      { $keywords = single_tag_title('', false);
  } elseif ( is_category() ) { $keywords = single_cat_title('', false);
  } elseif ( is_search() )   { $keywords = esc_html( $s, 1 );
  } else { $keywords = trim( wp_title('', false) );
  }
  if ( $keywords ) {
	echo "<meta name=\"keywords\" content=\"$keywords\">\n";
  }
}

function DGAThemes_description() {
  global $s, $post;
  $description = '';
  $blog_name = get_bloginfo('name');
  if ( is_single() ) {
  	if( !empty( $post->post_excerpt ) ) {
  	  $text = $post->post_excerpt;
  	} else {
  	  $text = $post->post_content;
  	}
  	$description = trim( str_replace( array( "\r\n", "\r", "\n", "　", " "), " ", str_replace( "\"", "'", strip_tags( $text ) ) ) );
  	if ( !( $description ) ) $description = $blog_name . "-" . trim( wp_title('', false) );
  } elseif ( is_home () || is_front_page())    { $description = _DGA('description');
  } elseif ( is_tag() )      { $description = $blog_name . "'" . single_tag_title('', false) . "'";
  } elseif ( is_category() ) { $description = trim(strip_tags(category_description()));
  } elseif ( is_archive() )  { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
  } elseif ( is_search() )   { $description = $blog_name . ": '" . esc_html( $s, 1 ) . "' 的搜索結果";
  } else { $description = $blog_name . "'" . trim( wp_title('', false) ) . "'";
  }
  $description = mb_substr( $description, 0, 220, 'utf-8' );
  echo "<meta name=\"description\" content=\"$description\">\n";
}

function DGAThemes_comments_list($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    global $commentcount,$wpdb, $post;

    $start_down = get_post_meta($post->ID,'start_down',true);
    
    if(!$commentcount) { 
        $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_type = '' AND comment_approved = '1' AND !comment_parent");
        $cnt = count($comments);
        $page = get_query_var('cpage');
        $cpp=get_option('comments_per_page');
        if (ceil($cnt / $cpp) == 1 || ($page > 1 && $page  == ceil($cnt / $cpp))) {
            $commentcount = $cnt + 1;
        } else {
            $commentcount = $cpp * $page + 1;
        }
    }


    echo '<li '; comment_class(); echo ' id="comment-'.get_comment_ID().'">';

    if(!$parent_id = $comment->comment_parent) {
        echo '<span class="comt-f">'; printf('#%1$s', --$commentcount); echo '</span>';
    }


    echo '<div class="comt-avatar">';
    DGAThemes_avatar($comment->comment_author_email);
    echo '</div>';


    echo '<div class="comt-main" id="div-comment-'.get_comment_ID().'">';
      echo str_replace(' src=', ' data-src=', convert_smilies(get_comment_text()));
      
      echo '<div class="comt-meta">';
        if ($comment->comment_approved == '0'){
            echo '<span class="comt-approved">待审核</span>';
        }

        echo '<span class="comt-author">'.get_comment_author_link();
        if(getUserBuyTrue($comment->user_id,$post->ID) && $start_down == 'yes' && _DGA('post_comment_bought')) echo '<span class="comt-bought">已购买</span>';
        echo '</span>';
        $_commenttime = strtotime($comment->comment_date); 
        echo (time()-$_commenttime)>86400 ? date('Y-m-d G:i:s', $_commenttime) : date('G:i', $_commenttime);
        if ($comment->comment_approved !== '0'){
            $replyText = get_comment_reply_link( array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
          echo preg_replace('# href=[\s\S]*? onclick=#', ' href="javascript:;" onclick=', $replyText );
        }
      echo '</div>';
    echo '</div>';
}

add_filter('get_avatar', 'MBT_get_avatar', 10, 3);
function MBT_get_avatar($avatar, $id_or_email, $size){
  $default_avatar = get_bloginfo('template_url').'/static/img/avatar.png';
  if(is_object($id_or_email)) {
      if($id_or_email->user_id != 0) {
        $email = $id_or_email->user_id;
    $user = get_user_by('email',$email);
    $user_avatar = get_user_meta($id_or_email->user_id, 'photo', true);
    if($user_avatar)
      return '<img src="'.$user_avatar.'" class="avatar avatar-'.$size.' photo" width="'.$size.'" height="'.$size.'" alt="'.$user->display_name .'" />';
    else
      return '<img src="'.$default_avatar.'" class="avatar avatar-'.$size.' photo" width="'.$size.'" height="'.$size.'" alt="'.$user->display_name .'" />';
      
      }elseif(!empty($id_or_email->comment_author_email)) {
    return '<img src="'.$default_avatar.'" class="avatar avatar-'.$size.' photo" width="'.$size.'" height="'.$size.'" alt="'.$user->display_name .'" />';
      }
    }else{
    if(is_numeric($id_or_email) && $id_or_email > 0){
      $user = get_user_by('id',$id_or_email);
      $user_avatar = get_user_meta($id_or_email, 'photo', true);
      if($user_avatar)
        return '<img src="'.$user_avatar.'" class="avatar avatar-'.$size.' photo" width="'.$size.'" height="'.$size.'" alt="'.$user->display_name .'" />';
      else
        return '<img src="'.$default_avatar.'" class="avatar avatar-'.$size.' photo" width="'.$size.'" height="'.$size.'" alt="'.$user->display_name .'" />';
    }elseif(is_email($id_or_email)){
      $user = get_user_by('email',$id_or_email);
      $user_avatar = get_user_meta($user->ID, 'photo', true);
      if($user_avatar)
        return '<img src="'.$user_avatar.'" class="avatar avatar-'.$size.' photo" width="'.$size.'" height="'.$size.'" alt="'.$user->display_name .'" />';
      else
        return '<img src="'.$default_avatar.'" class="avatar avatar-'.$size.' photo" width="'.$size.'" height="'.$size.'" alt="'.$user->display_name .'" />';
    }else{
      return '<img src="'.$default_avatar.'" class="avatar avatar-'.$size.' photo" width="'.$size.'" height="'.$size.'" alt="" />';
    }
  }
  return $avatar;
}

function DGAThemes_get_avatar($uid){
  $photo = get_user_meta($uid, 'photo', true);
  if($photo) return $photo;
  else return get_bloginfo("template_url").'/static/img/avatar.png';
}

function DGAThemes_avatar($id=0,$size='50',$class=''){
  $photo = get_user_meta($id, 'photo', true);
  if($photo) echo '<img class="avatar '.$class.'" src="'.$photo.'" width="'.$size.'" height="'.$size.'" />';
  else echo get_avatar($id,$size);
}

function DGAThemes_page($template) {
  global $wpdb;
  $page_id = $wpdb->get_var($wpdb->prepare("SELECT `post_id` 
  FROM `$wpdb->postmeta`, `$wpdb->posts`
  WHERE `post_id` = `ID`
  AND `post_status` = 'publish'
  AND `meta_key` = '_wp_page_template'
  AND `meta_value` = %s
  LIMIT 1;", $template));
  return $page_id;
}

function DGAThemes_selfURL(){  
    $pageURL = 'http';
    $pageURL .= (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")?"s":"";
    $pageURL .= "://";
    $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    return $pageURL;      
}

function DGAThemes_strip_tags($content){
	if($content){
		$content = preg_replace("/\[.*?\].*?\[\/.*?\]/is", "", $content);
	}
	return strip_tags($content);
}

function DGAThemes_color(){
	$theme_color_custom = _DGA('theme_color_custom');
	$theme_color = _DGA('theme_color');
	$color = '';
	if($theme_color && $theme_color != '#1d1d1d'){
		$color = $theme_color;
	}
	if($theme_color_custom && $theme_color_custom != '#1d1d1d'){
		$color = $theme_color_custom;
	}
	if($color){
		echo ".btn, .nav-main> li.current-menu-item > a:after, .cat-nav li.current-menu-item a:after, .grids .grid.grid-tj:after, .pagination ul > .active > a,.pagination ul > .active > span, .pagination-trigger a, .erphpdown-box .down, .article-tags a:hover, .widget-erphpdown .down, .comt-submit, .sign .captcha-clk, .btn-primary, .mocat .more a, .mocat h2:after, .filter a.active{background-color:$color !important;}
		a:hover, .nav-main> li.current-menu-item > a, .nav-right .nav-login a, .nav-right .nav-search a, .nav-main .sub-menu a:hover, .tagslist li .name,.banner a, .grids .grid h3 a:hover, .widget-tags .items a:hover, .sign-trans a,.sitenav ul li a:hover, .sitenav ul li.active a:hover, .sitenav ul li:hover>a,.usermenu li a:hover,.userlist-title .dripicons,.sitenav ul li.current-category-ancestor>a, .sitenav ul li.current-menu-item>a, .sitenav ul li.current-menu-parent>a,.download-option-btn ul li a.active:hover i,.download-option-btn ul li a i,.download-option-btn ul li a,.sitenav ul li a:hover, .sitenav ul li.active a:hover, .sitenav ul li:hover>a,.article-content a,.sitenav ul li.current-category-ancestor>a, .sitenav ul li.current-menu-item>a, .sitenav ul li.current-menu-parent>a,.cat-nav li a{color:$color;}
		.erphpdown-box, .comt-submit, .sign .captcha-clk, .btn-primary,.signuser-info .avatar:hover,.sitenav ul li.current-category-ancestor>a, .sitenav ul li.current-menu-item>a, .sitenav ul li.current-menu-parent>a{border-color:$color !important;}
		@media (max-width: 768px){
			.nav-right .nav-button a,{color:$color !important;}
		}.searchform .sbtn,.pricing-single.active .ordr-btn>a,.pricing-single:hover .ordr-btn>a,.pricing-single.active, .pricing-single:hover,.banner a:hover,.more-link-hidden,.cat-nav li a:hover,.entry__price,.usermenu li.active a,input[type=checkbox]:checked, input[type=radio]:checked,.user-tips,.download-option-btn ul li a.active,.comt-bought,.tagslist li:hover .name,.cat-nav li.current-menu-item a,.loader:after, .loader:before,#nprogress .bar,.swiper-pagination-bullet-active,.banserach-btn,body.home #particles-js,.usersign-register,#loading-center .dot{background-color: $color !important;color: #fff}.more-link-hidden:hover, {color: #fff}";
	}
}


function DGAThemes_animation(){

  if(_DGA('is_css_animation',true)){
    echo "@keyframes fade-in { 0% { transform: translateY(20px); opacity: 0 } 100% { transform: translateY(0); opacity: 1 } } @-webkit-keyframes fade-in { 0% { -webkit-transform: translateY(20px); opacity: 0 } 100% { -webkit-transform: translateY(0); opacity: 1 } }";
  }
}


function DGAThemes_ad($pos,$mt='',$mb=''){
  if(_DGA($pos.'_s')){
    $style= 'style="';
    if($mt != ''){
      $style .= 'margin-top:'.$mt.'px; ';
    }
    if($mb != ''){
      $style .= 'margin-bottom:'.$mb.'px; ';
    }
    $style .='"';
    if($style == 'style=""') $style='';
    echo '<div class="modown-ad" '.$style.'>'._DGA($pos).'</div>';
  }
}

if(_DGA('file_rename')){
  add_filter('wp_handle_upload_prefilter', 'DGAThemes_wp_handle_upload_prefilter'); 
  function DGAThemes_wp_handle_upload_prefilter($file){  
      $time=date("dHis");  
      $file['name'] = $time."".mt_rand(100,999).".".pathinfo($file['name'] , PATHINFO_EXTENSION);  
      return $file;  
  } 
}




