<?php

defined('WPGRADE_SHORTCODES_PATH') or define('WPGRADE_SHORTCODES_PATH', plugin_dir_path(__FILE__) );
defined('WPGRADE_SHORTCODES_URL') or define('WPGRADE_SHORTCODES_URL', plugin_dir_url(dirname(__FILE__) . '/shortcodes.php') );

if ( ! defined( 'ABSPATH' ) )
	die('-1');

class WpGradeShortcode {

    public $plug_dir;
    protected $shortcode;
    protected $settings;
    protected $params;
    protected $self_closed;
    protected $code;
    protected $direct;
    protected $icon;
    protected $shortcodes;
    protected $name;
    protected $backend_assets;
    protected $frontend_assets;
    protected $load_frontend_scripts;

    public function __construct() {

        $this->plug_dir = plugins_url();
        $this->self_closed = false;
        $this->shortcodes = array();
        $this->autoload();

        // init assets list // useless
        $this->assets = array(
            'js' => array(),
            'css' => array()
        );
    }

    public function autoload () {

        $shortcodes = get_option('wpgrade_shortcodes_list');

        if ( $shortcodes ){ // check if the current version supports the shortcodes list from database

            foreach ($shortcodes as $file ){

                $file_name = 'WpGradeShortcode_'. $file .'.php';
                $file_path =  WPGRADE_SHORTCODES_PATH . '/shortcodes/'. $file_name;

                if ( !file_exists($file_path) ) continue;

                include_once($file_path);
                $shortcode_class = 'WpGradeShortcode_'. $file;
                $shortcode = new $shortcode_class();

                // create a list of params needed for js to create the admin panel
                $this->shortcodes[$shortcode_class]["name"] = $shortcode->name;
                $this->shortcodes[$shortcode_class]["code"] = $shortcode->code;
                $this->shortcodes[$shortcode_class]["self_closed"] = $shortcode->self_closed;
                $this->shortcodes[$shortcode_class]["direct"] = $shortcode->direct;
                $this->shortcodes[$shortcode_class]["icon"] = $shortcode->icon;
                if ( $shortcode->direct == false ) {
                    $this->shortcodes[$shortcode_class]["params"] = $shortcode->params;
                }
            }

        } else { // old depricated way ... keep it for fallback

            $FILES = scandir(WPGRADE_SHORTCODES_PATH . '/shortcodes', 1);
            // get rid of . and ..
            array_pop($FILES);
            array_pop($FILES);

            foreach ($FILES as $file ){

                include_once(WPGRADE_SHORTCODES_PATH . '/shortcodes/'.$file);
                $file = str_replace('.php', '', $file);
                $shortcode = new $file();

                // create a list of params needed for js to create the admin panel
                $this->shortcodes[$file]["name"] = $shortcode->name;
                $this->shortcodes[$file]["code"] = $shortcode->code;
                $this->shortcodes[$file]["self_closed"] = $shortcode->self_closed;
                $this->shortcodes[$file]["direct"] = $shortcode->direct;
                $this->shortcodes[$file]["icon"] = $shortcode->icon;
                if ( $shortcode->direct == false ) {
                    $this->shortcodes[$file]["params"] = $shortcode->params;
                }
            }
        } // end of version check
    }

    public function get_shortcodes() {
        return $this->shortcodes;
    }

    public function get_code() {
        return $this->code;
    }

    public function load_backend_assets($buttons){

        if ( !empty($this->backend_assets) ) {
            $types = $this->backend_assets;

            foreach ( $types as $type => $assets ) {
                foreach( $assets as $key => $asset ) {
                    $path = WPGRADE_SHORTCODES_URL . $asset['path'];
                    if ($type == 'js') {
                        wp_enqueue_script( $asset['name'], $path, $asset['deps'] );
                    } elseif ( $type == 'css' ) {
                        wp_enqueue_style( $asset['name'], $path, $asset['deps'] );
                    }
                }
            }
        }

        // do not modify buttons here ... we just add our scripts
        return $buttons;
    }

    public function load_frontend_assets(){

        if ( !empty($this->frontend_assets) && $this->load_frontend_scripts == true ) {
            $types = $this->frontend_assets;

            foreach ( $types as $type => $assets ) {
                foreach( $assets as $key => $asset ) {
                    $path = WPGRADE_SHORTCODES_URL . $asset['path'];
                    if ($type == 'js') {
                        wp_enqueue_script( $asset['name'], $path, $asset['deps'] );
                    } elseif ( $type == 'css' ) {
                        wp_enqueue_style( $asset['name'], $path, $asset['deps'] );
                    }
                }
            }
        }
    }

    public function get_clean_content($content){ // depricated - remove in further themes
        $content = do_shortcode( $content );
        $content = preg_replace('#<br class="pxg_removable" />#', '', $content); // remove our temp brs

        return $content;
    }
}
global $wpgrade_shortcodes;
$wpgrade_shortcodes = new WpGradeShortcode();