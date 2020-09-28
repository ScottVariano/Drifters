<?php
get_header();

if(!is_home() || !is_archive()):
	include 'includes/flex-layers.php';
endif;

get_footer(); ?>