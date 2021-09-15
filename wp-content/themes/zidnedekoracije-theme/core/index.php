<?php 
/**
 * Custom functions for this theme.
 */
require get_template_directory() . '/core/functions.php';

/**
 * Custom filters and actions for this theme.
 */
require get_template_directory() . '/core/filters_actions.php';

/**
 * Custom shortcodes for this theme.
 */
require get_template_directory() . '/core/shortcodes.php';

/**
 * Implement the Custom customizer functions.
 */
require get_template_directory() . '/core/customizer/index.php';

/**
 * Register CPT's automatically.
 */
require get_template_directory() . '/includes/cpt/index.php';
?>