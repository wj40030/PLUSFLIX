<?php $pageStyles = ['admin']; ?>
<div class="page-container">
    <div class="admin-section max-width-700 margin-auto">
        <h2>Edytuj Platformę: <?php echo $data['platform']->name; ?></h2>
        <form action="<?php echo URLROOT; ?>/pages/editPlatform/<?php echo $data['platform']->id; ?>" method="post">
            <div class="form-group">
                <label>Nazwa Platformy</label>
                <input type="text" name="name" value="<?php echo $data['platform']->name; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Cena miesięczna (PLN)</label>
                <input type="number" step="0.01" name="price" value="<?php echo $data['platform']->price; ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Oferta / Opis subskrypcji</label>
                <textarea name="offer" rows="4" class="form-control"><?php echo $data['platform']->offer; ?></textarea>
            </div>
            <div class="flex-gap-10">
                <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
                <a href="<?php echo URLROOT; ?>/pages/admin#streaming" class="btn btn-gray">Anuluj</a>
            </div>
        </form>
    </div>
</div>