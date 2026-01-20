<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : SITENAME; ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
    <?php if (isset($pageStyles) && is_array($pageStyles)) : ?>
        <?php foreach ($pageStyles as $style) : ?>
            <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/<?php echo htmlspecialchars($style); ?>.css">
        <?php endforeach; ?>
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
                <span class="welcome-msg">Witaj, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
                <a href="<?php echo URLROOT; ?>/auth/logout" class="btn-logout">Wyloguj</a>
            <?php else : ?>
                <a href="<?php echo URLROOT; ?>/auth/login" class="btn-login">Zaloguj się</a>
            <?php endif; ?>
        </div>
    </header>
    <div class="container">
        <?php echo $content ?? ''; ?>
    </div>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> PLUSFLIX. Wszelkie prawa zastrzeżone.</p>
    </footer>
</body>
</html>
