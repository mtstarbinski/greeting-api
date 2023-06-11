<?php 

function gapi_rest_api_init () {  
    register_rest_route('gapi/v1', '/greeting', [
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'wp_custom_restAPI_GET',
        'permission_callback' => '__return_true'
    ]);


    register_rest_route('gapi/v1', '/greeting', [
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'wp_custom_restAPI_POST',
        'permission_callback' => function () {
            // include api auth
            require_once(GAPI_PLUGIN_DIR . '/oauth-api.php');
            return auth($token, $clientId, $clientSecret, $issuer);
        }
    ]);
}