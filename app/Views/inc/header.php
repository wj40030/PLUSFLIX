<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? $data['title'] : SITENAME; ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <?php if (isset($data['css'])) : ?>
        <?php if (is_array($data['css'])) : ?>
            <?php foreach ($data['css'] as $style) : ?>
                <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/<?php echo $style; ?>.css">
            <?php endforeach; ?>
        <?php else : ?>
            <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/<?php echo $data['css']; ?>.css">
        <?php endif; ?>
    <?php endif; ?>
</head>
<body>
    <header>
        <a href="<?php echo URLROOT; ?>" class="logo">PLUSFLIX</a>
        <nav>
            <a href="<?php echo URLROOT; ?>">Strona glowna</a>
            <a href="<?php echo URLROOT; ?>/productions">Produkcje</a>
            <a href="<?php echo URLROOT; ?>/random">Losuj</a>
            <a href="<?php echo URLROOT; ?>/recommended">Polecane</a>
            <?php if (isset($_SESSION['user_id'])) : ?>
                <a href="<?php echo URLROOT; ?>/pages/watchlist">Watchlista</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                <a href="<?php echo URLROOT; ?>/pages/admin" class="admin-link">Admin</a>
            <?php endif; ?>
        </nav>
        <div class="user-info">
            <?php if (isset($_SESSION['user_id'])) : ?>
                <span class="welcome-msg">Witaj, <strong><?php echo $_SESSION['username']; ?></strong></span>
                <a href="<?php echo URLROOT; ?>/auth/logout" class="btn-logout">Wyloguj</a>
            <?php else : ?>
                <a href="<?php echo URLROOT; ?>/auth/login" class="btn-login">Zaloguj sie</a>
            <?php endif; ?>
        </div>
    </header>
    <div class="container">
