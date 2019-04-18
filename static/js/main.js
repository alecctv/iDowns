var IDOWNS = {
	paged: 1,
	lazy: 0,
	ias: 0,
	water: 0,
	body: jQuery("body"),
	init: function(obj){
		var that = this;
		that.lazy = obj.lazy;
		that.ias = obj.ias;
		that.water = obj.water;
		if(that.body.hasClass('page-template-waterfall')) that.water=1;
		that.other();
		that.scroll();
		if(that.lazy && !that.water) that.lazyload();
		if(that.ias) that.iasLoad();
		that.erphpBox();
		that.share();
		if(!that.body.hasClass("logged-in"))
			that.login();
		if(that.body.hasClass("home"))
			that.catFilter();
		that.comment();
		that.sidebar();
	},
	other: function(){


		var that = this;
		jQuery(function($){
			$('.sitenav-on').on('click', function(){
			$('body').toggleClass('sitenav-active')
			})

			$('.sitenav-mask').on('click', function(){
				$('body').removeClass('sitenav-active')
			})

			$('.searchstart-on').on('click', function(){
				$(this).hide()
				$('.searchstart-off').show()
				$('body').addClass('searchform-active')
				$('.sinput').focus()
			})

			$('.searchstart-off').on('click', function(){
				$(this).hide()
				$('.searchstart-on').show()
				$('body').removeClass('searchform-active')
			})

			if($.cookie("idowns_sitetips_new_cookie")!=null){
				
			}else{
				$('.site-tips').css("bottom","0");
			}

			$('.site-tips .close').on('click',function(){

			 	$('.site-tips').css("bottom","-188px");

				$.cookie('idowns_sitetips_new_cookie', '1', { expires: 3 }); 

			});


		});
		

		jQuery(".totop").click(function(){
			that.scrollTo();
		});

		/*fancybox*/
		$(function() {
			jQuery(".gallery a").attr("data-fancybox","images");
			//jQuery('a[data-fancybox="images"]').fancybox();
		});
		
		/** Load page */
		setTimeout(function() { $('#loading').fadeOut(); }, 300);

		/* exported ScrollPosStyler */ 

		var ScrollPosStyler = (function(document, window) {
		  "use strict";

		  /* ====================
		   * private variables
		   * ==================== */
		  var scrollPosY = 0,
		      busy = false,
		      onTop = true,

		      // toggle style / class when scrolling below this position (in px)
		      scrollOffsetY = 200,

		      // choose elements to apply style / class to
		      elements = document.getElementsByClassName("sps");


		  /* ====================
		   * private funcion to check scroll position
		   * ==================== */
		  function onScroll() {
		    // ensure that events don't stack
		    if (!busy) {
		      // get current scroll position from window
		      scrollPosY = window.pageYOffset;

		      // if we were above, and are now below scroll position...
		      if (onTop && scrollPosY > scrollOffsetY) {
		        // suspend accepting scroll events
		        busy = true;

		        // remember that we are below scroll position
		        onTop = false;

		        // asynchronuously add style / class to elements
		        window.requestAnimationFrame(belowScrollPos);

		      // if we were below, and are now above scroll position...
		      } else if (!onTop && scrollPosY <= scrollOffsetY) {
		        // suspend accepting scroll events
		        busy = true;

		        // remember that we are above scroll position
		        onTop = true;

		        // asynchronuously add style / class to elements
		        window.requestAnimationFrame(aboveScrollPos);
		      }
		    }
		  }


		  /* ====================
		   * private function to style elements when above scroll position
		   * ==================== */
		  function aboveScrollPos() {
		    // iterate over elements
		    // for (var elem of elements) {
		    for (var i = 0; elements[i]; ++i) { // chrome workaround
		      // add style / class to element
		      elements[i].classList.add("sps--abv");
		      elements[i].classList.remove("sps--blw");
		    }

		    // resume accepting scroll events
		    busy = false;
		  }

		  /* ====================
		   * private function to style elements when below scroll position
		   * ==================== */
		  function belowScrollPos() {
		    // iterate over elements
		    // for (var elem of elements) {
		    for (var i = 0; elements[i]; ++i) { // chrome workaround
		      // add style / class to element
		      elements[i].classList.add("sps--blw");
		      elements[i].classList.remove("sps--abv");
		    }

		    // resume accepting scroll events
		    busy = false;
		  }


		  /* ====================
		   * public function to initially style elements based on scroll position
		   * ==================== */
		  var pub = {
		    init: function() {
		      // suspend accepting scroll events
		      busy = true;

		      // get current scroll position from window
		      scrollPosY = window.pageYOffset;

		      // if we are below scroll position...
		      if (scrollPosY > scrollOffsetY) {
		        // remember that we are below scroll position
		        onTop = false;

		        // asynchronuously add style / class to elements
		        window.requestAnimationFrame(belowScrollPos);

		      // if we are above scroll position...
		      } else { // (scrollPosY <= scrollOffsetY)
		        // remember that we are above scroll position
		        onTop = true;

		        // asynchronuously add style / class to elements
		        window.requestAnimationFrame(aboveScrollPos);
		      }
		    }
		  };


		  /* ====================
		   * main initialization
		   * ==================== */
		  // add initial style / class to elements when DOM is ready
		  document.addEventListener("DOMContentLoaded", function() {
		    // defer initialization to allow browser to restore scroll position
		    window.setTimeout(pub.init, 1);
		  });

		  // register for window scroll events
		  window.addEventListener("scroll", onScroll);


		  return pub;
		})(document, window);

	
	},
	sidebar: function(){
		var that = this;
		
	},
	scroll: function(){
		jQuery(window).scroll(function() {
			// document.documentElement.scrollTop + document.body.scrollTop > 99 ? jQuery('.header').addClass('nav-fixed-top') : jQuery('.header').removeClass('nav-fixed-top');
			document.documentElement.scrollTop + document.body.scrollTop > 150 ? jQuery('.rollbar').show() : jQuery('.rollbar').hide();
		});
	},
	lazyload: function(){
		var that = this;
		if(jQuery('.thumb:first').data('src')){
			jQuery('.thumb').lazyload({
		          data_attribute: 'src',
		          placeholder: _DGA.uri + '/static/img/thumbnail.png',
		          threshold: 400
		    });
		}
	},
	iasLoad: function(){
		var that = this;
		if(jQuery('.pagination').length){
			if(that.water){
				var grids = document.querySelector('.grids');
				imagesLoaded( grids, function() {
					
				    var msnry = new Masonry( grids, {
				      itemSelector: '.grid',
				      //columnWidth: 285,
				      //gutter: 20,
				      visibleStyle: { transform: 'translateY(0)', opacity: 1 },
  					  hiddenStyle: { transform: 'translateY(100px)', opacity: 0 },
				    });

					jQuery.ias({
						triggerPageThreshold : 3,
						history              : false,
						container            : '.posts',
						item                 : '.post',
						pagination           : '.pagination',
						next                 : '.next-page a',
						loader               : '<div class="loader">',
						trigger              : '加载更多',
						onLoadItems          : function(items){
							//console.log('load');
							//jQuery(items).css({ opacity: 0 });
						},
						onRenderComplete     : function(items) {
							//console.log('render');
							imagesLoaded( grids, function() {
							  msnry.appended( items );
							  jQuery('.grid').css({ opacity: 1 });
							});
							
						}
				    });
				    
				});
			}else{
				jQuery.ias({
					triggerPageThreshold : 3,
					history              : false,
					container            : '.posts',
					item                 : '.post',
					pagination           : '.pagination',
					next                 : '.next-page a',
					loader               : '<div class="loader">',
					trigger              : '加载更多',
					onRenderComplete     : function(items) {
						if(that.lazy) that.lazyload();
					}
			    });
			}

		}
	},
	erphpBox: function(){
		var that = this;
		jQuery('.erphp-box').click(function(){
			jQuery('body').append('<div class="erphpdown-popover-mask" style="display: block;"></div><div class="erphpdown-popover" style="display: block;"><h3>资源购买</h3><div class="erphpdown-popover-item"><iframe src="'+jQuery(this).attr("href")+'" frameborder="0" width="400px" height="230px" /></div><span class="erphpdown-popover-close"><i class="dripicons dripicons-cross"></i></span></div>');
			jQuery('.erphpdown-popover-mask, .erphpdown-popover-close').click(function(){
				jQuery('.erphpdown-popover-mask, .erphpdown-popover').remove();
			});
			return false;
		});
	},
	share: function(){
		var that = this;
        if(jQuery('.article-content img:first').length ){
            _DGA.shareimage = jQuery('.article-content img:first').attr('src')
        }  
		var share = {
	        url: document.URL,
	        pic: _DGA.shareimage,
	        title: document.title || '',
	        desc: jQuery('meta[name="description"]').length ? jQuery('meta[name="description"]').attr('content') : ''    
	    }
	    jQuery('.share-weixin').each(function(){
		    if( !jQuery(this).find('.share-popover').length ){
				jQuery(this).append('<span class="share-popover"><span class="share-popover-inner" id="weixin-qrcode"></span></span>');
				jQuery('#weixin-qrcode').qrcode({
					width: 80,
					height: 80,
					text: jQuery(this).data('url')
				});
			}
		})
		jQuery('.article-shares a').on('click', function(){
			var dom = jQuery(this);
		    var to = dom.data('share');
		    var url = '';
		    switch(to){
		        case 'qq':
		            url = 'http://connect.qq.com/widget/shareqq/index.html?url='+share.url+'&desc='+share.desc+'&summary='+share.title+'&site=zeshlife&pics='+share.pic;
		            break;
		        case 'weibo':
		            url = 'http://service.weibo.com/share/share.php?title='+share.title+'&url='+share.url+'&source=bookmark&pic='+share.pic;
		            break;
		        case 'douban':
		            url = 'http://www.douban.com/share/service?image='+share.pic+'&href='+share.url+'&name='+share.title+'&text='+share.desc;
		            break;
		        case 'qzone':
		            url = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='+share.url+'&title='+share.title+'&desc='+share.desc;
		            break;
		        case 'tqq':
		            url = 'http://share.v.t.qq.com/index.php?c=share&a=index&url='+share.url+'&title='+share.title;
		            break;
		        case 'renren':
		            url = 'http://widget.renren.com/dialog/share?srcUrl='+share.pic+'&resourceUrl='+share.url+'&title='+share.title+'&description='+share.desc;
		            break;
		    }
		    if( !dom.attr('href') && !dom.attr('target') ){
		    	dom.attr('href', url).attr('target', '_blank');
		    }
		});
	},
	catFilter: function(){
		var that = this;
		jQuery('.cat-nav > li > a').on('click',function(){
			var next_url = jQuery(this).attr("href");
		    
	        jQuery('.cat-nav > li').removeClass('current-menu-item');
	        jQuery(this).parent().addClass('current-menu-item');
	        jQuery(".posts-loading").show();
	        jQuery("#posts, .pagination").hide();
	        jQuery(".pagination").html('');
	        jQuery(".pagination-trigger").remove();

		    jQuery.ajax({
		        type: 'get',
		        url: next_url + '#posts',
		        success: function(data){
		            posts = jQuery(data).find("#posts .post");
		            pagination = jQuery(data).find(".pagination ul");

		            next_link = jQuery(pagination).find(".next-page > a").attr("href");
		            if (next_link != undefined){
		                jQuery(".pagination").html(pagination.fadeIn(100));
		            }else{
		            	jQuery(".pagination").html('');
		            }
		            
	                if (next_url.indexOf("page") < 1) {
	                  jQuery("#posts").html('');
	                }
	                jQuery("#posts").append(posts.fadeIn(100));

	                if(that.lazy) that.lazyload();

	                if(that.ias){
		                that.iasLoad();
		            }else{
		            	jQuery(".pagination").show();
		            }
	                
                    jQuery(".posts-loading").hide();
                    jQuery("#posts").show();    
		            
		        }
		    });
		    return false;
		});
	},


	login: function(){
		var that = this;
		jQuery(function($){
			$('.signin-loader').on('click', function(){
				that.body.addClass('sign-show');
				$('#sign-in').show().find('input:first').focus();
				$('#sign-up').hide();
				return false;
			});
			$('.signin-loader.usersign-login').on('click', function(){
				that.body.addClass('sign-show');
				$('#sign-in').show().find('input:first').focus();
				$('#sign-up').hide();
				return false;
			});
			$('.signin-loader.usersign-register').on('click', function(){
				that.body.addClass('sign-show');
				$('#sign-up').show().find('input:first').focus();
				$('#sign-in').hide();
				return false;
			});
			$('.signup-loader-login').on('click', function(){
				that.body.addClass('sign-show');
				$('#sign-in').show().find('input:first').focus();
				$('#sign-up').hide();
			});
			$('.signup-loader-reg').on('click', function(){
				that.body.addClass('sign-show');
				$('#sign-up').show().find('input:first').focus();
				$('#sign-in').hide();
			});
			$('.signclose-loader').on('click', function(){
				that.body.removeClass('sign-show');
			});
			$('.sign-mask').on('click', function(){
				that.body.removeClass('sign-show');
			});
			
			$('.signinsubmit-loader').on('click', function(){
				if( $("#user_login").val() == '' ){
					logtips('用户名不能为空')
					return
				}
				if( $("#user_pass").val() == '' ){
					logtips('密码不能为空')
					return
				}
				logtips("登录中，请稍等...");
				$('.signinsubmit-loader').attr("disabled",true);
				$.post(
					_DGA.uri+'/action/login.php',
					{
						log: $("#user_login").val(),
						pwd: $("#user_pass").val(),
						action: "mobantu_login",
					},
					function (data) {
						if ($.trim(data) != "1") {
							logtips("用户名或密码错误");
							$('.signinsubmit-loader').attr("disabled",false);
						}
						else {
							logtips("登录成功，跳转中...");
							location.reload();                     
						}
					}
				);
			});

			$('.signupsubmit-loader').on('click', function(){
				if( !is_name($("#user_register").val()) ){
					logtips('用户名只能由字母数字或下划线组成的3-16位字符')
					return
				}
				if( !is_mail($("#user_email").val()) ){
					logtips('邮箱格式错误')
					return
				}
				if( !$("#user_pass2").val() ){
					logtips('请输入密码')
					return
				}
	            logtips("注册中，请稍等...");
	            $('.signupsubmit-loader').attr("disabled",true);
	            $.post(
	            	_DGA.uri+'/action/login.php',
	            	{
	            		user_register: $("#user_register").val(),
	            		user_email: $("#user_email").val(),
	            		password: $("#user_pass2").val(),
	            		captcha: $("#captcha").val(),
					    action: "mobantu_register"
					},
					function (data) {
						if ($.trim(data) == "1") {
							logtips("注册成功，登录中...");
							//$("#user_register").val("");
							//$("#user_email").val("");
							//$("#captcha").val("");
							//$('#sign-in').show().find('input:first').focus();
	            			//$('#sign-up').hide();
							location.reload(); 
						}else {
							logtips(data);
							$('.signupsubmit-loader').attr("disabled",false);
						}
					}
				);										   
	        });

	        $('.captcha-clk2').bind('click',function(){
				var captcha = _DGA.uri+'/action/captcha2.php?'+Math.random();
				$(this).attr('src',captcha);
			});

			

			$('.captcha-clk').bind('click',function(){

			/*var captcha = _DGA.uri+'/action/captcha.php?'+Math.random();

			$(this).attr('src',captcha);*/

			if( !is_mail($("#user_email").val()) ){

				logtips('邮箱格式错误')

				return

			}

			

			var captcha = $(this);

			if(captcha.hasClass("disabled")){

				logtips('您操作太快了，等等吧')

			}else{

				captcha.addClass("disabled");

				captcha.html("发送中...");

				$.post(

					_DGA.uri+'/action/captcha.php?'+Math.random(),

					{

						action: "mobantu_captcha",

						email:$("#user_email").val()

					},

					function (data) {

						if($.trim(data) == "1"){

							logtips('已发送验证码至邮箱，可能会出现在垃圾箱里哦~')

							var countdown=60; 

							settime()

							function settime() { 

								if (countdown == 0) { 

									captcha.removeClass("disabled");   

									captcha.html("重新发送验证码");

									countdown = 60; 

									return;

								} else { 

									captcha.addClass("disabled");

									captcha.html("重新发送(" + countdown + ")"); 

									countdown--; 

								} 

								setTimeout(function() { settime() },1000) 

							}

							

						}else if($.trim(data) == "2"){

							logtips('邮箱已存在')

							captcha.html("发送验证码至邮箱");

							captcha.removeClass("disabled"); 

						}else{

							logtips('验证码发送失败，请稍后重试')

							captcha.html("发送验证码至邮箱");

							captcha.removeClass("disabled"); 

						}

					}

					);

			}

		});



			var _loginTipstimer

			function logtips(str){

				if( !str ) return false

					_loginTipstimer && clearTimeout(_loginTipstimer)

				$('.sign-tips').html(str).animate({

					height: 29

				}, 220)

				_loginTipstimer = setTimeout(function(){

					$('.sign-tips').animate({

						height: 0

					}, 220)

				}, 5000)

			}
		});
	},
	comment: function(){
		var that = this;
		jQuery(function($){
			$('.commentlist .url').attr('target','_blank')

			$('.comment-user-change').on('click', function(){
				$('#comment-author-info').slideDown(300)
		    	$('#comment-author-info input:first').focus()
			})


		    var edit_mode = '0',
		        txt1 = '<div class="comt-tip comt-loading">评论提交中...</div>',
		        txt2 = '<div class="comt-tip comt-error">#</div>',
		        txt3 = '">',
		        cancel_edit = '取消编辑',
		        edit,
		        num = 1,
		        comm_array = [];
		    comm_array.push('');

		    $comments = $('#comments-title');
		    $cancel = $('#cancel-comment-reply-link');
		    cancel_text = $cancel.text();
		    $submit = $('#commentform #submit');
		    $submit.attr('disabled', false);
		    $('.comt-tips').append(txt1 + txt2);
		    $('.comt-loading').hide();
		    $('.comt-error').hide();
		    $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
		    $('#commentform').submit(function() {
		        $('.comt-loading').slideDown(300);
		        $submit.attr('disabled', true).fadeTo('slow', 0.5);
		        if (edit) $('#comment').after('<input type="text" name="edit_id" id="edit_id" value="' + edit + '" style="display:none;" />');
		        $.ajax({
		            url: _DGA.uri + '/action/comment.php',
		            data: $(this).serialize(),
		            type: $(this).attr('method'),
		            error: function(request) {
		                $('.comt-loading').slideUp(300);
		                $('.comt-error').slideDown(300).html(request.responseText);
		                setTimeout(function() {
		                        $submit.attr('disabled', false).fadeTo('slow', 1);
		                        $('.comt-error').slideUp(300)
		                    },
		                    3000)
		            },
		            success: function(data) {
		                $('.comt-loading').slideUp(300);
		                comm_array.push($('#comment').val());
		                $('textarea').each(function() {
		                    this.value = ''
		                });
		                var t = addComment,
		                    cancel = t.I('cancel-comment-reply-link'),
		                    temp = t.I('wp-temp-form-div'),
		                    respond = t.I(t.respondId),
		                    post = t.I('comment_post_ID').value,
		                    parent = t.I('comment_parent').value;
		                if (!edit && $comments.length) {
		                    n = parseInt($comments.text().match(/\d+/));
		                    $comments.text($comments.text().replace(n, n + 1))
		                }
		                new_htm = '" id="new_comm_' + num + '"></';
		                new_htm = (parent == '0') ? ('\n<ol style="clear:both;" class="commentlist commentnew' + new_htm + 'ol>') : ('\n<ul class="children' + new_htm + 'ul>');
		                ok_htm = '\n<span id="success_' + num + txt3;
		                ok_htm += '</span><span></span>\n';

		                if (parent == '0') {
		                    if ($('#postcomments .commentlist').length) {
		                        $('#postcomments .commentlist').before(new_htm);
		                    } else {
		                        $('#respond').after(new_htm);
		                    }
		                } else {
		                    $('#respond').after(new_htm);
		                }

		                $('#comment-author-info').slideUp()

		                // console.log( $('#new_comm_' + num) )
		                $('#new_comm_' + num).hide().append(data);
		                $('#new_comm_' + num + ' li').append(ok_htm);
		                $('#new_comm_' + num).fadeIn(1000);
		                /*$body.animate({
		                        scrollTop: $('#new_comm_' + num).offset().top - 200
		                    },
		                    500);*/
		                $('#new_comm_' + num).find('.comt-avatar .avatar').attr('src', $('.commentnew .avatar:last').attr('src'));
		                countdown();
		                num++;
		                edit = '';
		                $('*').remove('#edit_id');
		                cancel.style.display = 'none';
		                cancel.onclick = null;
		                t.I('comment_parent').value = '0';
		                if (temp && respond) {
		                    temp.parentNode.insertBefore(respond, temp);
		                    temp.parentNode.removeChild(temp)
		                }
		            }
		        });
		        return false
		    });
		    addComment = {
		        moveForm: function(commId, parentId, respondId, postId, num) {
		            var t = this,
		                div, comm = t.I(commId),
		                respond = t.I(respondId),
		                cancel = t.I('cancel-comment-reply-link'),
		                parent = t.I('comment_parent'),
		                post = t.I('comment_post_ID');
		            if (edit) exit_prev_edit();
		            num ? (t.I('comment').value = comm_array[num], edit = t.I('new_comm_' + num).innerHTML.match(/(comment-)(\d+)/)[2], $new_sucs = $('#success_' + num), $new_sucs.hide(), $new_comm = $('#new_comm_' + num), $new_comm.hide(), $cancel.text(cancel_edit)) : $cancel.text(cancel_text);
		            t.respondId = respondId;
		            postId = postId || false;
		            if (!t.I('wp-temp-form-div')) {
		                div = document.createElement('div');
		                div.id = 'wp-temp-form-div';
		                div.style.display = 'none';
		                respond.parentNode.insertBefore(div, respond)
		            }!comm ? (temp = t.I('wp-temp-form-div'), t.I('comment_parent').value = '0', temp.parentNode.insertBefore(respond, temp), temp.parentNode.removeChild(temp)) : comm.parentNode.insertBefore(respond, comm.nextSibling);
		            $body.animate({
		                    scrollTop: $('#respond').offset().top - 180
		                },
		                400);
		                // pcsheight()
		            if (post && postId) post.value = postId;
		            parent.value = parentId;
		            cancel.style.display = '';
		            cancel.onclick = function() {
		                if (edit) exit_prev_edit();
		                var t = addComment,
		                    temp = t.I('wp-temp-form-div'),
		                    respond = t.I(t.respondId);
		                t.I('comment_parent').value = '0';
		                if (temp && respond) {
		                    temp.parentNode.insertBefore(respond, temp);
		                    temp.parentNode.removeChild(temp)
		                }
		                this.style.display = 'none';
		                this.onclick = null;
		                return false
		            };
		            try {
		                t.I('comment').focus()
		            } catch (e) {}
		            return false
		        },
		        I: function(e) {
		            return document.getElementById(e)
		        }
		    };

		    function exit_prev_edit() {
		        $new_comm.show();
		        $new_sucs.show();
		        $('textarea').each(function() {
		            this.value = ''
		        });
		        edit = ''
		    }
		    var wait = 15,
		        submit_val = $submit.val();

		    function countdown() {
		        if (wait > 0) {
		            $submit.val(wait);
		            wait--;
		            setTimeout(countdown, 1000)
		        } else {
		            $submit.val(submit_val).attr('disabled', false).fadeTo('slow', 1);
		            wait = 15
		        }
		    }
		});
	},
	scrollTo: function(name='', add='', speed='') {
	    if (!speed) speed = 300
	    if (!name) {
	        jQuery('html,body').animate({
	            scrollTop: 0
	        }, speed)
	    } else {
	        if (jQuery(name).length > 0) {
	            jQuery('html,body').animate({
	                scrollTop: $(name).offset().top + (add || 0)
	            }, speed)
	        }
	    }
	}
}


function is_name(str) {    
	return /^[\w]{3,16}$/.test(str) 
}
function is_mail(str) {
	return /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/.test(str)
}
function is_url(str) {
    return /^((http|https)\:\/\/)([a-z0-9-]{1,}.)?[a-z0-9-]{2,}.([a-z0-9-]{1,}.)?[a-z0-9]{2,}$/.test(str)
}