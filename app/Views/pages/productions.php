<?php require APPROOT . '/Views/inc/header.php'; ?>

<div class="page-container">
    <h1 class="page-title"><?php echo $data['title']; ?></h1>
    <p class="page-description"><?php echo $data['description']; ?></p>

    <?php if (empty($data['movies'])): ?>
        <p class="no-results">Brak filmow w bazie danych</p>
    <?php else: ?>
        <div class="movies-grid">
            <?php foreach($data['movies'] as $movie): ?>
                <a href="<?php echo URLROOT; ?>/pages/detail/<?php echo $movie->id; ?>" class="movie-card-link">
                    <div class="movie-card">
                        <h3 class="movie-title"><?php echo $movie->title; ?></h3>
                        <p class="movie-description"><?php echo $movie->description; ?></p>
                        <div class="movie-details">
                            <p><strong>Rok:</strong> <?php echo $movie->year; ?></p>
                            <p><strong>Gatunek:</strong> <?php echo $movie->genre; ?></p>
                            <p><strong>Ocena:</strong> <?php echo ($movie->rating > 0) ? $movie->rating . '/10' : 'Brak ocen'; ?></p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
