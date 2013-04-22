<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Circle extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = false;
        $this->name = "Circle";
        $this->code = "circle";
        $this->icon = "icon-circle-blank";
        $this->direct = false;

        $this->params = array(
            'title' => array(
                'type' => 'text',
                'name' => 'Title (inside of circle)',
                'admin_class' => 'span12'
            ),
        );

        add_shortcode('circle', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts, $content){

        extract( shortcode_atts( array(
            'title' => '',
        ), $atts ) );

        ob_start(); ?>
            <div class="pie-chart">
                <?php if ( !empty($title) ) { ?>
                    <h1><?php echo $title; ?></h1>
                <?php } ?>
                <div class="circle"></div>
            </div>
        <?php return $this->get_clean_content( ob_get_clean() );
    }
}
