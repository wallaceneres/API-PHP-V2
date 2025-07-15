<?php

    session_start();

    //define uma constante de controle

    define('ROOT', true);

    require_once('inc/config.php');
    require_once('inc/database.php');
    require_once('inc/html_header.php');

    //verifica se o usuario está logado

    //$_SESSION['id_admin'] = 1;

    if(!isset($_SESSION['id_admin']))
    {
        // apresenta a tela de login
        require_once('login.php');
    }else
    {
        //backoffice
        require_once('home.php');
    }

    require_once('inc/html_footer.php');
