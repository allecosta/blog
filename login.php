<?php

include('config.php');
include('includes/registration_login.php');
include('includes/headsection.php');

?>

<title>Entre | VidabelaBlog</title>
</head>

<body>
    <div class="container">
        <?php include(ROOT_PATH . '/includes/navbar.php'); ?>
        <div style="width: 40%; margin: 20px auto;">
            <form action="POST" action="login.php">
                <h2>Login</h2>
                <?php include(ROOT_PATH . '/includes/errors.php') ?>
                <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Usuário">
                <input type="password" name="password" value="<?php echo $password; ?>" placeholder="Senha">
                <button type="submit" class="btn" name="login-btn">Login</button>
                <p>
                    Ainda não é um membro? <a href="register.php">Registre-se</a>
                </p>
            </form>
        </div>
    </div>

    <?php include(ROOT_PATH . '/includes/footer.php'); ?>