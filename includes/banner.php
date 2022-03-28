<?php if (isset($_SESSION['user']['username'])) { ?>
    <div class="logged-in-info">
        <span>Bem vindo <?php echo $_SESSION['user']['username'] ?></span>
        |
        <span><a href="logout.php">Sair</a></span>
    </div>
<?php } else { ?>
    <div class="banner">
        <div class="welcome-msg">
            <h1>Inspiração de hoje</h1>
            <p>
                Um dia sua vida<br>
                piscará diante de seus olhos<br>
                Verifique se vale a pena assistir<br>
                Faça o seu melhor hoje!
            </p>
            <a href="register.php" class="btn">Junte-se a nós!</a>
        </div>
        <div class="login-div">
            <form action="<?php echo BASE_URL . 'index.php'; ?>" method="POST">
                <h2>Login</h2>
                <div style="width: 60%; margin: 0px auto;">
                    <?php include(ROOT_PATH . '/includes/errors.php') ?>
                </div>
                <input type="text" name="username" placeholder="Nome de usuário">
                <input type="password" name="password" placeholder="Senha">
                <button class="btn" type="submit" name="login-btn">Entrar</button>
            </form>
        </div>
    </div>
<?php } ?>