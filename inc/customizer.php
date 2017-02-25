<?php
/**
 * usra Theme Customizer
 *
 * @package usra
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function usra_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

}
add_action( 'customize_register', 'usra_customize_register' );
function usra_custom_image_register($wp_customize) {
    if ( ! isset( $wp_customize ) ) {
        return;
    }
    $wp_customize->add_section(
        'usra_hero', array(
            'title'         => __('Hero','theme-slug'),
            'description'   => __('Set the hero image', 'theme-slug'),
            'active_callback'   => 'is_front_page',
        )
    );
    $wp_customize->add_setting( 'usra_hero_image',array(
        'sanatize_callback'     => esc_url_raw,
        'transport'             => 'postMessage'
    ));
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize, 'usra_hero_image',
            array(
                'settings'          => 'usra_hero_image',
                'section'           => 'usra_hero',
                'label'             => __('Hero Image','theme-slug'),
                'description'       => __('Select the image','theme-slug'),
            )
        )
    );
}
add_action('customize_register','usra_custom_image_register');
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function usra_customize_preview_js() {
	wp_enqueue_script( 'usra_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'usra_customize_preview_js' );

function usra_customizer_css() {
    ?>
    <style type="text/css">
        <?php
            if ( get_theme_mod( 'usra_hero_image' ) ) {
                $home_top_background_image_url = get_theme_mod( 'usra_hero_image' );
            } else {
                $home_top_background_image_url = get_stylesheet_directory_uri() . '';
            }
            // if ( 0 < count( strlen( ( $home_top_background_image_url = get_theme_mod( 'usra_hero_image', sprintf( '', get_stylesheet_directory_uri() ) ) ) ) ) ) { ?>
        .hero-div {
            background-image: url( <?php echo $home_top_background_image_url; ?> );
            background-position: center;
            background-size: cover;
        }
        <?php // } // end if ?>
    </style>
    <?php
} // end sk_customizer_css
add_action( 'wp_head', 'usra_customizer_css');


