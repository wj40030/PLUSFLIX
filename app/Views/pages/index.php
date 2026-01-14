<?php require APPROOT . '/Views/inc/header.php'; ?>

<div class="page-container">
    <h1 class="page-title"><?php echo $data['title']; ?></h1>
    <p class="page-description"><?php echo $data['description']; ?></p>

    <div class="search-container">
        <div class="search-form">
            <div class="search-wrapper">
                <input
                    type="text"
                    name="search"
                    id="searchInput"
                    placeholder="Wpisz tytul filmu..."
                    class="search-input"
                    autocomplete="off"
                >
                <div id="suggestions" class="suggestions"></div>
            </div>
        </div>
    </div>
    <h2 class="section-title" id="searchResultsTitle" style="display:none;">Wyniki wyszukiwania</h2>
    <div class="movies-grid" id="dynamicSearchResults"></div>

    <h2 class="section-title" id="latestMoviesTitle">Najnowsze filmy</h2>
    <?php if (!empty($data['movies'])): ?>
        <div class="movies-grid">
            <?php
            $count = 0;
            foreach($data['movies'] as $movie):
                if($count >= 6) break;
                $count++;
            ?>
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

    <h3 style="margin-top:50px;">Dane z bazy danych:</h3>
    <div class="grid">
        <?php foreach($data['examples'] as $example) : ?>
            <div class="card">
                <h4><?php echo $example->title; ?></h4>
                <p><?php echo $example->description; ?></p>
                <small>Dodano: <?php echo $example->created_at; ?></small>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
const searchInput = document.getElementById('searchInput');
const searchResultsTitle = document.getElementById('searchResultsTitle');
const dynamicSearchResults = document.getElementById('dynamicSearchResults');
const latestMoviesTitle = document.getElementById('latestMoviesTitle');
const urlRoot = '<?php echo URLROOT; ?>';

const allMovies = <?php echo json_encode($data['movies']); ?>;

function createMovieCard(movie) {
    const ratingDisplay = movie.rating > 0 ? `${movie.rating}/10` : 'Brak ocen';
    return `
        <a href="${urlRoot}/pages/detail/${movie.id}" class="movie-card-link">
            <div class="movie-card">
                <h3 class="movie-title">${movie.title}</h3>
                <p class="movie-description">${movie.description}</p>
                <div class="movie-details">
                    <p><strong>Rok:</strong> ${movie.year}</p>
                    <p><strong>Gatunek:</strong> ${movie.genre}</p>
                    <p><strong>Ocena:</strong> ${ratingDisplay}</p>
                </div>
            </div>
        </a>
    `;
}

searchInput.addEventListener('input', ({target}) => {
    const term = target.value.trim().toLowerCase();

    latestMoviesTitle.style.display = term ? 'none' : 'block';
    searchResultsTitle.style.display = term ? 'block' : 'none';
    dynamicSearchResults.style.display = term ? 'flex' : 'none';

    if (!term) return dynamicSearchResults.innerHTML = '';

    const found = allMovies.filter(movie => Object.values(movie).join(' ').toLowerCase().includes(term));

    searchResultsTitle.innerText = found.length ? `Wyniki: "${target.value}"` : 'Brak wyników';
    dynamicSearchResults.innerHTML = found.map(createMovieCard).join('') || '<p>Brak wyników.</p>';
});
</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
