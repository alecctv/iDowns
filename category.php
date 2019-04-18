<?php get_header();$cat_ID = get_query_var('cat');?>
<?php 
    if($_GET['t'] != '' && isset($_GET['t'])){
        $curr = get_term_by('slug',$_GET['t'],'post_tag');
        if($curr){
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            echo '<script>document.title = "';single_cat_title();echo ' / '.$curr->name.' - '.get_bloginfo('name');
            if($paged > 1) echo ' - 第'.$paged.'页';
            echo '";</script>';
        }
    }
?>
<div class="banner banner-archive" <?php if(_DGA('banner_archive_img')){?> style="background-image: url(<?php echo _DGA('banner_archive_img');?>);" <?php }?>>
	<div class="container">
		<h1 class="archive-title"><?php single_cat_title() ?></h1>
		<p class="archive-desc"><?php echo category_description();?></p>
	</div>
</div>
<div class="main">
	<div class="container">
		<?php DGAThemes_ad('ad_list_header');?>
		<?php if(_DGA('filter')){?>
		<div class="filters">
            <div class="filter-item">
                <span>标签</span>
                <div class="filter">
                    <?php 
                        if($_GET['t'] == '' || !isset($_GET['t'])) $class2="active";else $class2 = ''; 
                        if(isset($_GET['o']) && $_GET['o']){
                            echo '<a href="'.add_query_arg(array("o"=>$_GET['o'],"paged"=>1),get_category_link($cat_ID)).'" rel="nofollow" class="'.$class2.'">全部</a>';
                        }else{
                            echo '<a href="'.add_query_arg(array("paged"=>1),get_category_link($cat_ID)).'" rel="nofollow" class="'.$class2.'">全部</a>';
                        }
                        $filter_tag_ids = _DGA('filter_tags');
                        if($filter_tag_ids){
                            $filter_tag_ids_array = explode(',', $filter_tag_ids);
                            foreach ($filter_tag_ids_array as $tag_id) {
                                $term = get_term_by('id',$tag_id,'post_tag');
                                if($_GET['t'] == $term->slug) $class="active";else $class = ''; 
                                if(isset($_GET['o']) && $_GET['o']){
                                    echo '<a href="'.add_query_arg(array("t"=>$term->slug,"o"=>$_GET['o'],"paged"=>1),get_category_link($cat_ID)).'" rel="nofollow" class="'.$class.'">' . $term->name . '</a>';
                                }else{
                                    echo '<a href="'.add_query_arg(array("t"=>$term->slug,"paged"=>1),get_category_link($cat_ID)).'" rel="nofollow" class="'.$class.'">' . $term->name . '</a>';
                                }
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="filter-item">
                <span>排序</span>
                <div class="filter">
                    <?php 
                        if($_GET['o'] == '' || !isset($_GET['o'])){ 
                            $class3="active";
                        }elseif($_GET['o'] == 'download'){
                            $class4 = 'active';
                        }elseif($_GET['o'] == 'view'){
                            $class5 = 'active';
                        }
                        if(isset($_GET['t']) && $_GET['t']){
                            echo '<a href="'.add_query_arg(array("t"=>$_GET['t'],"paged"=>1),get_category_link($cat_ID)).'" rel="nofollow" class="'.$class3.'">最新</a>';
                            echo '<a href="'.add_query_arg(array("t"=>$_GET['t'],"o"=>"download","paged"=>1),get_category_link($cat_ID)).'" rel="nofollow" class="'.$class4.'">下载最多</a>';
                            echo '<a href="'.add_query_arg(array("t"=>$_GET['t'],"o"=>"view","paged"=>1),get_category_link($cat_ID)).'" rel="nofollow" class="'.$class5.'">浏览最多</a>';
                        }else{
                            echo '<a href="'.add_query_arg(array("paged"=>1),get_category_link($cat_ID)).'" rel="nofollow" class="'.$class3.'">最新</a>';
                            echo '<a href="'.add_query_arg(array("o"=>"download","paged"=>1),get_category_link($cat_ID)).'" rel="nofollow" class="'.$class4.'">下载最多</a>';
                            echo '<a href="'.add_query_arg(array("o"=>"view","paged"=>1),get_category_link($cat_ID)).'" rel="nofollow" class="'.$class5.'">浏览最多</a>';
                        }
                    ?>
                </div>
            </div>
        </div>
		<?php }?>
		<div id="posts" class="posts grids clearfix">
			<?php 
				if(_DGA('filter')){
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $args = array(
                        'cat' => $cat_ID,
                        'paged' => $paged
                    );
                    if(isset($_GET['t']) && $_GET['t']){
                        $args['tag'] = $_GET['t'];
                    }
                    if(isset($_GET['o']) && $_GET['o']){
                        if($_GET['o'] == 'download'){
                            $args['meta_query'] = array();
                            array_push($args['meta_query'], array(
                                'relation' => 'OR', 
                                'exist_clause' => array(
                                    'key' => 'down_times', 
                                    'compare' => 'EXISTS'
                                ),
                                'not_exist_clause' => array(
                                    'key' => 'down_times', 
                                    'compare' => 'NOT EXISTS'
                                ),
                                
                            ) );
                        }
                        elseif($_GET['o'] == 'view'){
                            $args['meta_key'] = 'views';
                        }

                        $args['orderby'] = 'meta_value_num';
                    }
                    query_posts($args);
				}
				while ( have_posts() ) : the_post(); 
				switch (_DGA('home_postlist')) {
                   case "style_0":
                     get_template_part( 'content', get_post_format() );
                     break;
                   case "style_1":
                     get_template_part( 'content', 'item' );
                     break;
                }
				endwhile; 
				if(!_DGA('filter')) wp_reset_query(); 
			?>
		</div>
		<?php DGAThemes_paging();?>
		<?php DGAThemes_ad('ad_list_footer');?>
	</div>
</div>
<?php get_footer();?>