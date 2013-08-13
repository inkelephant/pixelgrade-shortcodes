<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_InfoBox extends  WpGradeShortcode {

    public function __construct($settings = array()) {

        $this->self_closed = false;
        $this->direct = false;
        $this->name = "InfoBox";
        $this->code = "infobox";
        $this->icon = "icon-info-sign";

        $this->params = array(
            'title' => array(
                'type' => 'text',
                'name' => 'Title',
                'admin_class' => 'span6'
            ),
            'align' => array(
                'type' => 'select',
                'name' => 'Align',
                'options' => array('' => '-- Align --', 'align-left' => 'Left', 'align-center' => 'Center', 'align-right' => 'Right'),
                'admin_class' => 'span5 push1'
            ),
            'subtitle' => array(
                'type' => 'text',
                'name' => 'Subtitle',
                'admin_class' => 'span12'
            )
        );

        // add_shortcode('tabs', array( $this, 'add_tabs_shortcode') );
        add_shortcode('infobox', array( $this, 'add_infobox_shortcode') );

        // frontend assets needs to be loaded after the add_shortcode function
//        $this->frontend_assets["js"] = array(
//            'tabs' => array(
//                'name' => 'frontend_tabs',
//                'path' => 'js/shortcodes/frontend_tabs.js',
//                'deps'=> array( 'jquery' )
//            )
//        );
//        add_action('wp_footer', array($this, 'load_frontend_assets'));

    }

    public function add_infobox_shortcode( $atts, $content ) {
        $title = '';
		$icon = '';
         extract( shortcode_atts( array(
             'title' => '',
             'align' => '',
             'subtitle' => ''
         ), $atts ) );

        ob_start(); 

        ?>

        <div class="shc shc-infobox <?php 
            switch ($align){
                case 'align-left':{
                    echo 'align-left border-left';
                    break;
                }
                case 'align-right':{
                    echo 'align-right border-right';
                    break;
                }
                case 'align-center':{
                    echo 'align-center border-left-right';
                    break;
                }                                

                default: break;
            };
        ?>">
            <h1 class="infobox-title"><?php echo $title; ?></h1>
            <span class="infobox-subtitle"><?php echo $subtitle; ?></span>
        </div>

        <?php

		return ob_get_clean();
    }
}