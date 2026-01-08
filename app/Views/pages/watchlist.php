<?php require APPROOT . '/Views/inc/header.php'; ?>

<div style="max-width:800px;margin:40px auto;padding:20px;">
    <h1><?php echo isset($data['title']) ? $data['title'] : 'Watchlist'; ?></h1>
    <p><?php echo isset($data['description']) ? $data['description'] : 'Twoja watchlista jest pusta.'; ?></p>
</div>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
