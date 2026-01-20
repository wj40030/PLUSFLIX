<?php $pageStyles = ['productions']; ?>

<div class="page-container">
    <div class="center-content margin-bottom-40">
        <h1 class="page-title"><?php echo isset($title) ? htmlspecialchars($title) : ''; ?></h1>
        <p class="page-description"><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></p>

        <form action="<?php echo URLROOT; ?>/random" method="post">
            <button type="submit" class="btn-back btn-random">
                🎲 Losuj kolejną produkcję
            </button>
        </form>
    </div>

    <?php if (!empty($movie)) : ?>
        <div class="movie-details-container">
            <div class="movie-poster">
                <div class="poster-placeholder">
                    <span>Brak zdjęcia</span>
                </div>
            </div>

            <div class="movie-info">
                <h2 class="movie-details-title"><?php echo isset($movie->title) ? htmlspecialchars($movie->title) : ''; ?></h2>

                <div class="movie-meta">
                    <span class="meta-item"><strong>Rok:</strong> <?php echo isset($movie->year) ? htmlspecialchars($movie->year) : ''; ?></span>
                    <span class="meta-item"><strong>Gatunek:</strong> <?php echo isset($movie->genre) ? htmlspecialchars($movie->genre) : ''; ?></span>
                    <span class="meta-item"><strong>Typ:</strong> <?php echo isset($movie->type) ? htmlspecialchars($movie->type) : ''; ?></span>
                    <span class="meta-item rating"><strong>Ocena:</strong> <?php echo (isset($movie->rating) && $movie->rating > 0) ? htmlspecialchars($movie->rating) . '/10' : 'Brak ocen'; ?></span>
                </div>

                <div class="movie-description-full">
                    <h3>Opis</h3>
                    <p><?php echo isset($movie->description) ? htmlspecialchars($movie->description) : ''; ?></p>
                </div>

                <div class="movie-actions">
                    <a href="<?php echo URLROOT; ?>/pages/productions/<?php echo isset($movie->id) ? (int)$movie->id : 0; ?>" class="btn-back">Zobacz szczegóły / Recenzje</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
