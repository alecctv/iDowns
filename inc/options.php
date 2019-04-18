<?php

/**
 * A unique identifier is defined to store the options in the database and reference them from the yunsheji.cc theme.
 */
function optionsframework_option_name() {
	// Change this to use your theme slug
	if (!theme_check_active()) {
		return 'iDwons';
	}
	return 'iDowns';
}


/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'theme-textdomain'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'face' => 'yahei',
		'style' => 'normal',
		'color' => '#383121' );
		
	$typography_content = array(
		'size' => '13px',
		'face' => 'yahei',
		'style' => 'normal',
		'color' => '#000000' );
		
	// Typography Options
	$typography_options = array(
		'sizes' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	// $options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}


	$adsdesc =  '可添加广告联盟代码或自定义代码';



	$qrcode = get_stylesheet_directory_uri() . '/static/img/qrcode.png';
	$logo = get_stylesheet_directory_uri() . '/static/img/logo.png';
	$favicon = get_stylesheet_directory_uri() . '/static/img/favicon.ico';
	$footer_iconbg = get_stylesheet_directory_uri() . '/static/img/3.png';
	$home_slide = get_stylesheet_directory_uri() . '/static/img/slide.jpg';

	$options = array();


	
	$options[] = array(
		'name' => '基本',
		'type' => 'heading');


	$options[] = array(
		'name' => "主题风格",
		'desc' => "13种颜色供选择，点击选择你喜欢的颜色，保存后前端展示会有所改变。",
		'id' => "theme_color",
		'std' => "#1d1d1d",
		'type' => "colorradio",
		'options' => array(
			'#1d1d1d' => 1,
			'#2CDB87' => 2,
			'#00D6AC' => 3,
			'#FF6651' => 4,
			'#EA84FF' => 5,
			'#FDAC5F' => 6,
			'#FD77B2' => 7,
			'#76BDFF' => 8,
			'#C38CFF' => 9,
			'#FF926F' => 10,
			'#8AC78F' => 11,
			'#C7C183' => 12,
			'#1E88E5' => 13
		)
	);

	

	$options[] = array(
		'id' => 'theme_color_custom',
		'std' => "",
		'desc' => '不喜欢上面提供的颜色，你好可以在这里自定义设置，如果不用自定义颜色清空即可（默认不用自定义）',
		'type' => "color");

	$options[] = array(
		'name' => 'Favicon图标',
		'id' => 'favicon',
		'desc' => '',
		'std' => $favicon,
		'type' => 'upload');

	$options[] = array(
		'name' => 'Logo 电脑端',
		'id' => 'logo',
		'desc' => '建议尺寸：140*60px 格式：png',
		'std' => $logo,
		'type' => 'upload');

	$options[] = array(
		'name' => 'Logo 手机端',
		'id' => 'logo_src_m',
		'desc' => '最大高：30px；建议尺寸：180*60px 格式：png',
		'std' => $logo,
		'type' => 'upload');

	$options[] = array(
		'name' => '登录Logo',
		'id' => 'logo_login',
		'desc' => '建议尺寸：100*100px 格式：png',
		'std' => $logo,
		'type' => 'upload');

	$options[] = array(
		'name' => 'PC端导航栏登录注册',
		'id' => 'sign_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => '开启');

	$options[] = array(
		'name' => '底部侧边栏显示搜索按钮',
		'id' => 'nav_search',
		'type' => "checkbox",
		'std' => true,
		'desc' => '开启');

	$options[] = array(
		'name' => '开启左下角QQ联系按钮',
		'id' => 'footer_qq',
		'type' => "checkbox",
		'std' => true,
		'desc' => '显示');

	$options[] = array(
		'name' => '',
		'id' => 'footer_qqhao',
		'type' => "text",
		'std' => '200933220',
		'desc' => 'QQ号码');


	$options[] = array(
		'name' => '首页顶部',
		'type' => 'heading');
	
	$options[] = array(
		'name' => 'V1.5新增-首页顶部风格',
		'id' => 'home_header_style',
		'desc' => '',
		'options' => array(
			'style_0' => 'Banner+标题按钮',
			'style_1' => 'Banner+搜索框',
			'style_2' => '幻灯片布局'
		),
		'std' => 'style_0',
		'type' => "radio"
	);

	$options[] = array(
		'name' => '首页banner图片',
		'id' => 'banner_img',
		'type' => "upload",
		'std' => '',
		'desc' => '');

	$options[] = array(
		'name' => '首页banner标题',
		'id' => 'banner_title',
		'type' => "text",
		'std' => 'iDowns',
		'desc' => '');

	$options[] = array(
		'name' => '首页banner描述',
		'id' => 'banner_desc',
		'type' => "text",
		'std' => '可能是最不专业的wordpress建站仿站、二次开发、主题插件折腾人！',
		'desc' => '');

	$options[] = array(
		'name' => '首页banner按钮',
		'id' => 'banner_btn',
		'type' => "text",
		'std' => '查看详情',
		'desc' => '');

	$options[] = array(
		'name' => '首页banner链接',
		'id' => 'banner_link',
		'type' => "text",
		'std' => 'http://ylit.cc/',
		'desc' => '');

	$options[] = array(
        'name' => 'V1.5新增-幻灯片排序',
        'id' => 'focusslide_sort',
        'desc' => '默认：1 2 3(设置1 3 5 则按顺序只显示3个幻灯片，数字用空格隔开)',
        'std' => '1 2 3',
        'type' => 'text');
    
    for ($i=1; $i <= 3; $i++) {    
    $options[] = array(
        'name' => '图'.$i,
        'id' => 'focusslide_title_'.$i,
        'desc' => '标题(可不填)',
        'std' => 'iDowns主题 - 精品WordPress Theme',
        'type' => 'text');

    $options[] = array(
        'id' => 'focusslide_href_'.$i,
        'desc' => '链接',
        'std' => '#',
        'type' => 'text');

    $options[] = array(
        'id' => 'focusslide_blank_'.$i,
        'std' => true,
        'desc' => '新窗口打开',
        'type' => 'checkbox');
    
    $options[] = array(
        'id' => 'focusslide_src_'.$i,
        'desc' => '图片，建议尺寸：'.'1920*600',
        'std' => $home_slide,
        'type' => 'upload');
	}



	$options[] = array(
		'name' => '首页模块',
		'type' => 'heading');


	

	$options[] = array(
		'name' => '首页分类菜单',
		'id' => 'home_cat',
		'type' => "checkbox",
		'std' => true,
		'desc' => '显示（在WP后台菜单-新建一个菜单，把全部分类目录设置为分类导航菜单，既可实现ajax查看分类下文章）');

	$options[] = array(
		'name' => '首页关键字(keywords)',
		'id' => 'keywords',
		'std' => 'iDowns,虚拟资源分享下载主题,wordpress主题定制',
		'desc' => '关键字有利于SEO优化，建议个数在5-10之间，用英文逗号隔开',
		'settings' => array(
			'rows' => 4
		),
		'type' => 'textarea');

	$options[] = array(
		'name' => '首页描述(description)',
		'id' => 'description',
		'std' => 'iDowns,虚拟资源分享下载主题,不专业提供wordpress主题定制开发服务',
		'desc' => '描述有利于SEO优化，建议字数在30-70之间',
		'settings' => array(
			'rows' => 4
		),
		'type' => 'textarea');

	$options[] = array(
		'name' => 'V1.5新增-首页顶部推荐文章模块风格',
		'id' => 'home_box_style',
		'desc' => '',
		'options' => array(
			'style_0' => 'boxcms+卡片风格',
			'style_1' => 'boxcms+列表风格',
			'style_2' => '不启用'
		),
		'std' => 'style_0',
		'type' => "radio"
	);


	if ( $options_categories ) {
        $options[] = array(
            'name' => __( '首页顶部推荐文章所属分类' ),
            'desc' => __( '建议为此模块设一个分类为“首页推荐”。' ),
            'std' => 1,
            'id' => 'home_cms_categories',
            'type' => 'select',
            'options' => $options_categories
        );
    }

    $options[] = array(
		'name' => '',
		'id' => 'home_cms_postnum',
		'std' => 3,
		'desc' => '默认：3，显示文章数',
		'type' => 'text');

    $options[] = array(
		'name' => 'V1.5新增-首页粒子特效条',
		'id' => 'home_particles',
		'type' => "checkbox",
		'std' => true,
		'desc' => '显示');

	$options[] = array(
		'name' => '',
		'id' => 'home_particles_tite',
		'type' => "text",
		'std' => '优雅的主题大概总有人喜欢',
		'desc' => '大标题');

	$options[] = array(
		'name' => '',
		'id' => 'home_particles_desc',
		'type' => "text",
		'std' => '你好，欢迎来到WordPress主题世界，推荐几款主题',
		'desc' => '副标题');



	$options[] = array(
		'name' => '开启首页会员价格表模块',
		'id' => 'home_pricing',
		'type' => "checkbox",
		'std' => true,
		'desc' => '显示');

	$options[] = array(
		'name' => '',
		'id' => 'home_prictite',
		'type' => "text",
		'std' => '会员特权',
		'desc' => '员价格表标题');

	$options[] = array(
		'name' => '',
		'id' => 'home_pricdesc',
		'type' => "text",
		'std' => '开通本站会员，VIP素材资源免费下载，节省你撩妹的时间！',
		'desc' => '副标题');

	$options[] = array(
		'name' => '价格1',
		'id' => 'home_pricing1',
		'type' => "textarea",
		'std' => '<li>节省23%</li> <li>购买原创素材9折</li> <li>全球CDN极速访问</li> <li>无广告直接下</li>',
		'desc' => '---1---会员价格表内容');

	$options[] = array(
		'name' => '价格2',
		'id' => 'home_pricing2',
		'type' => "textarea",
		'std' => '<li>节省32%</li> <li>购买原创素材9折</li> <li>全球CDN极速访问</li> <li>无广告直接下</li>',
		'desc' => '---2---会员价格表内容');

	$options[] = array(
		'name' => '价格3',
		'id' => 'home_pricing3',
		'type' => "textarea",
		'std' => '<li>节省38%</li> <li>购买原创素材9折</li> <li>全球CDN极速访问</li> <li>无广告直接下</li>',
		'desc' => '---3---会员价格表内容');

	$options[] = array(
		'name' => '开启首页底部按钮模块',
		'id' => 'home_btn',
		'type' => "checkbox",
		'std' => true,
		'desc' => '显示');

	$options[] = array(
		'name' => '',
		'id' => 'home_btntite',
		'type' => "text",
		'std' => '更多精彩资源分享',
		'desc' => '按钮模块主标题');

	$options[] = array(
		'name' => '',
		'id' => 'home_btndesc',
		'type' => "text",
		'std' => '本站致力分享整合行业最新原创精品作资源！',
		'desc' => '副标题');

	$options[] = array(
		'name' => '友情链接',
		'id' => 'friendlink',
		'type' => "checkbox",
		'std' => true,
		'desc' => '开启');

	$options[] = array(
		'name' => '按钮1',
		'id' => 'home_btntext1',
		'type' => "textarea",
		'std' => '<i class="dripicons dripicons-browser"></i>关于我们</a>',
		'desc' => '---1---按钮文字');

	$options[] = array(
		'name' => '',
		'id' => 'home_btnlink1',
		'type' => "text",
		'std' => '#',
		'desc' => '---1---按钮链接');

	$options[] = array(
		'name' => '按钮2',
		'id' => 'home_btntext2',
		'type' => "textarea",
		'std' => '<i class="dripicons dripicons-download"></i>下载教程</a>',
		'desc' => '---2---按钮文字');

	$options[] = array(
		'name' => '',
		'id' => 'home_btnlink2',
		'type' => "text",
		'std' => '#',
		'desc' => '---2---按钮链接');

	$options[] = array(
		'name' => '按钮3',
		'id' => 'home_btntext3',
		'type' => "textarea",
		'std' => '<i class="dripicons dripicons-web"></i>在线咨询</a>',
		'desc' => '---3---按钮文字');

	$options[] = array(
		'name' => '',
		'id' => 'home_btnlink3',
		'type' => "text",
		'std' => '#',
		'desc' => '---3---按钮链接');



	$options[] = array(
		'name' => 'CMS+',
		'type' => 'heading');



	$options[] = array(
		'name' => '首页文章底部CMS_A-----------',
		'id' => 'home_cms_a',
		'type' => "checkbox",
		'std' => true,
		'desc' => '开启');

	if ( $options_categories ) {
        $options[] = array(
            'name' => __( '模块1分类' ),
            'desc' => __( '只显示有文章的分类选项(左右两大块布局)' ),
            'std' => 1,
            'id' => 'home_cms_cat_a_a',
            'type' => 'select',
            'options' => $options_categories
        );
    }

    $options[] = array(
		'name' => '',
		'id' => 'home_cms_num_a_a',
		'std' => 5,
		'desc' => '默认：5，显示文章数',
		'type' => 'text');



    if ( $options_categories ) {
        $options[] = array(
            'name' => __( '模块2分类' ),
            'desc' => __( '只显示有文章的分类选项(左右两大块布局)' ),
            'std' => 1,
            'id' => 'home_cms_cat_a_b',
            'type' => 'select',
            'options' => $options_categories
        );
    }

    $options[] = array(
		'name' => '',
		'id' => 'home_cms_num_a_b',
		'std' => 5,
		'desc' => '默认：5，显示文章数',
		'type' => 'text');


	// CMS_B
	$options[] = array(
		'name' => '首页文章底部CMS_B-----------',
		'id' => 'home_cms_b',
		'type' => "checkbox",
		'std' => true,
		'desc' => '开启');

	if ( $options_categories ) {
        $options[] = array(
            'name' => __( '模块1分类' ),
            'desc' => __( '只显示有文章的分类选项(三个小块布局)' ),
            'std' => 1,
            'id' => 'home_cms_cat_b_a',
            'type' => 'select',
            'options' => $options_categories
        );
    }

    $options[] = array(
		'name' => '',
		'id' => 'home_cms_num_b_a',
		'std' => 5,
		'desc' => '默认：5，显示文章数',
		'type' => 'text');



    if ( $options_categories ) {
        $options[] = array(
            'name' => __( '模块2分类' ),
            'desc' => __( '只显示有文章的分类选项(左右两大块布局)' ),
            'std' => 1,
            'id' => 'home_cms_cat_b_b',
            'type' => 'select',
            'options' => $options_categories
        );
    }

    $options[] = array(
		'name' => '',
		'id' => 'home_cms_num_b_b',
		'std' => 5,
		'desc' => '默认：5，显示文章数',
		'type' => 'text');


     if ( $options_categories ) {
        $options[] = array(
            'name' => __( '模块3分类' ),
            'desc' => __( '只显示有文章的分类选项(左右两大块布局)' ),
            'std' => 1,
            'id' => 'home_cms_cat_b_c',
            'type' => 'select',
            'options' => $options_categories
        );
    }

    $options[] = array(
		'name' => '',
		'id' => 'home_cms_num_b_c',
		'std' => 5,
		'desc' => '默认：5，显示文章数',
		'type' => 'text');


    // END






	$options[] = array(
		'name' => '功能',
		'type' => 'heading');


	$options[] = array(
		'name' => '文章列表风格',
		'id' => 'home_postlist',
		'desc' => '',
		'options' => array(
			'style_0' => '网格布局',
			'style_1' => '列表布局'
		),
		'std' => 'style_0',
		'type' => "select"
	);

	$options[] = array(
		'name' => 'V1.7+ 开启顶部菜单浮动效果',
		'id' => 'is_header_sps',
		'type' => "checkbox",
		'std' => true,
		'desc' => '开启'.'');


	$options[] = array(
		'name' => '开启登陆注册组件弹窗',
		'id' => 'isloginpop',
		'type' => "checkbox",
		'std' => true,
		'desc' => '开启'.'（关闭后跳转到独立登录页面）');

	$options[] = array(
		'name' => 'V1.7+ 搜索排除页面类型',
		'id' => 'isserach_page',
		'type' => "checkbox",
		'std' => true,
		'desc' => '开启'.'（只显示搜索到的文章）');


	$options[] = array(
		'name' => 'V1.7+ 开启文章侧边栏滑动',
		'id' => 'is_sidebar_top',
		'type' => "checkbox",
		'std' => true,
		'desc' => '开启(只在文章页面生效)');


	$options[] = array(
		'name' => '上传文件重命名',
		'id' => 'file_rename',
		'type' => "checkbox",
		'std' => true,
		'desc' => '开启'.'（该功能会针对上传的文件和图片重命名，如：09075549994.jpg）');

	$options[] = array(
		'name' => '自动将文章中上传的第一张图片缩略图设为特色图像',
		'id' => 'set_postthumbnail',
		'type' => "checkbox",
		'std' => true,
		'desc' => '开启'.'（如果没有添加文章缩略图，将自动获取文章中的第一张图片的缩略图设置为特色图像，开启后只在保存和发布文章时有效）');

	$options[] = array(
		'name' => '自动将文章中的第一张图片设为特色图像-支持外链',
		'id' => 'thumb_postfirstimg_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => '开启'.'（如果文章没有缩略图，自动将文章中的第一张图片设为特色图像）');


	$options[] = array(
		'name' => 'Ajax文章列表自动加载',
		'id' => 'ajax_list_load',
		'type' => "checkbox",
		'std' => false,
		'desc' => '开启（关闭将使用翻页按钮）');

	$options[] = array(
		'name' => '图片延迟加载',
		'id' => 'lazyload',
		'type' => "checkbox",
		'std' => true,
		'desc' => '开启 （文章列表图片延迟加载，给网站提速）');

	$options[] = array(
		'name' => '熊掌号',
		'id' => 'xiongzhang',
		'type' => "checkbox",
		'std' => false,
		'desc' => '开启（资源自动推送给百度，申请地址https://xiongzhang.baidu.com/）');

	$options[] = array(
		'name' => '熊掌号appid',
		'desc' => 'appid如果填写错误，或者未审核通过，会造报错，导致某些js无法加载',
		'id' => 'xiongzhang_appid',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => '注册验证码',
		'id' => 'captcha',
		'desc' => '',
		'options' => array(
			'image' => '图形验证码',
			'email' => '邮件验证码'
		),
		'std' => 'image',
		'type' => "radio");

	$options[] = array(
		'name' => '边栏固定序号',
		'id' => 'sidebar_fixed',
		'type' => "text",
		'std' => '1,2',
		'desc' => '输入边栏小工具的序号，多个用半角英文逗号隔开，例如：1,2');


	$options[] = array(
		'name' => '充值固定金额',
		'id' => 'recharge_price_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => '开启');

	$options[] = array(
		'name' => '固定金额',
		'id' => 'recharge_price',
		'type' => "text",
		'std' => '1,5,10,50,100',
		'desc' => '输入价格，多个用半角英文逗号隔开，例如：1,5,10,50,100');
	
	$options[] = array(
		'name' => '全站右下-通知弹窗',
		'id' => 'all_page_tips',
		'std' => 'iDowns,虚拟资源分享下载主题,不专业提供wordpress主题定制开发服务,现已更新至V1.8版本！',
		'desc' => '推介纯文本内容即可！',
		'settings' => array(
			'rows' => 4
		),
		'type' => 'textarea');

	
	$options[] = array(
		'name' => '文章',
		'type' => 'heading');

	$options[] = array(
		'name' => '列表页banner图片',
		'id' => 'banner_archive_img',
		'type' => "upload",
		'std' => '',
		'desc' => '已做灰度处理，请上传一张高180px的图片，repeat-x模式');

	$options[] = array(
		'name' => '视频文章解析接口',
		'desc' => '默认用https://cdn.yangju.vip/k/?url=，可以自行切换，主题https和http站点对应',
		'id' => 'video_url_auto',
		'std' => 'https://cdn.yangju.vip/k/?url=',
		'type' => 'text');


	$options[] = array(
		'name' => '分类页筛选',
		'id' => 'filter',
		'type' => "checkbox",
		'std' => false,
		'desc' => '开启（分类页标签/排序筛选）');

	$options[] = array(
		'name' => '筛选标签IDs',
		'desc' => '输入标签ID列表，多个用英文半角逗号隔开',
		'id' => 'filter_tags',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => '文章阅读数',
		'id' => 'post_views',
		'desc' => '开启',
		'std' => true,
		'type' => "checkbox");

	$options[] = array(
		'name' => 'V1.7+ 开启商城文章新样式',
		'id' => 'is_shop_posts_box',
		'desc' => '开启',
		'std' => false,
		'type' => "checkbox");


	$options[] = array(
		'name' => '下载框位置',
		'id' => 'down_position',
		'desc' => '',
		'options' => array(
			'side' => '边栏',
			'top' => '内容上',
			'bottom' => '内容下',
			'sidetop' => '边栏与内容上',
			'sidebottom' => '边栏与内容下'
		),
		'std' => 'side',
		'type' => "radio");

	$options[] = array(
		'name' => '资源下载数',
		'id' => 'post_downloads',
		'desc' => '开启',
		'std' => true,
		'type' => "checkbox");


	$options[] = array(
		'name' => '文章标签',
		'id' => 'post_tags',
		'desc' => '开启',
		'std' => true,
		'type' => "checkbox");


	$options[] = array(
		'name' => '分享',
		'id' => 'post_share',
		'desc' => '开启',
		'std' => true,
		'type' => "checkbox");


	$options[] = array(
		'name' => '上一篇和下一篇文章',
		'id' => 'post_nav',
		'desc' => '开启',
		'std' => true,
		'type' => "checkbox");


	$options[] = array(
		'name' => '相关文章',
		'id' => 'post_related',
		'type' => "checkbox",
		'std' => true,
		'desc' => '开启');

	$options[] = array(
		'name' => '价格显示',
		'id' => 'post_price',
		'type' => "checkbox",
		'std' => false,
		'desc' => '隐藏（列表页item的价格）');

	$options[] = array(
		'name' => '评论显示已购买',
		'id' => 'post_comment_bought',
		'type' => "checkbox",
		'std' => true,
		'desc' => '开启');


	$options[] = array(
		'name' => '底部',
		'type' => 'heading');

	$options[] = array(
		'name' => '开启底部四个图标文字块',
		'id' => 'footer_iconbox',
		'type' => "checkbox",
		'std' => true,
		'desc' => '开启');

	$options[] = array(
		'name' => '模块背景图片',
		'id' => 'footer_iconbg',
		'desc' => '建议尺寸：1600*400px 格式：jpeg或png',
		'std' => $footer_iconbg,
		'type' => 'upload');

	$options[] = array(
		'name' => '底部块-1',
		'id' => 'footer_icon1',
		'type' => "textarea",
		'std' => '<i class="dripicons dripicons-message"></i>',
		'desc' => '图标代码');

	$options[] = array(
		'name' => '',
		'id' => 'footer_text1',
		'type' => "textarea",
		'std' => 'QQ：200933220 </br> 不定期在线',
		'desc' => '文字');

	$options[] = array(
		'name' => '底部块-2',
		'id' => 'footer_icon2',
		'type' => "textarea",
		'std' => '<i class="dripicons dripicons-cloud"></i>',
		'desc' => '图标代码');

	$options[] = array(
		'name' => '',
		'id' => 'footer_text2',
		'type' => "textarea",
		'std' => 'iDowns Theme <br> 每周更新优化',
		'desc' => '文字');

	$options[] = array(
		'name' => '底部块-3',
		'id' => 'footer_icon3',
		'type' => "textarea",
		'std' => '<i class="dripicons dripicons-mail"></i>',
		'desc' => '图标代码');

	$options[] = array(
		'name' => '',
		'id' => 'footer_text3',
		'type' => "textarea",
		'std' => 'i@ylit.cc <br> 7x24小时及时回复',
		'desc' => '文字');

	$options[] = array(
		'name' => '底部块-4',
		'id' => 'footer_icon4',
		'type' => "textarea",
		'std' => '<i class="dripicons dripicons-user-id"></i>',
		'desc' => '会员制度');

	$options[] = array(
		'name' => '',
		'id' => 'footer_text4',
		'type' => "textarea",
		'std' => 'USER VIP <br> 会员专属下载',
		'desc' => '文字');


	$options[] = array(
		'name' => '底部版权',
		'desc' => '可加html标签',
		'id' => 'copyright',
		'std' => 'Copyright ©  <a href="https://ylit.cc"> iDowns. </a> All Rights Reserved.',
		'type' => 'textarea');
	
	$options[] = array(
		'name' => '自定义CSS样式',
		'desc' => '位于&lt;/head&gt;之前，直接写样式代码，不用添加&lt;style&gt;标签',
		'id' => 'css',
		'std' => '',
		'type' => 'textarea');


	$options[] = array(
		'name' => '自定义底部代码',
		'desc' => '位于&lt;/body&gt;之前，若是js代码需添加&lt;script&gt;标签',
		'id' => 'js',
		'std' => '',
		'type' => 'textarea');

	$options[] = array(
		'name' => '网站统计代码',
		'desc' => '位于底部，会被隐藏，但不影响统计效果',
		'id' => 'analysis',
		'std' => '',
		'type' => 'textarea');



	$options[] = array(
		'name' => '社交登录',
		'type' => 'heading');

	$options[] = array(
		'name' => '登陆框文字',
		'id' => 'oauth_no_txt',
		'type' => "text",
		'std' => '卧槽~你还有脸回来',
		'desc' => '当不开启任何三方登陆时候，将显示文本信息');

	$options[] = array(
		'name' => 'QQ登录',
		'id' => 'oauth_qq',
		'type' => "checkbox",
		'std' => false,
		'desc' => '开启');

	$options[] = array(
		'name' => 'qq id',
		'id' => 'oauth_qqid',
		'type' => "text",
		'std' => '',
		'desc' => '');

	$options[] = array(
		'name' => 'qq key',
		'id' => 'oauth_qqkey',
		'type' => "text",
		'std' => '',
		'desc' => '');

	$options[] = array(
		'name' => '微博登录',
		'id' => 'oauth_weibo',
		'type' => "checkbox",
		'std' => false,
		'desc' => '开启');

	$options[] = array(
		'name' => 'weibo id',
		'id' => 'oauth_weiboid',
		'type' => "text",
		'std' => '',
		'desc' => '');

	$options[] = array(
		'name' => 'weibo key',
		'id' => 'oauth_weibokey',
		'type' => "text",
		'std' => '',
		'desc' => '');

	$options[] = array(
		'name' => '微信登录',
		'id' => 'oauth_weixin',
		'type' => "checkbox",
		'std' => false,
		'desc' => '开启');

	$options[] = array(
		'name' => 'weixin id',
		'id' => 'oauth_weixinid',
		'type' => "text",
		'std' => '',
		'desc' => '');

	$options[] = array(
		'name' => 'weixin srcret',
		'id' => 'oauth_weixinkey',
		'type' => "text",
		'std' => '',
		'desc' => '');

	$options[] = array(
		'name' => 'SMTP邮件配置',
		'type' => 'heading' );

	$options[] = array(
		'name' => 'SMTP服务',
		'desc' => '是否启用SMTP服务',
		'id' => 'mail_smtps',
		'std' => '0',
		'type' => 'checkbox');
	$options[] = array(
		'name' => '发信人',
		'desc' => '请填写发件人姓名',
		'id' => 'mail_name',
		'std' => 'YouName',
		'type' => 'text');
	$options[] = array(
		'name' => '邮件服务器',
		'desc' => '请填写SMTP服务器地址',
		'id' => 'mail_host',
		'std' => 'smtp.qq.com',
		'type' => 'text');
	$options[] = array(
		'name' => '服务器端口',
		'desc' => '请填写SMTP服务器端口',
		'id' => 'mail_port',
		'std' => '465',
		'type' => 'text');
	$options[] = array(
		'name' => '邮箱帐号',
		'desc' => '请填写邮箱账号',
		'id' => 'mail_username',
		'std' => '88888888@qq.com',
		'type' => 'text');
	$options[] = array(
		'name' => '邮箱密码',
		'desc' => '请填写邮箱密码',
		'id' => 'mail_passwd',
		'std' => '123456789',
		'type' => 'text');
	$options[] = array(
		'name' => '启用SMTPAuth服务',
		'desc' => '是否启用SMTPAuth服务',
		'id' => 'mail_smtpauth',
		'std' => '1',
		'type' => 'checkbox');
	$options[] = array(
		'name' => 'SMTPSecure设置',
		'desc' => '若启用SMTPAuth服务则填写ssl，若不启用则留空',
		'id' => 'mail_smtpsecure',
		'std' => 'ssl',
		'type' => 'text');


	$options[] = array(
		'name' => '广告位',
		'type' => 'heading' );

	$ads = array(
		//'ad_list_insert' => '列表插播（第三个位置）',
		'ad_banner_footer' => '首页banner下',
		'ad_home_footer' => '首页下',
		'ad_list_header' => '列表上',
		'ad_list_footer' => '列表下',
		'ad_post_header' => '文章内容上',
		'ad_post_footer' => '文章内容下',
		'ad_post_comment' => '文章评论下',
		'ad_erphpdown' => '下载页面',
	);

	foreach ($ads as $key => $adtit) {
		$options[] = array(
			'name' => $adtit,
			'id' => $key.'_s',
			'std' => false,
			'desc' => '开启',
			'type' => 'checkbox');
		$options[] = array(
			'desc' => $adsdesc,
			'id' => $key,
			'std' => '',
			'settings'=>array('rows'=>6),
			'type' => 'textarea');
	}


	$options[] = array(
		'name' => 'V1.8+ 辅助优化',
		'type' => 'heading' );

	$options[] = array(
		'name' => '开启网站内容css渐入动效',
		'id' => 'is_css_animation',
		'type' => "checkbox",
		'std' => flase,
		'desc' => '开启'.'（开启后细腻的一逼，兼容各种浏览器）');

	$options[] = array(
		'name' => 'loading动画加载',
		'id' => 'isloading',
		'type' => "checkbox",
		'std' => flase,
		'desc' => '开启'.'（开启全站打开页面时loading动画加载,IE低版本会出现不熄火的现象！）');

	$options[] = array(
		'name' => '启用网站源码压缩',
		'id' => 'iswebgizp',
		'type' => "checkbox",
		'std' => true,
		'desc' => '开启'.'（可增网页加打开速度）');

	$options[] = array(
		'name' => '移除 WP_Head 无关紧要的代码',
		'desc' => '开启',
		'id' => 'remove_head_links',
		'std' => true,
		'type' => 'checkbox');

	$options[] = array(
		'name' => '禁用日志修订功能',
		'desc' => '开启',
		'id' => 'diable_revision',
		'std' => true,
		'type' => 'checkbox');

	$options[] = array(
		'name' => '移除 admin bar 顶部黑边',
		'desc' => '开启',
		'id' => 'remove_admin_bar',
		'std' => true,
		'type' => 'checkbox');

	$options[] = array(
		'name' => '禁用 XML-RPC 接口',
		'desc' => '开启',
		'id' => 'disable_xml_rpc',
		'std' => true,
		'type' => 'checkbox');

	$options[] = array(
		'name' => '彻底关闭 pingback',
		'desc' => '开启',
		'id' => 'disable_trackbacks',
		'std' => true,
		'type' => 'checkbox');

	$options[] = array(
		'name' => '网站前台不加载语言包',
		'desc' => '开启',
		'id' => 'locale',
		'std' => true,
		'type' => 'checkbox');

	$options[] = array(
		'name' => '屏蔽 Emoji',
		'desc' => '开启',
		'id' => 'disable_emoji',
		'std' => true,
		'type' => 'checkbox');

	$options[] = array(
		'name' => '屏蔽 REST API',
		'desc' => '开启',
		'id' => 'disable_rest_api',
		'std' => true,
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => '百度主动推送',
		'desc' => '开启 <a href="http://zhanzhang.baidu.com/linksubmit/index" target="_blank">查看主动推送效果</a>',
		'id' => 'baidu_sitemap_api',
		'std' => false,
		'type' => 'checkbox');

	$options[] = array(
		'name' => '百度主动推送api接口',
		'desc' => '在百度站长平台获取主动推送接口地址，比如：http://data.zz.baidu.com/urls?site=域名&token=一组字符, <a class="button-primary" rel="nofollow" href="http://zhanzhang.baidu.com/linksubmit/index" target="_blank">主动推送接口地址</a>',
		'id' => 'baidu_sitemap_api_url',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => '关于CDN加速',
		'desc' => '现在CDN、产品和选择越来越多，仅仅弄一个设置选项，无法满足，所以有需求的，建议安装相应的插件，插件是个好东西，不要觉得插件多会影响啥，草他妈的收费CDN。',
		'id' => 'caotamadeCDN',
		'std' => true,
		'type' => 'checkbox');


	return $options;
}