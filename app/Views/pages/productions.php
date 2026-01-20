<?php $pageStyles = ['productions']; ?>

<div class="page-container">
    <h1 class="page-title"><?php echo $data['title']; ?></h1>
    <p class="page-description"><?php echo $data['description']; ?></p>

    <h2 class="section-title" id="filters">Filtry</h2>

    <div class="search-container">
        <div class="search-form">
            <form id="filterForm" action="<?php echo URLROOT; ?>/pages/productions" method="GET">
                <div class="filter-grid">
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
                <button type="submit" class="btn btn-primary btn-filter">Filtruj</button>
                <a href="<?php echo URLROOT; ?>/pages/productions" class="btn btn-light btn-clear-filters">Wyczyść filtry</a>
            </form>
        </div>
    </div>
    <div id="searchSectionWrapper">
        <div id="searchSectionContent">
            <h2 class="section-title" id="searchResultsTitle">Wyniki wyszukiwania</h2>
            <div class="movies-grid" id="dynamicSearchResults"></div>
            <div class="spacer-40"></div>
        </div>
    </div>


    <?php if (empty($data['movies'])): ?>
        <p class="no-results">Brak filmów w bazie danych</p>
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

<script>
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        const form = this;
        const inputs = form.querySelectorAll('select');
        let hasActiveFilters = false;
        let filtersChanged = false;

        const urlParams = new URLSearchParams(window.location.search);

        inputs.forEach(input => {
            const currentValue = input.value;
            const paramValue = urlParams.get(input.name) || '';

            if (currentValue !== '') {
                hasActiveFilters = true;
            }

            if (currentValue !== paramValue) {
                filtersChanged = true;
            }

            // Disable empty inputs to prevent them from being added to URL
            if (currentValue === '') {
                input.disabled = true;
            }
        });

        if (!hasActiveFilters || !filtersChanged) {
            e.preventDefault();
            // Re-enable inputs if we prevent submission
            inputs.forEach(input => input.disabled = false);
            
            if (!hasActiveFilters) {
                alert('Proszę wybrać co najmniej jeden filtr.');
            } else if (!filtersChanged) {
                alert('Wybrane filtry są takie same jak obecnie zastosowane.');
            }
        }
    });
</script>
