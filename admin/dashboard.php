<?php

include('../config.php');
include(ROOT_PATH . '/admin/includes/admin_functions.php');
include(ROOT_PATH . '/admin/includes/head_section.php');

?>

<title>Administrador | Painel</title>
</head>

<body>
    <div class="header">
        <div class="logo">
            <a href="<?php echo BASE_URL . 'admin/dashboard.php'; ?>">
                <h1>VidaBelaBlog | Administrador</h1>
            </a>
        </div>
        <?php if (isset($_SESSION['user'])) : ?>
            <div class="user-info">
                <span><?php echo $_SESSION['user']['username'] ?></span> &nbsp; &nbsp;
                <a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">Sair</a>
            </div>
        <?php endif ?>
    </div>
    <div class="container dashboard">
        <h1>Bem Vindo</h1>
        <div class="stats">
            <a href="users.php" class="first">
                <span>43</span><br>
                <span>Usuários recém-registrados</span>
            </a>
            <a href="posts.php">
                <span>43</span><br>
                <span>Posts Publicados</span>
            </a>
            <a>
                <span>43</span>
                <span>Comentários Publicados</span>
            </a>
        </div><br><br><br>
        <div>
            <a href="users.php">Adicionar Usuários</a>
            <a href="posts.php">Adicionar Posts</a>
        </div>
    </div>
</body>

</html>