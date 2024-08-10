<?php
session_start();
include "../db/bd_man.php";

$devolucao = false;

$url = parse_url($_SERVER['REQUEST_URI']);
if (isset($url['query'])) {
    parse_str($url['query'], $query);
    if (isset($query['devolver'])) {
        if (!isset($_COOKIE['login']))
            header("Location: ./login.php");
        if (!possui_carro($query['devolver'], $_COOKIE['login']))
            header('Location: ./devolucao.php');

        $devolucao = true;
    }
}

$carros = isset($_COOKIE['login']) ? carros_possuidos($_COOKIE['login']) : [];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Devolução de Veículo</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
        form.caixa-form,
        div.caixa-carros {
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 1rem;
            min-width: 45%;
        }
        div.carro {
            padding: .5rem;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        div.carro:last-child {
            border-bottom: none;
        }
        div.carro > .info {
            flex: 1;
            display: inline-flex;
            align-items: center;
            gap: 1rem;
        }
        div.carro h6 {
            margin: 0;
            font-size: 1.5rem;
        }
        div.carro > a {
            margin: .5rem;
        }
    </style>
</head>
<body>
    <?php include "../components/navbar.php"; ?>
    <main>
        <?php if (count($carros) == 0) { ?>
            <div class="no-cars">
                Você não está com a posse de nenhum carro.
            </div>
        <?php } else if (!$devolucao) { ?>
            <h4>Devolução de Carros</h4>
            <div class="caixa-carros">
                <?php foreach ($carros as $carro) { ?>
                <div class="carro">
                    <div class="info">
                        <h6><?php echo $carro['nome'] ?></h6>
                        <span>Alugado em <?php echo date('d/m/Y', strtotime($carro['data_alugado'])) ?>.</span>
                    </div>
                    <a class="btn btn-outline-secondary" href="?devolver=<?php echo $carro['id'] ?>">Devolver</a>
                </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <form action="../valida.php" method="get" class="caixa-form">
                <div class="mb-3">
                    <label for="km" class="form-label">Quilômetros percorridos</label>
                    <input type="number" name="km" class="form-control" min="0" step="0.1">
                    <input type="hidden" name="carro" value="<?php echo $query['devolver'] ?>">
                </div>
                <input type="submit" value="Devolver" class="btn btn-primary">
            </form>
        <?php } ?>
    </main>
</body>
</html>