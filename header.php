<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

	<meta charset="UTF-8">
	<!-- <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title> -->
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<script>
		// var siteUrl = '<?php echo get_home_url(); ?>';
	</script>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<!-- <div class="fixed-nav"> -->

		<!-- <div class="menu-toggle-backdrop"></div> -->
		<div class="menu-toggle-backdrop"></div>
		<div class="menu-toggle"></div>

	  	<?php
		$custom_logo_id = get_theme_mod('custom_logo');
		$logo = wp_get_attachment_image_src($custom_logo_id, 'large')[0];
		if(has_custom_logo()): ?>
	       	<!-- <a class="theme-logo" href="<?php echo home_url(); ?>">
	       		<img src="<?php echo esc_url($logo); ?>">
	       	</a> -->
		<?php
		endif; ?>
		<div class="fixed-nav">
			<div class="menu-toggle menu-toggle--nav"></div>
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="nav-flex d-flex justify-content-around">
							<div class="light-logo-wrap">
								<?php
								if($light_logo = get_field('light_logo', 'option')): ?>
									<a class="theme-logo theme-logo--light d-inline-block" href="<?php echo home_url(); ?>">
							       		<img class="d-block" src="<?php echo $light_logo['sizes']['large']; ?>">
							       	</a>
								<?php
								endif; ?>
							</div>
							<div class="nav-wrap">
							<?php
							$args = array(
								'menu'        => 'main-menu',
								'container'   => false,
								'menu_class'  => 'main-menu list-unstyled d-flex align-items-stretch flex-wrap mb-0'
							);
							wp_nav_menu($args); ?>
							</div>
							<div class="light-logo-wrap">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!-- </div> -->
	<!-- <div class="mobile-nav"> -->
		<?php
		// $mobile_args = array(
		//   'menu'        => 'mobile-menu',
		//   'container'   => false,
		//   'menu_class'  => 'mobile-menu list-unstyled text-center d-flex align-items-stretch mb-0'
		// );
		// wp_nav_menu($mobile_args); ?>
	<!-- </div> -->
	<div class="main">