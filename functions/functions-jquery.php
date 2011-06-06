<?php
/**************************************************************
INTIATE JQUERY SETUP
FUNCTION IS CALLED IN PARENT THEME
 **************************************************************/
function init_jquery()
{
    #add_action('init', 'init_jquery_google');
    add_action('init', 'init_jquery_local');
    add_action('init', 'register_jquery_plugins');
    add_action('template_redirect', 'enqueue_jquery_plugins');
}


/**************************************************************
USE GOOGLE'S JQUERY SCRIPT
 **************************************************************/
function init_jquery_google()
{
    if (!is_admin()):
        wp_deregister_script('jquery');
        wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js', false, 1.4);
    endif;
}


/**************************************************************
USE LOCAL JQUERY SCRIPT
 **************************************************************/
function init_jquery_local()
{
    if (!is_admin()):
        $src = get_stylesheet_directory_uri();
        wp_deregister_script('jquery');
        wp_register_script('jquery', $src . '/js/jquery142.min.js', false, 1.4);
    endif;
}


/**************************************************************
[PG] REGISTER SCRIPTS
 **************************************************************/
function register_jquery_plugins()
{
    $src = get_stylesheet_directory_uri();

    wp_register_script('hoverintent', $src . "/js/jquery.hoverIntent.js", false, '5', false);
    wp_register_script('mousewheel', $src . "/js/jquery.mousewheel.js", false, '3.0.4', false);
    wp_register_script('easing', $src . "/js/jquery.easing.1.2.js", false, '1.1.2', false);
}


/**************************************************************
ENQUEUE SCRIPTS BY DEFAULT
PARENT THEME WILL CALL THIS FUNCTION VIA ADD_ACTION
 **************************************************************/
function enqueue_jquery_plugins()
{
    global $wp_scripts, $post;

    #	LOAD JQUERY
    wp_enqueue_script('jquery');

    #	INTERFACE BEHAVIORS - DEPENDANCIES
    use_wp_enqueue('hoverintent', true);
    use_wp_enqueue('mousewheel', false);
    use_wp_enqueue('easing', false);

    $load = false;
    use_wp_enqueue('nivoslider', $load);

}


/**************************************************************
COMMENT REPLY ENQUEUE
 **************************************************************/
function comment_reply_queue_js()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
            wp_enqueue_script('comment-reply');
    }
}

add_action('get_header', 'comment_reply_queue_js');

?>