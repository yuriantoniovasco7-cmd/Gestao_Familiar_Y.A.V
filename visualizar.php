<?php
    include_once("conexao.php");

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $dados = null;
    $res_filhos = null;

    if ($id > 0) {
        // SQL Completo para buscar Cônjuge e as duas gerações acima (Pais e Avós)
        $sql_pessoa = "SELECT p.*, 
                   pai.nome AS nome_pai, pai.apelido AS apelido_pai,
                   mae.nome AS nome_mae, mae.apelido AS apelido_mae,
                   conj.nome AS nome_conjuge, conj.apelido AS apelido_conjuge,
                   avo_pp.nome AS avo_pp_n, avo_pp.apelido AS avo_pp_a,
                   avo_pm.nome AS avo_pm_n, avo_pm.apelido AS avo_pm_a,
                   avo_mp.nome AS avo_mp_n, avo_mp.apelido AS avo_mp_a,
                   avo_mm.nome AS avo_mm_n, avo_mm.apelido AS avo_mm_a
                   FROM pessoas p
                   LEFT JOIN pessoas pai ON p.id_pai = pai.id
                   LEFT JOIN pessoas mae ON p.id_mae = mae.id
                   LEFT JOIN pessoas conj ON p.id_conjuge = conj.id
                   LEFT JOIN pessoas avo_pp ON pai.id_pai = avo_pp.id
                   LEFT JOIN pessoas avo_pm ON pai.id_mae = avo_pm.id
                   LEFT JOIN pessoas avo_mp ON mae.id_pai = avo_mp.id
                   LEFT JOIN pessoas avo_mm ON mae.id_mae = avo_mm.id
                   WHERE p.id = $id";
        
        $res = $conn->query($sql_pessoa);
        if($res) { $dados = $res->fetch_assoc(); }

        $sql_filhos = "SELECT nome, apelido FROM pessoas WHERE id_pai = $id OR id_mae = $id";
        $res_filhos = $conn->query($sql_filhos);
    }
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Bilhete de Família</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f3d6a8; padding: 40px; }
        
        .bilhete-card {
            background: #fff;
            max-width: 850px;
            margin: auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border: 1px solid #ddd;
        }

        .header-bilhete {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header-bilhete h2 { margin: 0; text-transform: uppercase; letter-spacing: 2px; }
        
        .corpo-bilhete { padding: 40px; }

        .info-principal {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .campo { margin-bottom: 10px; }
        .label { font-weight: bold; color: #1e3c72; text-transform: uppercase; font-size: 12px; display: block; }
        .valor { font-size: 18px; color: #333; }

        .arvore-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 30px;
        }

        .familia-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 5px solid #2a5298;
        }

        .familia-box h3 { margin-top: 0; font-size: 16px; color: #1e3c72; border-bottom: 1px solid #ddd; padding-bottom: 5px; }

        .lista-parentes { list-style: none; padding: 0; margin: 0; }
        .lista-parentes li { padding: 5px 0; border-bottom: 1px dashed #ccc; font-size: 14px; }
        .lista-parentes li:last-child { border-bottom: none; }

        .footer-botoes {
            text-align: center;
            padding: 20px;
            background: #f1f1f1;
        }

        .btn-print {
            background: #1e3c72;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-print:hover { background: #e67e22; transform: scale(1.05); }

        @media print {
        body { 
            background: white !important; 
            padding: 0 !important; 
            margin: 0 !important; 
        }
        .no-print, 
        .menu-container, 
        .footer-botoes, 
        nav, 
        header { 
            display: none !important; 
            }

        .bilhete-card {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
        }

        .header-bilhete {
            background-color: #1e3c72 !important;
            -webkit-print-color-adjust: exact;
            color: white !important;
        }
       
        .familia-box {
            border-left: 5px solid #1e3c72 !important;
            -webkit-print-color-adjust: exact;
        }
    }
    </style>
</head>
<body>

<?php if ($dados): ?>
    <div class="bilhete-card">
        <div class="header-bilhete">
            <h2>Bilhete da Familiar</h2>
            <span style="font-size: 12px; opacity: 0.8;">Sistema de Gestão Estatística e Informação</span>
        </div>

        <div class="corpo-bilhete">
            <div class="info-principal">
                <div>
                    <div class="campo">
                        <span class="label">Nome Completo</span>
                        <span class="valor"><?php echo $dados['nome'] . " " . $dados['apelido']; ?></span>
                    </div>
                    <div class="campo">
                        <span class="label">Nº de Documento (BI)</span>
                        <span class="valor"><?php echo $dados['bi']; ?></span>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div class="campo">
                        <span class="label">Estado Civil</span>
                        <span class="valor"><?php echo $dados['estado_civil']; ?></span>
                    </div>
                    <?php if ($dados['estado_civil'] != 'Solteiro'): ?>
                    <div class="campo">
                        <span class="label">Cônjuge</span>
                        <span class="valor"><?php echo $dados['nome_conjuge'] ? $dados['nome_conjuge']." ".$dados['apelido_conjuge'] : "Não vinculado"; ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                </div>
                    <div class="campo">
                        <span class="label">Estado de Saúde </span>
                        <span class="valor"><?php echo $dados['estado_saude'] ?></span>
                </div>

              <div class="arvore-container">
                <div class="familia-box">
                    <h3>Linhagem Paterna</h3>
                    <ul class="lista-parentes">
                        <li><strong>Pai:</strong> <?php echo $dados['nome_pai'] ? $dados['nome_pai']." ".$dados['apelido_pai'] : "---"; ?></li>
                        <li><strong>Avô Paterno:</strong> <?php echo $dados['avo_pp_n'] ? $dados['avo_pp_n']." ".$dados['avo_pp_a'] : "---"; ?></li>
                        <li><strong>Avó Paterna:</strong> <?php echo $dados['avo_pm_n'] ? $dados['avo_pm_n']." ".$dados['avo_pm_a'] : "---"; ?></li>
                    </ul>
                </div>

                <div class="familia-box" style="border-left-color: #27ae60;">
                    <h3>Linhagem Materna</h3>
                    <ul class="lista-parentes">
                        <li><strong>Mãe:</strong> <?php echo $dados['nome_mae'] ? $dados['nome_mae']." ".$dados['apelido_mae'] : "---"; ?></li>
                        <li><strong>Avô Materno:</strong> <?php echo $dados['avo_mp_n'] ? $dados['avo_mp_n']." ".$dados['avo_mp_a'] : "---"; ?></li>
                        <li><strong>Avó Materna:</strong> <?php echo $dados['avo_mm_n'] ? $dados['avo_mm_n']." ".$dados['avo_mm_a'] : "---"; ?></li>
                    </ul>
                </div>
            </div>

            <div class="familia-box" style="margin-top: 20px; border-left-color: #0e61f0;">
                <h3>Descendência (Filhos)</h3>
                <ul class="lista-parentes">
                    <?php 
                    if ($res_filhos && $res_filhos->num_rows > 0) {
                        while($f = $res_filhos->fetch_assoc()) { echo "<li>" . $f['nome'] . " " . $f['apelido'] . "</li>"; }
                    } else { echo "<li>Nenhum descendente registado.</li>"; }
                    ?>
                </ul>
            </div>
        </div>

        <div class="footer-botoes no-print">
            <button class="btn-print" onclick="window.print()">IMPRIMIR PDF</button>
        </div>
    </div>
<?php else: ?>
    <div style="text-align:center; padding: 50px;">
        <h3>Membro não encontrado ou ID inválido.</h3>
        <a href="lista.php">Voltar para a lista</a>
    </div>
<?php endif; ?>


<div class="no-print" style="padding: 20px; max-width: 1000px; margin: 20px auto; text-align: left;">
    <a href="lista.php" style="
        background: #e67e22;;
        color: white;
        text-decoration: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: bold;
        display: inline-block;
        transition: 0.3s;
        font-family: Arial, sans-serif;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    " onmouseover="this.style.background='#2a5298'" onmouseout="this.style.background='#1e3c72'">Voltar para a Lista
    </a>
</div>
</body>
</html>