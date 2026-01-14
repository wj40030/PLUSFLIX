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
    <h2 class="section-title" id="searchResultsTitle" style="display:none; margin-bottom: 20px;">Wyniki wyszukiwania</h2>
    <div class="movies-grid" id="dynamicSearchResults" style="display:none;"></div>

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
                            <p><strong>Typ:</strong> <?php echo $movie->type; ?></p>
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

function createMovieCard(movie, index) {
    const ratingDisplay = movie.rating > 0 ? `${movie.rating}/10` : 'Brak ocen';
    const delay = index * 0.1; // Staggered animation
    return `
        <a href="${urlRoot}/pages/detail/${movie.id}" class="movie-card-link animate-fade-in" style="animation-delay: ${delay}s">
            <div class="movie-card">
                <h3 class="movie-title">${movie.title}</h3>
                <p class="movie-description">${movie.description}</p>
                <div class="movie-details">
                    <p><strong>Rok:</strong> ${movie.year}</p>
                    <p><strong>Gatunek:</strong> ${movie.genre}</p>
                    <p><strong>Typ:</strong> ${movie.type}</p>
                    <p><strong>Ocena:</strong> ${ratingDisplay}</p>
                </div>
            </div>
        </a>
    `;
}

let searchTimeout;

searchInput.addEventListener('input', ({target}) => {
    const term = target.value.trim().toLowerCase();

    if (searchTimeout) clearTimeout(searchTimeout);

    if (!term) {
        latestMoviesTitle.style.display = 'block';
        searchResultsTitle.style.display = 'none';
        dynamicSearchResults.style.display = 'none';
        dynamicSearchResults.innerHTML = '';
        return;
    }

    // Dodajemy klasę przejścia i czyścimy stare wyniki
    dynamicSearchResults.classList.add('search-results-transitioning');
    dynamicSearchResults.innerHTML = '';

    searchTimeout = setTimeout(() => {
        latestMoviesTitle.style.display = 'none';
        searchResultsTitle.style.display = 'block';
        dynamicSearchResults.style.display = 'grid';

        const found = allMovies.filter(movie => 
            movie.title.toLowerCase().includes(term) || 
            movie.description.toLowerCase().includes(term) || 
            movie.genre.toLowerCase().includes(term) ||
            movie.type.toLowerCase().includes(term)
        );

        searchResultsTitle.innerText = found.length ? `Wyniki wyszukiwania dla: "${target.value}"` : 'Brak wyników';
        
        // Render results
        const content = found.map((movie, index) => createMovieCard(movie, index)).join('') 
            || '<p class="no-results animate-fade-in">Nie znaleziono filmów spełniających kryteria.</p>';
        
        dynamicSearchResults.innerHTML = content;
        
        // Usuwamy klasę przejścia po renderowaniu
        requestAnimationFrame(() => {
            dynamicSearchResults.classList.remove('search-results-transitioning');
        });
    }, 300); // Mały delay dla lepszego efektu przejścia
});
</script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>
