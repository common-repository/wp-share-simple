<?php
/**
 * WP share simple Admin Options File
 */

function wp_share_simple_admin_page() {
add_options_page('WP Share Simple', 'WP Share Simple', 'manage_options', 'wp_share_simple', 'wp_share_simple_options_page');
}
add_action('admin_menu', 'wp_share_simple_admin_page');

function wp_share_simple_options_page () {
    ?>
    <div class="wrap">
     <form action="options.php" method="post">
               <?php settings_fields('wp_share_simple_options'); ?>
               <?php do_settings_sections('wp_share_simple'); ?>
         <input name="Submit" id="submit" class="button button-primary" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
     </form>
    </div>
    <?php
}

function wp_share_simple_admin_init(){
//register setting
register_setting( 'wp_share_simple_options', 'wp_share_simple_options');
// Add section
add_settings_section('wp_share_simple_main', 'Wp Share Simple Settings', 'wp_share_simple_dummy_text', 'wp_share_simple');

add_settings_field('wp_share_simple_active_plugin', 'Activate Simple Share Buttons', 'wp_share_simple_active_plugin', 'wp_share_simple', 'wp_share_simple_main');
// Add field to it
add_settings_field('wp_share_simple_button_option', 'Buttons Display Option', 'wp_share_simple_button_option', 'wp_share_simple', 'wp_share_simple_main');
// Share count Color
add_settings_field('wp_share_simple_count_color', 'Share Count Color', 'wp_share_simple_count_color', 'wp_share_simple', 'wp_share_simple_main');
// Style options
add_settings_field('wp_share_simple_style_option', 'Share Button Style', 'wp_share_simple_style_option', 'wp_share_simple', 'wp_share_simple_main');
//wp_share_simple_button_text

add_settings_field('wp_share_simple_button_text', 'Button Text', 'wp_share_simple_button_text', 'wp_share_simple', 'wp_share_simple_main');
}

add_action('admin_init', 'wp_share_simple_admin_init');

function wp_share_simple_dummy_text() {
  echo '';
}
function wp_share_simple_active_plugin() {
	$options = get_option('wp_share_simple_options');
	

	$activation = '';
	 
	if(isset($options['activate_plugin'])) {
		$activation = $options['activate_plugin'];
	}
	

	if($activation == 'on') {
		$html = '<input type="checkbox" id="wp_share_simple_activate_plugin" name=wp_share_simple_options[activate_plugin] '
				.  'checked />' ;
	}
	else {
		$html = '<input type="checkbox" id="wp_share_simple_activate_plugin" name=wp_share_simple_options[activate_plugin] '
				.  ' />' ;
	}
	echo $html;


}
function wp_share_simple_style_option() {
	$options = get_option('wp_share_simple_options');
	$style =  $options ? $options['style_option'] : 'style_1';

	if($style == null || $style=='') {
		$style = 'style_1';
	}

	$html = '';
	// If style 1 checked
	if($style == 'style_1') {
		$html .= '<input type="radio" id="wp_share_simple_style_1" name=wp_share_simple_options[style_option] value="style_1"'
				.  'checked />' ;
	}
	else {
		$html .= '<input type="radio" id="wp_share_simple_style_1" name=wp_share_simple_options[style_option] value="style_1"'
				.  ' />' ;
	}
	$html .= '<label for="wp_share_simple_style_1">Raised </label><br>';


	// If style 2 checked
    if($style == 'style_2') {
		$html .= '<input type="radio" id="wp_share_simple_style_2" name=wp_share_simple_options[style_option] value="style_2"'
			  . 'checked />';
	}
	else {
		$html .= '<input type="radio" id="wp_share_simple_style_2" name=wp_share_simple_options[style_option] value="style_2"'
			  . ' />';
	}
	$html .= '<label for="wp_share_simple_style_2">Flat Buttons</label>';
	
	
	
	echo $html;
}


function  wp_share_simple_button_text() {
	$options = get_option('wp_share_simple_options');
	$fb_text = "";
	$tw_text = "";
	if($options) {
		if(isset($options['fb_text'])) {
			$fb_text = $options['fb_text'];
		}
		
		if(isset($options['tw_text'])) {
			$tw_text = $options['tw_text'];
		}
		
	}
	
	$html = '<input type="text" id="wp_share_simple_fb_text" value="'.$fb_text.'" name=wp_share_simple_options[fb_text] value="" placeholder="Share on facebook" /><br>';
	
	$html .= '<input type="text" id="wp_share_simple_tw_text"  value="'.$tw_text.'" name=wp_share_simple_options[tw_text] value="" placeholder="Tweet on twitter" />';

	echo $html;
}

function wp_share_simple_count_color() {
    $options = get_option('wp_share_simple_options');
    $val =  $options != null ? $options['count_color'] : '#999';

    if($val == null || $val=='')
    {
        $val = '#999';
    }

    echo "<input type='text' id='wp_share_simple_count_color' name='wp_share_simple_options[count_color]' value='$val'/>";

}

// one of the plugin field.
function wp_share_simple_button_option () {
    $options = get_option('wp_share_simple_options');
    $val =  $options != null ? $options['display_option'] : 'both';
    if($val == null or $val =='')
    {
        // Default display
        $val = 'both';
    }

    $optionManual = $val == 'manual' ? "<option value = 'manual' selected>Manual</option>" : "<option value = 'manual'>Manual</option>";
    $optionTop    = $val == 'top' ? "<option value = 'top' selected>Top Only</option>":"  <option value = 'top'>Top Only</option>";
    $optionBottom = $val == 'bottom' ? "<option value = 'bottom' selected> Bottom Only</option>" :"<option value = 'bottom'> Bottom Only</option>";
    $optionBoth   = $val == 'both' ? "<option value = 'both' selected>Top & Bottom </option>":"<option value = 'both'>Top & Bottom </option>";

    echo "<select id = 'wp_share_simple_button_option' name='wp_share_simple_options[display_option]'>";
    echo $optionManual.$optionTop.$optionBottom.$optionBoth;	
    echo '</select><span style="padding:10px;"><i> Chose manual for shortcode</i>: <b> [wp_share_simple color="#999"]</b></span>';
}
?>