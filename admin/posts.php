<?php

include('../config.php');
include(ROOT_PATH . '/admin/includes/admin_functions.php');
include(ROOT_PATH . '/admin/includes/post_functions.php');
include(ROOT_PATH . '/admin/includes/head_section.php');

// $posts = getAllPosts();

?>

<title>Gerenciador de Posts</title>
</head>

<body>
    <?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

    <div class="container content">
        <?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

        <div class="table-div" style="width: 80%;">
            <?php include(ROOT_PATH . '/admin/includes/messages.php') ?>

            <?php if (empty($posts)) : ?>
                <h1 style="text-align: center; margin-top: 20px;">Não há postagens no banco de dados</h1>
            <?php else : ?>
                <table class="table">
                    <thead>
                        <th>N</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Visualização</th>

                        <?php if ($_SESSION['user']['role'] == "Admin") : ?>
                            <th><small>Publicado</small></th>
                        <?php endif ?>

                        <th><small>Edite</small></th>
                        <th><small>Delete</small></th>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $key => $post) : ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $post['author']; ?></td>
                                <td>
                                    <a target="_blank" href="<?php echo BASE_URL . 'single_post.php?post-slug=' . $post['slug'] ?>">
                                        <?php echo $post['title']; ?>
                                    </a>
                                </td>
                                <td><?php echo $post['views']; ?></td>

                                <?php if ($_SESSION['user']['role'] == "Admin") : ?>
                                    <td>
                                        <?php if ($post['published'] == true) : ?>
                                            <a class="fa fa-check btn unpublish" href="posts.php?unpublish=<?php echo $post['id'] ?>">
                                            </a>
                                        <?php else : ?>
                                            <a class="fa fa-times btn publish" href="posts.php?publish=<?php echo $post['id'] ?>">
                                            </a>
                                        <?php endif ?>
                                    </td>
                                <?php endif ?>

                                <td>
                                    <a class="fa fa-pencil btn edit" href="create_post.php?edit-post=<?php echo $post['id'] ?>">
                                    </a>
                                </td>
                                <td>
                                    <a class="fa fa-trash btn delete" href="create_post.php?delete-post=<?php echo $post['id'] ?>">
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