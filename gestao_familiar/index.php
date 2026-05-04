<?php
    include_once("conexao.php");
    include_once("menu.php");

    $sql_pessoas = "SELECT id, nome, apelido FROM pessoas ORDER BY nome ASC";
    $res_pessoas = $conn->query($sql_pessoas);
    $pessoas_array = [];
    if ($res_pessoas->num_rows > 0) {
        while($row = $res_pessoas->fetch_assoc()) {
            $pessoas_array[] = $row;
        }
    }
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>CADASTRO FAMILIAR</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f3d6a8; margin: 0; }
        .main-container { max-width: 600px; margin: 20px auto; padding: 20px; }
        
        .card-form { 
            background: #f5f2ed; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 8px 20px rgba(0,0,0,0.1); 
            border-top: 5px solid #1e3c72;
        }

        h2 { color: #000000; text-align: center; margin-bottom: 25px; text-transform: uppercase; font-size: 20px; }
        
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 600; color: #000000; font-size: 14px; }
        
        input, select { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #ddd; 
            border-radius: 6px; 
            box-sizing: border-box; 
            font-size: 15px;
            transition: 0.3s;
        }

        input:focus, select:focus { border-color: #1e3c72; outline: none; box-shadow: 0 0 5px rgba(30,60,114,0.2); }

        .btn-submit { 
            width: 100%; 
            padding: 15px; 
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%); 
            color: #000; 
            border: none; 
            border-radius: 6px; 
            font-weight: bold; 
            font-size: 16px; 
            cursor: pointer; 
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(39,174,96,0.3); }
        
        .row { display: flex; gap: 15px; }
        .row .form-group { flex: 1; }

        #seccao_conjuge { 
            background: #f9f9f9; 
            padding: 15px; 
            border-radius: 8px; 
            border-left: 4px solid #f39c12; 
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="main-container">
    <div class="card-form">
        <h2>CADASTRO FAMILIAR</h2>
        
        <form action="salvar.php" method="POST">
            <div class="row">
                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" name="nome" required placeholder="Ex: Yuri">
                </div>
                <div class="form-group">
                    <label>Apelido:</label>
                    <input type="text" name="apelido" required placeholder="Ex: Vasco">
                </div>
            </div>

            <div class="form-group">
                <label>Número de BI:</label>
                <input type="text" name="bi" required placeholder="07010********Y">
            </div>

            <div class="row">
                <div class="form-group">
                    <label>Data de Nascimento:</label>
                    <input type="date" name="data_nascimento" required>
                </div>
                <div class="form-group">
                    <label>Sexo:</label>
                    <select name="sexo" required>
                        <option value="M">Masculino</option>
                        <option value="F">Feminino</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Estado Civil:</label>
                <select name="estado_civil" id="estado_civil" onchange="verificarEstadoCivil()" required>
                    <option value="Solteiro">Solteiro/a</option>
                    <option value="Casado">Casado/a</option>
                    <option value="Divorciado">Divorciado/a</option>
                    <option value="Viúvo">Viúvo/a</option>
                </select>
            </div>

            <div class="form-group">
              <label>Situação Atual</label>
                <select name="estado_saude" required>
                <option value="Vivo">Vivo</option>
                <option value="Falecido">Falecido</option>
             </select>
            </div>

            <div id="seccao_conjuge" style="display: none;">
                <label>Cônjuge / Parceiro:</label>
                <select name="id_conjuge">
                    <option value="">-- Selecione se já estiver no sistema --</option>
                    <?php foreach ($pessoas_array as $p): ?>
                        <option value="<?php echo $p['id']; ?>">
                            <?php echo $p['nome'] . " " . $p['apelido']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group" style="margin-top:15px;">
                <label>Filiação (Pai):</label>
                <select name="id_pai">
                    <option value="">-- Selecione o Pai --</option>
                    <?php foreach ($pessoas_array as $p): ?>
                        <option value="<?php echo $p['id']; ?>"><?php echo $p['nome'] . " " . $p['apelido']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Filiação (Mãe):</label>
                <select name="id_mae">
                    <option value="">-- Selecione a Mãe --</option>
                    <?php foreach ($pessoas_array as $p): ?>
                        <option value="<?php echo $p['id']; ?>"><?php echo $p['nome'] . " " . $p['apelido']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn-submit">FINALIZAR REGISTO</button>
        </form>
    </div>
</div>

<script>
function verificarEstadoCivil() {
    var estadoCivil = document.getElementById('estado_civil').value;
    var divConjuge = document.getElementById('seccao_conjuge');
    if (estadoCivil !== 'Solteiro') {
        divConjuge.style.display = 'block';
    } else {
        divConjuge.style.display = 'none';
    }
}
</script>

</body>
</html>