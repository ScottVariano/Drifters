<?php
get_header(); ?>

<div class="page-404 flex-layer flex-layer--header">
	<div class="container">
		<div class="row">
			<div class="col-12 text-center style-short">
            	<?php
                $custom_logo_id = get_theme_mod('custom_logo');
                $logo = wp_get_attachment_image_src($custom_logo_id, 'large')[0];
                if(has_custom_logo()): ?>
                    <a class="theme-logo d-inline-block" href="<?php echo home_url(); ?>">
                        <img class="d-inline-block" src="<?php echo esc_url($logo); ?>">
                    </a>
                <?php
                endif; ?>
                <h1 class="mx-auto"><span class="title-404 d-block">404</span><span class="subtitle-404 d-block">Page Not Found</span></h1>
                <p class="text-center mb-0">
                	<a class="btn" href="<?php echo home_url(); ?>">Go Home</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php
get_footer(); ?>