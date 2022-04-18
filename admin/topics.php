<?php

include('../config.php');
include(ROOT_PATH . '/admin/includes/admin_functions.php');
include(ROOT_PATH . '/admin/includes/head_section.php');

$topics = getAllTopics();

?>

<title>Administrador | Gerenciador de Tópicos</title>

</head>

<body>
    <?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
    <div class="container content">
        <?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

        <div class="action">
            <h1 class="page-title">Criar | Editar Tópicos</h1>
            <form method="POST" action="<?php echo BASE_URL, 'admin/topics.php'; ?>">
                <?php include(ROOT_PATH . '/includes/errors.php') ?>

                <?php if ($isEditingTopic === true) : ?>
                    <input type="hidden" name="topics-id" value="<?php echo $topicsId; ?>">
                <?php endif ?>

                <input type="text" name="topics-name" value="<?php echo $topicsName; ?>" placeholder="Tópico">

                <?php if ($isEditingTopic === true) : ?>
                    <button type="submit" class="btn" name="update-topics">Atualizar</button>
                <?php else : ?>
                    <button type="submit" class="btn" name="create-topics">Salvar Tópico</button>
                <?php endif ?>
            </form>
        </div>

        <div class="table-div">
            <?php include(ROOT_PATH . '/includes/messages.php') ?>

            <?php if (empty($topics)) : ?>
                <h1>Nenhum tópico no Banco de Dados</h1>
            <?php else : ?>
                <table class="table">
                    <thead>
                        <th>N</th>
                        <th>Nome do Tópico</th>
                        <th colspan="2">Ação</th>
                    </thead>
                    <tbody>
                        <?php foreach ($topics as $key => $topic) : ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $topic['name']; ?></td>
                                <td>
                                    <a class="fa fa-pencil btn edit" href="topics.php?edit-topic=<?php echo $topic['id'] ?>">
                                    </a>
                                </td>
                                <td>
                                    <a class="fa fa-trash btn delete" href="topics.php?delete-topic=<?php echo $topic['id'] ?>">
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