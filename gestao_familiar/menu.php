<style>

    body { 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        background-color: #f3d6a8; 
        margin: 0; 
        color: #333;
    }

    .nav-container {
        background: linear-gradient(135deg, #4773c3 0%, #437eec 100%);
        padding: 15px 0;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-bottom: 3px solid #f39c12;
        margin-bottom: 30px;
    }

    .nav-link {
        color: #000;
        text-decoration: none;
        font-weight: bold;
        margin: 0 20px;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
    }

    .nav-link:hover {
        color: #f39c12;
        text-shadow: 0 0 5px rgba(255,255,255,0.3);
    }

    .btn-acao {
        background-color: #27ae60;
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-acao:hover { background-color: #2ecc71; }
</style>

<div class="nav-container">
    <a href="index.php" class="nav-link">[+] REGISTAR NOVO</a>
    <a href="lista.php" class="nav-link">[≡] VER LISTA</a>
    <a href="estatisticas.php" class="nav-link">[📈] ESTATÍSTICAS</a>
</div>
