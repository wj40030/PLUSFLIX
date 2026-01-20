<?php $pageStyles = ['productions']; ?>

<div class="page-container">
    <div class="center-content margin-bottom-40">
        <h1 class="page-title"><?php echo $data['title']; ?></h1>
        <p class="page-description"><?php echo $data['description']; ?></p>
    </div>

    <?php if (!empty($data['movies'])) : ?>
        <div class="movies-grid">
            <?php foreach ($data['movies'] as $movie) : ?>
                <div class="movie-card-container">
                    <a href="<?php echo URLROOT; ?>/pages/detail/<?php echo $movie->id; ?>" class="movie-card-link no-transform">
                        <div class="movie-card">
                            <h3 class="movie-title"><?php echo $movie->title; ?></h3>
                            <p class="movie-description"><?php echo substr($movie->description, 0, 100) . '...'; ?></p>
                            <div class="movie-details">
                                <p><strong>Rok:</strong> <?php echo $movie->year; ?></p>
                                <p><strong>Gatunek:</strong> <?php echo $movie->genre; ?></p>
                                <p><strong>Typ:</strong> <?php echo $movie->type; ?></p>
                                <p><strong>Ocena:</strong> <?php echo ($movie->rating > 0) ? $movie->rating . '/10' : 'Brak ocen'; ?></p>
                            </div>
                            <div class="margin-top-15">
                                <form action="<?php echo URLROOT; ?>/pages/removeFromWatchlist/<?php echo $movie->id; ?>" method="post">
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
