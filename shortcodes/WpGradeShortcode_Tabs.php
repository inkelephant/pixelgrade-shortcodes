<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Tabs extends  WpGradeShortcode {

    public function __construct($settings = array()) {

        $this->backend_assets["js"] = array(
            'tabs' => array(
                'name' => 'tabs',
                'path' => 'js/shortcodes/backend_tabs.js',
                'deps'=> array( 'jquery' )
            )
        );

        // load backend assets only when an editor is present
        add_action( 'mce_buttons_2', array( $this, 'load_backend_assets' ) );

        $this->self_closed = false;
        $this->direct = false;
        $this->name = "Tabs";
        $this->code = "tabs";
        $this->icon = "icon-folder-close";

        $this->params = array(
            'tabs' => array(
                'type' => 'tabs',
                'name' => 'Tabs',
            ),
        );

        add_shortcode('tabs', array( $this, 'add_tabs_shortcode') );
        add_shortcode('tab', array( $this, 'add_tab_shortcode') );
//        add_shortcode('tabs_content', array( $this, 'add_tabs_content_shortcode') );
        // frontend assets needs to be loaded after the add_shortcode function
//        $this->frontend_assets["js"] = array(
//            'columns' => array(
//                'name' => 'frontend_testimonials',
//                'path' => 'js/shortcodes/frontend_testimonials.js',
//                'deps'=> array( 'jquery' )
//            )
//        );
//        add_action('wp_footer', array($this, 'load_frontend_assets'));

    }

    public function add_tabs_shortcode( $atts, $content ) {

//         extract( shortcode_atts( array(
//             'number' => '-1',
//         ), $atts ) );

        ob_start(); ?>
            <div class="row">
                <div class="span6">
                    <?php echo do_shortcode($content); ?>
                </div>
            </div>
        <?php return ob_get_clean();
    }

    public function add_tab_shortcode( $atts, $content ) {
        $title = '';
         extract( shortcode_atts( array(
             'title' => '',
         ), $atts ) );

        ob_start(); ?>

        <div class="block-inner block-text">
            <?php echo do_shortcode($content); ?>
        </div>

        <li class="tab-titles-list-item">
            <a href="#">
                <?php echo do_shortcode( $title ); ?>
            </a>
        </li>

    <?php }
}