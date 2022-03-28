<?php

$username = "";
$email = "";
$errors = array();

if (isset($_POST['reg-user'])) {
    $username = esc($_POST['username']);
    $email = esc($_POST['email']);
    $passwordOne = esc($_POST['passwordOne']);
    $passwordTwo = esc($_POST['passwordTwo']);

    if (empty($username)) {
        array_push($errors, "Ops! Vamos precisar do seu nome de usuário");
    }

    if (empty($email)) {
        array_push($errors, "Ops! Favor informar o seu email");
    }

    if (empty($passwordOne)) {
        array_push($errors, "Ops! Você esqueceu a senha");
    }

    if ($passwordOne != $passwordTwo) {
        array_push($errors, "Ops! As senhas informada não correspondem, favor verificar");
    }

    /**
     * Verifica se nenhum usuário está registrado duas vezes
     * Email e os nomes de usuários devem ser exclusivos
     */
    $userCheckQuery = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($conn, $userCheckQuery);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['username'] === $username) {
            array_push($errors, "Este usuário já existe!");
        }

        if ($user['email'] === '$email') {
            array_push($errors, "Este email já existe!");
        }
    }

    /**
     * Registra o usuário se não houver erros nos formulário
     */
    if (count($errors)) {
        $password = md5($passwordOne);
        $query = "INSERT INTO users (username, email, password, created_at, updated_at)
                VALUES ('$username', '$email', '$password', NOW(), NOW()";
        mysqli_query($conn, $query);

        $regUserId = mysqli_insert_id($conn);

        $_SESSION['user'] = getUserById($regUserId);

        if (in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
            $_SESSION['message'] = "Agora você está logado em";
            header('location: ' . BASE_URL, 'admin/dashboard.php');
            exit(0);
        } else {
            $_SESSION['message'] = "Agora você está logado em";
            header('location: index.php');
            exit(0);
        }
    }
}

if (isset($_POST['login-btn'])) {
    $username = esc($_POST['username']);
    $password = esc($_POST['password']);

    if (empty($username)) {
        array_push($errors, "É necessario informar o nome de usuário");
    }

    if (empty($password)) {
        array_push($errors, "É necessario informar a senha");
    }

    if (empty($errors)) {
        $password = md5($password);
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $regUserId = mysqli_fetch_assoc($result)['id'];
            $_SESSION['user'] = getUserById($regUserId);

            if (in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
                $_SESSION['message'] = "Agora você está logado em";
                header('location: ' . BASE_URL, '/admin/dashboard.php');
                exit(0);
            } else {
                $_SESSION['message'] = "Agora você está logado em";
                header('location: index.php');
                exit(0);
            }
        } else {
            array_push($errors, "Ops! Credenciais erradas");
        }
    }
}

function esc(String $value)
{
    global $conn;
    $val = trim($value);
    $val = mysqli_real_escape_string($conn, $value);
    return $val;
}

function getUserById($id)
{
    global $conn;
    $sql = "SELECT * FROM users WHERE id=$id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    return $user;
}
