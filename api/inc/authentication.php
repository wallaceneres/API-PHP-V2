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

    $usuarios = [
        [
            'user' => 'Joao',
            'pass' => 'abc123'
        ],
        [
            'user' => 'Ana',
            'pass' => 'abc456'
        ],
        [
            'user' => 'Pedro',
            'pass' => 'abc456'
        ]
    ];

    //verifica se user e pass tem autenticação valida

    $user = $_SERVER['PHP_AUTH_USER'];
    $pass = $_SERVER['PHP_AUTH_PW'];

    $valid_authentication = false;

    foreach($usuarios as $usuario)
    {
        if($usuario['user'] == $user && $usuario['pass'] == $pass)
        {
            $valid_authentication = true;
        }
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

