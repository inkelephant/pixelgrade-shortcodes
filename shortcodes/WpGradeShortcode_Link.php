<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Link extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = true;
        $this->name = "Link";
        $this->code = "link";
        $this->icon = "icon-link";
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
                'admin_class' => 'span5 push1'
            ),
            'content' => array(
                'type' => 'textarea',
                'name' => 'Content',
                'admin_class' => 'span12'
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
         );

        add_shortcode('link', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts){

        extract( shortcode_atts( array(
            'link' => '#',
            'label' => '',
            'class' => ''
        ), $atts ) );

        if ( !empty( $class ) ) {
            $class = 'class="' . $class . '"';
        }

        return '<a href="'.$link.'" '.$class.' >'. $label .'</a>';
    }
}
