<?php
$exclude_id = $post->ID; 
$limit = 4;


    $cats = ''; foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
    $args = array(
        'category__in'        => explode(',', $cats), 
        'post__not_in'        => explode(',', $exclude_id),
        'ignore_sticky_posts' => 1,
        'posts_per_page'      => $limit
    );
    query_posts($args);
    if(have_posts()) :
        echo '<div class="single-related"><h3 class="related-title">相关推荐</h3><ul class="clearfix">';
        while( have_posts() ) :
            the_post();
            echo '<li><a href="'.get_permalink().'"><img src="'.DGAThemes_thumbnail().'" class="thumb" alt="'.get_the_title().'"><h4>'.get_the_title().'</h4></a>';
            ?>
            <div class="meta">
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
              </div>
            <?php
            echo '</li>';
        endwhile;
        echo '</ul></div>';
    endif;
    wp_reset_query();
