<?php require APPROOT . '/Views/inc/header.php'; ?>
    <h1><?php echo $data['title']; ?></h1>
    <p><?php echo $data['description']; ?></p>

    <h3>Dane z bazy danych:</h3>
    <div class="grid">
        <?php foreach($data['series'] as $series) : ?>
            <div class="card">
                <h4><?php echo $series->title; ?></h4>
                <p><?php echo $series->description; ?></p>
            </div>
        <?php endforeach; ?>
    </div>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
