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
