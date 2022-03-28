<?php

include('config.php');
include('includes/functions.php');
include('includes/headsection.php');

if (isset($_POST['topics'])) {
    $topicsId = $_GET['topics'];
    $posts = getPublishedPostsByTopics($topicsId);
}

?>

<title>VidaBelaBlog | Home</title>
</head>

<body>
    <div class="container">
        <?php include(ROOT_PATH . '/includes/navbar.php'); ?>
        <div class="content">
            <h2 class="content-title">
                Artigos Sobre <u><?php echo getTopicsNameById($topicsId); ?></u>
            </h2>
            <hr>
            <?php foreach ($posts as $post) : ?>
                <div class="post" style="margin-left: 0px;">
                    <img src="<?php echo BASE_URL . '/static/images/' . $post['image']; ?>" class="post-image" alt="">
                    <a href="single_post.php?post-slug=<?php echo $post['slug']; ?>">
                        <div class="post-info">
                            <h3><?php echo $post['title'] ?></h3>
                            <div class="info">
                                <span><?php echo date("F j, Y", strtotime($post['created_at'])); ?></span>
                                <span class="read-more">Leia mais...</span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach ?>
        </div>
    </div>

    <?php include(ROOT_PATH . '/includes/footer.php'); ?>