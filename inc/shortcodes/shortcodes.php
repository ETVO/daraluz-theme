<?php
/**
 * Custom Customizer controls and options
 * 
 * @package WordPress
 * @subpackage GPR-Theme
 */
    
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

define('SHORTCODES_DIR', THEME_INC_DIR . 'shortcodes/blocks/');

class Theme_Shortcodes {

    /**
     * Setup the shortcodes
     * 
     * @since 1.0
     */
    public function __construct()
    {
        $this->register_shortcodes();

        add_filter('wpcf7_form_elements', [$this, 'add_support_wpcf7']);
    }

    /**
     * Register all of the shortcodes and require their files
     *
     * @since 1.0
     */
    public static function register_shortcodes() 
    {
        $dir = SHORTCODES_DIR;
        
        $codes = array(
            'daraluz_slides'
        );

        // Add shortcodes
        foreach($codes as $code) {
            $code_function = str_replace(['/','-'], '_', $code);
            if(file_exists($dir . $code . '.php')) {
                require_once($dir . $code . '.php');
                add_shortcode($code_function, $code_function);
            }
        }
    }

    /**
     * Add filter to make CF7 shortcode-friendly
     *
     * @param $form
     * @since 1.0
     */
    public static function add_support_wpcf7( $form ) 
    {
        $form = do_shortcode($form);
        
        return $form;
    }
    
}

new Theme_Shortcodes();