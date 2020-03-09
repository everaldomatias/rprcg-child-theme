<?php

function customizer_territories( $wp_customize ) {

    /*------------------------------------------------------------------------*/
    /*  Section: Hello World
    /*------------------------------------------------------------------------*/
    $wp_customize->add_panel( 'coletivo_territories' ,
		array(
			'priority'        => coletivo_get_customizer_priority( 'coletivo_territories' ),
			'title'           => esc_html__( 'Seção: Territórios', 'coletivo' ),
			'description'     => '',
			'active_callback' => 'coletivo_showon_frontpage'
		)
	);
	$wp_customize->add_section( 'coletivo_territories_settings' ,
		array(
			'priority'    => 3,
			'title'       => esc_html__( 'Section Settings', 'coletivo' ),
			'description' => '',
			'panel'       => 'coletivo_territories',
		)
    );
    
	// Show Content
	$wp_customize->add_setting( 'coletivo_territories_disable',
		array(
			'sanitize_callback' => 'coletivo_sanitize_checkbox',
			'default'           => '',
		)
	);
	$wp_customize->add_control( 'coletivo_territories_disable',
		array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Hide this section?', 'coletivo' ),
			'section'     => 'coletivo_territories_settings',
			'description' => esc_html__( 'Check this box to hide this section.', 'coletivo' ),
		)
    );
    
	// Section ID
	$wp_customize->add_setting( 'coletivo_territories_id',
		array(
			'sanitize_callback' => 'coletivo_sanitize_text',
			'default'           => esc_html__( 'territories', 'coletivo' ),
		)
	);
	$wp_customize->add_control( 'coletivo_territories_id',
		array(
			'label'       => esc_html__( 'Section ID:', 'coletivo' ),
			'section'     => 'coletivo_territories_settings',
			'description' => esc_html__( 'The section id, we will use this for link anchor.', 'coletivo' )
		)
    );
    
	// Title
	$wp_customize->add_setting( 'coletivo_territories_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Territórios', 'coletivo' ),
		)
	);
	$wp_customize->add_control( 'coletivo_territories_title',
		array(
			'label'       => esc_html__( 'Section Title', 'coletivo' ),
			'section'     => 'coletivo_territories_settings',
			'description' => '',
		)
    );
    
	// Sub Title
	$wp_customize->add_setting( 'coletivo_territories_subtitle',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => esc_html__( 'Section subtitle', 'coletivo' ),
		)
	);
	$wp_customize->add_control( 'coletivo_territories_subtitle',
		array(
			'label'       => esc_html__( 'Section Subtitle', 'coletivo' ),
			'section'     => 'coletivo_territories_settings',
			'description' => '',
		)
    );
    
    // Description
    $wp_customize->add_setting( 'coletivo_territories_desc',
        array(
            'sanitize_callback' => 'coletivo_sanitize_text',
            'default'           => '',
        )
    );
    $wp_customize->add_control( new coletivo_Editor_Custom_Control(
        $wp_customize,
        'coletivo_territories_desc',
        array(
            'label' 		=> esc_html__( 'Section Description', 'coletivo' ),
            'section' 		=> 'coletivo_territories_settings',
            'description'   => '',
        )
    ));
    
    add_filter( 'coletivo_customizer_partials_selective_refresh_keys', 'territories_add_section_customizer' );

}
add_action( 'coletivo_customize_after_register', 'customizer_territories', 10, 1 );

/**
 * Add settings and ID on list of the sections
 */
function territories_add_section_customizer( $value ) {

    $territories = array(
        'id' => 'territories',
        'selector' => '.section-territories',
        'settings' => array(
            'coletivo_territories_disable',
            'coletivo_territories_id',
            'coletivo_territories_title',
            'coletivo_territories_subtitle',
            'coletivo_territories_desc'
        ),
    );

	$value[] = $territories;

    return $value;

}