<?php
    include_once("conexao.php");

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Relatorio_Familiar_Limpo.csv');

        $saida = fopen('php://output', 'w');

        fprintf($saida, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($saida, array(
            'ID', 
            'Nome Completo', 
            'Apelido', 
            'BI', 
            'Data de Nascimento', 
            'Sexo', 
            'Estado Civil'
        ), ';');

        $sql = "SELECT 
                    id, 
                    nome, 
                    apelido, 
                    bi, 
                    data_nascimento, 
                    sexo, 
                    estado_civil 
            FROM pessoas 
            ORDER BY apelido ASC, nome ASC";

        $resultado = $conn->query($sql);

     if ($resultado && $resultado->num_rows > 0) {
        while($linha = $resultado->fetch_assoc()) {
            
            $linha['sexo'] = ($linha['sexo'] == 'M') ? 'Masculino' : 'Feminino';
            
            $linha['data_nascimento'] = date('d/m/Y', strtotime($linha['data_nascimento']));

            fputcsv($saida, $linha, ';');
              }
         }

          fclose($saida);
    exit();
?>