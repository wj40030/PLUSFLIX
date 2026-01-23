<?php $pageStyles = ['productions']; ?>

<h1><?php echo isset($title) ? htmlspecialchars($title) : ''; ?></h1>
<p><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></p>

<h3>Dane z bazy danych:</h3>
<div class="grid">
    <?php if (!empty($series)) : ?>
        <?php foreach($series as $item) : ?>
            <div class="card">
                <h4><?php echo isset($item->title) ? htmlspecialchars($item->title) : ''; ?></h4>
                <p><?php echo isset($item->description) ? htmlspecialchars($item->description) : ''; ?></p>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Brak danych.</p>
    <?php endif; ?>
</div>
