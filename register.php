<?php

include('config.php');
include('includes/registration_login.php');
include('includes/headsection.php');

?>

<title>Registre-se | VidaBelaBlog</title>
</head>

<body>
    <div class="container">
        <?php include(ROOT_PATH . '/includes/navbar.php'); ?>
        <div style="width: 40%; margin: 20px auto;">
            <form action="register.php" action="POST">
                <h2>Registre</h2>
                <?php include(ROOT_PATH . '/includes/errors.php') ?>
                <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Usuário">
                <input type="email" name="email" value="<?php echo $email; ?>" placeholder="Email">
                <input type="password" name="passwordOne" placeholder="Senha">
                <input type="password" name="passwordTwo" placeholder="Confirme a senha">
                <button type="submit" class="btn" name="reg-user">Registre</button>
                <p>
                    Já é um membro? <a href="login.php">Entre</a>
                </p>
            </form>
        </div>
    </div>

    <?php include(ROOT_PATH . '/includes/footer.php'); ?>