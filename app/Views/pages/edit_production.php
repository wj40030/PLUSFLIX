<?php require APPROOT . '/Views/inc/header.php'; ?>

    <div class="page-container">
        <div class="admin-section max-width-800 margin-auto">
            <h2>Edytuj Produkcję: <?php echo $data['movie']->title; ?></h2>

            <form action="<?php echo URLROOT; ?>/pages/editProduction/<?php echo $data['movie']->id; ?>" method="post">
                <div class="form-group">
                    <label>Tytuł</label>
                    <input type="text" name="title" value="<?php echo $data['movie']->title; ?>" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Rok</label>
                    <input type="number" name="year" value="<?php echo $data['movie']->year; ?>" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Typ</label>
                    <select name="type" class="form-control">
                        <option value="Film" <?php echo ($data['movie']->type == 'Film') ? 'selected' : ''; ?>>Film</option>
                        <option value="Serial" <?php echo ($data['movie']->type == 'Serial') ? 'selected' : ''; ?>>Serial</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Gatunek</label>
                    <select name="genre_id" class="form-control" required>
                        <?php foreach($data['genres'] as $genre) : ?>
                            <option value="<?php echo $genre->id; ?>"
                                    <?php echo ($data['movie']->genre_id == $genre->id) ? 'selected' : ''; ?>>
                                <?php echo $genre->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Platforma Streamingowa</label>
                    <select name="streaming_platforms_id" class="form-control" required>
                        <?php foreach($data['streamings'] as $streaming) : ?>
                            <option value="<?php echo $streaming->id; ?>"
                                    <?php echo ($data['movie']->streaming_platforms_id == $streaming->id) ? 'selected' : ''; ?>>
                                <?php echo $streaming->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Opis</label>
                    <textarea name="description" rows="5" class="form-control"><?php echo $data['movie']->description; ?></textarea>
                </div>

                <div class="flex-gap-10">
                    <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
                    <a href="<?php echo URLROOT; ?>/pages/admin" class="btn btn-gray">Anuluj</a>
                </div>
            </form>
        </div>
    </div>

<?php require APPROOT . '/Views/inc/footer.php'; ?>