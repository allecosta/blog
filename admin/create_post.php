<?php

include('../config.php');
include(ROOT_PATH . '/admin/includes/admin_functions.php');
include(ROOT_PATH . '/admin/includes/post_functions.php');
include(ROOT_PATH . '/admin/includes/head_section.php');

$topics = getAllTopics();

?>

<title>Criar Postagem</title>
</head>

<body>
    <?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

    <div class="action create-post-div">
        <h1 class="page-title">Criar | Editar Postagem</h1>
        <form method="POST" enctype="multipart/form-data" action="<?php echo BASE_URL . 'admin/create_post.php'; ?>">

            <?php include(ROOT_PATH . '/includes/errors.php') ?>

            <?php if ($isEditingPost === true) : ?>
                <input type="hidden" name="posts_id" value="<?php echo $postId; ?>">
            <?php endif ?>

            <input type="text" name="title" value="<?php echo $title; ?>" placeholder="Título">
            <label style="float: left; margin: 5px auto 5px;">Imagem em Destaque</label>
            <input type="file" name="featured-image">
            <textarea name="body" id="body" cols="30" rows="10"><?php echo $body; ?></textarea>
            <select name="topics_id">
                <option value="selected disabled">Escolha o Tópico</option>
                <?php foreach ($topics as $topic) : ?>
                    <option value="<?php echo $topic['id']; ?>">
                        <?php echo $topic['name']; ?>
                    </option>
                <?php endforeach ?>
            </select>

            <?php if ($_SESSION['user']['role'] == 'Admin') : ?>
                <?php if ($published == true) : ?>
                    <label for="publish">
                        Publicar
                        <input type="checkbox" value="1" name="publish" checked="checked">&nbsp;
                    </label>
                <?php else : ?>
                    <label for="publish">
                        Publicar
                        <input type="checkbox" value="1" name="publish">&nbsp;
                    </label>
                <?php endif ?>
            <?php endif ?>

            <?php if ($isEditingPost === true) : ?>
                <button type="submit" class="btn" name="update-post">Atualizar</button>
            <?php else : ?>
                <button type="submit" class="btn" name="create-post">Salvar Postagem</button>
            <?php endif ?>

        </form>
    </div>
</body>

</html>

<script>
    CKEDITOR.replace('body');
</script>