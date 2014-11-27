<?php

/*
	This adds a setting to the "writing" page
	The setting's called "Template Directory"
	It should point to where the templates for posts are
 */

	add_action('admin_init', 'maq_add_settings_page');
	function maq_add_settings_page () {
		add_settings_section(
			'make_a_query',
			'Make A Query',
			'maq_add_settings_page_callback',
			'writing'
		);
		register_setting('writing', 'make_a_query_templates_directory');
		add_settings_field(
			'make_a_query_templates_directory',
			'Templates Directory',
			'maq_add_setting_templates_directory_callback',
			'writing',
			'make_a_query'
		);
	}

	function maq_add_settings_page_callback () {
		echo '<p>"Template Directory" requires a trailing slash</p>';
	}

	function maq_add_setting_templates_directory_callback () {
		echo '<input '.
			'name="make_a_query_templates_directory" '.
			'id="make_a_query_templates_directory" '.
			'class="regular-text ltr" '.
			'value="' . get_option('make_a_query_templates_directory') . '" '.
			'type="text" >';
	}