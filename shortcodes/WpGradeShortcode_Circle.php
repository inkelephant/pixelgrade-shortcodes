<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Circle extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = true;
        $this->name = "Circle Knob";
        $this->code = "circle";
        $this->icon = "icon-circle-blank";
        $this->direct = false;

        $this->params = array(
            'title' => array(
                'type' => 'text',
                'name' => 'Title (inside of circle knob)',
                'admin_class' => 'span4'
            ),
            'color' => array(
                'type' => 'text',
                'name' => 'Color (knob color in HEX format)',
                'admin_class' => 'span7 push1'
            ),
            'value' => array(
                'type' => 'text',
                'name' => 'Value (0 to 100)',
                'admin_class' => 'span4'
            ),
            'offset' => array(
                'type' => 'text',
                'name' => 'Offset Angle (starting angle in degrees - default=0)',
                'admin_class' => 'span7 push1'
            ),
        );

        add_shortcode('circle', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts, $content){

        extract( shortcode_atts( array(
            'title' => '',
            'color' => '',
            'value' => '',
            'offset' => '',
        ), $atts ) );
		
		return '<input class="dial" type="text" value="'.$value.'" data-text="'.$title.'" data-fgcolor="'.$color.'" data-angleoffset="'.$offset.'" />';
    }
}
