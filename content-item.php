

<article class="post excerpt">
  <a class="focus" href="<?php the_permalink();?>" rel="bookmark">
    <img <?php echo (_DGA('lazyload'))?'data-src':'src';?>="<?php echo DGAThemes_thumbnail();?>" class="thumb" alt="<?php the_title();?>">
  </a>

  <h2 itemprop="name headline"><a itemprop="url" rel="bookmark" href="<?php the_permalink();?>" title=""><?php the_title();?></a></h2>
  <div class="note"><?php echo _get_excerpt($limit=80, $after='...'); ?></div>
  <div class="meta">
    <span class="meta_s"><time><?php echo DGAThemes_timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ) ?></time></span>
    <span class="meta_s"><?php the_category(' / '); ?></span>
    <span class="meta_s"><i class="dripicons dripicons-preview"></i> <?php DGAThemes_views();?></span>
    <?php 
      $start_down=get_post_meta(get_the_ID(), 'start_down', true);
      $price=get_post_meta(get_the_ID(), 'down_price', true);
      $memberDown=get_post_meta(get_the_ID(), 'member_down',TRUE);
      if($start_down && !_DGA('post_price')){
        echo '<span class="meta_s">';
        if($memberDown == '4') echo '<i class="dripicons dripicons-ticket"></i> VIP专享';
        elseif($price) echo '<i class="dripicons dripicons-ticket"></i> '.$price.' '.get_option("ice_name_alipay");
        else echo '<i class="dripicons dripicons-ticket"></i> 免费';
        echo '</span>';
      }
    ?>
  </div>
</article>
