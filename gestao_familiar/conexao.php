<?php   
$host = "localhost";
$usuario = "root";
$senha = "";
$db = "gestao_familiar";

$conn = new mysqli($host, $usuario, $senha, $db);

if ($conn->connect_error) {
    die("Falha de conexao: " . $conn->connect_error);
}
?>