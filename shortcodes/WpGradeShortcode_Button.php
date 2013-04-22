<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Button extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = false;
        $this->name = "Button";
        $this->code = "button";
        $this->icon = "icon-bookmark";
        $this->direct = false;

        $this->params = array(
            'link' => array(
                'type' => 'text',
                'name' => 'Link',
                'admin_class' => 'span6'
            ),
            'label' => array(
                'type' => 'text',
                'name' => 'Label',
                'admin_class' => 'span5 push1',
                'is_content' => true
            ),
            'class' => array(
                'type' => 'text',
                'name' => 'Class',
                'admin_class' => 'span6'
            ),
            'id' => array(
                'type' => 'text',
                'name' => 'ID',
                'admin_class' => 'span5 push1'
            ),
            'size' => array(
                'type' => 'select',
                'name' => 'Size',
                'options' => array('' => '-- Select Size --', 'small' => 'Small', 'medium' => 'Medium', 'big' => 'Big'),
                'admin_class' => 'span6'
            )
        );

        add_shortcode('button', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts){

        extract( shortcode_atts( array(
        ), $atts ) );
        ob_start(); ?>

        <?php return $this->get_clean_content( ob_get_clean() );
    }
}
