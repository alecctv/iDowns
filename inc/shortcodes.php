<?php
add_shortcode('mocat','DGAThemes_homepage_cat');
function DGAThemes_homepage_cat($atts){
	$atts = shortcode_atts( array(
        'id' => 1,
        'num' => 8,
        'title' => '',
        'more' => 1,
        'text' => '查看更多'
    ), $atts, 'mocat' );
    $title = $atts['title']?$atts['title']:get_cat_name($atts['id']);

    $html = '<div class="mocat"><div class="container">';
    $html .= '<h2>'.$title.'</h2>';
    $html .= '<div class="grids clearfix">';
    $args = array(
		'cat'              => $atts['id'],
		'showposts'        => $atts['num'],
		'ignore_sticky_posts' => 1
	);
	query_posts($args);
	while (have_posts()) : the_post();

		$tj = get_post_meta(get_the_ID(),'down_recommend',true);
		if($tj) $tj = ' grid-tj'; else $tj = '';
		$start_down=get_post_meta(get_the_ID(), 'start_down', true);
	    $price=get_post_meta(get_the_ID(), 'down_price', true);
	    $memberDown=get_post_meta(get_the_ID(), 'member_down',TRUE);
		$html .= '<div class="post grid'.$tj.'">
		  <a href="'.get_permalink().'" title="'.get_the_title().'" target="_blank" rel="bookmark">
		    <img src="'.DGAThemes_thumbnail().'" class="thumb" alt="'.get_the_title().'">
		  </a>
		  <h3 itemprop="name headline"><a itemprop="url" rel="bookmark" href="'.get_permalink().'" title="'.get_the_title().'" target="_blank">'.get_the_title().'</a></h3>
		  <div class="grid-meta">
		    <span class="time">'.DGAThemes_timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ).'</span>
		    <span><i class="dripicons dripicons-preview"></i> '.DGAThemes_views(false).'</span>';
		    if($start_down){
		        $html .= '<span class="price">';
		  	    if($memberDown == '4') $html .= '<i class="dripicons dripicons-ticket"></i> VIP专享';
		  	    elseif($price) $html .= '<i class="dripicons dripicons-ticket"></i> '.$price.' '.get_option("ice_name_alipay");
		  	    else $html .= '<i class="dripicons dripicons-ticket"></i> 免费';
		        $html .= '</span>';
		  	}
		$html .= '</div>
		</div>';

	endwhile; wp_reset_query(); 
	$html .= '</div>';
	if($atts['more']) $html .= '<div class="more"><a href="'.get_category_link($atts['id']).'" target="_blank">'.$atts['text'].'</a></div>';
    $html .= '</div></div>';
    return $html;
}