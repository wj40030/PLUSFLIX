<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title'] ?? SITENAME; ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <?php if (isset($data['css'])) : ?>
        <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/<?php echo $data['css']; ?>.css">
    <?php endif; ?>
</head>
<body>
    <header>
        <a href="<?php echo URLROOT; ?>" class="logo">PLUSFLIX</a>
        <nav>
            <a href="<?php echo URLROOT; ?>">Strona główna</a>
            <a href="<?php echo URLROOT; ?>/productions">Produkcje</a>
            <a href="<?php echo URLROOT; ?>/random">Losuj</a>
            <a href="<?php echo URLROOT; ?>/recommended">Polecane</a>
        </nav>
    </header>
    <div class="container">
