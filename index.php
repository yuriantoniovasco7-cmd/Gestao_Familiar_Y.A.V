<?php
    include_once("conexao.php");

    $total = $conn->query("SELECT COUNT(*) as t FROM pessoas")->fetch_assoc()['t'];
    $vivos = $conn->query("SELECT COUNT(*) as v FROM pessoas WHERE estado_saude = 'Vivo'")->fetch_assoc()['v'];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
   
    <meta charset="UTF-8">
    <title>Painel Principal - Gestão Familiar</title>
    <style>
    
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f3d6a8; margin: 0; }
        
        .hero-section {
            background: linear-gradient(135deg, #437eec 0%, #437eec 100%);
            color: white; padding: 40px 20px; text-align: center; border-bottom: 5px solid #f39c12;
        }

        .container { max-width: 1000px; margin: -40px auto 40px auto; padding: 0 20px; }

        .stats-row { display: flex; gap: 20px; margin-bottom: 30px; }
        .stat-card {
            background: #f5f2ed; flex: 1; padding: 20px; border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0,0,0,0.1); text-align: center; border-top: 5px solid #c3d5f7;
        }
        .stat-card h3 { margin: 0; color: #437eec; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; }
        .stat-card p { margin: 10px 0 0 0; font-size: 26px; font-weight: bold; color: #333; }

        .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
        .menu-item {
            background: #f5f2ed; padding: 25px; border-radius: 15px; text-decoration: none;
            color: #333; text-align: center; transition: 0.3s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #dcd7cf;
        }
        .menu-item:hover {
            transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            border-color: #f39c12;
        }
        .icon { font-size: 45px; margin-bottom: 10px; display: block; }
        .menu-item h4 { margin: 10px 0; font-size: 19px; color: #437eec; border-bottom: 2px solid #f39c12; display: inline-block; padding-bottom: 5px; }
        .menu-item p { font-size: 14px; color: #555; line-height: 1.6; margin-top: 10px; }
    </style>
</head>
<body>

    <div class="hero-section">
        <h1>SISTEMA DE GESTÃO FAMILIAR</h1>
        <p>Mapeamento de Linhagem e Integridade Referencial</p>
    </div>

    <div class="container">
        <div class="stats-row">
            <div class="stat-card">
                <h3>Membros Totais</h3>
                <p><?php echo $total; ?></p>
            </div>
            <div class="stat-card" style="border-top-color: #27ae60;">
                <h3>Status Vivo</h3>
                <p><?php echo $vivos; ?></p>
            </div>
            <div class="stat-card" style="border-top-color: #f39c12;">
                <h3>Base de Dados</h3>
                <p style="font-size: 18px;">Conectada</p>
            </div>
            
        </div>

        <div class="menu-grid">
            <a href="resisto.php" class="menu-item">
                <span class="icon">👨‍👩‍👦‍👦</span>
                <h4>Registo de Membros</h4>
                <p>Mapear novos indivíduos, definir Pais, Mães e relações conjugais.</p>
            </a>

            <a href="lista.php" class="menu-item">
                <span class="icon">📜</span>
                <h4>Gestão Familiar</h4>
                <p>Listagem completa da base de dados, consulta de agregados e emissão de Bilhetes de Família.</p>
            </a>

            <a href="estatisticas.php" class="menu-item">
                <span class="icon">📊</span>
                <h4>Análise Estatística</h4>
                <p>Aceder à Pirâmide Etária, Taxa de Dependência e Indicadores de Fecundidade do grupo.</p>
            </a>
        </div>
    </div>

</body>
</html>