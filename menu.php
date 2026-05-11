<style>
    /* Configuração Base para Footer no Fim */
    html, body {
        height: 100%;
        margin: 0;
    }
    body { 
        display: flex;
        flex-direction: column;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        background-color: #f3d6a8; 
    }

    .main-wrapper {
        flex: 1 0 auto;
        padding: 20px;
    }

    .footer-fct {
        flex-shrink: 0;
        background: #ffffff;
        border-top: 1px solid #437eec;
        padding: 20px 50px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }


    .btn-voltar-fct {
        background: #ffffff;
        color: #1b345d;
        text-decoration: none;
        font-weight: bold;
        padding: 12px 20px;
        border-radius: 10px;
        border: 1px solid #437eec;
        box-shadow: 0 5px 0 #437eec; 
        transition: all 0.1s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    .btn-voltar-fct:hover {
        transform: translateY(2px);
        box-shadow: 0 3px 0 #cbd5e1;
    }
    .btn-voltar-fct:active {
        transform: translateY(5px);
        box-shadow: none;
    }

    .info-academica {
        text-align: right;
        color: #64748b;
        font-size: 12px;
        line-height: 1.5;
    }
    .info-academica strong {
        color: #0f172a;
        font-size: 14px;
        text-transform: uppercase;
    }

    @media print { .nav-header, .footer-fct { display: none; } }
</style>

<div class="main-wrapper">
    </div> <footer class="footer-fct">
        <div class="footer-left">
            <a href="index.php" class="btn-voltar-fct">
                VOLTAR AO PAINEL
            </a>
        </div>

        <div class="info-academica">
            <strong>Yuri Antonio Vasco</strong><br>
            Faculdade de Ciência e Tecnologia<br>
            Cadeira: Aplicações Web • 2026
        </div>
    </footer>
</body>
</html>