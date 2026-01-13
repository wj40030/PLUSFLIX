<?php require APPROOT . '/Views/inc/header.php'; ?>

<div class="page-container">
    <div class="movie-details-container">
        <div class="movie-poster">
            <div class="poster-placeholder">
                <span>Brak zdjecia</span>
            </div>
        </div>

        <div class="movie-info">
            <h1 class="movie-details-title"><?php echo $data['movie']->title; ?></h1>

            <div class="movie-meta">
                <span class="meta-item"><strong>Rok:</strong> <?php echo $data['movie']->year; ?></span>
                <span class="meta-item"><strong>Gatunek:</strong> <?php echo $data['movie']->genre; ?></span>
                <span class="meta-item"><strong>Typ:</strong> <?php echo $data['movie']->type; ?></span>
                <span class="meta-item rating"><strong>Ocena:</strong> <?php echo $data['movie']->rating; ?>/10</span>
            </div>

            <div class="movie-description-full">
                <h3>Opis</h3>
                <p><?php echo $data['movie']->description; ?></p>
            </div>

            <div class="movie-actions">
                <a href="<?php echo URLROOT; ?>" class="btn-back">Powrot do strony glownej</a>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/Views/inc/footer.php'; ?>

