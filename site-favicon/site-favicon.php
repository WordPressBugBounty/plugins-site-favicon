<?php
/*
Plugin Name: Site Favicon
Description: Add a favicon.
Version: 1.0
Requires at least: 5.0
Author: Web Guy
Author URI: https://webguy.io/
License: Public Domain
License URI: https://wikipedia.org/wiki/Public_domain
Text Domain: site-favicon
*/

if ( !defined( 'ABSPATH' ) ) {
	status_header( 404 );
	exit;
}

add_action( 'wp_head', 'sitefavicon_add_custom', 100 );
function sitefavicon_add_custom() {
	$favicon = get_option( 'favicon', '' );
	if ( $favicon ) {
		echo '<link rel="icon" href="' . esc_url( $favicon ) . '" sizes="32x32">';
	}
}

add_action( 'customize_register', 'sitefavicon_customizer_setting' );
function sitefavicon_customizer_setting( $wp_customize ) {
	$wp_customize->add_setting(
		'favicon',
		array(
			'default' => '',
			'type' => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize,
		'favicon',
		array(
			'label' => __( 'Site Favicon', 'site-favicon' ),
			'settings' => 'favicon',
			'priority' => 15,
			'section' => 'title_tagline',
			'mime_type' => 'image',
			'button_labels' => array(
				'select' => __( 'Select Site Favicon', 'site-favicon' ),
				'change' => __( 'Change Site Favicon', 'site-favicon' ),
				'remove' => __( 'Remove', 'site-favicon' ),
				'default' => __( 'Default', 'site-favicon' ),
				'placeholder' => __( 'No favicon selected', 'site-favicon' ),
				'frame_title' => __( 'Select Site Favicon', 'site-favicon' ),
				'frame_button' => __( 'Select', 'site-favicon' )
			)
		)
	) );
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'favicon_url',
		array(
			'description' => '<p style="font-style:normal;margin-top:0">' . __( 'Upload favicon (32x32 recommended).', 'site-favicon' ) . '</p>',
			'settings' => 'favicon',
			'priority' => 16,
			'section' => 'title_tagline',
			'type' => 'url',
			'input_attrs' => array(
				'placeholder' => __( 'Or add URL of favicon', 'site-favicon' )
			)
		)
	) );
}