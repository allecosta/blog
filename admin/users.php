<?php

include('../config.php');
include(ROOT_PATH . '/admin/includes/admin_functions.php');

$admins = getAdminUsers();
$roles = ['Admin', 'Author'];

include(ROOT_PATH . '/admin/includes/head_section.php');

?>

<title>Administrador | Gerenciamento de Usuários</title>
</head>

<body>
    <?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
    <div class="container content">
        <?php include(ROOT_PATH . '/admin/includes/menu.php') ?>
        <div class="action">
            <h1 class="page-title">Criar | Editar - Usuário Administrador</h1>
            <form method="POST" action="<?php echo BASE_URL . 'admin/users.php'; ?>">
                <?php include(ROOT_PATH . '/includes/errors.php') ?>

                <?php if ($isEditingUser === true) : ?>
                    <input type="hidden" name="admin-id" value="<?php echo $adminId; ?>">
                <?php endif ?>

                <input type="text" name="username" value="<?php $username; ?>" placeholder="Usuário">
                <input type="email" name="email" value="<?php echo $email; ?>" placeholder="Email">
                <input type="password" name="password" placeholder="Senha">
                <input type="password" name="passwordConfirmation" placeholder="Confirmação da senha">

                <select name="role">
                    <option value="" selected disabled>Atribuir Função</option>
                    <?php foreach ($roles as $key => $role) : ?>
                        <option value="<?php echo $role; ?><?php echo $role; ?>"></option>
                    <?php endforeach ?>
                </select>

                <?php if ($isEditingUser === true) : ?>
                    <button type="submit" class="" name="update-admin">Atualizar</button>
                <?php endif ?>
            </form>
        </div>
        <div class="table-div">
            <?php include(ROOT_PATH . '/admin/includes/messages.php') ?>

            <?php if (empty($admins)) : ?>
                <h1>Nenhum administrador no banco de dados</h1>
            <?php else : ?>
                <table class="table">
                    <thead>
                        <th>N</th>
                        <th>Administrador</th>
                        <th>Função</th>
                        <th colspan="2">Ação</th>
                    </thead>
                    <tbody>
                        <?php foreach ($admins as $key => $admin) : ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td>
                                    <?php echo $admin['username']; ?>, &nbsp;
                                    <?php echo $admin['email']; ?>
                                </td>
                                <td><?php echo $admin['role']; ?></td>
                                <td>
                                    <a class="fa fa-pencil btn edit" href="users.php?edit-admin=<?php echo $admin['id'] ?>">
                                    </a>
                                </td>
                                <td>
                                    <a class="fa fa-trash btn delete" href="users.php?delete-admin=<?php echo $admin['id'] ?>">
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
    </div>
</body>

</html>