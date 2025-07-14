<?php

require_once('inc/config.php');

//request à api com pedido de autenticacao

$variaveis = [
    'id' => '1'
];

$resultados = api_request('get_datetime','','','GET',$variaveis);
print_r($resultados);

function api_request($endpoint, $user = null, $pass = null, $method = 'GET', $variables = [])
{
    $curl = curl_init();
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode(API_USER . ':' . API_PASS)
    );

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $url = API_BASE_ENDPOINT . $endpoint . '/';

    //if request is GET

    if($method == 'GET')
    {
        if(!empty($variables))
        {
            $url .= '?' . http_build_query($variables);
        }
    }

    //if request is POST

    if($method == 'POST')
    {
        $variables = array_merge(['endpoint => $endpoint'], $variables);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $variables);
    }

    //defines curl url

    curl_setopt($curl, CURLOPT_URL, $url);

    $response = curl_exec($curl);

    //verifies errors
    if(curl_errno($curl))
    {
        throw new Exception(curl_errno($curl));
    }

    curl_close($curl);

    return json_decode($response, true);
}

?>