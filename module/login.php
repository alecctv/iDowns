<div class="sign">			
	<div class="sign-mask"></div>			
	<div class="container">			
		<div class="signmod-header">登入/注册</div>
		<div class="sign-tips"></div>
		<!-- 三方登录 -->
		<?php if (_DGA('oauth_qq') || _DGA('oauth_weibo') || _DGA('oauth_weixin')) { ?>
			<div class="sign-social">
				<!-- <h2>社交账号快速登录</h2>-->
				<?php if(_DGA('oauth_qq')){?><a class="login-qq" href="<?php echo home_url();?>/oauth/qq?rurl=<?php echo DGAThemes_selfURL();?>"><i class="fa">&#xe609;QQ登录</i></a><?php }?>
				<?php if(_DGA('oauth_weibo')){?><a class="login-weibo" href="<?php echo home_url();?>/oauth/weibo?rurl=<?php echo DGAThemes_selfURL();?>"><i class="fa">&#xe608;微博登录</i></a><?php }?>
				<?php if(_DGA('oauth_weixin')){?><a class="login-weixin" href="https://open.weixin.qq.com/connect/qrconnect?appid=<?php echo _DGA('oauth_weixinid');?>&redirect_uri=<?php echo home_url();?>/oauth/weixin/&response_type=code&scope=snsapi_login&state=MBT_weixin_login#wechat_redirect"><i class="fa">&#xe60e;微信登录</i></a><?php }?>			
			</div>	
		<?php } else { ?>
			<div class="sign-social"><?php echo _DGA('oauth_no_txt');?></div>
		<?php } ?>
		<form id="sign-in">  	
			<div class="form-item"><input type="text" name="user_login" class="form-control" id="user_login" placeholder="用户名"></div>			
			<div class="form-item"><input type="password" name="password" class="form-control" id="user_pass" placeholder="密码"></div>			
			<div class="sign-submit">			
				<input type="button" class="btn signinsubmit-loader" name="submit" value="登录">  			
				<input type="hidden" name="action" value="signin">			
			</div>			
			<div class="sign-trans">没有账号？ <a href="javascript:;" class="signup-loader-reg">注册</a><a href="<?php echo home_url("/wp-login.php?action=lostpassword"); ?>" style="float:right" rel="nofollow" target="_blank">忘记密码？</a></div>	
			<?php if(_DGA('oauth_qq') || _DGA('oauth_weibo') || _DGA('oauth_weixin')){?>			
			
			<?php }?>		
		</form>			

		<form id="sign-up" style="display: none;"> 					
			<div class="form-item"><input type="text" name="name" class="form-control" id="user_register" placeholder="用户名"></div>			
			<div class="form-item"><input type="email" name="email" class="form-control" id="user_email" placeholder="邮箱"></div>		
			<div class="form-item"><input type="password" name="password2" class="form-control" id="user_pass2" placeholder="密码"></div>	
			<div class="form-item">
				<?php if(_DGA('captcha') == 'email'){?>
				<input type="text" class="form-control" style="width:40%;display: inline-block;" id="captcha" name="captcha" placeholder="验证码"><span class="captcha-clk">获取邮箱验证码</span>
				<?php }else{?>
				<input type="text" class="form-control" style="width:40%;display: inline-block;" id="captcha" name="captcha" placeholder="验证码"><img src="<?php bloginfo("template_url");?>/static/img/captcha.png" class="captcha-clk2" style="height:40px;position: relative;top: -2px;cursor: pointer;"/>
				<?php }?>
			</div>			
			<div class="sign-submit">			
				<input type="button" class="btn signupsubmit-loader" name="submit" value="注册">  			
				<input type="hidden" name="action" value="signup">  				
			</div>			
			<div class="sign-trans">已有账号？ <a href="javascript:;" class="signup-loader-login">登录</a></div>		
			<?php if(_DGA('oauth_qq') || _DGA('oauth_weibo') || _DGA('oauth_weixin')){?>			
			
			<?php }?>	
		</form>			
	</div>			
</div>