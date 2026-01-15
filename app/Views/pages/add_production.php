<?php require APPROOT . '/Views/inc/header.php'; ?>

    <div class="page-container">
        <div class="admin-section" style="max-width: 700px; margin: 0 auto;">
            <div class="section-header">
                <h2>Dodaj Nową Produkcję</h2>
                <a href="<?php echo URLROOT; ?>/pages/admin" class="btn" style="background: #444;">Wróć</a>
            </div>

            <form action="<?php echo URLROOT; ?>/pages/addProduction" method="post" style="margin-top: 20px;">
                <div class="form-group">
                    <label>Tytuł</label>
                    <input type="text" name="title" class="form-control" required placeholder="Tytuł filmu lub serialu">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Rok produkcji</label>
                        <input type="number" name="year" class="form-control" required value="<?php echo date('Y'); ?>">
                    </div>
                    <div class="form-group">
                        <label>Typ</label>
                        <select name="type" class="form-control">
                            <option value="Film">Film</option>
                            <option value="Serial">Serial</option>
                        </select>
                    </div>
                </div>

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

                <div class="form-group">
                    <label>Opis produkcji</label>
                    <textarea name="description" class="form-control" rows="6" placeholder="Pełny opis..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px;">Opublikuj Produkcję</button>
            </form>
        </div>
    </div>

<?php require APPROOT . '/Views/inc/footer.php'; ?>