jQuery(function($){

	document.onkeydown = function() {
		if (event.keyCode == 13) {
			$(".submit").click();
		}
	}

	var _loginTipstimer
	function logtips(str){
		if( !str ) return false
		_loginTipstimer && clearTimeout(_loginTipstimer)
		$('.sign-tips').html(str).slideDown();
		_loginTipstimer = setTimeout(function(){
			$('.sign-tips').slideUp();
		}, 5000)
	}

	$('.login-loader').on('click', function(){
											
		if( !$("#username").val() ){
			logtips('用户名或邮箱不能为空')
			return
		}
		
		if( !$("#password").val() ){
			logtips('密码不能为空')
			return
		}
		
		var currbtn = $(this);				
		currbtn.val("登录中...");
		$.post(
			_DGA.uri+'/action/login.php',
			{
				log: $("#username").val(),
				pwd: $("#password").val(),
				action: "mobantu_login"
				
			},
			function (data) {
				if ($.trim(data) != "1") {
					logtips("用户名或密码错误");
					currbtn.val("登录");
				}
				else {
					location.reload();                     
				}
			}
		);
	})
	$("#regname").bind("blur",function(){
		var currInput = $(this);		
		$.post(
			_DGA.uri+'/action/check.php',
			{
				user_register: $("#regname").val(),
				action: "name"
			},
			function (data) {
				if ($.trim(data) == "1") {
					currInput.parent().next(".sign-tip").remove();
				}else {
					/*currInput.focus();*/
					if(currInput.parent().next(".sign-tip").length){
						currInput.parent().next(".sign-tip").text(data);
					}else{
						currInput.parent().after("<p class='sign-tip' style='display:block'>"+data+"</p>");
					}
				}
			}
		);	
	});
	$("#regemail").bind("blur",function(){
		var currInput = $(this);		
		$.post(
			_DGA.uri+'/action/check.php',
			{
				user_email: $("#regemail").val(),
				action: "email"
			},
			function (data) {
				if ($.trim(data) == "1") {
					currInput.parent().next(".sign-tip").remove();
				}else {
					/*currInput.focus();*/
					if(currInput.parent().next(".sign-tip").length){
						currInput.parent().next(".sign-tip").text(data);
					}else{
						currInput.parent().after("<p class='sign-tip' style='display:block'>"+data+"</p>");
					}
				}
			}
		);	
	});
	$('.register-loader').on('click', function(){
		if( !is_check_name($("#regname").val()) ){
			logtips('用户名只能由字母数字或下划线组成的6-16位字符')
			return
		}
		
		if( !is_check_mail($("#regemail").val()) ){
			logtips('邮箱格式错误')
			return
		}

		if( $("#regpass").val().length < 6 ){
			logtips('密码太短，至少6位')
			return
		}
		

		if( !$("#captcha").val() ){
			logtips('验证码不能为空')
			return
		}
		
		var currbtn = $(this);				
		currbtn.val("注册中...");
		$.post(
			_DGA.uri+'/action/login.php',
			{
				user_register: $("#regname").val(),
				user_email: $("#regemail").val(),
				password: $("#regpass").val(),
				captcha: $("#captcha").val(),
				action: "mobantu_register"
			},
			function (data) {
				if ($.trim(data) == "1") {
					location.reload(); 
				}
				else {
					logtips(data);
					currbtn.val("注册账号");
				}
			}
		);										   
	})
	$('.pass-loader').on('click', function(){
		if( !$("#passname").val() ){
			logtips('用户名或邮箱不能为空');
			return
		}

		var currbtn = $(this);				
		currbtn.val("处理中...");
		$.post(
			_DGA.uri+'/action/login.php',
			{
				passname: $("#passname").val(),
				action: "password"
			},
			function (data) {
				if ($.trim(data) == "1") {
					$("#passform").remove();
					$(".passPart h2").after("<div class=regSuccess>确认链接已经发送到您的邮箱，请查收并确认。</div>");
					/*setTimeout(function(){location.reload(); }, 2000);*/
				}
				else {
					logtips(data);
					currbtn.val("找回密码");
				}
			}
		);								   
	})
	$('.reset-loader').on('click', function(){
		if( $("#resetpass").val().length < 6 ){
			logtips('密码太短，至少6位')
			return
		}
		
		if( $("#resetpass").val() != $("#resetpass2").val()){
			logtips('两次输入密码不一致')
			return
		}
		var currbtn = $(this);				
		currbtn.val("修改中...");
		$.post(
			_DGA.uri+'/action/login.php',
			{
				resetpass: $("#resetpass").val(),
				key: $("#resetkey").val(),
				username: $("#user_login").val(),
				action: "reset"
			},
			function (data) {
				if ($.trim(data) == "1") {
					$("#resetform").remove();
					$(".resetPart h2").after("<div class=regSuccess>密码修改成功，请牢记密码哦。</div>");
					/*setTimeout(function(){location.reload(); }, 2000);*/
				}
				else {
					logtips(data);
					currbtn.val("修改密码");
				}
			}
		);								   
	});

	$('.captcha-clk').bind('click',function(){

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

					email:$("#regemail").val()

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

	$('.captcha-clk2').bind('click',function(){
		var captcha = _DGA.uri+'/action/captcha2.php?'+Math.random();
		$(this).attr('src',captcha);
	});

	
});


function is_check_name(str) {    
	return /^[\w]{3,16}$/.test(str) 
}
function is_check_mail(str) {
	return /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/.test(str)
}
function is_check_url(str) {
    return /^((http|https)\:\/\/)([a-z0-9-]{1,}.)?[a-z0-9-]{2,}.([a-z0-9-]{1,}.)?[a-z0-9]{2,}$/.test(str)
}