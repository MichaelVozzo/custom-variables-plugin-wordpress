<?php
// Admin menu and settings registration
add_action('admin_menu', 'custom_options_menu');
add_action('admin_init', 'custom_options_init');

// Add menu page
add_action('admin_menu', 'custom_options_menu');

//Enqueue the options JS
function enqueue_custom_admin_js() {
    wp_enqueue_script('custom-options-js', plugin_dir_url(__FILE__) . '/js/custom-options.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_js');

function custom_options_menu() {
	add_menu_page('Global Variables', 'Global Variables', 'manage_options', 'custom-options', 'custom_options_page');
}

// Initialize settings
add_action('admin_init', 'custom_options_init');

// Callback for custom options section
function custom_options_section_callback() {
	echo '<p>Add your global variables below:</p>';
}

function custom_options_init() {
	register_setting('custom_options_group', 'global_variables');
	add_settings_section('custom_options_section', 'Global Variables', 'custom_options_section_callback', 'custom-options');
	add_settings_field('global_variables', 'Global Variables', 'global_variables_callback', 'custom-options', 'custom_options_section');
}

// Callback for global variables field
function global_variables_callback() {
    $global_variables = get_option('global_variables');
    if (!$global_variables) {
        $global_variables = array();
    }
    
    echo '<div id="global-variables-container">';
    echo '<div class="global-variable">';
    echo '<label for="variable-label">Name</label>';
    echo '<label for="variable-type">Data Type</label>';
    echo '<label for="variable-value">Value</label>';
    echo '<label for="variable-shortcode">Shortcode</label>';
    echo '</div>';
    
    foreach ($global_variables as $index => $variable) {
        echo '<div class="global-variable">';
        echo '<input type="text" id="variable-label" name="global_variables[' . $index . '][label]" value="' . esc_attr($variable['label']) . '" placeholder="Label" />';
        echo '<select id="variable-type" name="global_variables[' . $index . '][type]">';
        echo '<option value="text" ' . selected($variable['type'], 'text', false) . '>Text String</option>';
        echo '<option value="email" ' . selected($variable['type'], 'email', false) . '>Email</option>';
        echo '<option value="url" ' . selected($variable['type'], 'url', false) . '>URL</option>';
        echo '</select>';
        echo '<input type="text" id="variable-value" name="global_variables[' . $index . '][value]" value="' . esc_attr($variable['value']) . '" placeholder="Value" />';
        $title = sanitize_title($variable['label']);
        echo '<div class="shortcode-wrap">';
        echo '<input type="text" id="variable-shortcode" class="shortcode-display" value="[gvar title=&quot;' . $title . '&quot;]" readonly />';
            echo '<button class="copy-shortcode"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 115.77 122.88" style="enable-background:new 0 0 115.77 122.88" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class="st0" d="M89.62,13.96v7.73h12.19h0.01v0.02c3.85,0.01,7.34,1.57,9.86,4.1c2.5,2.51,4.06,5.98,4.07,9.82h0.02v0.02 v73.27v0.01h-0.02c-0.01,3.84-1.57,7.33-4.1,9.86c-2.51,2.5-5.98,4.06-9.82,4.07v0.02h-0.02h-61.7H40.1v-0.02 c-3.84-0.01-7.34-1.57-9.86-4.1c-2.5-2.51-4.06-5.98-4.07-9.82h-0.02v-0.02V92.51H13.96h-0.01v-0.02c-3.84-0.01-7.34-1.57-9.86-4.1 c-2.5-2.51-4.06-5.98-4.07-9.82H0v-0.02V13.96v-0.01h0.02c0.01-3.85,1.58-7.34,4.1-9.86c2.51-2.5,5.98-4.06,9.82-4.07V0h0.02h61.7 h0.01v0.02c3.85,0.01,7.34,1.57,9.86,4.1c2.5,2.51,4.06,5.98,4.07,9.82h0.02V13.96L89.62,13.96z M79.04,21.69v-7.73v-0.02h0.02 c0-0.91-0.39-1.75-1.01-2.37c-0.61-0.61-1.46-1-2.37-1v0.02h-0.01h-61.7h-0.02v-0.02c-0.91,0-1.75,0.39-2.37,1.01 c-0.61,0.61-1,1.46-1,2.37h0.02v0.01v64.59v0.02h-0.02c0,0.91,0.39,1.75,1.01,2.37c0.61,0.61,1.46,1,2.37,1v-0.02h0.01h12.19V35.65 v-0.01h0.02c0.01-3.85,1.58-7.34,4.1-9.86c2.51-2.5,5.98-4.06,9.82-4.07v-0.02h0.02H79.04L79.04,21.69z M105.18,108.92V35.65v-0.02 h0.02c0-0.91-0.39-1.75-1.01-2.37c-0.61-0.61-1.46-1-2.37-1v0.02h-0.01h-61.7h-0.02v-0.02c-0.91,0-1.75,0.39-2.37,1.01 c-0.61,0.61-1,1.46-1,2.37h0.02v0.01v73.27v0.02h-0.02c0,0.91,0.39,1.75,1.01,2.37c0.61,0.61,1.46,1,2.37,1v-0.02h0.01h61.7h0.02 v0.02c0.91,0,1.75-0.39,2.37-1.01c0.61-0.61,1-1.46,1-2.37h-0.02V108.92L105.18,108.92z"/></g></svg></button>';
            echo '</div>';
            echo '<button class="remove-variable"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 122.88" style="enable-background:new 0 0 122.88 122.88" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class="st0" d="M1.63,97.99l36.55-36.55L1.63,24.89c-2.17-2.17-2.17-5.73,0-7.9L16.99,1.63c2.17-2.17,5.73-2.17,7.9,0 l36.55,36.55L97.99,1.63c2.17-2.17,5.73-2.17,7.9,0l15.36,15.36c2.17,2.17,2.17,5.73,0,7.9L84.7,61.44l36.55,36.55 c2.17,2.17,2.17,5.73,0,7.9l-15.36,15.36c-2.17,2.17-5.73,2.17-7.9,0L61.44,84.7l-36.55,36.55c-2.17,2.17-5.73,2.17-7.9,0 L1.63,105.89C-0.54,103.72-0.54,100.16,1.63,97.99L1.63,97.99z"/></g></svg></button>';
            echo '</div>';
        }
        echo '</div>';
    
        echo '<button id="add-variable" class="button">Add Variable</button>';
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