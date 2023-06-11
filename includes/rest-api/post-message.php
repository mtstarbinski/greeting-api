<?php

// post api callback
function wp_custom_restAPI_POST(WP_REST_Request $request){

    $arg = $request->get_param('greeting');
    if (!$arg) {
        $response = 'Invalid argument.';
    } else {
        global $wpdb;
        $table_name = $wpdb->prefix . 'greetings';

        $wpdb->update(
            $table_name,
            array(
                'greeting' => $arg,
            ),
            array(
                'id' => 1,
            ),
            array( 
                '%s',
            ), 
        );
        $response = "Greeting updated!";
    }

    return rest_ensure_response($response);
}