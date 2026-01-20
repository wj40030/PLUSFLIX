<?php $pageStyles = ['login']; ?>

<div class="login-container">
    <div class="login-box">
        <h2>Logowanie do PLUSFLIX</h2>
        <p>Zaloguj się aby uzyskać dostep do aplikacji</p>

        <form action="<?php echo URLROOT; ?>/auth/login" method="post">
            <?php if (!empty($data['error'])): ?>
                <div class="invalid-feedback">
                    <?php echo $data['error']; ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="username">Nazwa użytkownika:</label>
                <input
                    type="text"
                    name="username"
                    id="username"
                    class="form-control"
                    value="<?php echo $data['username']; ?>"
                    placeholder="Wpisz nazwe uzytkownika"
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Haslo:</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Wpisz haslo">
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
