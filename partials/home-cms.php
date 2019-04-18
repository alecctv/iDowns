<!-- 顶部BOX -->

<?php if(_DGA('home_cms_a','true')){?>
       
<section class="home-posts-cms">
    <div class="container">
        <div class="homecate3 row">
            <div class="box">
                <?php
                    $home_cms_cat_a_a = _DGA('home_cms_cat_a_a');
                    $home_cms_num_a_a = _DGA('home_cms_num_a_a','5');
                    $cat_name_a_a = get_category($home_cms_cat_a_a);
                ?>
                <div class="title">
                    <h4><?php echo $cat_name_a_a->name; ?></h4>
                    <i><a rel="nofollow" href="<?php echo get_category_link($home_cms_cat_a_a);?>" target="_blank">更多</a></i> 
                </div>
                    <ul>
                        <?php
                            query_posts("cat='$home_cms_cat_a_a'&posts_per_page=$home_cms_num_a_a "); 
                            while(have_posts()): the_post();
                        ?>
                        <li>
                            <div class="img"> 
                                <a href="<?php the_permalink();?>" title="<?php the_title();?>" target="_blank">
                                    <img <?php echo (_DGA('lazyload'))?'data-src':'src';?>="<?php echo DGAThemes_thumbnail();?>" class="thumb" alt="<?php the_title();?>">
                                </a> 
                            </div>
                            <div class="imgr">
                                <h3>
                                    <a href="<?php the_permalink();?>" title="<?php the_title();?>" target="_blank"><?php the_title();?></a>
                                    <?php echo DGAThemes_timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ) ?>
                                </h3>
                                <p><?php echo _get_excerpt($limit=50, $after='...');?></p>
                            </div>

                        </li>
                        <?php endwhile; wp_reset_query();  ?>
                    </ul>
            </div>
            
            <div class="box">
                <?php
                    $home_cms_cat_a_b = _DGA('home_cms_cat_a_b');
                    $home_cms_num_a_b = _DGA('home_cms_num_a_b','5');
                    $cat_name_a_b = get_category($home_cms_cat_a_b);
                ?>
                <div class="title">
                    <h4><?php echo $cat_name_a_b->name; ?></h4>
                    <i><a rel="nofollow" href="<?php echo get_category_link($home_cms_cat_a_b);?>" target="_blank">更多</a></i> 
                </div>
                    <ul>
                        <?php
                            query_posts("cat='$home_cms_cat_a_b'&posts_per_page=$home_cms_num_a_b "); 
                            while(have_posts()): the_post();
                        ?>
                        <li>
                            <div class="img"> 
                                <a href="<?php the_permalink();?>" title="<?php the_title();?>" target="_blank">
                                    <img <?php echo (_DGA('lazyload'))?'data-src':'src';?>="<?php echo DGAThemes_thumbnail();?>" class="thumb" alt="<?php the_title();?>">
                                </a> 
                            </div>
                            <div class="imgr">
                                <h3>
                                    <a href="<?php the_permalink();?>" title="<?php the_title();?>" target="_blank"><?php the_title();?></a>
                                    <?php echo DGAThemes_timeago( get_gmt_from_date(get_the_time('Y-m-d G:i:s')) ) ?>
                                </h3>
                                <p><?php echo _get_excerpt($limit=50, $after='...');?></p>
                            </div>

                        </li>
                        <?php endwhile; wp_reset_query();  ?>
                    </ul>
            </div>
            <!-- END -->
        </div>
    </div>
</section>
<?php }?>

<?php if(_DGA('home_cms_b','true')){?>
<section class="home-posts-cms-b">
    <div class="container">
        <div class="homecate4 row">

            <div class="box">
                <?php
                    $home_cms_cat_b_a = _DGA('home_cms_cat_b_a');
                    $home_cms_num_b_a = _DGA('home_cms_num_b_a','5');
                    $cat_name_b_a = get_category($home_cms_cat_b_a);
                ?>
                <div class="title">
                    <h4><?php echo $cat_name_b_a->name; ?></h4>
                    <i><a rel="nofollow" href="<?php echo get_category_link($home_cms_cat_b_a);?>" target="_blank">更多</a></i> 
                </div>
                <ul>
                    <?php
                        query_posts("cat='$home_cms_cat_b_a'&posts_per_page=$home_cms_num_b_a "); 
                        while(have_posts()): the_post();
                    ?>
                    <li><a href="<?php the_permalink();?>" title="<?php the_title();?>" target="_blank"> <?php the_title();?></a></li>
                    <?php endwhile; wp_reset_query();  ?>
                </ul>
            </div>

            <div class="box">
                <?php
                    $home_cms_cat_b_b = _DGA('home_cms_cat_b_b');
                    $home_cms_num_b_b = _DGA('home_cms_num_b_b','5');
                    $cat_name_b_b = get_category($home_cms_cat_b_b);
                ?>
                <div class="title">
                    <h4><?php echo $cat_name_b_b->name; ?></h4>
                    <i><a rel="nofollow" href="<?php echo get_category_link($home_cms_cat_b_b);?>" target="_blank">更多</a></i> 
                </div>
                <ul>
                    <?php
                        query_posts("cat='$home_cms_cat_b_b'&posts_per_page=$home_cms_num_b_b "); 
                        while(have_posts()): the_post();
                    ?>
                    <li><a href="<?php the_permalink();?>" title="<?php the_title();?>" target="_blank"> <?php the_title();?></a></li>
                    <?php endwhile; wp_reset_query();  ?>
                </ul>
            </div>

            <div class="box">
                <?php
                    $home_cms_cat_b_c = _DGA('home_cms_cat_b_c');
                    $home_cms_num_b_c = _DGA('home_cms_num_b_c','5');
                    $cat_name_b_c = get_category($home_cms_cat_b_c);
                ?>
                <div class="title">
                    <h4><?php echo $cat_name_b_c->name; ?></h4>
                    <i><a rel="nofollow" href="<?php echo get_category_link($home_cms_cat_b_c);?>" target="_blank">更多</a></i> 
                </div>
                <ul>
                    <?php
                        query_posts("cat='$home_cms_cat_b_c'&posts_per_page=$home_cms_num_b_c "); 
                        while(have_posts()): the_post();
                    ?>
                    <li><a href="<?php the_permalink();?>" title="<?php the_title();?>" target="_blank"> <?php the_title();?></a></li>
                    <?php endwhile; wp_reset_query();  ?>
                </ul>
            </div>
            
            <!-- END -->
        </div>
    </div>
</section> 
<?php }?>