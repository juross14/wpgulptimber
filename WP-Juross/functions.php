<?php
/**
 * WP Timber & Gulp
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

/**
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( 'Timber' ) ) {

	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'loadscripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'loadstyles' ) );
		parent::__construct();
	}

	/** This is where you can register custom post types. */
	public function register_post_types() {

	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {

	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$args = array(
			'depth' => 2,
		);
		$context['menu'] = new \Timber\Menu( 'main-menu',$args );
		$context['footer_widgets'] = Timber::get_widgets('footer_widgets');
		$context['site']  = $this;
		return $context;
	}

	public function loadstyles() {
		//Enqueue_Bootstrap_Fancy_slick_Styles
		wp_register_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
		wp_register_style( 'fancy', get_template_directory_uri() . '/assets/css/jquery.fancybox.min.css');
		wp_register_style( 'slick', get_template_directory_uri() . '/assets/css/slick.min.css');

		wp_enqueue_style( 'bootstrap' );
		wp_enqueue_style( 'fancy' );
		wp_enqueue_style( 'slick' );

		wp_enqueue_style( 'skeleton-base' );
		wp_enqueue_style( 'skeleton-style' );


		wp_register_style( 'customcss', get_template_directory_uri() . '/custom.css');
		wp_enqueue_style( 'customcss' );

		//Preprocess SCSS
		wp_register_style( 'prepro-css', get_template_directory_uri() . '/dist/style.css');
		wp_enqueue_style( 'prepro-css' );

	}

	public function loadscripts() {
		//Enqueue_Bootstrap_Fancy_slick_Scripts
		wp_register_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery-3.6.0.min.js');
		wp_enqueue_script( 'jquery' );
		wp_register_script( 'lazyjs', get_template_directory_uri() . '/assets/js/lazyload.min.js');
		wp_enqueue_script( 'lazyjs' );
		wp_register_script( 'bootstrapjs', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', '', '', true);
		wp_enqueue_script( 'bootstrapjs' );

		//Preprocess JS
		wp_register_script( 'prepro-js', get_template_directory_uri() . '/dist/script-min.js', '', '', true);
		wp_enqueue_script( 'prepro-js' );
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		//Apply do_shortcode() to widgets so that shortcodes will be executed in widgets
		add_filter( 'widget_text', 'do_shortcode' );

		//Widget support for a right sidebar
		register_sidebar( array(
			'name' => 'Right Sidebar',
			'id' => 'right-sidebar',
			'description' => 'Widgets in this area will be shown on the right-hand side.',
			'before_widget' => '<div id="%1$s">',
			'after_widget'  => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
		));

		//Widget support for the footer
		register_sidebar( array(
			'name' => 'Footer Widget',
			'id' => 'footer_widgets',
			'description' => 'Widgets in this area will be shown in the footer.',
			'before_widget' => '<div id="%1$s">',
			'after_widget'  => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
		));

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'custom-logo', array(
			'height'      => 100,
			'width'       => 400,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'site-title', 'site-description' ),
		));

		add_theme_support( 'menus' );





	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig\Extension\StringLoaderExtension() );
		$twig->addFilter( new Twig\TwigFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		return $twig;
	}

}

new StarterSite();


// bootstrap 5 wp_nav_menu walker
class bootstrap_5_wp_nav_menu_walker extends Walker_Nav_menu
{
  private $current_item;
  private $dropdown_menu_alignment_values = [
	'dropdown-menu-start',
	'dropdown-menu-end',
	'dropdown-menu-sm-start',
	'dropdown-menu-sm-end',
	'dropdown-menu-md-start',
	'dropdown-menu-md-end',
	'dropdown-menu-lg-start',
	'dropdown-menu-lg-end',
	'dropdown-menu-xl-start',
	'dropdown-menu-xl-end',
	'dropdown-menu-xxl-start',
	'dropdown-menu-xxl-end'
  ];

  function start_lvl(&$output, $depth = 0, $args = null)
  {
	$dropdown_menu_class[] = '';
	foreach($this->current_item->classes as $class) {
	  if(in_array($class, $this->dropdown_menu_alignment_values)) {
		$dropdown_menu_class[] = $class;
	  }
	}
	$indent = str_repeat("\t", $depth);
	$submenu = ($depth > 0) ? ' sub-menu' : '';
	$output .= "\n$indent<ul class=\"dropdown-menu$submenu " . esc_attr(implode(" ",$dropdown_menu_class)) . " depth_$depth\">\n";
  }

  function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
	$this->current_item = $item;

	$indent = ($depth) ? str_repeat("\t", $depth) : '';

	$li_attributes = '';
	$class_names = $value = '';

	$classes = empty($item->classes) ? array() : (array) $item->classes;

	$classes[] = ($args->walker->has_children) ? 'dropdown' : '';
	$classes[] = 'nav-item';
	$classes[] = 'nav-item-' . $item->ID;
	if ($depth && $args->walker->has_children) {
	  $classes[] = 'dropdown-menu dropdown-menu-end';
	}

	$class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
	$class_names = ' class="' . esc_attr($class_names) . '"';

	$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
	$id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

	$output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';

	$attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
	$attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
	$attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
	$attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

	$active_class = ($item->current || $item->current_item_ancestor || in_array("current_page_parent", $item->classes, true) || in_array("current-post-ancestor", $item->classes, true)) ? 'active' : '';
	$nav_link_class = ( $depth > 0 ) ? 'dropdown-item ' : 'nav-link ';
	$attributes .= ( $args->walker->has_children ) ? ' class="'. $nav_link_class . $active_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="'. $nav_link_class . $active_class . '"';

	$item_output = $args->before;
	$item_output .= '<a' . $attributes . '>';
	$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
	$item_output .= '</a>';
	$item_output .= $args->after;

	$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }
}
// register a new menu
register_nav_menu('main-menu', 'Main menu');