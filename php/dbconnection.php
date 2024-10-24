<?php
$servename = 'localhost';
$username = 'root';
$password = '';
$dbname = 'cadastrox';

$conn = new mysqli($servename, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    die("Erro ao conectar com banco de dados " . $conn->error);
}
?>
