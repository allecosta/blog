<?php

/**
 * Retorna todos os posts publicados
 */
function getPublishedPosts()
{
    global $conn;
    $sql = "SELECT * FROM posts WHERE published=true";
    $result = mysqli_query($conn, $sql);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $finalPosts = array();
    foreach ($posts as $post) {
        $post['topics'] = getPostsTopics($post['id']);
        array_push($finalPosts, $post);
    }

    return $finalPosts;
}

/**
 * Recebe o ID da postagem, e retorna o topico da postagem
 */
function getPostsTopics($postsId)
{
    global $conn;
    $sql = "SELECT * FROM topics WHERE id=
        (SELECT topics_id FROM posts_topics WHERE posts_id=$postsId) LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $topics = mysqli_fetch_assoc($result);
    return $topics;
}

/**
 * Retorna todas as postagens em um tópico
 */
function getPublishedPostsByTopics($topicsId)
{
    global $conn;
    $sql = "SELECT * FROM posts ps WHERE ps.id IN 
        (SELECT pt.posts_id FROM posts_topics pt 
            WHERE pt.topics_id=$topicsId GROUP BY pt.posts_id
                HAVING COUNT(1) = 1)";
    $result = mysqli_query($conn, $sql);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $finalPosts = array();

    foreach ($posts as $post) {
        $post['topics'] = getPostsTopics($post['id']);
        array_push($finalPosts, $post);
    }

    return $finalPosts;
}

/**
 * Retorna o nome do tópico por ID do tópico
 */
function getTopicsNameById($id)
{
    global $conn;
    $sql = "SELECT name FROM topics WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $topics = mysqli_fetch_assoc($result);
    return $topics['name'];
}

/**
 * Retorna uma unica postagem
 */

function getPost($slug)
{
    global $conn;
    $postSlug = $_GET['post-slug'];
    $sql = "SELECT * FROM posts WHERE slug='$postSlug' AND published=true";
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);

    if ($post) {
        $post['topics'] = getPostsTopics($post['id']);
    }

    return $post;
}

/**
 * Retorna todos os topicos
 */
function getAllTopics()
{
    global $conn;
    $sql = "SELECT * FROM topics";
    $result = mysqli_query($conn, $sql);
    $topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $topics;
}
