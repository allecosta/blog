<?php
//require_once('includes/headsection.php');
require_once('config.php');
require_once(ROOT_PATH . '/includes/functions.php');
require_once(ROOT_PATH . '/includes/registration_login.php');

$posts = getPublishedPosts();

require_once(ROOT_PATH . '/includes/headsection.php');

?>

<title>VidaBelaBlog | Home</title>
</head>

<body>
    <div class="container">
        <?php
        include(ROOT_PATH . '/includes/navbar.php');
        include(ROOT_PATH . '/includes/banner.php');
        ?>
        <div class="content">
            <h2 class="content-title">Artigos Recentes</h2>
            <hr>
            <?php foreach ($posts as $post) : ?>
                <div class="post" style="margin-left: 0px;">
                    <img src="<?php echo BASE_URL . '/static/images/' . $post['image']; ?>" class="post-image" alt="">
                    <?php if (isset($post['topics']['name'])) : ?>
                        <a href="<?php echo BASE_URL . 'filtered_posts.php?topics=' . $post['topics']['id'] ?>" class="btn category">
                            <?php echo $post['topics']['name'] ?>
                        </a>
                    <?php endif ?>
                    <a href="single_post.php?post-slug=<?php echo $post['slug']; ?>">
                        <div class="post-info">
                            <h3><?php $post['title'] ?></h3>
                            <div class="info">
                                <span><?php echo date("F j, Y", strtotime($post['created_at'])); ?></span>
                                <span class="read-more">Leia mais...</span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach ?>
        </div>

        <?php include(ROOT_PATH . '/includes/footer.php') ?>