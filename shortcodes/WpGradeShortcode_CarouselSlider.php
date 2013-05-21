<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_CarouselSlider extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = false;
        $this->name = "Carousel Slider";
        $this->code = "carousel-slider";
        $this->icon = "icon-sort";
        $this->direct = false;

        $this->params = array(
            'info_box' => array(
                "type" => "info",
                "value" => "Use this shortcode to create an carousel of shortcodes ( yeah wieeerd). The items supported inside this shortcode are team member and icon shortcodes or all simple html images tags."
            ),
            'title' => array(
                'type' => 'text',
                'name' => 'Title',
                'admin_class' => 'span6'
            ),
            'class' => array(
                'type' => 'text',
                'name' => 'Class',
                'admin_class' => 'span6'
            ),
//            'number' => array(
//                'type' => 'select',
//                'name' => 'Number of slides',
//                'options' => array('' => '-- Select Size --', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6'),
//                'admin_class' => 'span6'
//            )
        );

        add_shortcode('carousel-slider', array( $this, 'add_shortcode') );
    }

    public function add_shortcode($atts, $content){
        extract( shortcode_atts( array(
			'title' => '',
			'class' => '',
        ), $atts ) );
        ob_start(); ?>
        <div class="carousel_slider">
            <ul class="slides">
                <?php

                $array = array (
                    '[icon' => '<li class="slide-item">[icon',
                    '[/icon]' => '[/icon]</li>',
                    '[team-member' => '<li class="slide-item">[team-member',
                    '[/team-member]' => '[/team-member]</li>',
                );

                $content = strtr($content, $array);

                echo do_shortcode($content); ?>
            </ul>
        </div>
        <?php return ob_get_clean();
    }
}

/*
 * somewhere i need to put this in front-end
 *
 *
        // carousel slider
        // tiny helper function to add breakpoints
        function getGridSize() {
            return (window.innerWidth < 600) ? 2 :
                (window.innerWidth < 900) ? 3 : 4;
        }

        $(".carousel_slider").flexslider({
            animation: "slide",
            animationLoop: false,
            minItems: getGridSize(), // use function to pull in initial value
            maxItems: getGridSize() // use function to pull in initial value
        });
        $(window).resize(function() {
            var gridSize = getGridSize();

            flexslider.vars.minItems = gridSize;
            flexslider.vars.maxItems = gridSize;
        });
 *
 */