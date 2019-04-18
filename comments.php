<?php
if ( get_option('default_comment_status') !== 'open' ) return;
defined('ABSPATH') or die('This file can not be loaded directly.');

if ( !comments_open() ) return;

$my_email = get_bloginfo ( 'admin_email' );
$str = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_approved = '1' AND comment_type = '' AND comment_author_email";
$count_t = $post->comment_count;

date_default_timezone_set('PRC');
$closeTimer = (strtotime(date('Y-m-d G:i:s'))-strtotime(get_the_time('Y-m-d G:i:s')))/86400;
?>
<div class="single-comment">
	<h3 class="comments-title" id="comments">
		评论<small><?php echo $count_t ? $count_t : '0'; ?></small>
	</h3>
	<div id="respond" class="comments-respond no_webshot">
		<?php if ( get_option('comment_registration') && !is_user_logged_in() ) { ?>
		<div class="comment-signarea">
			<h3 class="text-muted">请先 <a href="javascript:;" class="signin-loader">登录</a> ！</h3>
		</div>
		<?php }elseif( get_option('close_comments_for_old_posts') && $closeTimer > get_option('close_comments_days_old') ) { ?>
		<h3 class="title">
			<strong>文章评论已关闭！</strong>
		</h3>
		<?php }else{ ?>
		
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
			<div class="comt">
				<div class="comt-title">
					<?php 
						if ( is_user_logged_in() ) {
							global $current_user;
							get_currentuserinfo();
							DGAThemes_avatar($current_user->ID);
							echo '<p>'.$user_identity.'</p>';
						}else{
							if( $comment_author_email!=='' ) {
								DGAThemes_avatar($comment->comment_author_email);
							}else{
								DGAThemes_avatar();
							}
							if ( !empty($comment_author) ){
								echo '<p>'.$comment_author.'</p>';
								echo '<p><a href="javascript:;" class="comment-user-change">更换</a></p>';
							}
						}
					?>
					<p><a id="cancel-comment-reply-link" href="javascript:;">取消</a></p>
				</div>
				<div class="comt-box">
					<textarea placeholder="" class="comt-area" name="comment" id="comment" cols="100%" rows="3" tabindex="1" onkeydown="if(event.ctrlKey&amp;&amp;event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
					<div class="comt-ctrl">
						<div class="comt-tips"><?php comment_id_fields(); do_action('comment_form', $post->ID); ?></div>
						<button class="comt-submit" type="submit" name="submit" id="submit" tabindex="5">提交评论</button>
					</div>
				</div>

				<?php if ( !is_user_logged_in() ) { ?>
					<?php if( get_option('require_name_email') ){ ?>
						<div class="comt-comterinfo" id="comment-author-info" <?php if ( !empty($comment_author) ) echo 'style="display:none"'; ?>>
							<ul>
								<li><input class="ipt" type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" tabindex="2" placeholder="昵称">昵称 (必填)</li>
								<li><input class="ipt" type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" tabindex="3" placeholder="邮箱">邮箱 (必填)</li>
								<li><input class="ipt" type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" tabindex="4" placeholder="网址">网址</li>
							</ul>
						</div>
					<?php } ?>
				<?php } ?>
			</div>

		</form>
		<?php } ?>
	</div>
	<?php  
	if ( have_comments() ) { 
		?>
		<div id="postcomments" class="postcomments">
			<ol class="commentlist">
				<?php wp_list_comments('type=comment&callback=DGAThemes_comments_list'); ?>
			</ol>
			<div class="comments-pagination">
				<?php paginate_comments_links('prev_next=0');?>
			</div>
		</div>
		<?php 
	}?>
</div>



