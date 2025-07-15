<?php

    session_start();
    //remocao do usuario da sessao
    unset($_SESSION['id_admin']);
    unset($_SESSION['usuario']);

    header('Location: index.php');