<?php require APPROOT . '/Views/inc/header.php'; ?>

    <div class="admin-container">
        <aside class="admin-sidebar">
            <h2>Panel Admina</h2>
            <nav id="admin-nav">
                <a href="#dashboard" class="active">Pulpit</a>
                <a href="#productions">Produkcje</a>
                <a href="#streaming">Platformy VOD</a>
                <a href="#comments">Komentarze</a>
            </nav>
        </aside>

        <main class="admin-content">
            <section id="dashboard" class="admin-section">
                <h1>Witaj, Administratorze</h1>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Użytkownicy</h3>
                        <p class="stat-number">N/A</p>
                    </div>
                    <div class="stat-card">
                        <h3>Produkcje</h3>
                        <p class="stat-number"><?php echo $data['stats']['movies']; ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Komentarze</h3>
                        <p class="stat-number"><?php echo $data['stats']['ratings']; ?></p>
                    </div>
                </div>
            </section>

            <section id="productions" class="admin-section">
                <div class="section-header">
                    <h2>Zarządzanie Produkcjami</h2>
                    <a href="<?php echo URLROOT; ?>/pages/addProduction" class="btn btn-primary">+ Dodaj Produkcję</a>
                </div>

                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                        <tr><th>ID</th><th>Tytuł</th><th>Gatunek</th><th>Akcje</th></tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($data['movies'])) : ?>
                            <?php foreach($data['movies'] as $movie) : ?>
                                <tr>
                                    <td>#<?php echo $movie->id; ?></td>
                                    <td><strong><?php echo $movie->title; ?></strong></td>
                                    <td><?php echo $movie->genre; ?></td>
                                    <td>
                                        <div class="flex-gap-5">
                                            <a href="<?php echo URLROOT; ?>/pages/editProduction/<?php echo $movie->id; ?>" class="btn-sm btn-edit">Edytuj</a>
                                            <form action="<?php echo URLROOT; ?>/pages/deleteProduction/<?php echo $movie->id; ?>" method="post" onsubmit="return confirm('Czy na pewno chcesz usunąć tę produkcję?');">
                                                <button type="submit" class="btn-sm btn-delete">Usuń</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="4" class="text-center">Brak produkcji do wyświetlenia.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if($data['totalPages'] > 1) : ?>
                    <div class="pagination-admin">
                        <?php for($i = 1; $i <= $data['totalPages']; $i++) : ?>
                            <a href="<?php echo URLROOT; ?>/pages/admin/<?php echo $i; ?>#productions"
                               class="btn-sm <?php echo ($i == $data['currentPage']) ? 'btn-primary' : 'btn-edit'; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </section>

            <section id="streaming" class="admin-section">
                <h2>Platformy Streamingowe</h2>
                <div class="grid-streaming">
                    <?php if(!empty($data['platforms'])) : ?>
                        <?php foreach($data['platforms'] as $platform) : ?>
                            <div class="streaming-card">
                                <h3><?php echo $platform->name; ?></h3>
                                <p><strong>Cena:</strong> <?php echo $platform->price; ?> PLN</p>
                                <p><strong>Oferta:</strong> <?php echo $platform->offer; ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Brak danych o platformach.</p>
                    <?php endif; ?>
                </div>
            </section>

            <section id="comments" class="admin-section">
                <h2>Moderacja Komentarzy i Ocen</h2>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Użytkownik</th>
                            <th>Produkcja</th>
                            <th>Ocena</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th>Akcje</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($data['ratings'])) : ?>
                            <?php foreach($data['ratings'] as $rating) : ?>
                                <tr>
                                    <td><?php echo $rating->id; ?></td>
                                    <td><?php echo $rating->username; ?></td>
                                    <td><?php echo $rating->production_title; ?></td>
                                    <td><?php echo $rating->rating; ?>/10</td>
                                    <td><?php echo date('d.m.Y H:i', strtotime($rating->created_at)); ?></td>
                                    <td>
                                        <span class="badge <?php echo $rating->is_approved ? 'badge-approved' : 'badge-pending'; ?>">
                                            <?php echo $rating->is_approved ? 'Zatwierdzony' : 'Oczekuje'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex-gap-5">
                                            <?php if(!$rating->is_approved) : ?>
                                                <form action="<?php echo URLROOT; ?>/pages/approveRating/<?php echo $rating->id; ?>" method="post">
                                                    <button type="submit" class="btn-sm btn-edit">Zatwierdź</button>
                                                </form>
                                            <?php endif; ?>
                                            <form action="<?php echo URLROOT; ?>/pages/deleteRating/<?php echo $rating->id; ?>" method="post" onsubmit="return confirm('Usunąć ocenę?');">
                                                <button type="submit" class="btn-sm btn-delete">Usuń</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="7" class="text-center">Brak komentarzy.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script>
        const navLinks = document.querySelectorAll('#admin-nav a');
        const sections = document.querySelectorAll('.admin-section');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (pageYOffset >= sectionTop - 150) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').includes(current)) {
                    link.classList.add('active');
                }
            });
        });
    </script>

<?php require APPROOT . '/Views/inc/footer.php'; ?>