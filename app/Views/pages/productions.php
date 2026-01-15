<?php require APPROOT . '/Views/inc/header.php'; ?>

<div class="page-container">
    <h1 class="page-title"><?php echo $data['title']; ?></h1>
    <p class="page-description"><?php echo $data['description']; ?></p>

    <h2 class="section-title" id="filters" style="text-align: center;">Filtry</h2>

    <div class="search-container">
        <div class="search-form" style="justify-content: center;">
            <form action="<?php echo URLROOT; ?>/pages/productions" method="GET" style="margin-top: 20px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Gatunek</label>
                        <?php
                            $sGenre = $_GET['genre_id'] ?? '';
                        ?>
                        <select name="genre_id" class="form-control">
                            <option value="">Wszystkie gatunki</option>
                            <?php foreach($data['genres'] as $genre) : ?>
                                <option value="<?php echo $genre->id; ?>"
                                <?php if ($sGenre == $genre->id) { echo ' selected'; } ?>>
                                    <?php echo $genre->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Platforma Streamingowa</label>
                        <?php
                        $sStreaming = $_GET['streaming_platforms_id'] ?? '';
                        ?>
                        <select name="streaming_platforms_id" class="form-control">
                            <option value="">Wszystkie platformy</option>
                            <?php foreach($data['streamings'] as $streaming) : ?>
                                <option value="<?php echo $streaming->id; ?>"
                                        <?php if ($sStreaming == $streaming->id) { echo ' selected'; } ?>>
                                    <?php echo $streaming->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px;">Filtruj</button>
                <a href="<?php echo URLROOT; ?>/pages/productions" class="btn btn-light" style="width: 100%; padding: 10px; margin-top: 10px; text-align: center; display: block; background: #eee; color: #333; text-decoration: none; border-radius: 5px;">Wyczyść filtry</a>
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
