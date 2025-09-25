<?php

    session_start();

    //define uma constante de controle

    define('ROOT', true);

    require_once('inc/config.php');
    require_once('inc/database.php');
    require_once('inc/html_header.php');

    //definir rota

    $rota = '';

    if(!isset($_SESSION['id_admin']) && $_SERVER['REQUEST_METHOD'] != 'POST')
    {
        $rota = 'login';
    }else if(!isset($_SESSION['id_admin']) && $_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $rota = 'login_submit';
    }else
    {
        // interior do backoffice
        $rota = 'home';

        //se existir uma rota explicitamente definida
        if(isset($_GET['r']))
        {
            $rota = $_GET['r'];
        }

    }

    switch ($rota) {
        case 'login':
            require_once('login.php');
            break;
        
        case 'login_submit':
            require_once('login_submit.php');
            break;
        
        case 'home':
            require_once('bo/home.php');
            break;

        case 'new_client':
            require_once('bo/new_client.php');
            break;
        
        case 'delete_client':
            require_once('bo/delete_client.php');
            break;

        case 'delete_client_ok':
            require_once('bo/delete_client_ok.php');
            break;

        case 'restore_client':
            require_once('bo/restore_client.php');
            break;

        case 'edit_client':
            require_once('bo/edit_client.php');
            break;

        default:
            echo "Rota não definida";
            break;
    }

    require_once('inc/html_footer.php');
