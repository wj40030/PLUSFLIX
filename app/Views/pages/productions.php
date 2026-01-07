<?php require APPROOT . '/Views/inc/header.php'; ?>
    <h1><?php echo $data['title']; ?></h1>
    <p><?php echo $data['description']; ?></p>
    <div class="production-highlight">
        To jest element ostylowany przez dedykowany plik CSS dla tego widoku (`production.css`).
    </div>
<?php require APPROOT . '/Views/inc/footer.php'; ?>
