<?php

    //verifica se o user e pass vieram com o request HTTP
    
    if(empty($_SERVER['PHP_AUTH_USER']) ||
       empty($_SERVER['PHP_AUTH_PW']))
    {
        echo json_encode([
            'status' => 'ERROR',
            'message' => 'Invalid access.'
        ]);
        exit();
    }

    //verifica se a autenticacao é valida

    require_once('config.php');
    require_once('database.php');

    $db = new database();

    $params = [
        ':user' => $user = $_SERVER['PHP_AUTH_USER'],
        ':pass' => $pass = $_SERVER['PHP_AUTH_PW']
    ];

    $results = $db->EXE_QUERY("SELECT id_client FROM `authentication` WHERE username=:user AND pass=:pass", $params);
    if(count($results) > 0)
    {
        $valid_authentication = true;
    }else{
        $valid_authentication = false;
    }

    //autenticacao invalida

    if(!$valid_authentication)
    {
        echo json_encode([
            'status' => 'ERROR',
            'message' => 'Invalid athentication credentials.'
        ]);
        exit();
    }

