<?php $pageStyles = ['admin']; ?>

<div class="page-container">
    <div class="admin-section max-width-700 margin-auto">
        <div class="section-header">
            <h2>Dodaj Nową Platformę Streamingową</h2>
            <a href="<?php echo URLROOT; ?>/pages/admin#streaming" class="btn btn-edit">Wróć</a>
        </div>

        <form action="<?php echo URLROOT; ?>/pages/addPlatform" method="post" class="margin-top-20">
            <div class="form-group">
                <label for="name">Nazwa Platformy</label>
                <input type="text" name="name" id="name" class="form-control" required placeholder="np. Netflix, HBO Max">
            </div>

            <div class="form-group">
                <label for="price">Cena subskrypcji (PLN / mies.)</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" required placeholder="0.00">
            </div>

            <div class="form-group">
                <label for="offer">Opis oferty</label>
                <textarea name="offer" id="offer" class="form-control" rows="5" placeholder="np. Jakość 4K, 4 ekrany jednocześnie..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary padding-15 width-100">Dodaj Platformę</button>
        </form>
    </div>
</div>