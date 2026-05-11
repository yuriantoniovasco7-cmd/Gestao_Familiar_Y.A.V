<?php
    include_once("conexao.php");

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Lista Familiar - Sistema de Gestão</title>
    <style>
         body { 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;  background-color: #f3d6a8; margin: 0; ; }
    
        .container { width: 95%; max-width: 1200px; margin: 20px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        
        h2 { color: #1e3c72; border-left: 5px solid #f39c12; padding-left: 10px; font-family: Arial; }
        
        table { width: 100%; border-collapse: collapse; font-family: 'Times New Roman', serif; margin-top: 20px; }
        th { background-color: #f39c12; color: #1e3c72; padding: 12px; text-align: left; font-family: Arial; text-transform: uppercase; font-size: 13px; }
        td { padding: 12px; border-bottom: 1px solid #1e3c72; font-size: 16px; }
        tr:hover { background-color: #f3d6a8; }
        
        .btn-excel { background-color: #057b36; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; float: right; display: inline-block; }
        .btn-ver { color: #1e3c72; font-weight: bold; text-decoration: none; border: 1px solid #1e3c72; padding: 5px 10px; border-radius: 4px; }
        .btn-ver:hover { background: #1e3c72; color: white; }
    </style>
</head>
<body>

    <div class="container">
        
        <h2>Membros Registados no Sistema</h2>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome Completo</th>
                    <th>BI / Documento</th>
                    <th>Data Nasc.</th>
                    <th>Estado Civil</th>
                    <th style="text-align: center;">Opções</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id, nome, apelido, bi, data_nascimento, estado_civil FROM pessoas ORDER BY apelido ASC, nome ASC";
                $res = $conn->query($sql);
                if ($res->num_rows > 0) {
                    while($row = $res->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td><strong>".$row['nome']." ".$row['apelido']."</strong></td>";
                        echo "<td>".$row['bi']."</td>";
                        echo "<td>".date('d/m/Y', strtotime($row['data_nascimento']))."</td>";
                        echo "<td>".$row['estado_civil']."</td>";
                        echo "<td style='text-align: center;'>
                                <a href='visualizar.php?id=".$row['id']."' class='btn-ver'>Ver Bilhete</a>
                                <a href='eliminar.php?id=".$row['id']."' onclick=\"return confirm('Apagar registo?')\" style='color:red; margin-left:10px; font-size:12px;'>[Eliminar]</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center;'>Nenhum registo encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
<br>
        <a href="exportar.php" class="btn-excel"> 📤Exportar dados(CSV/Excel)</a>


    </div>
    <?php include_once("menu.php"); ?> 
</html>