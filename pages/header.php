<?php require 'config.php';?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Classificados</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="assets/css/style.css"/>
        <script type="text/javascript" src="assets/js/jquery-3.4.1.min.js" rel="stylesheet"></script>
        <script type="text/javascript" src="assets/js/script.js" rel="stylesheet"></script>
        <script type="text/javascript" src="assets/js/bootstrap.min.js" rel="stylesheet"></script>

    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="./">Classificados</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <?php if (isset($_SESSION['cLogin']) && !empty($_SESSION['cLogin'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Meus Anúncios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="sair.php">Sair</a>
                            </li>
                        <?php else: ?>        

                            <li class="nav-item">
                                <a class="nav-link" href="cadastra-se.php">Cadastra-se</a>
                            </li>     
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
