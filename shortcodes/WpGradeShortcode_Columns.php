<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Columns extends  WpGradeShortcode {

    public function __construct($settings = array()) {

        $this->backend_assets["js"] = array(
            'columns' => array(
                'name' => 'columns',
                'path' => 'js/shortcodes/backend_columns.js',
                'deps'=> array( 'jquery' )
            )
        );

        // load backend assets only when an editor is present
        add_action( 'mce_buttons_2', array( $this, 'load_backend_assets' ) );

        $this->self_closed = false;
        $this->name = "Columns";
        $this->code = "columns";
        $this->icon = "icon-th-list";
        $this->direct = false;

        $this->params = array(
            'cols_nr' => array(
                'type' => 'select',
                'name' => 'No. of columns:',
                'options' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '6' => '6'),
                'admin_class' => 'span3 strong'
            ),
             'bg_color' => array(
                'type' => 'color',
                'name' => 'Background Color',
                'admin_class' => 'span7 push1'
            ),
            'full_width' => array(
                'type' => 'switch',
                'name' => 'Full Width Background ?',
                'admin_class' => 'span5 inline full_width_bg'
            ),
            'cols_slider' =>array(
                'type' => 'slider',
                'name' => 'Drag handlers to change the columns width.'
            ),
            'class' => array(
                'type' => 'tags',
                'name' => 'Custom CSS Class',
                'admin_class' => 'span12',
                'options' => array( 'narrow', 'inverse'),
                'value' => array( '' )
            ),
        );

        add_shortcode('col', array( $this, 'add_column_shortcode') );
        add_shortcode('row', array( $this, 'add_row_shortcode') );
    }

    public function add_row_shortcode($atts, $content){
        $class = '';
        $bg_color = '';

        extract( shortcode_atts( array(
            'bg_color' => '',
            'full_width' => '',
            'class' => ''
        ), $atts ) );

        if ( !empty($bg_color) ) {
            if ( substr($bg_color, 0, 1 ) != '#' ) {
                $bg_color = '#'. $bg_color;
            }
        }

        $is_narrow = false;
        $classes = explode(" ", $class);
        foreach ($classes as $my_class):
            if ($my_class == "narrow") $is_narrow = true;
        endforeach;

        $output = '';
        if ($is_narrow) {
			$output .= '<div class="narrow">'.PHP_EOL;
		}
		
		$output .= '<div class="row row-shortcode '.$class.'">'.PHP_EOL;
		if ( !empty($bg_color) ) {
			$output .= '<div class="row-background';
			if ( !empty( $full_width ) )  $output .= ' full-width'; 
			 $output .= '" style="background-color:'.$bg_color.';"></div>'.PHP_EOL;
		   } 
			$output .= $this->get_clean_content($content).PHP_EOL;
		$output .= '</div>'.PHP_EOL;
		
		if ($is_narrow) {
			$output .= '</div>'.PHP_EOL;
		}
		
		return  $output;
    }

    public function add_column_shortcode($atts, $content){
        $size = '';
        $class= '';

        extract( shortcode_atts( array(
            'size' => '1',
            'class' => ''
        ), $atts ) );

        $output = '';
        $output .= '<div class="span'.$size. ' ' .$class.'">'.PHP_EOL;
        $output .= $this->get_clean_content( $content ).PHP_EOL;
		$output .= '</div>'.PHP_EOL;
        return $output;
    }
}