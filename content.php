<?php $tj = get_post_meta(get_the_ID(),'down_recommend',true);?><div class="post grid<?php if($tj) echo ' grid-tj';?>">
  <a href="<?php the_permalink();?>" title="<?php the_title();?>" rel="bookmark">
    <img <?php echo (_DGA('lazyload') && !_DGA('waterfall'))?'data-src':'src';?>="<?php echo DGAThemes_thumbnail();?>" class="thumb" alt="<?php the_title();?>">
  </a>
  
    <?php if( has_post_format( 'gallery' )) { //相册 ?>
      <div class="entry-format">
      <i class="dripicons dripicons-photo"></i>
      </div>
      <?php } else if ( has_post_format( 'video' )) { //视频 ?>
      <div class="entry-format">
      <i class="dripicons dripicons-media-play"></i>
      </div>
    <?php } ?>

    <?php 
      $start_down=get_post_meta(get_the_ID(), 'start_down', true);
      $price=get_post_meta(get_the_ID(), 'down_price', true);
      $memberDown=get_post_meta(get_the_ID(), 'member_down',true);
      if($start_down && !_DGA('post_price')){
        echo '<div class="entry__price"><span class="entry__price-month">';
        if($memberDown == '4') echo '<i class="dripicons dripicons-ticket"></i> VIP专享';
        elseif($price) echo '<i class="dripicons dripicons-ticket"></i> '.$price.' '.get_option("ice_name_alipay");
        else echo '<i class="dripicons dripicons-ticket"></i> 免费';
        echo '</span></div>';
      }
      ?>
  
  <h3 itemprop="name headline"><a itemprop="url" rel="bookmark" href="<?php the_permalink();?>" title="<?php the_title();?>" ><?php the_title();?></a></h3>
  <div class="grid-meta">
    <span class="cats"><?php the_category(' / '); ?></span>
    <span class="time"><?php echo DGAThemes_timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ) ?></span>
    <span><i class="dripicons dripicons-preview"></i> <?php DGAThemes_views();?></span>
    
  </div>
</div>

