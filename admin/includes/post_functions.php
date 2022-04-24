<?php

$postId = 0;
$isEditingPost = false;
$published = 0;
$title = "";
$postSlug = "";
$body = "";
$featuredImage = "";
$postTopic = "";

/**
 * Funcao de postagem
 * Retorna todas as postagens do banco de Dados
 */
function getAllPosts()
{
    global $conn;

    if ($_SESSION['user']['role'] == 'Admin') {
        $sql = "SELECT * FROM posts";
    } else if ($_SESSION['user']['role'] == "Author") {
        $userId = $_SESSION['user']['id'];
        $sql = "SELECT * FROM posts WHERE user_id=$userId";
    }

    $result = mysqli_query($conn, $sql);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $finalPosts = array();

    foreach ($posts as $post) {
        $post['author'] = getPostAuthorById($post['user_id']);
        array_push($finalPosts, $post);
    }

    return $finalPosts;
}

/**
 * Obtem o author 
 * Nome de usuario de uma postagem
 */
function getPostAuthorById($userId)
{
    global $conn;

    $sql = "SELECT username FROM users WHERE id=$userId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        return mysqli_fetch_assoc($result)['username'];
    } else {
        return null;
    }
}

if (isset($_POST['create-post'])) {
    createPost($_POST);
}

if (isset($_GET['edit-post'])) {
    $isEditingPost = true;
    $postId = $_GET['edit-post'];

    editPost($postId);
}

if (isset($_POST['update-post'])) {
    $postId = $_GET['delete-post'];

    deletePost($postId);
}

function createPost($requestValues)
{
    global $conn, $errors, $title, $featuredImage, $topicsId, $body, $published;

    $title = esc($requestValues['title']);
    $body = htmlentities(esc($requestValues['body']));

    if (isset($requestValues['topics_id'])) {
        $topicsId = esc($requestValues['topics_id']);
    }

    if (isset($requestValues['publish'])) {
        $published = esc($requestValues['publish']);
    }

    $postSlug = makeSlug($title);

    if (empty($title)) {
        array_push($errors, "É necessario o título da postagem");
    }

    if (empty($body)) {
        array_push($errors, "É necessario o corpo da postagem");
    }

    if (empty($topicsId)) {
        array_push($errors, "É necessario o tópico da postagem");
    }

    $featuredImage = $_FILES['featured-image']['name'];

    if (empty($featuredImage)) {
        array_push($errors, "É necessario uma imagem em destaque");
    }

    $target = "../static/images/" . basename($featuredImage);

    if (!move_uploaded_file($_FILES['featured-image']['tmp_name'], $target)) {
        array_push($errors, "OPS! Falha ao enviar a imagem. Verifique as configurações do arquivo do seu servidor.");
    }

    $postCheckQuery = "SELECT * FROM posts WHERE slug='$postSlug' LIMIT 1";
    $result = mysqli_query($conn, $postCheckQuery);

    if (count($errors) == 0) {
        $query = "INSERT INTO posts (user_id, title, slug, image, body, published, created_at, updated_at)
                VALUES (1, '$title', '$postSlug', '$featuredImage', '$body', '$published', now(), now())";

        if (mysqli_query($conn, $query)) {
            $insertedPostId = mysqli_insert_id($conn);
            $sql = "INSERT INTO posts_topics (posts_id, topics_id) VALUES ($insertedPostId, $topicsId)";

            mysqli_query($conn, $sql);
            $_SESSION['message'] = "Postagem criada com sucesso";
            header('location: posts.php');
            exit(0);
        }
    }
}

/**
 * Busca a postagem do banco de dados
 * Define os campos de postagem no formulário para edição
 */
function editPost($roleId)
{
    global $conn, $title, $postSlug, $body, $published, $isEditingPost, $postId;

    $sql = "SELECT * FROM posts WHERE id=$roleId LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);
    $title = $post['title'];
    $body = $post['body'];
    $published = $post['published'];
}

function updatePost($requestValues)
{
    global $conn, $errors, $postId, $title, $featuredImage, $topicsId, $body, $published;

    $title = esc($requestValues['title']);
    $body = esc($requestValues['body']);
    $postId = esc($requestValues['posts_id']);

    if (isset($requestValues['topics_id'])) {
        $topicsId = esc($requestValues['topics_id']);
    }

    $postSlug = makeSlug($title);

    if (empty($title)) {
        array_push($errors, "É necessario o título da postagem");
    }

    if (empty($body)) {
        array_push($errors, "É necessario o corpo da postagem");
    }

    if (isset($_POST['featured-image'])) {
        $featuredImage = $_FILES['featured-image']['name'];
        $target = "../static/images/" . basename($featuredImage);

        if (!move_uploaded_file($_FILES['featured-image']['tmp_name'], $target)) {
            array_push($errors, "OPS! Falha ao enviar a imagem. Verifique as configurações do arquivo do seu servidor.");
        }
    }

    if (count($errors) == 0) {
        $query = "UPDATE posts SET title='$title', slug='$postSlug', views=0, image='$featuredImage', body='$body',
        published=$published, updated_at=now() WHERE id=$postId";

        if (mysqli_query($conn, $query)) {
            if (isset($topicsId)) {
                $insertedPostId = mysqli_insert_id($conn);
                $sql = "INSERT INTO posts_topics (posts_id, topics_id) VALUES ($insertedPostId, $topicsId)";

                mysqli_query($conn, $sql);

                $_SESSION['message'] = "Postagem criada com sucesso";
                header('location: posts.php');
                exit(0);
            }
        }

        $_SESSION['message'] = "Postagem atualizada com sucesso";
        header('location: posts.php');
        exit(0);
    }
}

function deletePost($postId)
{
    global $conn;

    $sql = "DELETE FROM posts WHERE id=$postId";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Postagem excluida com sucesso";
        header('location: posts.php');
        exit(0);
    }
}

if (isset($_GET['publish']) || isset($_GET['unpublish'])) {
    $message = "";

    if (isset($_GET['publish'])) {
        $message = "Postagem publicada com sucesso";
        $postId = $_GET['publish'];
    } else if (isset($_GET['unpublish'])) {
        $message = "Não publicado";
        $postId = $_GET['unpublish'];
    }

    togglePublishPost($postId, $message);
}

function togglePublishPost($postId, $message)
{
    global $conn;

    $sql = "UPDATE posts SET published=!published WHERE id=$postId";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = $message;
        header('location: posts.php');
        exit(0);
    }
}
