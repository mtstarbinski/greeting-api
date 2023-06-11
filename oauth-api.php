<?php

$scope  = 'OAuth API scope';
$issuer = 'OAuth API issuer';

$clientId = $_SERVER['HTTP_CLIENT_ID'];
$clientSecret = $_SERVER['HTTP_CLIENT_SECRET'];

$token = obtainToken($issuer, $clientId, $clientSecret, $scope);

// obtain an access token
function obtainToken($issuer, $clientId, $clientSecret, $scope){
    // prepare the request
    $uri = $issuer . '/v1/token';
    $token = base64_encode("$clientId:$clientSecret");
    $payload = http_build_query([
        'grant_type' => 'client_credentials',
        'scope'      => $scope
    ]);

    // build the curl request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $uri);
    curl_setopt( $ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
        "Authorization: Basic $token"
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // process and return the response
    $res = curl_exec($ch);
    $res = json_decode($res, true);
    if (! isset($res['access_token'])
        || ! isset($res['token_type'])) {
        return('failed, exiting.');
    }

    // here's your token to use in API requests
    return $res['access_token'];
}

// verify token remotely
function auth($token, $clientId, $clientSecret, $issuer){
    $metadataUrl = $issuer . '/.well-known/oauth-authorization-server';
    $metadata = http($metadataUrl);
    $introspectionUrl = $metadata['introspection_endpoint'];

    $params = [
        'token' => $token,
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
    ];

    $result = http($introspectionUrl, $params);

    if (!$result['active']) {
        return false;
    }

    return true;
}

function http($url, $params = null){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($params) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    }
    return json_decode(curl_exec($ch), true);
}

