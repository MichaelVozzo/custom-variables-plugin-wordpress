<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Step 1: Add Custom Tags to Bricks Builder
add_filter('bricks/dynamic_tags_list', 'add_custom_variable_tags_to_builder');
function add_custom_variable_tags_to_builder($tags) {
    $global_variables = get_option('global_variables', []);

    if (!is_array($global_variables)) {
        $global_variables = [];
    }

    foreach ($global_variables as $variable) {
        $tags[] = [
            'name'  => '{gvar_' . sanitize_title($variable['label']).'}',
            'label' => $variable['label'],
            'group' => 'Global Variables',
        ];
    }

    return $tags;
}

// Step 2: Render the Dynamic Data for the Custom Tags
add_filter('bricks/dynamic_data/render_tag', 'render_custom_variable_tags', 10, 3);
function render_custom_variable_tags($tag, $post, $context = 'text') {
    $global_variables = get_option('global_variables', []);

    if (!is_array($global_variables)) {
        $global_variables = [];
    }

    foreach ($global_variables as $variable) {
        $tag_name = '{gvar_' . sanitize_title($variable['label']).'}';
        
        if ($tag === $tag_name) {
            return $variable['value'];
        }
    }

    return $tag;
}

// Step 3: Render the Dynamic Tags in the Frontend Content
add_filter('bricks/dynamic_data/render_content', 'render_custom_variable_in_content', 10, 3);
add_filter('bricks/frontend/render_data', 'render_custom_variable_in_content', 10, 2);
function render_custom_variable_in_content($content, $post, $context = 'text') {
    $global_variables = get_option('global_variables', []);

    if (!is_array($global_variables)) {
        $global_variables = [];
    }

    foreach ($global_variables as $variable) {
        $tag = '{gvar_' . sanitize_title($variable['label']) . '}';
        $value = $variable['value'];

        $content = str_replace($tag, $value, $content);
    }

    return $content;
}
