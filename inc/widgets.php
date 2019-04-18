<?php  
add_action('widgets_init','unregister_mobantu_widget');
function unregister_mobantu_widget(){
    unregister_widget ('WP_Widget_Search');
    unregister_widget ('WP_Nav_Menu_Widget');
    unregister_widget ( 'WP_Widget_Calendar' );
	unregister_widget ( 'WP_Widget_Pages' );
	unregister_widget ( 'WP_Widget_Archives' );
	unregister_widget ( 'WP_Widget_Links' );
	unregister_widget ( 'WP_Widget_Meta' );
	unregister_widget ( 'WP_Widget_Text' );
	unregister_widget ( 'WP_Widget_Categories' );
	unregister_widget ( 'WP_Widget_Recent_Posts' );
	unregister_widget ( 'WP_Widget_Recent_Comments' );
	unregister_widget ( 'WP_Widget_RSS' );
	unregister_widget ( 'WP_Widget_Tag_Cloud' );
}



add_action( 'widgets_init', 'widget_tags_loader' );
function widget_tags_loader() {
	register_widget( 'widget_tags_loader' );
}

class widget_tags_loader extends WP_Widget {
	
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'widget-tags',
			'description' => '显示热门标签',
		);
		parent::__construct( 'widget_tags_loader', 'iDowns-标签云', $widget_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_name', $instance['title']);
		$count = $instance['count'];
		$offset = $instance['offset'];

		echo $before_widget;
		echo $before_title.$title.$after_title; 
		echo '<div class="items">';
		$tags_list = get_tags('orderby=count&order=DESC&number='.$count.'&offset='.$offset);
		if ($tags_list) { 
			foreach($tags_list as $tag) {
				echo '<a href="'.get_tag_link($tag).'">'. $tag->name .'</a>'; 
			} 
		}else{
			echo '暂无标签！';
		}
		echo '</div>';
		echo $after_widget;
	}

	public function form($instance) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '热门标签';
?>
		<p>
			<label>
				名称：
				<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" class="widefat" />
			</label>
		</p>
		<p>
			<label>
				显示数量：
				<input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="number" value="<?php echo $instance['count']; ?>" class="widefat" />
			</label>
		</p>
		<p>
			<label>
				去除前几个：
				<input id="<?php echo $this->get_field_id('offset'); ?>" name="<?php echo $this->get_field_name('offset'); ?>" type="number" value="<?php echo $instance['offset']; ?>" class="widefat" />
			</label>
		</p>
		
<?php
	}
}



add_action( 'widgets_init', 'widget_ads_loader' );
function widget_ads_loader() {
	register_widget( 'widget_ads' );
}

class widget_ads extends WP_Widget {
	
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'widget-text',
			'description' => '显示一个广告(包括富媒体)',
		);
		parent::__construct( 'widget_ads', 'iDowns-广告', $widget_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_name', $instance['title']);
		$code = $instance['code'];
		$nopadding = isset($instance['nopadding']) ? $instance['nopadding'] : '';

		if($nopadding)
			echo '<div class="widget widget-text nopadding">';
		else
			echo $before_widget;
		if($title) echo $before_title.$title.$after_title; 
		echo $code;
		echo $after_widget;
	}

	public function form($instance) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$code = ! empty( $instance['code'] ) ? $instance['code'] : '这里输入广告代码' ;
?>
	    <p>
			<label>
				名称：
				<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" class="widefat" />
			</label>
		</p>
		<p>
			<label>
				广告代码：
				<textarea id="<?php echo $this->get_field_id('code'); ?>" name="<?php echo $this->get_field_name('code'); ?>" class="widefat" rows="12" style="font-family:Courier New;"><?php echo $code; ?></textarea>
			</label>
		</p>
		<p>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['nopadding'], 'on' ); ?> id="<?php echo $this->get_field_id('nopadding'); ?>" name="<?php echo $this->get_field_name('nopadding'); ?>">No padding（无边距）
			</label>
		</p>
<?php
	}
}



add_action( 'widgets_init', 'widget_postlist_loader' );
function widget_postlist_loader() {
	register_widget( 'widget_postlist' );
}

class widget_postlist extends WP_Widget {
	
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'widget-postlist',
			'description' => '最新文章+热评文章+随机文章+推荐文章',
		);
		parent::__construct( 'widget_postlist', 'iDowns-文章列表', $widget_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title        = apply_filters('widget_name', $instance['title']);
		$limit        = $instance['limit'];
		$cat          = $instance['cat'];
		$orderby      = $instance['orderby'];
		$img = isset($instance['img']) ? $instance['img'] : '';

		echo $before_widget;
		echo $before_title.$title.$after_title.'<ul'.($img?' class="hasimg"':'').'>';
		if($orderby == 'recommend'){
			$args = array(
			  'order'            => 'DESC',
			  'orderby'          => 'date',
			  'cat'              => $cat,
			  'meta_query' => array(array('key'=>'down_recommend','value'=>'1')),
			  'showposts'        => $limit,
			  'ignore_sticky_posts' => 1
			);
		}else{
			$args = array(
				'order'            => 'DESC',
				'cat'              => $cat,
				'orderby'          => $orderby,
				'showposts'        => $limit,
				'ignore_sticky_posts' => 1
			);
		}
		query_posts($args);
		while (have_posts()) : the_post(); 
		?>
        <li>
          <?php if($img){?>
          <a href="<?php the_permalink();?>" title="<?php the_title();?>" target="_blank" rel="bookmark" class="img">
		    <img src="<?php echo DGAThemes_thumbnail(66,66,0);?>" class="thumb" alt="<?php the_title();?>">
		  </a>
		  <?php }?>
          <h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
          <p class="meta">
          	<span class="time"><?php echo DGAThemes_timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ) ?></span>
          	<span><i class="dripicons dripicons-preview"></i> <?php DGAThemes_views();?></span>
          	<?php 
		    $start_down=get_post_meta(get_the_ID(), 'start_down', true);
		    $price=get_post_meta(get_the_ID(), 'down_price', true);
		    $memberDown=get_post_meta(get_the_ID(), 'member_down',TRUE);
		    if($start_down && !_DGA('post_price')){
		    	echo '<span class="price">';
			    if($memberDown == '4') echo '<i class="dripicons dripicons-ticket"></i> VIP专享';
			    elseif($price) echo '<i class="dripicons dripicons-ticket"></i> '.$price.' '.get_option("ice_name_alipay");
			    else echo '<i class="dripicons dripicons-ticket"></i> 免费';
			    echo '</span>';
			}
		    ?>
          </p>
        </li>
		<?php
		endwhile; wp_reset_query();
		echo '</ul>';
		echo $after_widget;
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '最新文章' ;
?>
		<p>
			<label>
				标题：
				<input style="width:100%;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</label>
		</p>
		<p>
			<label>
				排序：
				<select style="width:100%;" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" style="width:100%;">
                	<option value="recommend" <?php selected('recommend', $instance['orderby']); ?>>推荐</option>
					<option value="comment_count" <?php selected('comment_count', $instance['orderby']); ?>>评论数</option>
					<option value="date" <?php selected('date', $instance['orderby']); ?>>发布时间</option>
					<option value="rand" <?php selected('rand', $instance['orderby']); ?>>随机</option>
				</select>
			</label>
		</p>
		<p>
			<label>
				分类限制：
				<a style="font-weight:bold;color:#f60;text-decoration:none;" href="javascript:;" title="格式：1,2 &nbsp;表限制ID为1,2分类的文章&#13;格式：-1,-2 &nbsp;表排除分类ID为1,2的文章&#13;也可直接写1或者-1；注意逗号须是英文的">？</a>
				<input style="width:100%;" id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>" type="text" value="<?php echo $instance['cat']; ?>" size="24" />
			</label>
		</p>
		<p>
			<label>
				显示数目：
				<input style="width:100%;" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo $instance['limit']; ?>" size="24" />
			</label>
		</p>
		<p>
			<label>
				<input style="vertical-align:-3px;margin-right:4px;" class="checkbox" type="checkbox" <?php checked( $instance['img'], 'on' ); ?> id="<?php echo $this->get_field_id('img'); ?>" name="<?php echo $this->get_field_name('img'); ?>">显示图片
			</label>
		</p>
		
	<?php
	}
}


add_action( 'widgets_init', 'widget_comment_loader' );

function widget_comment_loader() {
	register_widget( 'widget_commentlist' );
}

class widget_commentlist extends WP_Widget {
	
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'widget-commentlist',
			'description' => '边侧栏显示网友最新评论',
		);
		parent::__construct( 'widget_commentlist', 'iDowns-评论', $widget_ops );
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_name', $instance['title']);
		$not = $instance['not'];
		$limit = $instance['limit'];
		
		echo $before_widget;
		echo $before_title.$title.$after_title; 
		echo '<div>'.mowidget_comments($limit,$not).'</div>';
		echo $after_widget;
	}

	public function form($instance) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '网友评论' ;
?>
		<p>
			<label>
				标题：
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</label>
		</p>
        <p>
			<label>
				排除用户IDs：
				<input class="widefat" id="<?php echo $this->get_field_id('not'); ?>" name="<?php echo $this->get_field_name('not'); ?>" type="text" value="<?php echo $instance['not']; ?>" />
			</label>
		</p>
		<p>
			<label>
				显示数目：
				<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo $instance['limit']; ?>" />
			</label>
		</p>

<?php
	}
}

function mowidget_comments($limit,$not){
	global $wpdb;
	$output = '';
	$commargs = array('number' => $limit, 'author__not_in' => $not);
	$comments = get_comments($commargs);
	foreach ( $comments as $comment ) {
		if($comment->comment_approved == '1'){
			$author = '<a class="uname" href="javascript:;">'.$comment->comment_author.'</a>';
			if($comment->user_id){
				$author = '<a class="uname" href="javascript:;">'.get_user_by('ID',$comment->user_id)->nickname.'</a>';
			}
			$output .='<div class="comment-item comment-'.$comment->comment_ID.'">
			      <div class="postmeta">'.$author.' • '.DGAThemes_timeago( get_gmt_from_date($comment->comment_date) ).'</div>
			      <div class="sidebar-comments-comment">'.strip_tags($comment->comment_content).'</div>
			      <div class="sidebar-comments-title">
			        <p>来源：<a href="'.get_permalink($comment->comment_post_ID).'">'.$comment->post_title.'</a></p>
			      </div>
			    </div>';
		}
	}
	
	return $output;
}
