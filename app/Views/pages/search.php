<?php require APPROOT . '/Views/inc/header.php'; ?>

<div class="page-container">
    <h1 class="page-title"><?php echo $data['title']; ?></h1>
    <p class="page-description"><?php echo $data['description']; ?></p>

    <form method="POST" action="<?php echo URLROOT; ?>/pages/search" class="search-form">
        <input
            type="text"
            name="search"
            placeholder="Wpisz tytul, gatunek lub opis..."
            value="<?php echo $data['searchTerm']; ?>"
            class="search-input"
        >
        <button type="submit" class="search-button">Szukaj</button>
    </form>

    <div id="redirectMessage" class="redirect-message" style="display:none; text-align: center; margin: 20px; color: #e50914;">
        <p>Znaleziono pasujący film. Przekierowywanie...</p>
    </div>

    <?php if (!empty($data['searchTerm'])): ?>
        <h2 class="search-results-title">Wyniki wyszukiwania dla: "<?php echo $data['searchTerm']; ?>"</h2>

        <?php if (empty($data['movies'])): ?>
            <p class="no-results">Nie znaleziono filmow</p>
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
                                <p><strong>Ocena:</strong> <?php echo ($movie->rating > 0) ? $movie->rating . '/10' : 'Brak ocen'; ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php require APPROOT . '/Views/inc/footer.php'; ?>

<script>
const urlRoot = '<?php echo URLROOT; ?>';
const movies = <?php echo !empty($data['movies']) ? json_encode($data['movies']) : '[]'; ?>;
const term = "<?php echo !empty($data['searchTerm']) ? addslashes($data['searchTerm']) : ''; ?>".toLowerCase();

if (movies.length && term) {
    const starts = movies.filter(m => m.title.toLowerCase().startsWith(term));
    const target = movies.find(m => m.title.toLowerCase() === term)
        || (starts.length === 1 && starts[0])
        || (movies.length === 1 && movies[0]);

    if (target) {
        document.getElementById('redirectMessage').style.display = 'block';
        const grid = document.querySelector('.movies-grid');
        if (grid) grid.style.display = 'none';

        setTimeout(() => location.href = `${urlRoot}/pages/detail/${target.id}`, 100);
    }
}
</script>
