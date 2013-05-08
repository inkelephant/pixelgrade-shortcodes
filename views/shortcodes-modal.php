<?php
// get the root
$plug_path = dirname(dirname(__FILE__));
include_once($plug_path."/shortcodes.php");
global $wpgrade_shortcodes;
if (!defined('ABSPATH')) die('-1'); ?>

    <div id="wpgrade_shortcodes">
        <div class="l_modal_header">
            <button type="button" class="btn back"><i class="icon-reply"></i><span>Back</span></button>
            <div class="l_modal_title">Choose shortcode:</div>
            <button type="button" class="btn close close-reveal-modal"><i class="icon-remove"></i></button>
        </div>
        <div class="l_modal_body three_col">
            <div class="details_container ">
                <div class="details_content"></div>
            </div>
            <ul class="l_three_col">
                <?php
                $shortcoces_array = $wpgrade_shortcodes->get_shortcodes();
                foreach( $shortcoces_array as $key => $shortcode ) {
                    $class = 'shortcode_'.$shortcode["name"].'_open';
                    $data_trigger_open = 'shortcode_'.$shortcode["name"].'_open';
                    $shortcode_js =  json_encode( $shortcode, JSON_FORCE_OBJECT );
                    if ( $shortcode["direct"] ) {
                        $class .= ' insert-direct-shortcode';
                    } ?>
                    <li class="shortcode">
                        <a href="#" class="details <?php echo $class; ?>" data-params='<?php echo $shortcode_js; ?>' data-trigger-open="<?php echo $data_trigger_open ?>" >
                            <i class="icon <?php echo $shortcode["icon"]; ?>"></i>
                            <span class="title"><?php echo $shortcode["name"] ?></span>
                        </a>

                        <?php if ( !$shortcode['direct'] && !empty( $shortcode['params'] ) ) { ?>
                            <div class="shortcode_params details_content">
                                <form id="wpgrade_shortcodes_form" >
                                    <fieldset>
                                    <div class="row">
                                        <?php foreach ( $shortcode['params'] as $k => $param ) {

                                            $is_content = false;

                                            switch ( $param['type'] ) {
                                                case 'text' : {
                                                    $class= "span12";

                                                    if ( isset($param['admin_class'] ) ) $class = $param['admin_class'];
                                                    if ( isset($param['is_content'] ) ) $is_content = 'class="is_shortcode_content"'; ?>

                                                    <span class="<?php echo $class; ?>" >
                                                        <label for="<?php echo $k ?>"><?php echo $param['name'] ?></label>
                                                        <input type="<?php echo $param['type'] ?>" name="<?php echo $k ?>" <?php echo $is_content ?>/>
                                                    </span>

                                                <?php break; }
                                                case 'textarea' : {
                                                    $class= "span12";
                                                    if ( isset($param['admin_class'] ) ) $class = $param['admin_class'];
                                                    if ( isset($param['is_content'] ) ) $is_content = 'class="is_shortcode_content"'; ?>

                                                    <span class="<?php echo $class; ?>" >
                                                        <label for="<?php echo $k ?>"><?php echo $param['name'] ?></label>
                                                        <textarea type="<?php echo $param['type'] ?>" name="<?php echo $k ?>" <?php echo $is_content ?> ></textarea>
                                                    </span>

                                                <?php break; }
                                                case 'select' : {
                                                    $class= "span12";
                                                    if ( isset($param['admin_class'] ) ) $class = $param['admin_class']; ?>

                                                    <span class="<?php echo $class; ?>" >
                                                        <label for="<?php echo $k ?>"><?php echo $param['name'] ?></label>
                                                        <select name="<?php echo $k ?>">
                                                          <?php
                                                            $options = $param['options'];
                                                            foreach ( $options as $i => $opt ) { ?>
                                                              <option value="<?php echo $i ?>"><?php echo $opt ?></option>
                                                          <?php } ?>
                                                        </select>
                                                    </span>

                                                <?php break; }
                                                case 'switch' : {
                                                    $class= "span12";
                                                    if ( isset($param['admin_class'] ) ) $class = $param['admin_class']; ?>

                                                    <span class="<?php echo $class; ?>" >
                                                        <label for="<?php echo $k ?>"><?php echo $param['name'] ?></label>
                                                        <input type="checkbox" name="<?php echo $k ?>" />
                                                    </span>

                                                <?php break; }
                                                case 'color' : {
                                                    $class= "span12";

                                                    if ( isset($param['admin_class'] ) ) $class = $param['admin_class'];?>

                                                    <span class="<?php echo $class; ?>" >
                                                        <label for="<?php echo $k ?>"><?php echo $param['name'] ?></label>
                                                        <input type="text" name="<?php echo $k ?>" class="popup-colorpicker"/>
                                                    </span>

                                                <?php break; }
                                                case 'icon_list' : {
                                                    $class= "span12";

                                                    if ( isset($param['admin_class'] ) ) $class = $param['admin_class'];?>

                                                    <span class="<?php echo $class; ?>" >
                                                        <label for="<?php echo $k ?>"><?php echo $param['name'] ?></label>
                                                        <ul class="pxg_icon_list">
                                                            <input type="hidden" name="<?php echo $k ?>" class="selected_icon"/>
                                                            <?php foreach ($param["icons"] as $icon) { ?>
                                                                <li class="icon" data-icon="<?php echo $icon; ?>"><i class="icon-<?php echo $icon; ?>"></i></li>
                                                            <?php } ?>
                                                        </ul>
                                                    </span>

                                                <?php break; }
                                                case 'image' : {
                                                    $class= "span12";
                                                    if ( isset($param['admin_class'] ) ) $class = $param['admin_class']; ?>

                                                    <span class="<?php echo $class; ?>"  >
                                                        <label for="<?php echo $k ?>"><?php echo $param['name'] ?></label>
                                                        <div class="media_image_holder" >
                                                            <i class="icon-camera" style=""></i>
                                                            <input type="hidden" class="media_image_input" name="<?php echo $k ?>" />
                                                            <img class="upload_preview" />
                                                            <i class="icon-edit" ></i>
                                                        </div>
                                                    </span>

                                                <?php break; }
                                                case 'slider' : {
                                                    $class= "span12";

                                                    if ( isset($param['admin_class'] ) ) $class = $param['admin_class']; ?>

                                                    <div class="wpgrade_grid_row <?php echo $class; ?>" >
                                                        <label for="<?php echo $k ?>"><?php echo $param['name'] ?></label>
                                                        <ul class="ruler">
                                                            <li class="fixed active" data-name="handler-0">0</li>
                                                            <li>1</li>
                                                            <li>2</li>
                                                            <li>3</li>
                                                            <li class="active" data-name="handler-1">4</li>
                                                            <li>5</li>
                                                            <li>6</li>
                                                            <li>7</li>
                                                            <li class="active" data-name="handler-2">8</li>
                                                            <li>9</li>
                                                            <li>10</li>
                                                            <li>11</li>
                                                            <li class="active" data-name="handler-3">12</li>
                                                        </ul>

                                                        <ul type="<?php echo $param['type'] ?>" name="<?php echo $k ?>" <?php echo $is_content ?> class="grid_cols_slider" >
                                                        </ul>

                                                        <ul class="grid_cols_dimensions grid_full"></ul>
                                                        <ul class="grid_cols_content grid_full"></ul>

                                                    </div>

                                                    <?php break; }
                                                    }
                                                } ?>

                                        <button type="submit" class="btn hidden">Submit</button>
                                    </div>
                                    </fieldset>
                                </form>

                                <div id="data_params" type="hidden" data-params='<?php echo $shortcode_js; ?>' />
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="l_modal_footer">
            <a class="btn btn_secondary close">Cancel</a>
            <span>or</span>
            <a class="btn btn_primary disabled">Insert</a>
        </div>
    </div>