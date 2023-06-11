<?php

// get api callback
function wp_custom_restAPI_GET(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'greetings';

    $response = $wpdb->get_row( "SELECT greeting FROM $table_name WHERE id = 1" );

    return rest_ensure_response($response);
}