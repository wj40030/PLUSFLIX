<?php require APPROOT . '/Views/inc/header.php'; ?>

<div class="page-container">
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 class="page-title"><?php echo $data['title']; ?></h1>
        <p class="page-description"><?php echo $data['description']; ?></p>
    </div>

    <?php if (!empty($data['movies'])) : ?>
        <div class="movies-grid">
            <?php foreach ($data['movies'] as $movie) : ?>
                <div class="movie-card" style="position: relative;">
                    <a href="<?php echo URLROOT; ?>/pages/detail/<?php echo $movie->id; ?>" class="movie-card-link" style="transform: none;">
                        <h3 class="movie-title"><?php echo $movie->title; ?></h3>
                        <p class="movie-description"><?php echo substr($movie->description, 0, 100) . '...'; ?></p>
                        <div class="movie-details">
                            <p><strong>Rok:</strong> <?php echo $movie->year; ?></p>
                            <p><strong>Gatunek:</strong> <?php echo $movie->genre; ?></p>
                            <p><strong>Typ:</strong> <?php echo $movie->type; ?></p>
                            <p><strong>Ocena:</strong> <?php echo ($movie->rating > 0) ? $movie->rating . '/10' : 'Brak ocen'; ?></p>
                        </div>
                    </a>
                    <div style="margin-top: 15px;">
                        <form action="<?php echo URLROOT; ?>/pages/removeFromWatchlist/<?php echo $movie->id; ?>" method="post">
                            <button type="submit" class="btn" style="width: 100%; background: #555;">Usuń z listy</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div style="text-align: center; margin-top: 50px;">
            <p style="font-size: 1.2rem; color: #999;">Twoja watchlista jest pusta. Dodaj jakieś filmy, aby zobaczyć je tutaj!</p>
            <a href="<?php echo URLROOT; ?>/productions" class="btn btn-primary" style="margin-top: 20px;">Przeglądaj produkcje</a>
        </div>
    <?php endif; ?>
</div>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
