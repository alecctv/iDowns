<?php get_header();
$nosidebar = get_post_meta(get_the_ID(),'nosidebar',true);
$header_video_id = get_post_meta(get_the_ID(),'header_video_id',true);

if ($header_video_id && has_post_format( 'video' )) {
	get_template_part( 'module/single-video' );
}
	
?>

<?php 
if (_DGA('is_shop_posts_box',false) && get_post_meta(get_the_ID(), 'start_down', true)) {
	get_template_part( 'module/single-shop' ); 
} else {
	get_template_part( 'module/single-deft' ); 
}



?>

<?php get_footer();?>