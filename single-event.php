<?php
get_header(); ?>

<div class="flex-layer flex-layer--header">
    <div class="container">
        <div class="row">
            <div class="background background--short" data-position-calc></div>
            <div class="layered-fog" data-position-calc></div>
            <div class="col-12 text-center style-short">
                <?php
                $custom_logo_id = get_theme_mod('custom_logo');
                $logo = wp_get_attachment_image_src($custom_logo_id, 'large')[0];
                if(has_custom_logo()): ?>
                    <a class="theme-logo d-inline-block<?php echo $animation_class; ?>" href="<?php echo home_url(); ?>">
                        <img class="d-inline-block" src="<?php echo esc_url($logo); ?>">
                    </a>
                <?php
                endif; ?>
                <h1 class="mx-auto"><span class="d-block"><?php the_title(); ?></span><span class="d-block event-subtitle"><?php the_field('subtitle'); ?></span></h1>
                <p class="mt-3 mb-4 text-center mb-0">
                    <a class="btn btn-skeleton" href="<?php echo home_url(); ?>/events">&laquo; Back to Events</a>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="flex-layer flex-layer--wysiwyg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="text-center lead mb-4">
                    <?php
                    $event_date = strtotime(get_field('event_date'));
                    echo date_i18n( 'F j, Y', $event_date); ?>
                </p>
                <?php
                the_field('event_description'); ?>
                <p class="mt-4 mt-lg-5 text-center mb-0">
                    <a class="btn btn-skeleton" href="<?php echo home_url(); ?>/events">&laquo; Back to Events</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php
get_footer(); ?>