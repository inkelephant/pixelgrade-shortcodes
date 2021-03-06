editor = '';
(function($) {

    $(document).ready(function(){

        $('body').append('<div id="pixelgrade_shortcodes_modal"  class="reveal-modal l_pxg_modal">');

        var modal_selector = $('#pixelgrade_shortcodes_modal'),
            plugin_url;

        $.ajax({
            url: ajaxurl,
            data: {action: 'wpgrade_get_shortcodes_modal'},
            success: function(data){
                content = JSON.parse(data);
                modal_selector.html(content);
                //Variables
                var details = $('.details_container .details_content');
                var modal_title = $('.l_pxg_modal .l_modal_title');
                var default_title = modal_title.html();
                var triggered_woman = '';

                // fix on close
                $(document).on('reveal:close', '#pixelgrade_shortcodes_modal', function(){
                    toggle_details();
                    $('button.back').removeClass('active');
                    toggle_submit_btn();
                    change_title(default_title);
                    clean_details();
                    window.send_to_editor = window.send_to_editor_clone;
                });

                //Back Button Click
                $(document).on('click', '.l_modal_header button.back', function() {
                    toggle_details();
                    toggle_back_btn();
                    toggle_submit_btn();
                    change_title(default_title);
                    clean_details();
                });

                //Choose an item
                $(document).on('click', '.l_three_col li.shortcode a.details', function() {

                    // get the current selection and set it as content
                    var current_editor = get_current_editor_selected_content(),
                        content_field = $(this).next().find('.is_shortcode_content');

                    if ( content_field.attr('type') == 'text' ){
                        content_field.attr('value', current_editor.selection.getContent());
                    } else if ( content_field.attr('type') == 'textarea' ) {
                        content_field.text( current_editor.selection.getContent() );
                    }

                    var html_container = $(this).next().html(),
                        item_title = $(this).find('.title').html();

                    fill_details(html_container);
                    toggle_details();
                    toggle_back_btn();
                    toggle_submit_btn();
                    change_title('<span>Insert</span> '+item_title+' <span>Shortcode:</span>');

                    triggered_woman = details.find('button[type="submit"]');

                    details.trigger($(this).data('trigger-open'));
                });

                //Trigger Submit Button (need few improvements :)
                $(document).on('click', ".l_pxg_modal a.btn_primary", function() {
                    trigger_submit_btn(triggered_woman);
                });

                //Show the .details_container - display:block
                var toggle_details = function () {
                    $('.l_pxg_modal').toggleClass('s_active');
                }

                //Add html content from chosen shortcode into $details container
                var fill_details = function ($content) {
                    clean_details();
                    details.html($content).addClass('active');
                }

                //Change modal title
                var change_title = function ($title) {
                    modal_title.html($title);
                }

                //Empty details content
                var clean_details = function () {
                    details.html('').removeClass('active');
                }

                //Toggle Back button visibility
                var toggle_back_btn = function () {
                    $('button.back').toggleClass('active');
                }

                //Toggle Submit button
                var toggle_submit_btn = function () {
                    $('.l_pxg_modal .btn_primary').toggleClass('disabled');
                }

                //Trigger Submit button
                var trigger_submit_btn = function ($button) {
                    $button.trigger('click');
                }
                $(document).trigger('shortcodes_modal:ready');
            } // end of ajax success
        });

        tinymce.create('tinymce.plugins.wpgrade', {
            init : function(ed, url) {
                plugin_url = url;
                ed.addButton('wpgrade', {
                    title : 'Add a wpgrade',
                    class: 'pixelgrade_shortcodes',
                    onclick: function(){
                        modal_selector.reveal({
                            animation: 'fadeAndPop',                   //fade, fadeAndPop, none
                            animationspeed: 300,                       //how fast animtions are
                            closeonbackgroundclick: true,              //if you click background will modal close?
                            dismissmodalclass: 'close'    //the class of a button or element that will close an open modal
                        });
                        editor = ed;
                        get_current_editor_selected_content = function(){
                            return editor;
                        }
                        window.send_to_editor_clone = window.send_to_editor;
                    }
                });
            }
        });
        tinymce.PluginManager.add('wpgrade', tinymce.plugins.wpgrade);

        // if the shortcode doesn't have params it needs to be inserted directly
        modal_selector.on('click', '.insert-direct-shortcode', function(){

            var params = $(this).data('params');
            if ( params.self_closed ) {
                editor.selection.setContent('['+params.code+']');
            } else {
                editor.selection.setContent('['+params.code+' ]'+ editor.selection.getContent() +'[/'+params.code+']');
            }
            // close the modal whenever a shortcode is inserted
            modal_selector.trigger('reveal:close');
        });

        // when submiting a panel of params
        $(document).on('submit', '#wpgrade_shortcodes_form', function(e){
            e.preventDefault();

            var params = $(this).next('#data_params').data('params'),
                form_params =  $(this).serializeShortcodeParams(),
                user_params_string = '',
                user_params = {},
                shortcode_content = '';

            $.each( form_params, function(i,e){

                if (e.class == 'is_shortcode_content') {

                    shortcode_content = e.value;

                } else if ( e.value !== '' ) { // don't include the empty params and the content param

                    user_params_string += ' '+ e.name + '="'+ e.value+'"';
                    user_params[e.name] = e.value;
                }
            });

            if ( params.self_closed ) {
                editor.selection.setContent('['+params.code+user_params_string+']');
            } else {
                editor.selection.setContent('['+params.code+user_params_string+']<br class="pxg_removable" />'+ shortcode_content +'<br class="pxg_removable" />[/'+params.code+']');
            }

            modal_selector.trigger('reveal:close');
        }); // end of submit form

        $(document).on('click', '.media_image_holder', function(){
            var $self = $(this);

            tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
            formfield = $('#upload_image').attr('name');

            window.send_to_editor = function(html) {
                imgurl = $('img',html).attr('src');
                $self.find('.media_image_input').val(imgurl);
                $self.find('.upload_preview').attr('src',imgurl).show().next().toggleClass('active');
                tb_remove();
            }

            return false;
        });

    });


    $.fn.serializeShortcodeParams = function(){
        var return_els = {},
            elements = $(this).find('[name]');

        $.each(elements, function(i,el){
            return_els[i] = {};
            return_els[i].name = this.name;
            return_els[i].value = $(this).val();

            // init the class as false
            return_els[i].class = false;
            if ( $(this).attr('class') ) return_els[i].class = $(this).attr('class');
        });

        return return_els;
    };

    /*
     * jQuery Reveal Plugin 1.0
     * www.ZURB.com
     * Copyright 2010, ZURB
     * Free to use under the MIT license.
     * http://www.opensource.org/licenses/mit-license.php
     */
    $.fn.reveal=function(e){var t={animation:"fadeAndPop",animationspeed:300,closeonbackgroundclick:true,dismissmodalclass:"close-reveal-modal"};var e=$.extend({},t,e);return this.each(function(){function u(){i=false}function a(){i=true}var t=$(this),n=parseInt(t.css("top")),r=t.height()+n,i=false,s=$(".reveal-modal-bg");if(s.length==0){s=$('<div class="reveal-modal-bg" />').insertAfter(t)}t.bind("reveal:open",function(){s.unbind("click.modalEvent");$("."+e.dismissmodalclass).unbind("click.modalEvent");if(!i){a();if(e.animation=="fadeAndPop"){t.css({top:$(document).scrollTop()-r,opacity:0,visibility:"visible"});s.fadeIn(e.animationspeed/2);t.delay(e.animationspeed/2).animate({top:$(document).scrollTop()+n+"px",opacity:1},e.animationspeed,u())}if(e.animation=="fade"){t.css({opacity:0,visibility:"visible",top:$(document).scrollTop()+n});s.fadeIn(e.animationspeed/2);t.delay(e.animationspeed/2).animate({opacity:1},e.animationspeed,u())}if(e.animation=="none"){t.css({visibility:"visible",top:$(document).scrollTop()+n});s.css({display:"block"});u()}}t.unbind("reveal:open")});t.bind("reveal:close",function(){if(!i){a();if(e.animation=="fadeAndPop"){s.delay(e.animationspeed).fadeOut(e.animationspeed);t.animate({top:$(document).scrollTop()-r+"px",opacity:0},e.animationspeed/2,function(){t.css({top:n,opacity:1,visibility:"hidden"});u()})}if(e.animation=="fade"){s.delay(e.animationspeed).fadeOut(e.animationspeed);t.animate({opacity:0},e.animationspeed,function(){t.css({opacity:1,visibility:"hidden",top:n});u()})}if(e.animation=="none"){t.css({visibility:"hidden",top:n});s.css({display:"none"})}}t.unbind("reveal:close")});t.trigger("reveal:open");var o=$("."+e.dismissmodalclass).bind("click.modalEvent",function(){t.trigger("reveal:close")});if(e.closeonbackgroundclick){s.css({cursor:"pointer"});s.bind("click.modalEvent",function(){t.trigger("reveal:close")})}$("body").keyup(function(e){if(e.which===27){t.trigger("reveal:close")}})})}

})(jQuery);