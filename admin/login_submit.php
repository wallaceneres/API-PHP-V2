<?php
    defined('ROOT') or die('Acesso inválido');
?>

<?php

    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        die('Acesso Inválido');
    }

    $usuario = $_POST['text_usuario'];
    $senha = $_POST['text_senha'];

    //validacao

    if(empty($usuario) || empty($senha))
    {
        $_SESSION['error'] = 'Dados insuficientes';
        header('Location: index.php');
    }

    echo 'OK';
?>