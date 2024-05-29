<?php
// Shortcode implementations
add_shortcode('gvar', 'gvar_shortcode');

// Shortcode for displaying global variables
function gvar_shortcode($atts) {
	$atts = shortcode_atts(array(
		'title' => '',
		'format' => 'value', // 'label', 'value', or 'type'
	), $atts, 'gvar');

	// Sanitize the title
	$sanitized_title = sanitize_title_for_shortcode($atts['title']);

	if (empty($sanitized_title)) {
		return ''; // Title not provided or invalid
	}

	$global_variables = get_option('global_variables');
	foreach ($global_variables as $variable) {
		if (isset($variable['label']) && sanitize_title_for_shortcode($variable['label']) === $sanitized_title) {
			switch ($atts['format']) {
				case 'label':
					return isset($variable['label']) ? $variable['label'] : '';
				case 'type':
					return isset($variable['type']) ? $variable['type'] : '';
				case 'value':
				default:
					return isset($variable['value']) ? $variable['value'] : '';
			}
		}
	}

	return ''; // Variable not found
}