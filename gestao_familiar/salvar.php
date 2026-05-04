<?php
include_once("conexao.php");

    $nome            = $_POST['nome'];
    $apelido         = $_POST['apelido'];
    $bi              = $_POST['bi'];
    $data_nascimento = $_POST['data_nascimento'];
    $sexo            = $_POST['sexo'];
    $estado_civil    = $_POST['estado_civil'];
    $estado_saude    = $_POST['estado_saude'];

    $nasc = new DateTime($data_nascimento);
    $hoje = new DateTime();
    $idade = $hoje->diff($nasc)->y;

    if ($idade < 18 && $estado_civil != 'Solteiro') {
        die("<script>alert('Erro: Menores de 18 anos devem ser registados como Solteiros.'); window.history.back();</script>");
    }

    $id_pai = (!empty($_POST['id_pai'])) ? (int)$_POST['id_pai'] : "NULL";
    $id_mae = (!empty($_POST['id_mae'])) ? (int)$_POST['id_mae'] : "NULL";
    $id_conjuge_escolhido = (!empty($_POST['id_conjuge'])) ? (int)$_POST['id_conjuge'] : null;

    $check_bi = "SELECT id FROM pessoas WHERE bi = '$bi'";
    $res_bi = $conn->query($check_bi);
    if ($res_bi->num_rows > 0) {
        die("Erro: O BI $bi já está registado.");
    }

    $sql = "INSERT INTO pessoas (nome, apelido, bi, data_nascimento, sexo, estado_civil, id_pai, id_mae, estado_saude) 
        VALUES ('$nome', '$apelido', '$bi', '$data_nascimento', '$sexo', '$estado_civil', $id_pai, $id_mae, '$estado_saude')";

    if ($conn->query($sql) === TRUE) {
        $id_novo = $conn->insert_id; // ID da pessoa que acabou de entrar

    
    if ($id_conjuge_escolhido != null && $estado_civil == 'Casado') {
        
        $conn->query("UPDATE pessoas SET id_conjuge = $id_conjuge_escolhido WHERE id = $id_novo");
        
        $conn->query("UPDATE pessoas SET id_conjuge = $id_novo, estado_civil = 'Casado' WHERE id = $id_conjuge_escolhido");
    }

    header("Location: lista.php");
    exit();
} else {
    echo "Erro técnico: " . $conn->error;
}

?>