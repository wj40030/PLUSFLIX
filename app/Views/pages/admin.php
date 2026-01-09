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

            <section id="users" class="admin-section">
                <h2>Użytkownicy</h2>
                <table class="admin-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Login</th>
                        <th>Rola</th>
                        <th>Akcje</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>admin</td>
                        <td><span class="badge badge-admin">Admin</span></td>
                        <td><button class="btn-sm btn-edit">Edytuj</button></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>user</td>
                        <td><span class="badge badge-user">User</span></td>
                        <td><button class="btn-sm btn-edit">Edytuj</button></td>
                    </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

<?php require APPROOT . '/Views/inc/footer.php'; ?>