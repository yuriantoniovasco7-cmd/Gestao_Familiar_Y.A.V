<?php
    include_once("conexao.php");
    include_once("menu.php");
    
    $sql_etaria = "SELECT 
        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, data_nascimento, CURDATE()) < 15 THEN 1 ELSE 0 END) AS criancas,
         SUM(CASE WHEN TIMESTAMPDIFF(YEAR, data_nascimento, CURDATE()) BETWEEN 15 AND 24 THEN 1 ELSE 0 END) AS jovens,
         SUM(CASE WHEN TIMESTAMPDIFF(YEAR, data_nascimento, CURDATE()) BETWEEN 25 AND 64 THEN 1 ELSE 0 END) AS adultos,
         SUM(CASE WHEN TIMESTAMPDIFF(YEAR, data_nascimento, CURDATE()) >= 65 THEN 1 ELSE 0 END) AS idosos
    FROM pessoas";

    $res_etaria = $conn->query($sql_etaria)->fetch_assoc();

    $dependentes = $res_etaria['criancas'] + $res_etaria['idosos'];

    $ativos = $res_etaria['jovens'] + $res_etaria['adultos'];

    $taxa_dependencia = ($ativos > 0) ? ($dependentes / $ativos) * 100 : 0;

    $sql_filhos = "SELECT COUNT(*) as total_filhos FROM pessoas WHERE id_pai IS NOT NULL OR id_mae IS NOT NULL";

    $total_filhos = $conn->query($sql_filhos)->fetch_assoc()['total_filhos'];

    $sql_casais = "SELECT COUNT(DISTINCT id_pai, id_mae) as total_casais FROM pessoas WHERE id_pai IS NOT NULL AND id_mae IS NOT NULL";

    $total_casais = $conn->query($sql_casais)->fetch_assoc()['total_casais'];

    $media_filhos = ($total_casais > 0) ? $total_filhos / $total_casais : 0;

    $sql_filhos = "SELECT COUNT(*) as total_filhos FROM pessoas WHERE id_pai IS NOT NULL OR id_mae IS NOT NULL";

    $total_filhos = $conn->query($sql_filhos)->fetch_assoc()['total_filhos'];

    $sql_casais = "SELECT COUNT(DISTINCT id_pai, id_mae) as total_casais FROM pessoas WHERE id_pai IS NOT NULL AND id_mae IS NOT NULL";

    $total_casais = $conn->query($sql_casais)->fetch_assoc()['total_casais'];

    $media_fecundidade = ($total_casais > 0) ? $total_filhos / $total_casais : 0;

    $dados_grafico = [
        'Crianças' => $res_etaria['criancas'],
        'Jovens'   => $res_etaria['jovens'],
        'Adultos'  => $res_etaria['adultos'],
        'Idosos'   => $res_etaria['idosos']
        ];

    $labels = json_encode(array_keys($dados_grafico));
    $valores = json_encode(array_values($dados_grafico));

?>


<!DOCTYPE html>
<html lang="pt">
<head>
    <style>
        body { font-family: 'Times New Roman'; font-size: 12px; line-height: 1.5; padding: 20px; }
        .card { border: 1px solid #ffffff; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        h2 { border-bottom: 2px solid #070707; }
    </style>
</head>
<body>
    <h2>Painel de Gestão de Informação Familiar</h2>

    <div class="card">
        <h3>1. Composição da População (Pirâmide Etária)</h3>
        <ul>
            <li>Crianças (<15 anos): <?php echo $res_etaria['criancas']; ?></li>
            <li>Jovens (15-24 anos): <?php echo $res_etaria['jovens']; ?></li>
            <li>Adultos (25-64 anos): <?php echo $res_etaria['adultos']; ?></li>
            <li>Idosos (65+ anos): <?php echo $res_etaria['idosos']; ?></li>
        </ul>
    </div>

    <div class="card">
        <h3>2. Indicador Demográfico: Taxa de Dependência</h3>
        <p>A taxa de dependência atual é de: <strong><?php echo number_format($taxa_dependencia, 2); ?>%</strong></p>
        <small>Interpretação: Existem <?php echo number_format($taxa_dependencia, 2); ?> dependentes para cada 100 pessoas em idade ativa.</small>
    </div>

    <div class="card">
        <h3>2. Indicador de Fecundidade</h3>
        <p>Média de Filhos por Casal: <strong><?php echo number_format($media_filhos, 2); ?></strong></p>
</div>

<div class="card" style="width: 80%; margin: auto;">
    <h3>3. Distribuição por Faixa Etária (Linhagem Geral)</h3>
    <canvas id="graficoEtario"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('graficoEtario').getContext('2d');
new Chart(ctx, {
    type: 'bar', // Pode mudar para 'pie' (pizza) se preferir
    data: {
        labels: <?php echo $labels; ?>,
        datasets: [{
            label: 'Número de Indivíduos',
            data: <?php echo $valores; ?>,
            backgroundColor: [
                'rgba(51, 123, 246, 0.6)', 
                'rgba(13, 180, 35, 0.6)',
                'rgba(219, 164, 26, 0.6)', 
                'rgba(219, 16, 60, 0.6)'  
            ],
            borderColor: 'rgba(0, 0, 0, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

</body>
</html>