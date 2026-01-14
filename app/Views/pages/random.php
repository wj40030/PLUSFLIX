<?php require APPROOT . '/Views/inc/header.php'; ?>

<div class="page-container">
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 class="page-title"><?php echo $data['title']; ?></h1>
        <p class="page-description"><?php echo $data['description']; ?></p>
        
        <form action="<?php echo URLROOT; ?>/random" method="post">
            <button type="submit" class="btn-back" style="border: none; cursor: pointer; font-size: 1.2rem;">
                🎲 Losuj kolejną produkcję
            </button>
        </form>
    </div>

    <?php if ($data['movie']) : ?>
        <div class="movie-details-container">
            <div class="movie-poster">
                <div class="poster-placeholder">
                    <span>Brak zdjecia</span>
                </div>
            </div>

            <div class="movie-info">
                <h2 class="movie-details-title"><?php echo $data['movie']->title; ?></h2>

                <div class="movie-meta">
                    <span class="meta-item"><strong>Rok:</strong> <?php echo $data['movie']->year; ?></span>
                    <span class="meta-item"><strong>Gatunek:</strong> <?php echo $data['movie']->genre; ?></span>
                    <span class="meta-item"><strong>Typ:</strong> <?php echo $data['movie']->type; ?></span>
                    <span class="meta-item rating"><strong>Ocena:</strong> <?php echo ($data['movie']->rating > 0) ? $data['movie']->rating . '/10' : 'Brak ocen'; ?></span>
                </div>

                <div class="movie-description-full">
                    <h3>Opis</h3>
                    <p><?php echo $data['movie']->description; ?></p>
                </div>

                <div class="movie-actions">
                    <a href="<?php echo URLROOT; ?>/pages/productions/<?php echo $data['movie']->id; ?>" class="btn-back">Zobacz szczegóły / Recenzje</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
