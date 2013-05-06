<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Divider extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = true;
        $this->name = "Divider";
        $this->code = "hr";
        $this->icon = "icon-fire";
        $this->direct = false;

        $this->params = array(
            'align' => array(
                'type' => 'select',
                'name' => 'Alignment',
                'options' => array('' => '-- Select Alignment --', 'left' => 'Left', 'center' => 'Center', 'right' => 'Right'),
                'admin_class' => 'span6'
            )
        );

        add_shortcode('hr', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts, $content){
        extract( shortcode_atts( array(
			'align' => '',
        ), $atts ) );
        ob_start(); ?>
            <hr class="<?php echo $align; ?>">
        <?php return ob_get_clean();
    }
}
