<footer class="footer">
	<div class="container">
		<div class="footer-widgets">
	    	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_bottom')) : endif; ?>
	    </div>
	 </div>
	<div class="copyright-area bg-7">
			<div class="container">
				<!-- Contact address left -->
				<?php if( _DGA('footer_iconbox') ){ ?>
				<div class="row">
					<div class="conct-border two">
						<div class="col-md-3 col-sm-6">
							<div class="single-address">
								<div class="media">
									<div class="media-left">
										<?php echo _DGA('footer_icon1');?>
									</div>
									<div class="media-body text-center">
										<?php echo _DGA('footer_text1');?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="single-address">
								<div class="media">
									<div class="media-left">
										<?php echo _DGA('footer_icon2');?>
									</div>
									<div class="media-body text-center">
										<?php echo _DGA('footer_text2');?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="single-address">
								<div class="media">
									<div class="media-left">
										<?php echo _DGA('footer_icon3');?>
									</div>
									<div class="media-body text-center">
										<?php echo _DGA('footer_text3');?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="single-address">
								<div class="media">
									<div class="media-left">
										<?php echo _DGA('footer_icon4');?>
									</div>
									<div class="media-body text-center">
										<?php echo _DGA('footer_text4');?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				<!-- Contact address left -->
				<!-- Copyright right -->
				<div class="row">
					<div class="col-md-12">
						<div class="copyright-area text-center">
							<!-- Copyright social -->
							<div class="contact-social text-center pt-70 pb-35">
								<?php if((is_home() || is_single()) && _DGA('friendlink')){?>
							    <div class="footer-links">
							    	<ul><li>友情链接：</li><?php wp_list_bookmarks('title_li=&categorize=0&show_images=0'); ?></ul>
							    </div>
							    <?php }?>
							</div>
							<!-- Copyright social -->
							<div class="copyright-text">
								<p><?php echo _DGA('copyright');?></p>
							</div>
							<!-- Copyright text -->
						</div>
					</div>
				</div>
				<!-- Copyright right -->
			</div>
		</div>

</footer>
<div id="globalSearch" class="js-search search-form search-form-modal fadeZoomIn" role="dialog" aria-hidden="true" > 
	<form method="get" action="<?php echo esc_url( home_url() ) ?>" role="search"> 
		<div class="search-form-inner"> 
			<div class="search-form-box"> 
				<input class="form-search" type="text" name="s" placeholder="键入关键词"> 
			</div> 
		</div> 
	</form>
</div>

<?php if (_DGA('all_page_tips')) { ?>
	<div class="site-tips">
	<?php echo _DGA('all_page_tips'); ?>
	  <a href="javascript:;" class="close"><i class="dripicons dripicons-cross"></i></a>
	</div>
<?php } ?>


<div class="rollbar">
	<ul>
		<?php if( _DGA('nav_search') ){ ?>
			<li><a href="javascript:void(0)" data-toggle="modal" data-target="#globalSearch" data-backdrop="1"><span class="nav-search-btn"><i class="fa">&#xe600;</i></span></a></li>
    <?php } ?>

		<?php if (_DGA('footer_qq')) { ?>
			<li><a target="_bank" href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo _DGA('footer_qqhao') ?>&site=qq&menu=yes" class="qq"><i class="dripicons dripicons-message"></i></a></li>
		<?php } ?>
		
		<li><a href="javascript:;" class="totop"><i class="dripicons dripicons-chevron-up"></i></a></li>
	</ul>
</div>
<?php if (!is_user_logged_in() && _DGA('isloginpop')) {
	get_template_part('module/login');
}
?>
<?php wp_footer();?>
<script>IDOWNS.init({ias: <?php echo _DGA('ajax_list_load')?'1':'0';?>, lazy: <?php echo _DGA('lazyload')?'1':'0';?>, water: <?php echo _DGA('waterfall')?'1':'0';?>});</script>
<?php echo _DGA('js');?>
<?php if (is_single() && _DGA('xiongzhang')) {?> 
<script type="application/ld+json">
    {
        "@context": "https://ziyuan.baidu.com/contexts/cambrian.jsonld",
        "@id": "<?php the_permalink(); ?>",
        "appid": "<?php echo _DGA('xiongzhang_appid');?>",
        "title": "<?php the_title(); ?>",
        "images": [
            "<?php echo DGAThemes_thumbnail();?>"
            ],
        "description":"<?php echo _get_excerpt($limit=234, $after='');?>",
        "pubDate": "<?php the_time('Y-m-d');?>T<?php the_time('H:i:s');?>"
    }
</script>
<?php }?>
<?php if (!wp_is_mobile() && _DGA('is_sidebar_top',true)) { ?>
	<script type="text/javascript">
	  jQuery(document).ready(function() {
	  	<?php if (is_single()) { ?>
	    jQuery('.content, .sidebar').theiaStickySidebar({
	      additionalMarginTop: 30
	    });
	    <?php } ?>
	    <?php if (is_page_template( 'template/page-left-menu.php' )) { ?>
        jQuery('.single-content, .page-left-menu').theiaStickySidebar({
	      additionalMarginTop: 110
	    });
	    <?php } ?>
	  });
	</script>
<?php } ?>

<div class="analysis"><?php echo _DGA('analysis');?></div>
</body>
</html>