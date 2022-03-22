<?php
//require_once('includes/headsection.php');
require_once('config.php');
require_once(ROOT_PATH . '/includes/functions.php');

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