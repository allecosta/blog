<?php

session_start();

$server = 'localhost';
$username = '###';
$password = '###';
$dbname = 'db_vidabelablog';

$conn = mysqli_connect($server, $username, $password, $dbname);

if (!$conn) {
    die("Ops! Erro de conexão com o database." . mysqli_connect_error());
}

define('ROOT_PATH', realpath(dirname(__FILE__)));
define('BASE_URL', 'http://localhost:8000/');
