<?php

defined('WPGRADE_SHORTCODES_PATH') or define('WPGRADE_SHORTCODES_PATH', plugin_dir_path(__FILE__) );
if (!defined('ABSPATH')) die('-1');

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
    protected $assets;

    public function __construct() {

        $this->plug_dir = plugins_url();
        $this->self_closed = false;
        $this->shortcodes = array();
        $this->autoload();

        // init assets list
        $this->assets = array(
            'js' => array(),
            'css' => array()
        );
    }

    public function autoload () {
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
    }

    public function get_shortcodes() {
        return $this->shortcodes;
    }

    public function get_code() {
        return $this->code;
    }

    public function load_assests(){

        if ( !empty($this->assets) ) {
            $types = $this->assets;

            foreach ( $types as $type => $assets ) {
                foreach( $assets as $key => $asset ) {
                    $path = plugins_url() . '/pixelgrade-shortcodes/' . $asset['path'];
                    if ($type == 'js') {
                        wp_enqueue_script( $asset['name'], $path, $asset['deps'] );
                    } elseif ( $type == 'css' ) {
                        wp_enqueue_style( $asset['name'], $path, $asset['deps'] );
                    }
                }
            }
        }
    }

    public function get_clean_content($content){
        $content = do_shortcode( $content );
        $content = preg_replace('#<br class="pxg_removable" />#', '', $content); // remove our temp brs

        return $content;
    }
}
global $wpgrade_shortcodes;
$wpgrade_shortcodes = new WpGradeShortcode(); ?>