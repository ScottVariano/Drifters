<?php
// Enqueue CSS and JavaScript
function load_theme_scripts(){
  wp_enqueue_style('theme_css', get_template_directory_uri() . '/style.css');
  wp_register_script('theme_js', get_template_directory_uri() . '/theme.js', array('jquery'), true);
  wp_enqueue_script('theme_js');
}
add_action('wp_enqueue_scripts', 'load_theme_scripts');

// Load Theme Fonts
function load_theme_fonts(){
	wp_register_style('google-fonts-roboto', '//fonts.googleapis.com/css?family=Roboto');
	wp_enqueue_style('google-fonts-roboto');
  wp_register_style('font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css');
  wp_enqueue_style('font-awesome');
}
add_action('wp_print_styles', 'load_theme_fonts');

// Register Theme Menus
function register_theme_menus() {
  register_nav_menu('main-menu','Main Menu');
  register_nav_menu('mobile-menu','Mobile Menu');
}
add_action('init', 'register_theme_menus');

// Add Logo Support
function theme_logo_setup(){
	add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'theme_logo_setup');

// Add scripts to wp_head()
function add_site_url_head_script(){ ?>
  <script>
    var siteUrl = '<?php echo get_home_url(); ?>';
  </script>
<?php }
add_action('wp_head', 'add_site_url_head_script');

// Hide Admin Bar
// Ideally we should be creating themes that accomodate the
// admin bar, but you can hide it if it's still early in development.
add_filter('show_admin_bar', '__return_false');

// Create Custom Post Types
function create_theme_post_types(){
    register_post_type('event',
        array(
            'labels' => array(
                'name' => __('Events'),
                'singular_name' => __('Event')
            ),
            'public' => true,
            'has_archive' => true,
            // 'rewrite' => array('slug' => 'success-story')
        )
    );
}
add_action('init', 'create_theme_post_types');

// Create Custom Taxonomies
function create_custom_taxonomy(){
  register_taxonomy(  
      'example-category',
      'example-post-type',
      array(  
          'hierarchical' => true,  
          'labels' => array(
            'name' => _x('Example Taxonomies', 'taxonomy general name', 'textdomain'),
            'singular_name' => _x('Example Taxonomy', 'taxonomy singular name', 'textdomain'),
          ),
          'show_in_rest' => true,
          // 'rewrite' => array('slug' => 'example-taxonomy'),
      )  
  );
}  
add_action('init', 'create_custom_taxonomy');

// Change Custom Post Type Title Input Text
// This makes things clearer when "Add Title"
// doesn't apply to a custom post type.
function theme_post_type_title_input($title){
  $screen = get_current_screen();
  if('example-post-type' == $screen->post_type){
      $title = 'Add Example Post Type Title';
  }
  return $title;
}
add_filter('enter_title_here', 'theme_post_type_title_input');

// Add Class to Menu Links
// Make sure that an ACF field named "link_class" is attached
// to menu items. This allows you to add a class directly to
// the link instead of the list item. Delete if not needed.
function add_menu_link_class($atts, $item, $args){
  if(function_exists('get_field')){
    $link_class = get_field('link_class', $item);
    if($link_class){
      $atts['class'] = $link_class;
    }
    $anchor = get_field('anchor', $item);
    if($anchor){
      $atts['href'] = add_query_arg( 'anchor', $anchor, $atts['href']);
    }
  }
  return $atts;
}
add_filter('nav_menu_link_attributes', 'add_menu_link_class', 1, 3);

// Add Options Page
// Add any sitewide option fields to this page via ACF
if(function_exists('acf_add_options_page')){
  acf_add_options_page();
}

// ACF Link Markup
// Allows you to quickly generate a link from an ACF sub-field
// with the name "link" and add specific classes to it.
function acf_get_link($field_name, $classes){
  if(function_exists('get_sub_field')){
    $link = get_sub_field($field_name);
    if($link){
      $link_url = $link['url'];
      $link_title = $link['title'];
      $link_target = $link['target'] ? $link['target'] : '_self';
    ?>
    <a class="<?php echo $classes; ?>" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
    <?php }
  }
}

// Add Site URL as a JS Variable
// This is useful for things like REST API requests in theme.js
// that need to access a URL with the site's domain. You can use
// the variable rather than manually changing 'localhost' to the
// staging or live URL.
wp_localize_script('mylib', 'WPURLS', array(
  'siteurl' => get_option('siteurl')
));

// Add Custom Image Sizes
add_image_size('large-square', 1500, 1500, true);
add_image_size('medium-square', 750, 750, true);

// Register a REST route
add_action('rest_api_init', function(){
  register_rest_route( 'drifters/v1', '/events/', array(
    'methods' => 'GET',
    'callback' => 'events_query',
  ));
});
// Do the actual query and return the data
function events_query(){

  $offset = 1;
  if(isset($_GET['offset'])):
    $offset = $_GET['offset'];
  endif;

  $today = date('Ymd', current_time('timestamp', 0));
  $args = array(
    'offset' => $offset,
    'post_type' => 'event',
    'posts_per_page' => 3,
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

  $total = 0;
  // Run a custom query
  $events_query = new WP_Query($args);
  if($events_query->have_posts()):

    $total = $events_query->found_posts;
    $data = array();
    $count = 0;

    while($events_query->have_posts()): $events_query->the_post();
      $data[$count]['title'] =  get_the_title();
      $data[$count]['subtitle'] =  get_field('subtitle');
      $data[$count]['date'] =  date('F j, Y', strtotime(get_field('event_date')));
      $count++;
    endwhile;

    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = wp_get_attachment_image_src($custom_logo_id, 'large')[0];
    $logo_url = '';
    if(has_custom_logo()):
      $logo_url = esc_url($logo);
    endif;

    return array(
      'logo_url' => $logo_url,
      'total' => $total,
      'documents' => $data
    );
  else:
    $empty = array();
    return array(
      'total' => $total,
      'documents' => array()
    );
  endif;

}