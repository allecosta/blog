<?php

//require_once('includes/headsection.php');
require_once('config.php');
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
        </div>

        <?php include(ROOT_PATH . '/includes/footer.php') ?>