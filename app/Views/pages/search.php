<?php $pageStyles = ['productions']; ?>

<div class="page-container">
    <h1 class="page-title"><?php echo isset($title) ? htmlspecialchars($title) : ''; ?></h1>
    <p class="page-description"><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></p>

    <form method="POST" action="<?php echo URLROOT; ?>/pages/search" class="search-form">
        <label for="searchInput" class="sr-only">Szukaj</label>
        <input
            id="searchInput"
            type="text"
            name="search"
            placeholder="Wpisz tytuł, gatunek lub opis..."
            value="<?php echo isset($searchTerm) ? htmlspecialchars($searchTerm) : ''; ?>"
            class="search-input"
            aria-label="Szukaj"
        >
        <button type="submit" class="search-button">Szukaj</button>
    </form>

    <div id="redirectMessage" class="redirect-message">
        <p>Znaleziono pasujący film. Przekierowywanie...</p>
    </div>

    <?php if (!empty($searchTerm)): ?>
        <h2 class="search-results-title">Wyniki wyszukiwania dla: "<?php echo htmlspecialchars($searchTerm); ?>"</h2>

        <?php if (empty($movies)): ?>
            <p class="no-results">Nie znaleziono filmów</p>
        <?php else: ?>
            <div class="movies-grid">
                <?php foreach($movies as $movie): ?>
                    <a href="<?php echo URLROOT; ?>/pages/detail/<?php echo isset($movie->id) ? (int)$movie->id : 0; ?>" class="movie-card-link">
                        <div class="movie-card">
                            <h3 class="movie-title"><?php echo isset($movie->title) ? htmlspecialchars($movie->title) : ''; ?></h3>
                            <p class="movie-description"><?php echo isset($movie->description) ? htmlspecialchars($movie->description) : ''; ?></p>
                            <div class="movie-details">
                                <p><strong>Rok:</strong> <?php echo isset($movie->year) ? htmlspecialchars($movie->year) : ''; ?></p>
                                <p><strong>Gatunek:</strong> <?php echo isset($movie->genre) ? htmlspecialchars($movie->genre) : ''; ?></p>
                                <p><strong>Typ:</strong> <?php echo isset($movie->type) ? htmlspecialchars($movie->type) : ''; ?></p>
                                <p><strong>Ocena:</strong> <?php echo (isset($movie->rating) && $movie->rating > 0) ? htmlspecialchars($movie->rating) . '/10' : 'Brak ocen'; ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
const urlRoot = <?php echo json_encode(URLROOT); ?>;
const __movies = <?php echo json_encode($movies ?? []); ?>;
const movies = Array.isArray(__movies) ? __movies : [];
const term = (<?php echo json_encode(mb_strtolower($searchTerm ?? '')); ?> || '').toLowerCase();

if (movies.length && term) {
    const starts = movies.filter(m => m.title && m.title.toLowerCase().startsWith(term));
    const target = movies.find(m => m.title && m.title.toLowerCase() === term)
        || (starts.length === 1 && starts[0])
        || (movies.length === 1 && movies[0]);

    if (target) {
        const msg = document.getElementById('redirectMessage');
        if (msg) msg.classList.add('block');
        const grid = document.querySelector('.movies-grid');
        if (grid) grid.classList.add('hidden');

        setTimeout(() => location.href = `${urlRoot}/pages/detail/${target.id}`, 600);
    }
}
</script>
