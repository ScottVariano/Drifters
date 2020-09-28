<?php

// This generates markup to begin the flex layer
function layer_start(){

    $before = 'none';
    $after = 'none';

    $row_index = get_row_index() - 1;
    $row_prev = $row_index - 1;
    $row_next = $row_index + 1;

    if($prev = get_field('flex_layers')[$row_prev]):
        $prev_layer = $prev['acf_fc_layout'];
        $before = str_replace('_', '-', $prev_layer);
    endif;
    if($next = get_field('flex_layers')[$row_next]):
        $next_layer = $next['acf_fc_layout'];
        $after = str_replace('_', '-', $next_layer);
    endif;

    $layer = get_row()['acf_fc_layout'];
    $layer_name = str_replace('_', '-', $layer);
    $html = '<div class="flex-layer flex-layer--' . $layer_name . ' flex-layer--' . $layer_name . '--prev--' . $before . ' flex-layer--' . $layer_name . '--next--' . $after . '">';
    $html .= '<div class="container">';
    $html .= '<div class="row">';

    echo $html;
}
// This generates markup to end the flex layer
function layer_end(){
    $html = '</div>';
    $html .= '</div>';
    $html .= '</div>';
    echo $html;
}

if(have_rows('flex_layers')): while(have_rows('flex_layers')): the_row();

    if(get_row_layout() == 'header'):

        layer_start();

        $style = get_sub_field('style');
        $animation_class = '';
        if($style == 'tall'):
            $animation_class = ' wow fadeInUp';
        endif; ?>

            <div class="background background--<?php echo $style; ?>" data-position-calc></div>
            <div class="layered-fog" data-position-calc></div>

            <div class="col-12 text-center style-<?php echo $style; ?>">
                <?php
                $custom_logo_id = get_theme_mod('custom_logo');
                $logo = wp_get_attachment_image_src($custom_logo_id, 'large')[0];
                if(has_custom_logo()): ?>
                    <a class="theme-logo d-inline-block<?php echo $animation_class; ?>" href="<?php echo home_url(); ?>">
                        <img class="d-inline-block" src="<?php echo esc_url($logo); ?>">
                    </a>
                <?php
                endif; ?>
                <h1 class="mx-auto"><?php if($style == 'tall'): ?><span class="d-block wow fadeInUp" data-wow-delay=".25s"><?php the_sub_field('title_top'); ?></span><?php endif; ?><span<?php if($style == 'tall'): ?> class="wow fadeInUp" data-wow-delay=".5s"<?php endif; ?>><?php the_sub_field('title_main'); ?></span></h1>
                <?php
                if($style == 'tall'): ?>
                    <p class="mb-0 wow fadeInUp" data-wow-delay=".75s"><?php acf_get_link('link', 'btn'); ?></p>
                <?php
                endif ?>
            </div>
        <?php
        layer_end();

    elseif(get_row_layout() == 'compass_with_content'):

        layer_start(); ?>

            <div class="treeline"></div>

            <div class="col-12 col-lg-5 align-self-stretch compass p-0">
                <div class="compass__inner" data-position-calc></div>
            </div>
            <div class="col-12 col-lg-7 content text-center text-lg-left align-self-center wow fadeInRight" data-wow-delay=".5s">
                <h2><?php the_sub_field('title'); ?></h2>
                <p class="mb-4"><?php the_sub_field('content'); ?></p>
                <p class="mb-0"><?php acf_get_link('link', 'btn btn-skeleton'); ?></p>
            </div>

        <?php
        layer_end();

    elseif(get_row_layout() == 'photo_with_content'):

        layer_start(); ?>

            <div class="col-12 col-lg-6 align-self-stretch px-lg-3 wow fadeInLeft" data-wow-delay=".25s">
                <div class="photo">
                    <div class="photo__inner" data-position-calc>
                        <div class="background" data-position-calc style="background-image: url(<?php echo get_sub_field('photo')['sizes']['large']; ?>);"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 content align-self-start wow fadeInRight" data-wow-delay=".5s">
                <div class="brown-wrap">
                    <h2><?php the_sub_field('title'); ?></h2>
                    <div class="stylized-line"></div>
                    <p class="mb-4 mb-lg-5"><?php the_sub_field('content'); ?></p>
                    <p class="mb-0"><?php acf_get_link('link', 'btn btn-white'); ?></p>
                    <div class="stamp d-none d-lg-block" data-position-calc></div>
                </div>
            </div>

        <?php
        layer_end();

    elseif(get_row_layout() == 'events_preview'):

        layer_start(); ?>

            <div class="map"></div>

            <div class="col-12 text-center">
                <?php
                if($title = get_sub_field('title')): ?>
                    <h2 class="single-line wow fadeInUp" data-wow-delay=".25s"><?php echo $title; ?></h2>
                <?php
                endif; ?>
                <?php
                if($content = get_sub_field('content')): ?>
                    <p class="content mx-auto mb-5 wow fadeInUp" data-wow-delay=".5s"><?php echo $content; ?></p>
                <?php
                endif; ?>
            </div>
            <div class="col-12 text-center event-layers">

                <div class="dot-separator"></div>

                <?php
                $today = date('Ymd', current_time('timestamp', 0));
                $args = array(
                    'post_type' => 'event',
                    'posts_per_page' => get_sub_field('initial_events'),
                    'meta_key' => 'event_date',
                    'orderby' => 'meta_value',
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                            'key' => 'event_date',
                            'value' => $today,
                            'compare' => '>='
                        )
                    )
                );
                $events_query = new WP_Query($args);
                if($events_query->have_posts()):
                while($events_query->have_posts()): $events_query->the_post(); ?>

                    <div class="row event-row">
                        <div class="col-12 col-lg-5 mb-4 mb-lg-0 p-relative">
                            <div class="row event-card wow fadeInUp" data-wow-delay=".5s">
                                <div class="col-4 d-none d-sm-flex logo align-items-center">
                                    <?php
                                    $custom_logo_id = get_theme_mod('custom_logo');
                                    $logo = wp_get_attachment_image_src($custom_logo_id, 'large')[0];
                                    if(has_custom_logo()): ?>
                                        <a class="theme-logo d-inline-block" href="<?php echo home_url(); ?>">
                                            <img class="d-inline-block" src="<?php echo esc_url($logo); ?>">
                                        </a>
                                    <?php
                                    endif; ?>
                                </div>
                                <div class="col-12 col-sm-8 info-wrap d-flex align-items-center">
                                    <div class="info mx-auto">
                                        <p class="info__intro d-inline-block mx-auto">Drifters Kitchen &amp; Bar<span class="d-block">Presents</span></p>
                                        <h3><?php the_title(); ?></h3>
                                        <div class="stylized-line"></div>
                                        <p class="info__date mb-0"><?php echo date('F j, Y', strtotime(get_field('event_date'))); ?></p>
                                    </div>
                                </div>
                                <div class="event-hover p-4 d-flex align-items-center justify-content-center">
                                    <div>
                                        <h2 class="single-line"><?php the_field('subtitle'); ?></h2>
                                        <p class="info__date mb-0"><?php echo date('F j, Y', strtotime(get_field('event_date'))); ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="event-hover p-4 d-flex align-items-center justify-content-center">
                                <div>
                                    <h2 class="single-line"><?php the_field('subtitle'); ?></h2>
                                    <p class="info__date mb-0"><?php echo date('F j, Y', strtotime(get_field('event_date'))); ?></p>
                                </div>
                            </div> -->
                        </div>
                    </div>

                <?php
                endwhile;
                endif;
                wp_reset_postdata(); ?>
            </div>
            <div class="col-12 mt-4 text-center">
                <p class="mb-0 wow fadeInUp" data-wow-delay=".25s">
                    <?php
                    $should = get_sub_field('button_should');
                    if($should == 'link'): ?>
                        <a href="<?php echo get_sub_field('link')['url']; ?>" class="btn btn-skeleton">See All Events</a>
                    <?php
                    elseif($should == 'load'): ?>
                        <a href="#" data-events-load data-events-count="<?php the_sub_field('initial_events'); ?>" class="btn btn-skeleton">See More Events</a>
                    <?php
                    endif; ?>
                </p>
            </div>

        <?php
        layer_end();

    elseif(get_row_layout() == 'centerpiece'):

        layer_start(); ?>

            <div class="background" style="background-image: url(<?php echo get_sub_field('background')['sizes']['large']; ?>);" data-position-calc></div>

            <div class="col-12 text-center mx-auto">
                <div class="brown-wrap mx-auto wow fadeInUp" data-wow-delay=".25s">
                    <div class="stamp" data-position-calc></div>
                    <h2><?php the_sub_field('title'); ?></h2>
                    <div class="stylized-line"></div>
                    <p class="mb-4"><?php the_sub_field('content'); ?></p>
                    <?php
                    if(get_sub_field('link')): ?>
                        <p class="mb-0"><?php acf_get_link('link', 'btn btn-white'); ?></p>
                    <?php
                    endif;
                    if(get_sub_field('include_form')):
                        echo do_shortcode('[contact-form-7 id="' . get_sub_field('form') . '"]');
                    endif; ?>
                </div>
            </div>

        <?php
        layer_end();

    elseif(get_row_layout() == 'form'):

        layer_start(); ?>

            <div class="col-12 text-center">
                <p class="intro mx-auto"><?php the_sub_field('intro'); ?></p>
            </div>
            <?php
            echo do_shortcode('[contact-form-7 id="' . get_sub_field('form') . '"]'); ?>

        <?php
        layer_end();

    elseif(get_row_layout() == 'contact_info_with_form'):

        layer_start(); ?>

            <div class="contact-info col-12 col-lg-6 text-center">
                <div class="brown-wrap">
                    <h2><?php the_sub_field('contact_info_title'); ?></h2>
                    <h3>Hours</h3>
                    <p class="hours mb-4">THURSDAY THROUGH SUNDAY<br>3PM TILL' 11PM</p>
                    <div class="stylized-line"></div>
                    <p class="mt-3 mb-2">1600 MIDDLE COUNTRY ROAD<br>RIDGE, NEW YORK 11961</p>
                    <p class="mb-2"><a href="tel:1-631-775-8888">1-631-775-8888</a></p>
                    <p class="mb-0"><a href="mailto:INFO@DRIFTERSKITCHENANDBAR.COM">INFO@DRIFTERSKITCHENANDBAR.COM</a></p>
                </div>
            </div>
            <div class="form col-12 col-lg-6 text-center">
                <h2><?php the_sub_field('form_title'); ?></h2>
                <div class="stylized-line stylized-line--brown"></div>
                <?php
                echo do_shortcode('[contact-form-7 id="' . get_sub_field('form') . '"]'); ?>
            </div>

        <?php
        layer_end();

    elseif(get_row_layout() == 'map'):

        layer_start(); ?>

            <div class="col-12 text-center">
                <div class="map-and-location d-flex flex-row-reverse">
                    <div class="location">
                        <div class="location__inner" style="background-image: url(<?php echo get_sub_field('location_image')['sizes']['large']; ?>);" data-position-calc></div>
                    </div>
                    <a class="map" href="<?php the_sub_field('google_maps_link'); ?>" target="_blank" style="background-image: url(<?php echo get_sub_field('map_image')['sizes']['large']; ?>);">
                        <div class="map__inner">
                            <div class="map-marker mx-auto"></div>
                            <div class="btn">Get Directions</div>
                        </div>
                    </a>
                </div>
            </div>

        <?php
        layer_end();

    elseif(get_row_layout() == 'gallery'):

        layer_start(); ?>

            <div class="col-12 text-center">
                <?php
                echo do_shortcode('[foogallery id="' . get_sub_field('gallery') . '"]'); ?>
            </div>

        <?php
        layer_end();

    elseif(get_row_layout() == 'menu'):

        layer_start();

        $style = get_sub_field('menu_style'); ?>

            <div class="col-12 full-wrap full-wrap--<?php echo $style; ?> d-flex text-center">

                <div class="menu-wrap menu-wrap--<?php echo $style; ?>">

                    <?php
                    if($style == '1' || $style == '5'): ?>
                    <div class="brown-wrap">
                    <?php
                    endif; ?>

                    <?php
                    if($style == '2'): ?>
                    <div class="dotted-wrap mx-auto">
                    <div class="dot-border dot-border--1"></div>
                    <div class="dot-border dot-border--2"></div>
                    <div class="dot-border dot-border--3"></div>
                    <div class="dot-border dot-border--4"></div>
                    <?php
                    endif; ?>

                    <?php
                    if($style == '3'): ?>
                    <div class="white-wrap">
                    <?php
                    endif; ?>

                    <?php
                    if($style == '4'): ?>
                    <div class="non-dotted-wrap mx-auto">
                    <?php
                    endif; ?>
                    <?php
                    if($title = get_sub_field('title')): ?>
                        <h2><?php echo $title; ?></h2>
                    <?php
                    endif; ?>
                    <?php
                    if($description = get_sub_field('description')): ?>
                        <p class="description"><?php echo $description; ?></p>
                    <?php
                    endif; ?>
                    <?php
                    if(get_sub_field('title')): ?>
                        <?php
                        if($style == '1' || $style == '5'): ?>
                        <div class="stylized-line stylized-line--parchment"></div>
                        <?php
                        endif; ?>
                        <?php
                        if($style == '3'): ?>
                        <div class="stylized-line stylized-line--brown"></div>
                        <?php
                        endif; ?>
                    <?php
                    endif; ?>

                    <?php
                    if(have_rows('menu_items')): ?>
                        <div class="menu-items menu-items--<?php echo $style; ?> d-flex flex-wrap">
                        <?php
                        while(have_rows('menu_items')): the_row(); ?>
                            <div class="menu_items__single">
                                <h3><?php the_sub_field('title'); ?></h3>
                                <?php
                                if($description = get_sub_field('description')): ?>
                                <p class="mb-0"><?php echo $description; ?>&nbsp;&nbsp;<?php the_sub_field('price'); ?></p>
                                <?php
                                endif; ?>
                                <?php
                                if($subtitle = get_sub_field('additional_info')): ?>
                                    <p class="add-info mt-1 mb-0"><em><?php echo $subtitle; ?></em></p>
                                <?php
                                endif; ?>
                            </div>
                        <?php
                        endwhile; ?>
                        </div>
                    <?php
                    endif; ?>

                    <?php
                    if($style == '1' || $style == '2' || $style == '3' || $style == '4' || $style == '5'): ?>
                    </div>
                    <?php
                    endif; ?>

                </div>

                <div class="photo photo--<?php echo $style; ?>">
                    <div class="photo__inner" style="background-image: url(<?php echo get_sub_field('photo')['sizes']['large']; ?>);" data-position-calc></div>
                </div>

            </div>

        <?php
        layer_end();

    endif;

endwhile; endif;




