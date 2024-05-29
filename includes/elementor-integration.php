<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
/**
 * Register Request Variables Dynamic Tag Group.
 *
 * Register new dynamic tag group for Global Variables.
 *
 * @since 1.0.0
 * @param \Elementor\Core\DynamicTags\Manager $dynamic_tags_manager Elementor dynamic tags manager.
 * @return void
 */
function register_global_variables_dynamic_tag_group( $dynamic_tags_manager ) {

    $dynamic_tags_manager->register_group(
        'global-variables',
        [
            'title' => esc_html__( 'Global Variables', 'textdomain' )
        ]
    );

}
add_action( 'elementor/dynamic_tags/register', 'register_global_variables_dynamic_tag_group' );

/**
 * Register Global Variable Dynamic Tag.
 *
 * Include dynamic tag file and register tag class.
 *
 * @since 1.0.0
 * @param \Elementor\Core\DynamicTags\Manager $dynamic_tags_manager Elementor dynamic tags manager.
 * @return void
 */
function register_global_variable_dynamic_tag( $dynamic_tags_manager ) {

    require_once( plugin_dir_path(__FILE__) . 'dynamic-tags/global-variables-tag.php' );

    $dynamic_tags_manager->register( new \Elementor_Dynamic_Tag_Global_Variable );

}
add_action( 'elementor/dynamic_tags/register', 'register_global_variable_dynamic_tag' );
