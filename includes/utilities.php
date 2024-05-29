<?php
// Utility functions like sanitization
function sanitize_title_for_shortcode($title) {
    // Sanitization code
	// Remove non-alphanumeric characters and spaces
	$title = preg_replace('/[^a-zA-Z0-9]/', '', $title);
	
	// Convert to lowercase
	$title = strtolower($title);

	return $title;
}