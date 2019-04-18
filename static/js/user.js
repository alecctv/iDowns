jQuery(function($){



		var ajax_url = _DGA.uri+"/action/user.php";

		var _tipstimer

		function tips(str){

		    if( !str ) return false

		    _tipstimer && clearTimeout(_tipstimer)

		    $('.user-tips').html(str).animate({

		        top: 0

		    }, 220)

		    _tipstimer = setTimeout(function(){

		        $('.user-tips').animate({

		            top: -80

		        }, 220)

		    }, 5000)

		}





		/* click event

		 * ====================================================

		*/

		$(".prices label:last-child").addClass('active');

		$('.container-user').on('click', function(e){

		    e = e || window.event;

		    var target = e.target || e.srcElement

		    var _ta = $(target)



		    if( _ta.parent().attr('evt') ){

		        _ta = $(_ta.parent()[0])

		    }else if( _ta.parent().parent().attr('evt') ){

		        _ta = $(_ta.parent().parent()[0])

		    }



		    var type = _ta.attr('evt')



		    if( !type || _ta.hasClass('disabled') ) return 



		    switch( type ){

		    	case 'price.select':
		    		$(".prices label").removeClass('active');
		    		_ta.addClass('active');
		    	break;

		        case 'user.data.submit':

		            var form = _ta.parent().parent().parent()

		            var inputs = form.serializeObject()



		            var ispass = false

		            if( inputs.action === 'user.password' ) ispass = true



		            if( !inputs.action ){

		                return

		            }



		            if( ispass ){

		            	if( !$.trim(inputs.passwordold) ){
		                    tips('请输入原密码')
		                    return
		                }

		                if( !inputs.password || inputs.password.length < 6 ){

		                    tips('新密码不能为空且至少6位')

		                    return

		                }



		                if( inputs.password !== inputs.password2 ){

		                    tips('两次密码输入不一致')

		                    return

		                }


		            }else{



		                if( !/.{2,20}$/.test(inputs.nickname) ){

		                    tips('昵称限制在2-20字内')

		                    return

		                }





		                if( inputs.qq && !is_qq(inputs.qq) ){

		                    tips('QQ格式错误')

		                    return

		                }



		            }

					tips('修改中...')

		            $.ajax({  

		                type: 'POST',  

		                url:  ajax_url,  

		                data: inputs,  

		                dataType: 'json',

						/*data: {

							action: inputs.action,

							email: inputs.email,

							nickname: inputs.nickname,

							qq: inputs.qq,

							password: inputs.password

						},*/

		                success: function(data){  

		                    if( data.error ){

		                        if( data.msg ){

		                            tips(data.msg)

		                        }

		                        return

		                    }



		                    tips('修改成功！')



		                    cache_userdata = null

		                    $('.user-meta:eq(1) input:password').val('')

		                }  

		            });  



		            break;

					

					

					case 'user.email.submit':

					

						var form = _ta.parent().parent().parent()

						var inputs = form.serializeObject()

	

						if( !inputs.action ){

							return

						}

						

						if( !inputs.email ){

		                    tips('邮箱不能为空')

		                    return

		                }



		                if( !is_mail(inputs.email) ){

		                    tips('邮箱格式错误')

		                    return

		                }

						

						if( !inputs.captcha ){

		                    tips('请输入邮箱验证码')

		                    return

		                }

						

						tips('修改中...')

						$.ajax({  

							type: 'POST',  

							url:  ajax_url,  

							//data: inputs,  

							dataType: 'json',

							data: {

								action: inputs.action,

								captcha: inputs.captcha,

								email: inputs.email

							},

							success: function(data){  

								if( data.error ){

									if( data.msg ){

										tips(data.msg)

									}

									return

								}

	

								tips('邮箱修改成功！')

								location.reload();

							}  

						});

					

					break;

					

					case 'user.tixian.submit':

					

						var form = _ta.parent().parent().parent()

						var inputs = form.serializeObject()

	

						if( !inputs.action ){

							return

						}

						

						if( !inputs.ice_alipay ){

		                    tips('支付宝账号不能为空')

		                    return

		                }



		                if( !(inputs.ice_name) ){

		                    tips('支付宝姓名不能为空')

		                    return

		                }

						

						if( !inputs.ice_money ){

		                    tips('请输入提现金额')

		                    return

		                }

						

						tips('提现申请提交中...')

						$.ajax({  

							type: 'POST',  

							url:  ajax_url,  

							//data: inputs,  

							dataType: 'json',

							data: {
								action: inputs.action,
								ice_alipay: inputs.ice_alipay,
								ice_name: inputs.ice_name,
								ice_money: inputs.ice_money

							},

							success: function(data){  

								if( data.error ){

									if( data.msg ){

										tips(data.msg)

									}

									return

								}


								tips(data.msg)

								location.reload();

							}  

						});

					

					break;



					case 'user.email.captcha.submit':

						

						var form = _ta.parent().parent().parent()

						var inputs = form.serializeObject()

	

						if( !inputs.action ){

							return

						}

						

						if( !inputs.email ){

		                    tips('邮箱不能为空')

		                    return

		                }



		                if( !is_mail(inputs.email) ){

		                    tips('邮箱格式错误')

		                    return

		                }

						var captchabtn = $('#captcha_btn');

						

						if(captchabtn.hasClass("disabled")){

							tips('您操作太快了，等等吧')

						}else{

							tips('发送验证码中...')

							captchabtn.addClass("disabled");

							$.ajax({  

								type: 'POST',  

								url:  ajax_url,  

								//data: inputs,  

								dataType: 'json',

								data: {

									action: 'user.email.captcha',

									email: inputs.email

								},

								success: function(data){  

									if( data.error ){

										if( data.msg ){

											tips(data.msg)

											captchabtn.removeClass("disabled");   

										}

										return

									}

		

									tips('验证码已发送至新邮箱！')

									var countdown=60; 

									settime()

									function settime() { 

										if (countdown == 0) { 

											captchabtn.removeClass("disabled");   

											captchabtn.val("重新发送验证码");

											countdown = 60; 

											return;

										} else { 

											captchabtn.addClass("disabled");

											captchabtn.val("重新发送(" + countdown + ")"); 

											countdown--; 

										} 

										setTimeout(function() { settime() },1000) 

									}

								}  

							});

						}

						

					break;

					

					case 'user.charge.submit':

						var re = /^[1-9]+[0-9]*]*$/;

						if(document.getElementById("ice_money").value=="" || !re.test(document.getElementById("ice_money").value))

						{

							tips("请输入充值金额");

							return false;

						}else{

							document.getElementById("charge-form").submit();	

						}

					break;

					case 'user.charge.card':
						
						$('#modal-pay').modal('show')
					break;
						
					case 'user.charge.card.submit':
						if(document.getElementById("erphpcard_num").value=="" || document.getElementById("erphpcard_pass").value==""){
							tips("请输入充值卡号或卡密");
							return false;
						}else{
							tips('充值中...')
							$.ajax({  
								type: 'POST',  
								url:  ajax_url,  
								dataType: 'json',
								data: {
									action: 'user.charge.card',
									num: document.getElementById("erphpcard_num").value,
									pass: document.getElementById("erphpcard_pass").value
								},
								success: function(data){  
									if( data.error ){
										if( data.msg ){
											tips(data.msg)
										}
										return
									}
									tips('充值成功')
									location.reload();
								}  
							}); 
						}
					break;
					

					case 'user.vip.submit':

						$.ajax({  

							type: 'POST',  

							url:  ajax_url,  

							dataType: 'json',

							data: {

								action: 'user.vip',

								userType: $('input[name="userType"]:checked').val(),

							},

							success: function(data){  

								if( data.error ){

									if( data.msg ){

										tips(data.msg)

									}

									return

								}

								tips('升级成功')

								cache_vipdata = null

							}  

						});  

					break;

		    }

		})



});



function is_name(str) {    

    return /^[\w]{3,16}$/.test(str) 

}

function is_url(str) {

    return /^((http|https)\:\/\/)([a-z0-9-]{1,}.)?[a-z0-9-]{2,}.([a-z0-9-]{1,}.)?[a-z0-9]{2,}$/.test(str)

}

function is_qq(str) {

    return /^[1-9]\d{4,13}$/.test(str)

}

function is_mail(str) {

    return /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/.test(str)

}