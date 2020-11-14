		<div class="footer text-center">
			<div class="footer__main col-12">
				<?php
				$custom_logo_id = get_theme_mod('custom_logo');
				$logo = wp_get_attachment_image_src($custom_logo_id, 'large')[0];
				if(has_custom_logo()): ?>
			       	<a class="theme-logo d-inline-block mx-auto" href="<?php echo home_url(); ?>">
			       		<img class="d-inline-block" src="<?php echo esc_url($logo); ?>">
			       	</a>
				<?php
				endif; ?>
				<p class="info mb-4 mb-lg-5 text-uppercase"><?php the_field('hours', 'option'); ?><br><a href="tel:<?php the_field('phone_1', 'option'); ?>"><?php the_field('phone_2', 'option'); ?></a><br><?php the_field('address', 'option'); ?></p>
				<p class="social mb-0">
					<?php if(get_field('facebook_link', 'option')): ?><a href="<?php the_field('facebook_link', 'option'); ?>" class="fab fa-facebook-f"></a><?php endif; ?><?php if(get_field('instagram_link', 'option')): ?><a href="<?php the_field('instagram_link', 'option'); ?>" class="fab fa-instagram"></a><?php endif; ?><?php if(get_field('email', 'option')): ?><a href="mailto:<?php the_field('email', 'option'); ?>" class="fas fa-envelope"></a><?php endif; ?>
				</p>
			</div>

			<!-- <p class="mb-0">&copy; <?php echo date("Y"); ?> Example Company</p> -->
			<div class="footer__bottom">
				<div class="footer__bottom__trees">
				</div>
				<div class="footer__bottom__info col-12 d-flex align-items-stretch justify-content-center">
					<!-- <p class="mb-0">WEBSITE BY THE VOYAGERS AT <a href="https://unionsquareadv.com" target="_blank">UNION SQUARE ADVERTISING</a></p> -->
					<!-- <p class="mb-0 mx-3"><span class="d-inline-block"></span></p> -->
					<div class="mb-0"><div class="d-inline-block mr-1">&copy;</div><?php echo date("Y"); ?> DRIFTERS KITCHEN & BAR&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/accessibility-statement">ACCESSIBILITY STATEMENT</a></div>
				</div>
			</div>
		</div>
	</div><!-- .main -->
	<?php wp_footer(); ?>
	</body>
</html>