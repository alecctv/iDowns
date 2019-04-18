<!-- 顶部BOX -->
<section id="team" class="team-area ptb-150">
	<div id="particles-js">
    <div class="header-top-title">
        <h3><?php echo _DGA('home_particles_tite') ?></h3>
        <div><?php echo _DGA('home_particles_desc') ?></div>
    </div>
    <canvas class="particles-js-canvas-el" width="1486" height="120" style="width: 100%; height: 100%;"></canvas>
</div>
<script src="<?php bloginfo('template_url');?>/static/js/particles.min.js"></script>
<script> particlesJS.load('particles-js', '<?php bloginfo('template_url');?>/static/js/particlesjs-config.json', function () { console.log(' callback - particles.js config loaded'); }) </script>
</section>