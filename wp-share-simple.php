<?php
/**
 * Plugin Name: WP Share Simple
 * Description: A simple plugin to show the social shared count
 * Version: 1.3
 * Author: Vamsi Mannem
 */
defined('ABSPATH') or exit;
include_once 'wp-share-admin.php';
add_filter( 'the_content', 'wp_share_simple_content_filter', 20 );
/**
 * Add content to the begining of the post
 */
function wp_share_simple_content_filter( $content ) {
    global $post;
    $url = get_permalink($post->ID);
    $title = get_the_title($post->ID);

    if ( is_single() ){
        $options = get_option('wp_share_simple_options');
        
        if($options)
        {
             $val =  $options['display_option'];
             $colr = $options['count_color'];
             
             
             $activation = '';
             
             if(isset($options['activate_plugin'])) {
             	$activation = $options['activate_plugin'];
             }
             
             
             $str = '';
    $str .='<style>.wp-share-simple-count { color:'.$colr.';}</style><div class="wp-share-simple" data-url="'.$url.'" data-text="'.$title.'"';

             if(strlen($colr) > 0) {
                 $str .= ' data-countcolor ="'.$colr.'"';
             }
           $str .= '></div>';

           if($activation == 'on') {
           		if('manual' == $val)
           		{
           		// Do nothing // Option for v1.1
           		}
           		else if ('top' == $val)
           		{
           			$content = $str.$content;
           		}
           		else if ('bottom' == $val)
           		{
           			$content = $content.$str;
          	 	}
           		else if ('both' == $val){
           			$content = $str.$content.$str;
           		}
           		else {
           		// Default returns plain content

           		}
           }
        }
    }
    return $content;
}
// Adds required scripts and css to the plugin
function wp_share_simple_script() {
	wp_enqueue_script(
		'wp-share-core',
		plugins_url( '/js/jquery.sharrre.min.js' , __FILE__ ),
		array( 'jquery' )
	);
	wp_enqueue_script(
		'wp-share-script',
		plugins_url( '/js/wp-share-simple.js' , __FILE__ ),
		array( 'jquery' )
	);

	$options = get_option('wp_share_simple_options');
	
	//echo ($options['style_option']);
	$style_option = '';
	if($options)
	{
		$style_option = $options['style_option'];
	}

	$fb_text = "" ;
	$tw_text = "";
	
	if (isset ( $options ['fb_text'] )) {
		$fb_text = $options ['fb_text'];
	}
	
	if (isset ( $options ['tw_text'] )) {
		$tw_text = $options ['tw_text'];
	}
	
	if($style_option == 'style_2') {
		// Register and enqueue style two

		wp_register_style('wp-share-simple-style', plugins_url('/css/wp-share-simple-2.css', __FILE__));
		wp_enqueue_style('wp-share-simple-style');
	}
	else {
		
		// Style option 1 and 3 
		// Register raised style

		wp_register_style('wp-share-simple-style', plugins_url('/css/wp-share-simple.css', __FILE__));
		wp_enqueue_style('wp-share-simple-style');
	}
	
	wp_localize_script( 'wp-share-script', 'wp_share_simple_object',
			array( 'fb_text' => $fb_text, 'tw_text'=>$tw_text) );


}

add_action( 'wp_enqueue_scripts', 'wp_share_simple_script' );


/* Shortcode option to render the code any where */
function wp_share_simple_shortcode( $atts ){
	$options = get_option('wp_share_simple_options');

	$activation = $options['activate_plugin'];
	$val =  $options['display_option'];
	if($activation == 'on' && 'manual' == $val ) {

		$a = shortcode_atts( array(
				'color' => '#999',
		), $atts );
		$colr = $a['color'];
		$str .='<style>.wp-share-simple-count { color:'.$colr.';}</style><div class="wp-share-simple" data-url="'.$url.'" data-text="'.$title.'"';

		if(strlen($colr) > 0) {
			$str .= ' data-countcolor ="'.$colr.'"';
		}
		$str .= '></div>';
		return $str;
	}
}
add_shortcode( 'wp_share_simple', 'wp_share_simple_shortcode' );

?>