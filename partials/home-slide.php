<!-- 幻灯片 -->
<?php function mo_slider( $id='focusslide' ){
    $indicators = '';
    $inner = '';

    $sort = _DGA($id.'_sort') ? _DGA($id.'_sort') : '1 2 3';
    $sort = array_unique(explode(' ', trim($sort)));
    $i = 0;
    foreach ($sort as $key => $value) {
        if( _DGA($id.'_src_'.$value) && _DGA($id.'_href_'.$value) && _DGA($id.'_title_'.$value) ){
            $inner .= '<div class="swiper-slide"><a'.( _DGA($id.'_blank_'.$value) ? ' target="_blank"' : '' ).' href="'._DGA($id.'_href_'.$value).'"><img src="'._DGA($id.'_src_'.$value).'"></a></div>';
            $i++;
        }
    }
    echo ''.$inner.'';
}
?>

<section id="slide" class="">
<link rel="stylesheet" href="<?php bloginfo('template_url');?>/static/css/swiper.min.css">
<div class="home-swiper">
    <!-- Swiper -->
    <div class="swiper-container swiper-container-horizontal">
        <div class="swiper-wrapper">
            <?php mo_slider('focusslide'); ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</div>


<script src="<?php bloginfo('template_url');?>/static/js/swiper.min.js"></script>
<script type="text/javascript">

    var mySwiper = new Swiper('.swiper-container', {
        loop: true,
        pagination: '.swiper-pagination',
        paginationClickable: true,
        autoplay: 3000, 
        keyboardControl: true,
        prevButton: '.swiper-button-prev',
        nextButton: '.swiper-button-next',
    })    
</script>
</section>