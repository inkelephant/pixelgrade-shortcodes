<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Icon extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = false;
        $this->name = "Icon";
        $this->code = "icon";
        $this->icon = "icon-user";
        $this->direct = false;

        $this->params = array(
            'name' => array(
                'type' => 'text',
                'name' => 'Name',
                'admin_class' => 'span6'
            ),
            'type' => array(
                'type' => 'select',
                'name' => 'Type',
                'options' => array('' => '-- Select Type --', 'circle' => 'Circle', 'rectangle' => 'Rectangle'),
                'admin_class' => 'span6'
            ),
            'size' => array(
                'type' => 'select',
                'name' => 'Size',
                'options' => array('' => '-- Select Size --', 'small' => 'Small', 'medium' => 'Medium', 'big' => 'Big'),
                'admin_class' => 'span6'
            )
        );

        add_shortcode('icon', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts, $content){

        extract( shortcode_atts( array(
            'name' => '',
            'type' => '',
            'size' => '',
        ), $atts ) );

        ob_start(); ?>
        
  
           <i class="shc <?php echo $name." ".$type." ".$size; ?>"></i>

        <?php return $this->get_clean_content( ob_get_clean() );
    }
}
