<?php
/**
 * Theme functions and definitions
 * 
 * @package WordPress
 */

 // Exit if accessed directly.
if (!defined("ABSPATH")) {
	exit;
}

// Core constants 
define("THEME_DIR", get_stylesheet_directory());
define("THEME_URI", get_stylesheet_directory_uri());

/**
 * Theme class
 */
final class Theme_Functions
{

    /**
	 * Add hooks and load theme functions 
	 * 
	 * @since 1.0
	 */
	public function __construct()
	{
		// Define theme constants
		$this->theme_constants();
		
		// Import theme files
		$this->theme_imports();
        
        // Enqueue theme scripts
        add_action("wp_enqueue_scripts", array($this, "bootstrap_css"));
        add_action("wp_enqueue_scripts", array($this, "theme_css"), 99);
        add_action("wp_enqueue_scripts", array($this, "theme_js"), 99);

		// Enqueue theme fonts
		add_action("wp_enqueue_scripts", array($this, "theme_fonts"));
		add_action("admin_enqueue_scripts", array($this, "theme_fonts"));
		
        // Add action to make custom query before loading posts
        add_action("pre_get_posts", array($this, "set_query_params"));
        
		// Add action to define custom excerpt
        add_filter("excerpt_length", array($this, "custom_excerpt_len"), 999);
		add_filter('excerpt_more', array($this, 'new_excerpt_more'));
	}

	/**
	 * Define theme constants
	 *
	 * @since 1.0
	 */
	public static function theme_constants()
	{
		$version = self::get_theme_version();

		define("THEME_VERSION", $version);

		// JS and CSS files URIs
		define("THEME_JS_URI", THEME_URI . "/assets/public/js/");
		define("THEME_CSS_URI", THEME_URI . "/assets/public/css/");
		
		// Images URI
		define("THEME_IMG_URI", THEME_URI . "/assets/img/");
		
		// Fonts URI
		define("THEME_FONT_URI", THEME_URI . "/assets/fonts/");
		
		// Includes URI
		define("THEME_INC_DIR", THEME_DIR . "/inc/");
		define("THEME_INC_URI", THEME_URI . "/inc/");
	}

	/**
	 * Include theme classes and files
	 *
	 * @since 1.0
	 */
	public static function theme_imports()
	{
		// Directory of files to be included
		$dir = THEME_INC_DIR;

		// require_once($dir . 'walker/bs_menu_walker.php');
		
		require_once($dir . 'customizer/customizer.php');
		require_once($dir . 'kirki/kirki-installer-section.php');

		require_once($dir . 'shortcodes/shortcodes.php');
		
		// require_once($dir . 'helpers/helpers.php');
	}

	/**
	 * Enqueue theme CSS
	 *
	 * @since 1.0
	 */
	public static function bootstrap_css() 
	{
		$dir = THEME_CSS_URI;
		
		$version = THEME_VERSION;
		
		wp_deregister_style( "bootstrap" );
		wp_enqueue_style('bootstrap', $dir . 'bootstrap.css', [], $version, false);
	}

	/**
	 * Enqueue theme CSS
	 *
	 * @since 1.0
	 */
	public static function theme_css() 
	{
		$dir = THEME_CSS_URI;
		
		$version = THEME_VERSION;
		
		wp_dequeue_style( 'hello-elementor' );
		wp_deregister_style( 'hello-elementor' );
	
		wp_dequeue_script( 'hello-elementor-theme-style' );
		wp_deregister_script( 'hello-elementor-theme-style' );

		wp_enqueue_style('daraluz-theme', $dir . 'main.css', [], $version, false);
	}

	/**
	 * Enqueue theme JS
	 *
	 * @since 1.0
	 */
	public static function theme_js() 
	{	
		$dir = THEME_JS_URI;
		
		$version = THEME_VERSION;

		wp_enqueue_script('theme-js', $dir . 'main.js', ["jquery"], $version, false);
	}

	/**
	 * Enqueue theme fonts
	 *
	 * @since 1.0
	 */
	public static function theme_fonts() 
	{	
		$dir = THEME_FONT_URI;
		
		$version = THEME_VERSION;

		wp_enqueue_style('bootstrap-icons', $dir . 'bootstrap-icons/bootstrap-icons.css', [], "1.5.0", false);
		wp_enqueue_style('Barlow', $dir . 'Barlow/font.css', [], $version, false);
		wp_enqueue_style('Staccato222', $dir . 'Staccato222/font.css', [], $version, false);
	}

	/**
	 * Get theme version
	 *
	 * @return string Theme Version
	 * @since 1.0
	 */
	public static function get_theme_version() 
	{
		$theme = wp_get_theme();	
		return $theme->get("Version");
	}
	
	/**
     * Set query params for blog page by using the GET params
     *
     * @param [array] $query
	 * @since 2.0
     */
    public static function set_query_params( $query ) {
	
        if( $query->is_main_query() 
        && !$query->is_feed() ) {
        
            if(isset($_GET['category'])) {
                $category = $_GET['category'];
                $query->set( 'category_name', $category );
                $query->set( 'ignore_sticky_posts', true );
            }
        }
    }

	/**
     * Set custom excerpt length
     *
     * @param int $length
	 * @since 2.0
     */
	public static function custom_excerpt_len( $length ) {
		return 20;
	}

	/**
	 * Change excerpt more ellipsis
	 * 
	 * @param string more
	 * @since 3.0
	 */
	public static function new_excerpt_more($more) {
		return '...';
	}

}

new Theme_Functions();