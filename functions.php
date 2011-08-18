<?php
/**************************************************************
WELCOME TO THE FOUNDATION CHILD THEME TEMPLATE
--------------------------------------------------------------

THIS TEMPLATE WAS CREATED TO HELP FACILITATE THE
CREATION OF CHILD THEMES FOR
theFOUNDATION THEME FRAMEWORK

FOR INFORMATION ON HOW FILES ARE ORGANIZED
AND NAMING CONVENTIONS OF FUNCTIONS PLEASE
VISIT...

http://thefoundationthemes.com/
 **************************************************************/


/**
 *    DEFINE CONSTANTS AND UNIVERSAL VARS
 *
 * STYLESHEETPATH :: IS THE CHILD THEME PATH, IF NOT CHILD THEME THEN ITS THE PARENT THEME
 * TEMPLATEPATH :: IS THE PARENT THEME PATH
 *
 * @TODO figure out where the $data var is being set, if its a non-exsistent global var then remove it
 */
define('TEXTDOMAIN', 'thefdt');
define('THEMECUSTOMMETAKEY', '_fsl_media_options');
$content_width = $data['set_content_primary_width'];


/**
 * APPLY SHORT CODE AND AUTO EMBED FOR WIDGETS
 */
add_filter('widget_text', array($wp_embed, 'run_shortcode'), 8);
add_filter('widget_text', array($wp_embed, 'autoembed'), 8);


/**
 * INITIATE CUSTOM POST TYPE IF OPTION IS ENABALED
 *
 * theFOUNDATION THEME HAS A LIBRARY OF USEFUL CUSTOM POST TYPES THAT CAN BE USED AS BASE TO ROLL YOUR OWN
 * CUSTOM POST TYPE. JUST COPY THEM TO YOUR CHILD THEME AND THEY WILL OVER RIDE THE PARENT THEME
 *
 * @NOTE CUSTOM POST TYPES CAN BE ENABLED IN ADMIN > APPEARANCE > THEME OPTIONS MENU UNDER THE 'CUSTOM POST TYPE' TAB
 * @NOTE locate_template() does not work from the functions.php inside the child theme, rely on a hook placed in the parent theme
 */
function custom_post_type_init() {
    if (of_get_option('enable_custom_posttype_event', false) == true)
        locate_template('functions/post-type/post-type-event.php', true);
    if (of_get_option('enable_custom_posttype_portfolio', false) == true)
        locate_template('functions/post-type/post-type-portfolio.php', true);
    if (of_get_option('enable_custom_posttype_designer', false) == true)
        locate_template('functions/post-type/post-type-designer.php', true);
    if (of_get_option('enable_custom_posttype_swatch', false) == true)
        locate_template('functions/post-type/post-type-swatch.php', true);
    if (of_get_option('enable_custom_posttype_product', false) == true)
        locate_template('functions/post-type/post-type-product.php', true);
    if (of_get_option('enable_custom_posttype_post', false) == true)
        locate_template('functions/post-type/post-type-post.php', true);
    if (of_get_option('enable_custom_posttype_dictionary', false) == true)
        locate_template('functions/post-type/post-type-dictionary.php', true);
    if (of_get_option('enable_custom_posttype_lesson', false) == true)
        locate_template('functions/post-type/post-type-lesson.php', true);
    if (of_get_option('enable_custom_posttype_company', false) == true)
        locate_template('functions/post-type/post-type-company.php', true);
}
add_action( 'locate_custom_post_type', 'custom_post_type_init' );





/**
 * NICER EXCERPTS FOR THEME
 *
 * @param $text
 * @return string
 */
function improved_trim_excerpt($text)
{
    global $post;
    if ('' == $text) {
        $text = get_the_content('');
        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]&gt;', $text);
        $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
        $text = strip_tags($text, '<a><p><img>');
        $excerpt_length = 50;
        $words = explode(' ', $text, $excerpt_length + 1);
        if (count($words) > $excerpt_length) {
            array_pop($words);
            array_push($words, '[...]');
            $text = implode(' ', $words);
        }
    }
    return $text;
}

#remove_filter('get_the_excerpt', 'wp_trim_excerpt', 10);
#add_filter('get_the_excerpt', 'improved_trim_excerpt', 10);


/**
 * INCLUDE IMAGE IN RSS
 *
 * @param $content
 * @return string
 */
function rss_post_thumbnail($content)
{
    global $post;
    $featured_image = get_the_post_thumbnail($post->ID, 'medium', array('class' => 'alignleft'));

    if ($featured_image) :
        return "<p>" . $featured_image . "</p>";
    else :
        echo "<p>" . get_first_image($post->ID, 'thumbnail') . "</p>";
    endif;

    return $content;
}

add_filter('the_excerpt_rss', 'rss_post_thumbnail');
add_filter('the_content_feed', 'rss_post_thumbnail');




?>