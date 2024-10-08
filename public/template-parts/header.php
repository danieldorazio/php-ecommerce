<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/5/flatly/bootstrap.css">
    <link rel="stylesheet" href="<?php echo ROOT_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>PHP E-commerce</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="<?php echo ROOT_URL; ?>public?page=homepage">PHP E-commerce</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo ROOT_URL; ?>public?page=about">Chi Siamo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo ROOT_URL; ?>public?page=services">Servizi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo ROOT_URL; ?>shop?page=products-list">Prodotti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo ROOT_URL; ?>public?page=contacts">Contatti</a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo ROOT_URL; ?>shop/?page=cart">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="badge bedge-success rounded-pill bg-success js-totCartItems"></span>
                        </a>
                    </li>
                </ul>
                <!-- se l'utente non è loggato mostrami il pannello per loggare  -->
                <?php if (!$loggedInUser) : ?>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Area Riservata
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo ROOT_URL; ?>auth?page=login">Login / Registrazione</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php endif; ?>

                <!-- se l'utente è loggato mostrami il pannello per sloggare  -->
                <?php if ($loggedInUser) : ?>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $loggedInUser->email ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo ROOT_URL; ?>auth?page=logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php endif; ?>

                <!-- se l'utente è loggato ed è admin mostrami il pannello per accedere alla Dashboard  -->
                <?php if ($loggedInUser && $loggedInUser->is_admin) : ?>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Amministrazione
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo ROOT_URL; ?>admin">Dashboard</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php endif; ?>

            </div>
        </div>
    </nav>