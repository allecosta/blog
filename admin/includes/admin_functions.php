<?php

$adminId = 0;
$isEditingUser = false;
$username = "";
$role = "";
$email = "";

$errors = [];

$topicsId = 0;
$isEditingUser = false;
$topicsName = "";

/**
 * Administra ações dos usuários
 */
if (isset($_GET['edit-admin'])) {
    $isEditingUser = true;
    $adminId = $_GET['edit-admin'];
    editAdmin($adminId);
}

if (isset($_GET['delete-admin'])) {
    $adminId = $_GET['delete-admin'];
    deleteAdmin($adminId);
}

/**
 * Açoes de Topicos
 */
if (isset($_POST['create-topics'])) {
    createTopics($_POST);
}

if (isset($_GET['edit-topics'])) {
    $isEditingUser = true;
    $topicsId = $_GET['edit-topics'];
    editTopics($topicsId);
}

if (isset($_POST['update-topics'])) {
    updateTopics($_POST);
}

if (isset($_GET['delete-topics'])) {
    $topicsId = $_GET['delete-topics'];
    deleteTopics($topicsId);
}

/**
 * Recebe novos dados de administrador do formulário
 * Cria um novo usuário de administrador
 * Retorna todos os usuários administrativos com suas funções
 * 
 */
function createAdmin($requestValues)
{
    global $conn, $errors, $role, $username, $email;

    $username = esc($requestValues['username']);
    $email = esc($requestValues['email']);
    $password = esc($requestValues['password']);
    $passwordConfirmation = esc($requestValues['passwordConfirmation']);

    if (isset($requestValues['role'])) {
        $role = esc($requestValues['role']);
    }

    if (empty($username)) {
        array_push($errors, "OPS! Informe o nome de usuário");
    }

    if (empty($email)) {
        array_push($errors, "OPS! Informe o email");
    }

    if (empty($role)) {
        array_push($errors, "Essa função é necessária para usuários administrativos");
    }

    if (empty($password)) {
        array_push($errors, "OPS! Você esqueceu a senha");
    }

    if ($password != $passwordConfirmation) {
        array_push($errors, "OPS! As senhas não correspondem, favor verificar");
    }

    /**
     * Verifica se nenhum usuário está registrado duas vezes
     * O email e os nomes de usuário devem ser exclusivos
     * Registra o usuário se não houver erros no formulário
     */
    $userCheckQuery = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($conn, $userCheckQuery);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['username'] === $username) {
            array_push($errors, "OPS! Este usuário já existe");
        }

        if ($user['email'] === $email) {
            array_push($errors, "OPS! Este email já existe");
        }
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "INSERT INTO users (username, email, role, password, created_at, updated_at)
                VALUES ('$username', '$email', '$role', '$password', now(), now())";
        mysqli_query($conn, $query);

        $_SESSION['message'] = "Usuário adminitrador criado com sucesso";
        header('location: users.php');
        exit(0);
    }
}

/**
 * Busca o administrador do banco de dados
 * Define campos de administração no formulário para edição
 */
function editAdmin($adminId)
{
    global $conn, $username, $role, $isEditingUser, $adminId, $email;

    $sql = "SELECT * FROM users WHERE id=$adminId LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $admin = mysqli_fetch_assoc($result);
    $username = $admin['username'];
    $email = $admin['email'];
}

/**
 * Recebe solicitação de administrador do formulário e atualizações no banco de dados
 * Registra o usuário se não houver erros no formulário
 */
function updateAdmin($requestValues)
{
    global $conn, $errors, $role, $username, $isEditingUser, $adminId, $email;

    $adminId = $requestValues['adminId'];
    $isEditingUser = false;
    $username = esc($requestValues['username']);
    $email = esc($requestValues['email']);
    $password = esc($requestValues['password']);
    $passwordConfirmation = esc($requestValues['passwordConfirmation']);

    if (isset($requestValues['role'])) {
        $role = $requestValues['role'];
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "UPDATE users SET username='$username', email='$email', role='$role', password='$password'
                WHERE id=$adminId";
        mysqli_query($conn, $query);

        $_SESSION['message'] = "Usuário administrador atualizado com sucesso";
        header('location: users.php');
        exit(0);
    }
}

function deleteAdmin($adminId)
{
    global $conn;
    $sql = "DELETE FROM users WHERE id=$adminId";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Usuário deletado com sucesso";
        header('location: users.php');
        exit(0);
    }
}

/**
 * Funcoes de Topicos
 */
function getAllTopics()
{
    global $conn;

    $sql = "SELECT * FROM topics";
    $result = mysqli_query($conn, $sql);
    $topics = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $topics;
}

function createTopics($requestValues)
{
    global $conn, $errors, $topicsName;

    $topicsName = esc($requestValues['topics-name']);
    $topicSlug = makeSlug($topicsName);

    if (empty($topicsName)) {
        array_push($errors, "É necessário o nome do tópico");
    }

    $topicCheckQuery = "SELECT * FROM topics WHERE slug='$topicSlug' LIMIT 1";
    $result = mysqli_query($conn, $topicCheckQuery);

    if (mysqli_num_rows($result) > 0) {
        array_push($errors, "OPS! Este tópico já existe");
    }

    if (count($errors) == 0) {
        $query = "INSERT INTO topics (name, slug) VALUES ('$topicsName', '$topicSlug')";
        mysqli_query($conn, $query);

        $_SESSION['message'] = "Tópico criado com sucesso!";
        header('location: topics.php');
        exit(0);
    }
}

/**
 * Busca o topico no banco de dados, utilizando o ID como paramentro
 * Define campos de tópicos no formulario para edicao
 */
function editTopics($topicsId)
{
    global $conn, $topicsName, $isEditingUser, $topicsId;

    $sql = "SELECT * FROM topics WHERE id=$topicsId LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $topics = mysqli_fetch_assoc($result);
    $topicsName = $topics['name'];
}

function updateTopics($requestValues)
{
    global $conn, $errors, $topicsName, $topicsId;

    $topicsName = esc($requestValues['topics-name']);
    $topicsId = esc($requestValues['topics-id']);
    $topicSlug = makeSlug($topicsName);

    if (empty($topicsName)) {
        array_push($errors, "É necessário o nome do tópico");
    }

    if (count($errors) == 0) {
        $query = "UPDATE topics SET name='$topicsName', slug='$topicSlug' WHERE id=$topicsId";
        mysqli_query($conn, $query);

        $_SESSION['message'] = "Tópico atualizado com sucesso!";
        header('location: topics.php');
        exit(0);
    }
}

function deleteTopics($topicsId)
{
    global $conn;
    $sql = "DELETE FROM topics WHERE id=$topicsId";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Tópico excluido con sucesso!";
        header('location: topics.php');
        exit(0);
    }
}

/**
 * Retorna todos os usuários administrativos e suas funções correspondentes
 * Function esc - valor enviado do formulário, portanto, impedindo a injeção de SQL
 */
function getAdminUsers()
{
    global $conn, $roles;
    $sql = "SELECT * FROM users WHERE role IS NOT NULL";
    $result = mysqli_query($conn, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $users;
}

function esc(String $value)
{
    global $conn;
    $val = trim($value);
    $val = mysqli_escape_string($conn, $value);

    return $val;
}

function makeSlug(String $string)
{
    $string = strtolower($string);
    $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

    return $slug;
}
