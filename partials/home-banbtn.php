<!-- Banner -->
<div class="banner"<?php if(_DGA('banner_img')){?> style="background-image: url(<?php echo _DGA('banner_img');?>);" <?php }?>>
	<div class="container">
    	<h2><?php echo _DGA('banner_title');?></h2>
        <p><?php echo _DGA('banner_desc');?></p>
        <?php if(_DGA('banner_btn')){?><a href="<?php echo _DGA('banner_link');?>" target="_blank"><?php echo _DGA('banner_btn');?></a><?php }?>
    </div>
</div>