<?php require APPROOT . '/Views/inc/header.php'; ?>

<div class="page-container">
    <h1 class="page-title"><?php echo $data['title']; ?></h1>
    <p class="page-description"><?php echo $data['description']; ?></p>

    <h2 class="section-title" id="filters" style="text-align: center;">Filtry</h2>

    <div class="search-container">
        <div class="search-form" style="justify-content: center;">
            <form action="<?php echo URLROOT; ?>/pages/Productions" method="post" style="margin-top: 20px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Gatunek</label>
                        <select name="genre_id" class="form-control" required>
                            <?php foreach($data['genres'] as $genre) : ?>
                                <option value="<?php echo $genre->id; ?>">
                                    <?php echo $genre->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Platforma Streamingowa</label>
                        <select name="streaming_platforms_id" class="form-control" required>
                            <?php foreach($data['streamings'] as $streaming) : ?>
                                <option value="<?php echo $streaming->id; ?>">
                                    <?php echo $streaming->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px;">Filtruj</button>
            </form>
        </div>
    </div>
    <div id="searchSectionWrapper" style="display: grid; grid-template-rows: 0fr; transition: grid-template-rows 0.4s ease, height 0.4s ease; overflow: hidden;">
        <div style="min-height: 0;" id="searchSectionContent">
            <h2 class="section-title" id="searchResultsTitle" style="margin-bottom: 20px;">Wyniki wyszukiwania</h2>
            <div class="movies-grid" id="dynamicSearchResults"></div>
            <div style="height: 40px;"></div>
        </div>
    </div>


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
                            <p><strong>Typ:</strong> <?php echo $movie->type; ?></p>
                            <p><strong>Dostępność:</strong> <?php echo $movie->streaming_platforms; ?></p>
                            <p><strong>Ocena:</strong> <?php echo ($movie->rating > 0) ? $movie->rating . '/10' : 'Brak ocen'; ?></p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
