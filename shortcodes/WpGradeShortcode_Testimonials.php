<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Testimonials extends  WpGradeShortcode {

    static $load_frontend_scripts;

    public function __construct($settings = array()) {

        $this->self_closed = false;
        $this->name = "Testimonials";
        $this->code = "testimonials";
        $this->icon = "icon-star-empty";

        $this->params = array(
            'title' => array(
                'type' => 'text',
                'name' => 'Title',
//                'admin_class' => 'span6'
            ),
            'number' => array(
                'type' => 'text',
                'name' => 'Number',
                'admin_class' => 'span6'
            ),
            'class' => array(
                'type' => 'text',
                'name' => 'Class',
                'admin_class' => 'span5 push1'
            ),
            'orderby' => array(
                'type' => 'select',
                'name' => 'Order By',
                'options' => array('' => '-- Select Order By --', 'date' => 'Date', 'title' => 'Title', 'random' => 'Random'),
                'admin_class' => 'span6'
            ),
            'order' => array(
                'type' => 'select',
                'name' => 'Order',
                'options' => array('' => '-- Select Order --', 'ASC' => 'Ascending', 'DESC' => 'Descending'),
                'admin_class' => 'span5 push1'
            ),
            array(
                'type' => 'info',
                'value' => 'If you want specific testimonials include bellow posts IDs separeted by comma.'
            ),
            'include' => array(
            'type' => 'text',
            'name' => 'Include IDs',
            'admin_class' => 'span6'
            ),
                'exclude' => array(
                'type' => 'text',
                'name' => 'Exclude IDs',
                'admin_class' => 'span5 push1'
            ),
        );

        add_shortcode('testimonials', array( $this, 'add_shortcode') );

        // frontend assets needs to be loaded after the add_shortcode function
        $this->frontend_assets["js"] = array(
            'columns' => array(
                'name' => 'frontend_testimonials',
                'path' => '/js/shortcodes/frontend_testimonials.js',
                'deps'=> array( 'jquery' )
            )
        );
        add_action('wp_footer', array($this, 'load_frontend_assets'));
    }

    public function add_shortcode($atts){

        $this->load_frontend_scripts = true;

        // init vars
        $number = -1;
        $orderby = 'date';
        $order = 'DESC';

        extract( shortcode_atts( array(
            'title' => '',
            'number' => '-1',
            'order' => 'DESC',
            'orderby' => 'date',
            'include' => '',
            'exclude' => '',
        ), $atts ) );

        ob_start(); ?>
        <div class="testimonials">
            <?php if ( !empty($title) ) { ?>
                <h3 class="title"><?php echo $title; ?></h3>
            <?php
            }
            $query_args = array(
                'post_type' => 'testimonial',
                'posts_per_page' => $number,
                'order' => $order,
                'orderby' => $orderby
            );

            if ( !empty( $include ) ) {
                $include_array = explode( ',', $include );
                $query_args['posts__in'] = $include_array;
            }

            if ( !empty( $exclude ) ) {
                $exclude_array = explode( ',', $exclude );
                $query_args['post__not_in'] = $exclude_array;
            }

            $query = new WP_Query($query_args);

            if ( $query-> have_posts() ) : ?>
                <ul class="slides">
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <li>
                        <?php the_title(); ?>
                    </li>
                <?php endwhile;?>
                </ul>
            <?php endif; wp_reset_query(); ?>
        </div>
        <?php return ob_get_clean();
    }
}
