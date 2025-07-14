<?php

require_once('inc/config.php');

//request à api com pedido de autenticacao

//api_request('http://127.0.0.1/api/', 'Joao', 'abc123');
api_request('get_datetime');


function api_request($endpoint, $user = null, $pass = null, $method = 'GET', $variables = [])
{
    $curl = curl_init(API_BASE_ENDPOINT . $endpoint . '/');
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode(API_USER . ':' . API_PASS)
    );

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($curl);

    if(curl_errno($curl))
    {
        throw new Exception(curl_errno($curl));
    }

    curl_close($curl);

    echo $response;
}

?>