<?php $pageStyles = ['productions']; ?>

<div class="page-container">
    <h1 class="page-title"><?php echo isset($title) ? htmlspecialchars($title) : ''; ?></h1>
    <p class="page-description"><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></p>

    <?php if (empty($series)): ?>
        <p class="no-results">Brak filmów w bazie danych</p>
    <?php else: ?>
        <div class="movies-grid">
            <?php foreach($series as $item): ?>
                <a href="<?php echo URLROOT; ?>/pages/detail/<?php echo $item->id; ?>" class="movie-card-link">
                    <div class="movie-card">
                        <h3 class="movie-title"><?php echo $item->title; ?></h3>
                        <p class="movie-description"><?php echo $item->description; ?></p>
                        <div class="movie-details">
                            <p><strong>Rok:</strong> <?php echo $item->year; ?></p>
                            <p><strong>Gatunek:</strong> <?php echo $item->genre; ?></p>
                            <p><strong>Typ:</strong> <?php echo $item->type; ?></p>
                            <p><strong>Dostępność:</strong> <?php echo $item->streaming_platforms; ?></p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
