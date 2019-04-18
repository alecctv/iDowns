<!-- 价格表 -->
<section id="pricing" class="pricing-area pt-130 pb-100">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="section-heading pb-55 text-center">
					<h2><?php echo _DGA('home_prictite'); ?></h2>
					<p><?php echo _DGA('home_pricdesc'); ?></p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 col-sm-6">
				<div class="pricing-single white-bg text-center mb-30">
					<div class="price-titel uppercase">
						<h4>包月VIP会员</h4>
					</div>
					<div class="pricing-price">
                      <span>
	                      <?php 
	                      if (get_option("ciphp_month_price")) {
	                      	echo get_option("ciphp_month_price"); 
	                      }else{
	                      	echo "0";
	                      } ?>
                  		</span>
					</div>
					<div class="price-decs">
						<ul><?php echo _DGA('home_pricing1'); ?></ul>
					</div>
					<div class="ordr-btn uppercase">
						<a href="<?php echo get_option("erphp_url_front_vip"); ?>">开通会员</a>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-6">
				<div class="pricing-single active white-bg text-center mb-30">
					<div class="price-titel uppercase">
						<h4>包年VIP会员</h4>
					</div>
					<div class="pricing-price">
                      	<span>
	                      <?php 
	                      if (get_option("ciphp_year_price")) {
	                      	echo get_option("ciphp_year_price"); 
	                      }else{
	                      	echo "0";
	                      } ?>
                  		</span>
					</div>
					<div class="price-decs">
						<ul><?php echo _DGA('home_pricing2'); ?></ul>
					</div>
					<div class="ordr-btn uppercase">
						<a href="<?php echo get_option("erphp_url_front_vip"); ?>">开通会员</a>
					</div>
				</div>
			</div>
			<div class="col-md-4 hidden-sm">
				<div class="pricing-single white-bg text-center mb-30">
					<div class="price-titel uppercase">
						<h4>终身VIP会员</h4>
					</div>
					<div class="pricing-price">
						<span>
	                      <?php 
	                      if (get_option("ciphp_life_price")) {
	                      	echo get_option("ciphp_life_price"); 
	                      }else{
	                      	echo "0";
	                      } ?>
                  		</span>
					</div>
					<div class="price-decs">
						<ul><?php echo _DGA('home_pricing3'); ?></ul>
					</div>
					<div class="ordr-btn uppercase">
						<a href="<?php echo get_option("erphp_url_front_vip"); ?>">开通会员</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>