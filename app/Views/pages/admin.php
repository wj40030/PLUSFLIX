<?php require APPROOT . '/Views/inc/header.php'; ?>

    <div class="admin-container">
        <aside class="admin-sidebar">
            <h2>Panel Admina</h2>
            <nav>
                <a href="#dashboard" class="active">Pulpit</a>
                <a href="#productions">Produkcje</a>
                <a href="#streaming">Platformy VOD</a>
                <a href="#users">Użytkownicy</a>
                <a href="#comments">Komentarze</a>
            </nav>
        </aside>

        <main class="admin-content">
            <section id="dashboard" class="admin-section">
                <h1>Witaj, Administratorze</h1>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Użytkownicy</h3>
                        <p class="stat-number">1,245</p>
                    </div>
                    <div class="stat-card">
                        <h3>Produkcje</h3>
                        <p class="stat-number">84</p>
                    </div>
                    <div class="stat-card">
                        <h3>Komentarze</h3>
                        <p class="stat-number">342</p>
                    </div>
                </div>
            </section>

            <section id="productions" class="admin-section">
                <div class="section-header">
                    <h2>Zarządzanie Produkcjami</h2>
                    <button class="btn btn-primary">+ Dodaj Produkcję</button>
                </div>

                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tytuł</th>
                            <th>Gatunek</th>
                            <th>Platforma</th>
                            <th>Akcje</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Vox Machina</td>
                            <td>Animacja</td>
                            <td>Prime Video</td>
                            <td>
                                <button class="btn-sm btn-edit">Edytuj</button>
                                <button class="btn-sm btn-delete">Usuń</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="form-box" style="margin-top: 30px; border-top: 1px solid #444; padding-top: 20px;">
                    <h3>Formularz Produkcji (Makieta)</h3>
                    <form>
                        <div class="form-group">
                            <label>Tytuł filmu/serialu</label>
                            <input type="text" class="form-control" placeholder="Wpisz tytuł">
                        </div>
                        <div class="form-group">
                            <label>Przypisz do Streamingu</label>
                            <select class="form-control">
                                <option>Netflix</option>
                                <option>Prime Video</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kategorie / Tagi</label>
                            <div class="checkbox-group">
                                <label><input type="checkbox"> Horror</label>
                                <label><input type="checkbox"> Sci-Fi</label>
                                <label><input type="checkbox"> Dramat</label>
                            </div>
                        </div>
                        <button class="btn btn-primary">Zapisz</button>
                    </form>
                </div>
            </section>

            <section id="streaming" class="admin-section">
                <div class="section-header">
                    <h2>Platformy Streamingowe</h2>
                    <button class="btn btn-primary">+ Nowa Platforma</button>
                </div>

                <div class="grid-streaming">
                    <div class="streaming-card">
                        <div class="streaming-header">
                            <h3>Netflix</h3>
                            <div class="actions">
                                <button class="btn-icon">✏️</button>
                                <button class="btn-icon">🗑️</button>
                            </div>
                        </div>
                        <p><strong>Cena:</strong> 43.00 PLN</p>
                        <p><strong>Oferta:</strong> 4K, 4 Ekrany</p>
                    </div>

                    <div class="streaming-card">
                        <div class="streaming-header">
                            <h3>Prime Video</h3>
                            <div class="actions">
                                <button class="btn-icon">✏️</button>
                                <button class="btn-icon">🗑️</button>
                            </div>
                        </div>
                        <p><strong>Cena:</strong> 10.99 PLN</p>
                        <p><strong>Oferta:</strong> Darmowa dostawa, Video, Gaming</p>
                    </div>
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
                            <th>Komentarz</th>
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
                                <td style="max-width: 300px;"><?php echo htmlspecialchars($rating->comment); ?></td>
                                <td><?php echo date('d.m.Y H:i', strtotime($rating->created_at)); ?></td>
                                <td>
                                    <?php if($rating->is_approved) : ?>
                                        <span class="badge" style="background: green;">Zatwierdzony</span>
                                    <?php else : ?>
                                        <span class="badge" style="background: orange;">Oczekuje</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 5px;">
                                        <?php if(!$rating->is_approved) : ?>
                                            <form action="<?php echo URLROOT; ?>/pages/approveRating/<?php echo $rating->id; ?>" method="post">
                                                <button type="submit" class="btn-sm btn-edit">Zatwierdź</button>
                                            </form>
                                        <?php endif; ?>
                                        <form action="<?php echo URLROOT; ?>/pages/deleteRating/<?php echo $rating->id; ?>" method="post" onsubmit="return confirm('Czy na pewno chcesz usunąć tę ocenę?');">
                                            <button type="submit" class="btn-sm btn-delete">Usuń</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" style="text-align: center;">Brak komentarzy do wyświetlenia.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

<?php require APPROOT . '/Views/inc/footer.php'; ?>