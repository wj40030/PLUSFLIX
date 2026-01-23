<?php $pageStyles = ['productions']; ?>

<div class="page-container">
    <div class="center-content margin-bottom-40">
        <h1 class="page-title"><?php echo isset($title) ? htmlspecialchars($title) : ''; ?></h1>
        <p class="page-description"><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></p>
    </div>

    <?php if (!empty($movies)) : ?>
        <div class="movies-grid">
            <?php foreach ($movies as $movie) : ?>
                <div class="movie-card-container">
                    <a href="<?php echo URLROOT; ?>/pages/detail/<?php echo isset($movie->id) ? (int)$movie->id : 0; ?>" class="movie-card-link no-transform">
                        <div class="movie-card">
                            <h3 class="movie-title"><?php echo isset($movie->title) ? htmlspecialchars($movie->title) : ''; ?></h3>
                            <p class="movie-description"><?php echo isset($movie->description) ? htmlspecialchars(mb_substr($movie->description, 0, 100)) . '...' : ''; ?></p>
                            <div class="movie-details">
                                <p><strong>Rok:</strong> <?php echo isset($movie->year) ? htmlspecialchars($movie->year) : ''; ?></p>
                                <p><strong>Gatunek:</strong> <?php echo isset($movie->genre) ? htmlspecialchars($movie->genre) : ''; ?></p>
                                <p><strong>Typ:</strong> <?php echo isset($movie->type) ? htmlspecialchars($movie->type) : ''; ?></p>
                                <p><strong>Ocena:</strong> <?php echo (isset($movie->rating) && $movie->rating > 0) ? htmlspecialchars($movie->rating) . '/10' : 'Brak ocen'; ?></p>
                            </div>
                            <div class="margin-top-15">
                                <form action="<?php echo URLROOT; ?>/pages/removeFromWatchlist/<?php echo isset($movie->id) ? (int)$movie->id : 0; ?>" method="post">
                                    <button type="submit" class="btn btn-gray width-100">Usuń z listy</button>
                                </form>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="empty-state">
            <p class="empty-state-text">Twoja watchlista jest pusta. Dodaj jakieś filmy, aby zobaczyć je tutaj!</p>
            <a href="<?php echo URLROOT; ?>/productions" class="btn btn-primary margin-top-20">Przeglądaj produkcje</a>
        </div>
    <?php endif; ?>
</div>
