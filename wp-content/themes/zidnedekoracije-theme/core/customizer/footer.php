<?php 
    $column_number = array(1=>'One', 2=> 'Two' , 3=>'Three', 4=>'Four');

    $footer_layout = array(
            '1/1' => '1/1' ,
            '1/2,1/2' => '1/2 ,  1/2 ' , 
            '1/2,1/4,1/4' => '1/2 ,  1/4 , 1/4', 
            '1/4,1/4,1/4,1/4' => '1/4, 1/4, 1/4, 1/4', 
            '1/3,1/3,1/3' => '1/3, 1/3, 1/3',
        );

	$wp_customize->add_section( 'footer_customizer' , array(
        'title'      => __( 'Footer', 'magicwalls' ),
        'priority'   => 260,
	) );

	$wp_customize->add_setting( 'footer_customizer_text' , array(
        'default'   => 'copyright 2015 All Rights Reserved',
        'transport' => 'postMessage',
        'sanitize_callback' => 'text_sanitize'
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_customizer_text', array(
        'label'    => __( 'Footer CopyRight Text', 'magicwalls' ),
        'section'  => 'footer_customizer',
        'settings' => 'footer_customizer_text',
    ) ) );
    $wp_customize->add_setting( 'footer_layout' , array(
        'sanitize_callback' => 'footer_layout_sanizie'
    ) );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_layout', array(
        'label'    => __( 'Footer Layout ', 'magicwalls' ),
        'section'  => 'footer_customizer',
        'settings' => 'footer_layout',
        'type' => 'select',
        'choices' => $footer_layout
        
    ) ) );
    $wp_customize->add_setting( 'footer_column_number' , array(
        'sanitize_callback' => 'footer_sidebar_sanizie'
    ) );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_column_number', array(
        'label'    => __( 'Footer Column Number', 'magicwalls' ),
        'section'  => 'footer_customizer',
        'settings' => 'footer_column_number',
        'type' => 'select',
        'choices' => $column_number
        
    ) ) );
    $wp_customize->get_setting( 'footer_customizer_text' )->transport = 'postMessage';


?>