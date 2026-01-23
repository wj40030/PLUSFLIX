<?php $pageStyles = ['login']; ?>

<div class="login-container">
    <div class="login-box">
        <h2>Logowanie do PLUSFLIX</h2>
        <p>Zaloguj się aby uzyskać dostęp do aplikacji</p>

        <form action="<?php echo URLROOT; ?>/auth/login" method="post">
            <?php if (!empty($errors)) : ?>
                <div class="invalid-feedback">
                    <?php foreach ($errors as $err) : ?>
                        <p><?php echo htmlspecialchars($err); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="username">Nazwa użytkownika:</label>
                <input
                    type="text"
                    name="username"
                    id="username"
                    class="form-control"
                    value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>"
                    placeholder="Wpisz nazwę użytkownika"
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Haslo:</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Wpisz hasło">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Zaloguj się</button>
            </div>
        </form>

        <div class="login-info">
            <h4>Dane testowe:</h4>
            <p><strong>Użytkownik:</strong> user / user</p>
            <p><strong>Administrator:</strong> admin / tajne</p>
        </div>

    </div>
</div>
