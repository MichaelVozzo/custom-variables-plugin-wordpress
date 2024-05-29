<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Elementor_Dynamic_Tag_Global_Variable extends \Elementor\Core\DynamicTags\Tag {

	public function get_name() {
		return 'global-variable';
	}

	public function get_title() {
		return esc_html__('Custom Variable','textdomain');
	}

	public function get_group() {
		return 'global-variables';
	}

	public function get_categories() {
		return [ \Elementor\Modules\DynamicTags\Module::URL_CATEGORY,
			\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY,
			\Elementor\Modules\DynamicTags\Module::NUMBER_CATEGORY
			];
	}

	protected function _register_controls() {
		$this->add_control(
			'variable_name',
			[
				'label' => esc_html__( 'Variable Name', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->get_custom_variable_options(),
			]
		);
	}

	private function get_custom_variable_options() {
		$options = [];
		$variables = get_option('global_variables');
		if (!empty($variables)) {
			foreach ($variables as $variable) {
				$options[$variable['label']] = $variable['label'];
			}
		}
		return $options;
	}

	public function render() {
		$settings = $this->get_settings();
		$variable_name = $settings['variable_name'];
		$variables = get_option('global_variables');
		foreach ($variables as $variable) {
			if ($variable['label'] === $variable_name) {
				echo esc_html($variable['value']);
				break;
			}
		}
	}
}