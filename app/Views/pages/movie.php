<?php $pageStyles = ['reviews']; ?>

<div class="page-container">
    <div class="movie-details-container">
        <div class="movie-poster">
            <div class="poster-placeholder">
                <span>Brak zdjęcia</span>
            </div>
        </div>

        <div class="movie-info">
            <h1 class="movie-details-title"><?php echo isset($data['movie']->title) ? htmlspecialchars($data['movie']->title) : ''; ?></h1>

            <div class="movie-meta">
                <span class="meta-item"><strong>Rok:</strong> <?php echo isset($data['movie']->year) ? htmlspecialchars($data['movie']->year) : ''; ?></span>
                <span class="meta-item"><strong>Gatunek:</strong> <?php echo isset($data['movie']->genre) ? htmlspecialchars($data['movie']->genre) : ''; ?></span>
                <span class="meta-item"><strong>Typ:</strong> <?php echo isset($data['movie']->type) ? htmlspecialchars($data['movie']->type) : ''; ?></span>
                <span class="meta-item"><strong>Dostępność:</strong> <?php echo (!empty($data['movie']->streaming_platforms)) ? htmlspecialchars($data['movie']->streaming_platforms) : 'Brak danych'; ?></span>
                <span class="meta-item rating"><strong>Ocena:</strong>
                    <?php echo (isset($data['movie']->rating) && $data['movie']->rating > 0) ? htmlspecialchars($data['movie']->rating) . '/10' : 'Brak ocen'; ?>
                </span>
            </div>

            <div class="movie-description-full">
                <h3>Opis</h3>
                <p><?php echo isset($data['movie']->description) ? htmlspecialchars($data['movie']->description) : ''; ?></p>
            </div>

            <div class="movie-actions">
                <a href="<?php echo URLROOT; ?>" class="btn-back">Powrót do strony głównej</a>
                
                <?php if (isLoggedIn()) : ?>
                    <?php if (!$data['isInWatchlist']) : ?>
                        <form action="<?php echo URLROOT; ?>/pages/addToWatchlist/<?php echo isset($data['movie']->id) ? (int)$data['movie']->id : 0; ?>" method="post" class="inline-form">
                            <button type="submit" class="btn btn-primary margin-left-10">+ Dodaj do watchlisty</button>
                        </form>
                    <?php else : ?>
                        <form action="<?php echo URLROOT; ?>/pages/removeFromWatchlist/<?php echo isset($data['movie']->id) ? (int)$data['movie']->id : 0; ?>" method="post" class="inline-form">
                            <button type="submit" class="btn btn-gray margin-left-10">Usuń z watchlisty</button>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="movie-reviews-section">
        <h2>Recenzje i Oceny</h2>

        <?php if (isLoggedIn()) : ?>
            <div class="add-review-form">
                <h3>Dodaj swoją ocenę</h3>
                <form action="<?php echo URLROOT; ?>/pages/detail/<?php echo isset($data['movie']->id) ? (int)$data['movie']->id : 0; ?>" method="post">
                    <div class="form-group">
                        <label for="rating">Ocena (1-10):</label>
                        <select name="rating" id="rating" required class="form-control">
                            <option value="">Wybierz ocenę</option>
                            <?php for ($i = 10; $i >= 1; $i--) : ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="comment">Komentarz:</label>
                        <textarea name="comment" id="comment" rows="3" class="form-control" placeholder="Co sądzisz o tym tytule?"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Opublikuj</button>
                </form>
            </div>
        <?php else : ?>
            <p><a href="<?php echo URLROOT; ?>/auth/login">Zaloguj się</a>, aby dodać ocenę.</p>
        <?php endif; ?>

        <div class="reviews-list">
            <?php if (!empty($data['ratings'])) : ?>
                <?php foreach ($data['ratings'] as $rating) : ?>
                    <div class="review-item <?php echo !$rating->is_approved ? 'pending-review' : ''; ?>">
                        <div class="review-header">
                            <span class="review-author"><?php echo htmlspecialchars($rating->username); ?></span>
                            <?php if (!$rating->is_approved) : ?>
                                <span class="badge badge-pending">Oczekuje na zatwierdzenie</span>
                            <?php endif; ?>
                            <span class="review-rating"><?php echo htmlspecialchars($rating->rating); ?>/10</span>
                            <span class="review-date"><?php echo date('d.m.Y H:i', strtotime($rating->created_at)); ?></span>
                        </div>
                        <?php if (!empty($rating->comment)) : ?>
                            <div class="review-comment">
                                <?php echo htmlspecialchars($rating->comment); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Brak ocen dla tego tytułu. Bądź pierwszy!</p>
            <?php endif; ?>
        </div>
    </div>
</div>
