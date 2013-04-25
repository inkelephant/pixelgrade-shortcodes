<?php

if (!defined('ABSPATH')) die('-1');

class WpGradeShortcode_Icon extends  WpGradeShortcode {

    public function __construct($settings = array()) {
        $this->self_closed = true;
        $this->name = "Icon";
        $this->code = "icon";
        $this->icon = "icon-magic";
        $this->direct = false;

        $this->assets["js"] = array(
            "icons" => array(
                'name' => 'icons',
                'path' => '/js/shortcodes/icons.js',
                'deps'=> array( 'jquery' )
            )
        );

        $this->load_assests();

        $this->params = array(
            'type' => array(
                'type' => 'select',
                'name' => 'Background Shape',
                'options' => array('' => '-- Select Type --', 'circle' => 'Circle', 'rectangle' => 'Rectangle'),
                'admin_class' => 'span6'
            ),
            'size' => array(
                'type' => 'select',
                'name' => 'Icon Size',
                'options' => array('' => '-- Select Size --', 'small' => 'Small', 'medium' => 'Medium', 'big' => 'Big'),
                'admin_class' => 'span5 push1'
            ),
            'name'=> array(
              'type'=> 'icon_list',
              'name' => 'Select icon:',
              'icons' => array(
                  "glass",
                  "music",
                  "search",
                  "envelope",
                  "heart",
                  "star",
                  "star-empty",
                  "user",
                  "film",
                  "th-large",
                  "th",
                  "th-list",
                  "ok",
                  "remove",
                  "zoom-in",
                  "zoom-out",
                  "off",
                  "signal",
                  "cog",
                  "trash",
                  "home",
                  "file",
                  "time",
                  "road",
                  "download-alt",
                  "download",
                  "upload",
                  "inbox",
                  "play-circle",
                  "repeat",
                  "refresh",
                  "list-alt",
                  "lock",
                  "flag",
                  "headphones",
                  "volume-off",
                  "volume-down",
                  "volume-up",
                  "qrcode",
                  "barcode",
                  "tag",
                  "tags",
                  "book",
                  "bookmark",
                  "print",
                  "camera",
                  "font",
                  "bold",
                  "italic",
                  "text-height",
                  "text-width",
                  "align-left",
                  "align-center",
                  "align-right",
                  "align-justify",
                  "list",
                  "indent-left",
                  "indent-right",
                  "facetime-video",
                  "picture",
                  "pencil",
                  "map-marker",
                  "adjust",
                  "tint",
                  "edit",
                  "share",
                  "check",
                  "move",
                  "step-backward",
                  "fast-backward",
                  "backward",
                  "play",
                  "pause",
                  "stop",
                  "forward",
                  "fast-forward",
                  "step-forward",
                  "eject",
                  "chevron-left",
                  "chevron-right",
                  "plus-sign",
                  "minus-sign",
                  "remove-sign",
                  "ok-sign",
                  "question-sign",
                  "info-sign",
                  "screenshot",
                  "remove-circle",
                  "ok-circle",
                  "ban-circle",
                  "arrow-left",
                  "arrow-right",
                  "arrow-up",
                  "arrow-down",
                  "share-alt",
                  "resize-full",
                  "resize-small",
                  "plus",
                  "minus",
                  "asterisk",
                  "exclamation-sign",
                  "gift",
                  "leaf",
                  "fire",
                  "eye-open",
                  "eye-close",
                  "warning-sign",
                  "plane",
                  "calendar",
                  "random",
                  "comment",
                  "magnet",
                  "chevron-up",
                  "chevron-down",
                  "retweet",
                  "shopping-cart",
                  "folder-close",
                  "folder-open",
                  "resize-vertical",
                  "resize-horizontal",
                  "bar-chart",
                  "twitter-sign",
                  "facebook-sign",
                  "camera-retro",
                  "key",
                  "cogs",
                  "comments",
                  "thumbs-up",
                  "thumbs-down",
                  "star-half",
                  "heart-empty",
                  "signout",
                  "linkedin-sign",
                  "pushpin",
                  "external-link",
                  "signin",
                  "trophy",
                  "github-sign",
                  "upload-alt",
                  "lemon",
                  "phone",
                  "check-empty",
                  "bookmark-empty",
                  "phone-sign",
                  "twitter",
                  "facebook",
                  "github",
                  "unlock",
                  "credit-card",
                  "rss",
                  "hdd",
                  "bullhorn",
                  "bell",
                  "certificate",
                  "hand-right",
                  "hand-left",
                  "hand-up",
                  "hand-down",
                  "circle-arrow-left",
                  "circle-arrow-right",
                  "circle-arrow-up",
                  "circle-arrow-down",
                  "globe",
                  "wrench",
                  "tasks",
                  "filter",
                  "briefcase",
                  "fullscreen",
                  "group",
                  "link",
                  "cloud",
                  "beaker",
                  "cut",
                  "copy",
                  "paper-clip",
                  "save",
                  "sign-blank",
                  "reorder",
                  "list-ul",
                  "list-ol",
                  "strikethrough",
                  "underline",
                  "table",
                  "magic",
                  "truck",
                  "pinterest",
                  "pinterest-sign",
                  "google-plus-sign",
                  "google-plus",
                  "money",
                  "caret-down",
                  "caret-up",
                  "caret-left",
                  "caret-right",
                  "columns",
                  "sort",
                  "sort-down",
                  "sort-up",
                  "envelope-alt",
                  "linkedin",
                  "undo",
                  "legal",
                  "dashboard",
                  "comment-alt",
                  "comments-alt",
                  "bolt",
                  "sitemap",
                  "umbrella",
                  "paste",
                  "lightbulb",
                  "exchange",
                  "cloud-download",
                  "cloud-upload",
                  "user-md",
                  "stethoscope",
                  "suitcase",
                  "bell-alt",
                  "coffee",
                  "food",
                  "file-alt",
                  "building",
                  "hospital",
                  "ambulance",
                  "medkit",
                  "fighter-jet",
                  "beer",
                  "h-sign",
                  "plus-sign-alt",
                  "double-angle-left",
                  "double-angle-right",
                  "double-angle-up",
                  "double-angle-down",
                  "angle-left",
                  "angle-right",
                  "angle-up",
                  "angle-down",
                  "desktop",
                  "laptop",
                  "tablet",
                  "mobile-phone",
                  "circle-blank",
                  "quote-left",
                  "quote-right",
                  "spinner",
                  "circle",
                  "reply",
                  "github-alt",
                  "folder-close-alt",
                  "folder-open-alt",
                   "user",
                  "film",
                  "th-large"
                )
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

           <i class="shc <?php echo $type." ".$size; ?> icon-<?php echo $name; ?>"></i>

        <?php return ob_get_clean();
    }
}
