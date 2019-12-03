<?php
/*
* Plugin Name:Floating CTA
* Description: Plugin to show a CTA bar on the site using shortcode
* Author: Adam Amit
* Version: 1.0.0
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

Class FloatingCTA {

    private $options;

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'addSettingsPage' ) );
        add_action( 'admin_init', array( $this, 'addSettingsSection' ));
        add_action( 'admin_enqueue_scripts', array( $this, 'fcta_admin_assets' ) );
        add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), array( $this, 'fcta_add_plugin_page_settings_link' ) );
        add_shortcode( 'fcta_shortcode', array( $this, 'fcta_generate_shortcode' ) );
    }

    public function addSettingsPage() {
        add_menu_page( 'Floating CTA Settings', 'CTA Settings', 'manage_options', 'fcta-settings', 
        array( $this,'floating_cta_settings_view' ), 'dashicons-editor-code', '90');
    }

    public function fcta_admin_assets() {
        wp_register_style( 'fcta_admin_styles', plugins_url( 'assets/css/admin-styles.css', __FILE__ ), false, '1.0.0' );
        wp_enqueue_style( 'fcta_admin_styles' );
    }

    public function fcta_add_plugin_page_settings_link( $links ) {
        $links[] = '<a href="' .
            admin_url( 'admin.php?page=fcta-settings' ) .
            '">' . __('Settings') . '</a>';
        return $links;
    }

    public function floating_cta_settings_view() {
        // Set class property
        $this->options = get_option( 'fcta_option_name' );
        ?>
        <div class="wrap setting-page">
            <h1>Floating Call to Action Settings</h1>
            <form method="post" action="options.php">
            <?php
                settings_fields( 'fcta_option_group' );
                do_settings_sections( 'fcta-settings' );
                submit_button();
            ?>
            </form>
        </div>
        <div class="shortcode-wrap">
            <h4>Use this shortcode inside your templates</h4>
            <input type="text" value="[fcta_shortcode]" readonly>
        </div>
        <?php
    }

    public function addSettingsSection() {

        register_setting( 
            'fcta_option_group', 
            'fcta_option_name',
            array( $this, 'sanitize' )
        );

        add_settings_section(
            'fcta_section_id',
            'Floating CTA Options',
            array( $this, 'floating_custom_sections' ),
            'fcta-settings'
        );

        /* CTA Color Field */
        add_settings_field(
            'fcta_bg',
            'Floating CTA Background',
            array( $this, 'fcta_bg_callback' ),
            'fcta-settings',
            'fcta_section_id'
        );

        /* CTA Position Field */
        add_settings_field(
            'fcta_pos',
            'Floating CTA Position',
            array( $this, 'fcta_pos_callback' ),
            'fcta-settings',
            'fcta_section_id'
        );

        /* CTA Content Field */
        add_settings_field(
            'fcta_content',
            'Floating CTA Content',
            array( $this, 'fcta_content_callback' ),
            'fcta-settings',
            'fcta_section_id'
        );

    }

    public function floating_custom_sections() {
        echo "Please enter your prefered CTA options";
    }

    public function sanitize( $input ) {
        $new_input = array();

        if( isset( $input['fcta_bg'] ) )
            $new_input['fcta_bg'] = sanitize_text_field( $input['fcta_bg'] );

        if( isset( $input['fcta_pos'] ) )
            $new_input['fcta_pos'] = sanitize_text_field( $input['fcta_pos'] );

        if( isset( $input['fcta_content'] ) )
            $new_input['fcta_content'] = sanitize_text_field( $input['fcta_content'] );

        return $new_input;
    }

    public function fcta_bg_callback() {
        printf(
            '<input type="color" id="fcta_bg" name="fcta_option_name[fcta_bg]" class="fcta-input-field" value="%s" />',
            isset( $this->options['fcta_bg'] ) ? esc_attr( $this->options['fcta_bg']) : ''
        );
        // var_dump($this->options);
    }

    public function fcta_pos_callback() {
        ?>
            <select name="fcta_option_name[fcta_pos]" id="fcta_pos" class="fcta-input-field">
                <option value="Top" <?php echo isset( $this->options['fcta_pos'] ) ? ( selected( $this->options['fcta_pos'], 'Top', false ) ) : ( '' ); ?>>
                    <?php echo "Top"; ?>
                </option>
                <option value="Bottom" <?php echo isset( $this->options['fcta_pos'] ) ? ( selected( $this->options['fcta_pos'], 'Bottom', false ) ) : ( '' ); ?>>
                    <?php echo "Bottom"; ?>
                </option>
            </select>
        <?php
    }

    public function fcta_content_callback() {
        printf(
            '<textarea id="fcta_content" name="fcta_option_name[fcta_content]" rows="4" cols="50" class="fcta-input-field">%s</textarea>',
            isset( $this->options['fcta_content'] ) ? esc_attr( $this->options['fcta_content']) : ''
        );
    }

    public function fcta_generate_shortcode() {
        $data = get_option('fcta_option_name');
        $html = '<section class="floating-cta-bar fixed-' . strtolower( $data['fcta_pos'] ) . ' text-light py-4" style="background-color: ' . $data['fcta_bg'] . '">';
        $html .= '<div class="container-fluid"><div class="row">';
        $html .= '<div class="col-11"><p class="mb-0 text-center">' . $data['fcta_content'] . ' </p></div>';
        $html .= '<div class="col-1"><button id="cta-btn" type="button" class="close text-light" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $html .= '</div></div></section>';
        return $html;
    }

}

new FloatingCTA();