<?php
    include_once("conexao.php");

        if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM pessoas WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
        header("Location: lista.php");
        exit();
    } else {
        echo "Erro ao eliminar: " . $conn->error;
    }
}
?>