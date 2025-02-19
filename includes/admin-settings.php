<?php
// Admin menu and settings registration
add_action('admin_menu', 'custom_options_menu');
add_action('admin_init', 'custom_options_init');

// Enqueue the options JS
function enqueue_custom_admin_js() {
    wp_enqueue_script('custom-options-js', plugin_dir_url(__FILE__) . 'js/custom-options.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_js');

// Add menu page
function custom_options_menu() {
    add_menu_page('Global Variables', 'Global Variables', 'manage_options', 'custom-options', 'custom_options_page');
}

// Initialize settings
function custom_options_init() {
    register_setting('custom_options_group', 'global_variables', 'validate_global_variables');
    add_settings_section('custom_options_section', 'Global Variables', 'custom_options_section_callback', 'custom-options');
    add_settings_field('global_variables', 'Global Variables', 'global_variables_callback', 'custom-options', 'custom_options_section');
}

// Callback for custom options section
function custom_options_section_callback() {
    echo '<p class="intro-box">For best practices keep the names of your variables short, as the name is used for shortcode. For example, a variable called <strong>phone</strong> produces shortcode <strong>[gvar title="phone"]</strong>. Once set, variable names cannot be changed to prevent breaking existing references. The plugin integrates with Elementor and Bricks Dynamic Tags and Data</p>';
    echo '<p>Add your global variables below:</p>';
}

// Callback for global variables field
function global_variables_callback() {
    $global_variables = get_option('global_variables', array());
    
    echo '<div id="global-variables-container">';
        echo '<div class="global-variable">';
        echo '<label for="variable-label">Name <span class="required">*</span></label>';
        echo '<label for="variable-type">Data Type</label>';
        echo '<label for="variable-value">Value</label>';
        echo '<label for="variable-shortcode">Shortcode</label>';
        echo '</div>';
        
        foreach ($global_variables as $index => $variable) {
            $readonly = isset($variable['saved']) ? 'readonly' : '';
            echo '<div class="global-variable">';
            echo '<input type="text" name="global_variables[' . $index . '][label]" value="' . esc_attr($variable['label']) . '" placeholder="Variable Name" ' . $readonly . ' />';
            echo '<select name="global_variables[' . $index . '][type]">';
            echo '<option value="text" ' . selected($variable['type'], 'text', false) . '>Text String</option>';
            echo '<option value="email" ' . selected($variable['type'], 'email', false) . '>Email</option>';
            echo '<option value="url" ' . selected($variable['type'], 'url', false) . '>URL</option>';
            echo '</select>';
            echo '<input type="text" name="global_variables[' . $index . '][value]" value="' . esc_attr($variable['value']) . '" placeholder="Value" />';
            $title = sanitize_title($variable['label']);
            echo '<div class="shortcode-wrap">';
            echo '<input type="text" class="shortcode-display" value="[gvar title=&quot;' . $title . '&quot;]" readonly />';
            echo '<button class="copy-shortcode"><img src="'. plugin_dir_url(__DIR__) . 'images/copy.svg" /></button><div id="copied-popup" class="copied-popup">Copied!</div>';
            echo '</div>';
            echo '<button class="remove-variable"><img src="'. plugin_dir_url(__DIR__) . 'images/remove.svg" /></button>';
            echo '</div>';
        }
        echo '</div>';
        
        echo '<button id="add-variable" class="button">Add Variable</button>';
    }

// Validate Global Variables
function validate_global_variables($input) {
    $valid = array();
    
    foreach ($input as $key => $variable) {
        $valid[$key]['label'] = sanitize_text_field($variable['label']);
        
        if ($variable['type'] == 'email') {
            if (!is_email($variable['value'])) {
                add_settings_error('global_variables', 'invalid_email', 'Invalid email address');
            } else {
                $valid[$key]['value'] = sanitize_email($variable['value']);
            }
        } elseif ($variable['type'] == 'url') {
            if (!filter_var($variable['value'], FILTER_VALIDATE_URL)) {
                add_settings_error('global_variables', 'invalid_url', 'Invalid URL');
            } else {
                $valid[$key]['value'] = esc_url_raw($variable['value']);
            }
        } else {
            $valid[$key]['value'] = sanitize_text_field($variable['value']);
        }
        
        $valid[$key]['type'] = $variable['type'];
    }
    
    return $valid;
}

// Callback for the options page
function custom_options_page() {
    ?>
    <div class="wrap cv-wrap">
        <form method="post" action="options.php">
            <?php
            settings_fields('custom_options_group');
            do_settings_sections('custom-options');
            wp_nonce_field('custom_options_nonce', 'custom_options_nonce');
            submit_button('Save Global Variables');
            ?>
        </form>
    </div> 
    <?php
}