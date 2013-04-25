<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Columns extends  WpGradeShortcode {

    public function __construct($settings = array()) {

        $this->assets["js"] = array(
            'columns' => array(
                'name' => 'columns',
                'path' => '/js/shortcodes/columns.js',
                'deps'=> array( 'jquery' )
            )
        );

        $this->load_assests();

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
                'admin_class' => 'span3 push1'
            ),
            'full_width' => array(
                'type' => 'switch',
                'name' => 'Full Width Background',
                'admin_class' => 'span4 push2 inline'
            ),
            'cols_slider' =>array(
                'type' => 'slider',
                'name' => 'Drag handlers to change the columns width.'
            ),
            'class' => array(
                'type' => 'text',
                'name' => 'Custom CSS Class',
                'admin_class' => 'span12'
            ),
        );

        add_shortcode('col', array( $this, 'add_column_shortcode') );
        add_shortcode('row', array( $this, 'add_row_shortcode') );
    }

    public function add_row_shortcode($atts, $content){
        extract( shortcode_atts( array(
            'bg_color' => '#fff',
            'full_width' => '',
            'class' => ''
        ), $atts ) );
        ob_start(); ?>
        <?php
            $is_narrow = false;
            $classes = explode(" ", $class);
            foreach ($classes as $my_class):
                if ($my_class == "narrow") $is_narrow = true;
            endforeach;
            if ($is_narrow): ?>
                <div class="narrow">
                    <div class="row row-shortcode <?php echo $class; ?>">
                        <?php if ( !empty($bg_color) ) { ?>
                            <div class="row-background full-width" style="background-color:<?php echo $bg_color; ?>;"></div>
                        <?php } ?>
                        <?php echo $this->get_clean_content($content); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="row row-shortcode <?php echo $class; ?>">
                    <?php if ( !empty($bg_color) ) { ?>
                        <div class="row-background full-width" style="background-color:<?php echo $bg_color; ?>;"></div>
                    <?php } ?>
                    <?php echo $this->get_clean_content($content); ?>
                </div>
            <?php endif; ?>
        <?php return ob_get_clean();
    }

    public function add_column_shortcode($atts, $content){

        extract( shortcode_atts( array(
            'size' => '1',
        ), $atts ) );

        ob_start(); ?>
            <div class="span<?php echo $size; ?>">
                <?php echo $this->get_clean_content( $content ); ?>
            </div>
        <?php return ob_get_clean();
    }
}