<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="manifest" href="manifest.json">
<script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/calculadora/service-worker.js');
    }
</script>
    <title>Calculadora de Juros Compostos</title>
    <style>
        .container {
            background-color: #f0f0f0; /* Fundo cinza claro para contraste */
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center text-primary">Calculadora de Juros Compostos</h1>
        <form method="POST" action="" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="valorInicial" class="form-label">Valor inicial de aporte (R$):</label>
                <input type="number" class="form-control" id="valorInicial" name="valorInicial" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="valorMensal" class="form-label">Valor mensal de aporte (R$):</label>
                <input type="number" class="form-control" id="valorMensal" name="valorMensal" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="jurosAnual" class="form-label">Taxa de juros anual (%):</label>
                <input type="number" class="form-control" id="jurosAnual" name="jurosAnual" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="tempoMeses" class="form-label">Tempo investido (meses):</label>
                <input type="number" class="form-control" id="tempoMeses" name="tempoMeses" required>
            </div>
            <button type="submit" class="btn btn-primary">Calcular</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validação dos dados
            if (
                !is_numeric($_POST['valorInicial']) ||
                !is_numeric($_POST['valorMensal']) ||
                !is_numeric($_POST['jurosAnual']) ||
                !is_numeric($_POST['tempoMeses']) ||
                $_POST['valorInicial'] < 0 ||
                $_POST['valorMensal'] < 0 ||
                $_POST['jurosAnual'] < 0 ||
                $_POST['tempoMeses'] < 0
            ) {
                echo "<div class='alert alert-danger'>Por favor, insira apenas números positivos.</div>";
            } else {
                // Cálculo dos juros compostos
                $valorInicial = floatval($_POST['valorInicial']);
                $valorMensal = floatval($_POST['valorMensal']);
                $jurosAnual = floatval($_POST['jurosAnual']) / 100;
                $tempoMeses = intval($_POST['tempoMeses']);

                $jurosMensal = pow(1 + $jurosAnual, 1 / 12) - 1;
                $montante = $valorInicial;
                $capitalInvestido = $valorInicial;
                
                for ($i = 1; $i <= $tempoMeses; $i++) {
                    $montante = ($montante + $valorMensal) * (1 + $jurosMensal);
                    $capitalInvestido += $valorMensal;
                }

                $jurosAcumulados = $montante - $capitalInvestido;

                // Exibir os resultados
                echo "<h2>Resultado</h2>";
                echo "<p>Capital Investido: R$ " . number_format($capitalInvestido, 2, ',', '.') . "</p>";
                echo "<p>Juros Acumulados: R$ " . number_format($jurosAcumulados, 2, ',', '.') . "</p>";
                echo "<p>Montante Final: R$ " . number_format($montante, 2, ',', '.') . "</p>";
            }
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>