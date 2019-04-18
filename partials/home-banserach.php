<!-- Banner搜索框 -->
<div class="bansearch"<?php if(_DGA('banner_img')){?> style="background-image: url(<?php echo _DGA('banner_img');?>);" <?php }?>>
	<div class="container">
		<div class="ban-searchform">
	    	<form method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>" >
	        <input tabindex="2" class="form-control" name="s" type="text" placeholder="输入关键字" value="<?php echo htmlspecialchars($s) ?>">
	        <button tabindex="3" class="banserach-btn" type="submit">搜索</button>
	      	</form>
      	</div>
    </div>
</div>