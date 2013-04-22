<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Glossary extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = false;
        $this->name = "Glossary";
        $this->code = "glossary";
        $this->icon = "icon-info-sign";
        $this->direct = false;

        $this->params = array(
            'title' => array(
                'type' => 'text',
                'name' => 'Title',
                'admin_class' => 'span6'
            ),
            'link' => array(
                'type' => 'text',
                'name' => 'Link',
                'admin_class' => 'span5 push1'
            ),
            'content' => array(
                'type' => 'textarea',
                'name' => 'Content',
                'admin_class' => 'span12',
                'is_content' => true
            ),
            'align' => array(
                'type' => 'select',
                'name' => 'Align',
                'options' => array('' => '-- Select Size --', 'left' => 'Left', 'right' => 'Right'),
                'admin_class' => 'span6'
            ),
            'class' => array(
                'type' => 'text',
                'name' => 'Class',
                'admin_class' => 'span5 push1'
            ),
        );

        add_shortcode('glossary', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts, $content){

        extract( shortcode_atts( array(
            'title' => '',
            'link' => '#',
            'align' => 'right',
            'class' => ''
        ), $atts ) );

        ob_start(); ?>
            <div class="glossary <?php if ( !empty($align) ) echo $align; if ( !empty($class) ) echo $class; ?>">
                <?php if ( !empty($title) ) { ?>
                    <h3><?php echo $title; ?></h3>
                <?php } ?>
                <p><?php echo do_shortcode($content); ?></p>

                <?php if ( !empty($link) ) {?>
                    <a class="link" href="<?php echo $link ?>" target="_blank">continue reading &raquo;</a>
                <?php } ?>
            </div>
        <?php return ob_get_clean();
    }
}
