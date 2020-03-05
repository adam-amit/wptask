<?php
/*
* Plugin Name:Event CPT
* Description: Plugin to create Event Table and Custom post type
* Author: Adam Amit
* Version: 1.0.0
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


Class EventCPT {

    private $options;

    public function __construct() {
        add_action( 'init', array( $this, 'eventCustomPostType' ) );
        add_filter('manage_events_posts_columns' , array($this,'events_post_type_columns'));
        add_action( 'manage_events_posts_custom_column' , array( $this, 'events_post_type_custom_columns' ), 10, 2 );
        add_action( 'add_meta_boxes_events', array( $this, 'event_add_meta_boxes' ) );
        add_action( 'save_post_events', array( $this, 'event_save_meta_box_data' ) );
        add_shortcode( 'events_table', array( $this, 'generate_event_view' ) );
    }

    public function eventCustomPostType() {
            
        $labels = array(
            'name'                  => _x( 'Events', 'Post Type General Name', 'one' ),
            'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'one' ),
            'menu_name'             => __( 'Event', 'one' ),
            'name_admin_bar'        => __( 'Event', 'one' ),
            'archives'              => __( 'Event Archives', 'one' ),
            'attributes'            => __( 'Event Attributes', 'one' ),
            'parent_item_colon'     => __( 'Parent Event:', 'one' ),
            'all_items'             => __( 'All Events', 'one' ),
            'add_new_item'          => __( 'Add New Event', 'one' ),
            'add_new'               => __( 'Add New', 'one' ),
            'new_item'              => __( 'New Event', 'one' ),
            'edit_item'             => __( 'Edit Event', 'one' ),
            'update_item'           => __( 'Update Event', 'one' ),
            'view_item'             => __( 'View Event', 'one' ),
            'view_items'            => __( 'View Events', 'one' ),
            'search_items'          => __( 'Search Event', 'one' ),
            'not_found'             => __( 'Not found', 'one' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'one' ),
            'featured_image'        => __( 'Featured Image', 'one' ),
            'set_featured_image'    => __( 'Set featured image', 'one' ),
            'remove_featured_image' => __( 'Remove featured image', 'one' ),
            'use_featured_image'    => __( 'Use as featured image', 'one' ),
            'insert_into_item'      => __( 'Insert into event', 'one' ),
            'uploaded_to_this_item' => __( 'Uploaded to this event', 'one' ),
            'items_list'            => __( 'Items list', 'one' ),
            'items_list_navigation' => __( 'Items list navigation', 'one' ),
            'filter_items_list'     => __( 'Filter Events list', 'one' ),
        );
        $args = array(
            'label'                 => __( 'Event', 'one' ),
            'description'           => __( 'Event Post Type', 'one' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
        );
        register_post_type( 'events', $args );
    }

    public function event_add_meta_boxes( $post ){
        add_meta_box( 'event_meta_box', __( 'Event Detail', 'one' ), array( $this, 'event_build_meta_box' ), 'events', 'side', 'low' );
    }

    public function event_build_meta_box( $post ){
        // our code here
        wp_nonce_field( basename( __FILE__ ), 'event_build_meta_box_nonce' );

        $event_date = get_post_meta( $post->ID, '_event_date', true );
        $event_location = get_post_meta( $post->ID, '_event_location', true );
        $event_count = get_post_meta( $post->ID, '_event_count', true );

        ?>
        <div class='inside'>
            <h3><?php _e( 'Event Date', 'one' ); ?></h3>
            <p>
                <input type="date" name="date" value="<?php echo $event_date; ?>" />
            </p>
            <h3><?php _e( 'Event Location', 'one' ); ?></h3>
            <p>
                <input type="text" name="location" value="<?php echo $event_location; ?>" />
            </p>
            <h3><?php _e( 'Event Count', 'one' ); ?></h3>
            <p>
                <input type="number" name="count" max="60" value="<?php echo $event_count; ?>" />
            </p>
        </div>
        <?php

    }

    public function event_save_meta_box_data( $post_id ) {
        if ( !isset( $_POST['event_build_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['event_build_meta_box_nonce'], basename( __FILE__ ) ) ){
            return;
        }

        // return if autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
            return;
        }

        // Check the user's permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) ){
            return;
        }

        // store custom fields values
        // Event Date Value
        if ( isset( $_REQUEST['date'] ) ) {
            update_post_meta( $post_id, '_event_date', sanitize_text_field( $_POST['date'] ) );
        }

        // Event Location String
        if ( isset( $_REQUEST['location'] ) ) {
            update_post_meta( $post_id, '_event_location', sanitize_text_field( $_POST['location'] ) );
        }

        // Event Date Value
        if ( isset( $_REQUEST['count'] ) ) {
            update_post_meta( $post_id, '_event_count', sanitize_text_field( $_POST['count'] ) );
        }

    }

    public function events_post_type_columns( $columns ) {
        unset(
            $columns['wpseo-score'],
            $columns['wpseo-title'],
            $columns['wpseo-metadesc'],
            $columns['wpseo-focuskw']
        );
        return array(
                'cb' => '<input type="checkbox" />',
                'title' => __('Title'),
                'event_date' => __('Event Date'),
                'event_location' => __('Event Location'),
                'event_count' => __('Event Count'),
                'post_id' =>__( 'Post ID')
            );
            //return $columns;
    }

    public function events_post_type_custom_columns( $column, $post_id ) {
        switch( $column ) {
            case 'event_date' : 
                echo get_post_meta( $post_id, '_event_date', true );
            break;
            case 'event_location' :
                echo get_post_meta( $post_id, '_event_location', true );
            break;
            case 'event_count' :
                echo get_post_meta( $post_id, '_event_count', true );
            break;
            case 'post_id' :
                echo $post_id; 
             break;        
        }
    }

    public function generate_event_view() {
        $args = array(
            'numberposts' => -1,
            'post_type'   => 'events'
        );
           
        $all_events = get_posts( $args );

        if( $all_events ) {
            $html = '<table style="width:100%">';
            $html .= '<tr><th>Event Title</th><th>Event Date</th><th>Event Location</th><th>Event Capacity</th></tr>';
            
            foreach( $all_events as $event ) : setup_postdata( $event );
                $html .= '<tr>';
                $html .= '<td>' . $event->post_title . '</td>';
                $html .= '<td>'. get_post_meta( $event->ID, '_event_date', true ) .'</td>';
                $html .= '<td>'. get_post_meta( $event->ID, '_event_location', true ) .'</td>';
                $html .= '<td>'. get_post_meta( $event->ID, '_event_count', true ) .'</td>';
                $html .= '</tr>';
            endforeach;

            $html .= '</table>';
        } else {
            $html = '<h3>Sorry No Event Found</h3>';
        }
        
        return $html;
    }

}

new EventCPT();
