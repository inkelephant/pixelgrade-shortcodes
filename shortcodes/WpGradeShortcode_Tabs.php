<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Tabs extends  WpGradeShortcode {

    public function __construct($settings = array()) {

        $this->backend_assets["js"] = array(
            'tabs' => array(
                'name' => 'tabs',
                'path' => 'js/shortcodes/backend_tabs.js',
                'deps'=> array( 'jquery' )
            )
        );

        // load backend assets only when an editor is present
        add_action( 'mce_buttons_2', array( $this, 'load_backend_assets' ) );

        $this->self_closed = false;
        $this->direct = false;
        $this->name = "Tabs";
        $this->code = "tabs";
        $this->icon = "icon-folder-close";

        $this->params = array(
            'tabs' => array(
                'type' => 'tabs',
                'name' => 'Tabs',
            ),
        );

        add_shortcode('tabs', array( $this, 'add_tabs_shortcode') );
        add_shortcode('tab', array( $this, 'add_tab_shortcode') );

        // frontend assets needs to be loaded after the add_shortcode function
//        $this->frontend_assets["js"] = array(
//            'tabs' => array(
//                'name' => 'frontend_tabs',
//                'path' => 'js/shortcodes/frontend_tabs.js',
//                'deps'=> array( 'jquery' )
//            )
//        );
//        add_action('wp_footer', array($this, 'load_frontend_assets'));

    }

    public function add_tabs_shortcode( $atts, $content ) {

//         extract( shortcode_atts( array(
//             'number' => '-1',
//         ), $atts ) );

        // prepare the icons first
        preg_match_all ( '#<icon>(.*?)</icon>#', do_shortcode( $content ), $icons );
        if ( isset( $icons[1] ) ) {
            $icons = $icons[1];
        }

        ob_start(); ?>
        <div class="row">
            <div class="span6">
                <div class="tabs-content">
                    <?php
                    preg_match_all ( '#<body>([\s\S]*?)</body>#', do_shortcode( $content ), $contents );
                    if ( !empty( $contents ) && isset($contents[1]) ) {
                        foreach ( $contents[1] as $key => $value ) { ?>
                            <div class="tabs-content-pane <?php if ( $key == 0 ) { ?>active<?php } ?>" id="ui-tab-<?php echo $key; ?>">
                                <div class="block-inner block-text">
                                    <?php wpgrade_display_content($value) ?>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
            <div class="span6">
                <div class="block-inner block-inner_last block-text">
                    <ul class="nav nav-tabs tab-titles-list">
                        <?php preg_match_all( '#<title>(.*?)</title>#', do_shortcode( $content ), $titles );
                        if ( !empty( $titles ) && isset($titles[1]) ) {
                            foreach ( $titles[1] as $key => $title ) { ?>
                                <li class="tab-titles-list-item <?php if ( $key == 0 ) { ?>active<?php } ?>">
                                    <a href="#ui-tab-<?php echo $key; ?>">
                                        <?php if ( isset( $icons[$key] ) && !empty($icons[$key] ) ) { ?>
                                            <i class="icon-<?php echo $icons[$key]; ?>"></i>
                                        <?php }
                                        echo $title ?>
                                    </a>
                                </li>
                            <?php }
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php return ob_get_clean();
    }

    public function add_tab_shortcode( $atts, $content ) {

        $title = $icon = '';
         extract( shortcode_atts( array(
             'title' => '',
             'icon' => ''
         ), $atts ) );

        ob_start(); ?>
        <title><?php echo do_shortcode( $title ); ?></title>
        <icon><?php echo $icon ?></icon>
        <body><?php echo do_shortcode( $content ); ?></body>
    <?php return ob_get_clean();
    }
}