<?php
session_start();
include "../db/bd_man.php";
$carros = pegar_carros();
$url = parse_url($_SERVER['REQUEST_URI']);
if (isset($url['query'])) {
    parse_str($url['query'], $query);
    if (!isset($_COOKIE['login']))
        header("Location: ./login.php");
    if (isset($query['alugar'])) {
        alugar_carro($query['alugar'], $_COOKIE['login']);
        header("Location: alugar.php");
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Locadora - Carros</title>
    <style>
        div.carro_exib {
            padding: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            display: flex;
            gap: 1rem;
        }
        div.carro_exib > img {
            width: 350px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px
        }
        div.carro_exib > div.informacoes {
            flex: 1;
        }
        div.carro_exib > div.alugar_action {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        div.carro_exib .btn {
            height: 100%;
            width: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        div.informacao_alugado {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 250px;
        }
    </style>
</head>
<body>
    <?php include "../components/navbar.php"; ?>
    <main>
        <?php if (count($carros) > 0) foreach ($carros as $carro) { ?>
            <div class="carro_exib">
                <img src="<?php echo "../" . $carro['imagem'] ?>" alt="<?php echo $carro['nome'] ?>">
                <div class="informacoes">
                    <h4 class="nome_carro"><?php echo $carro['nome'] ?></h4>
                    <span>Consumo: <?php echo $carro['consumo'] . " Km/l" ?></span><br>
                    <span>Custo por Km: <?php echo "R$" . $carro['custo'] ?></span>
                </div>
                <?php if (!isset($carro['cliente_usuario'])) {?>
                    <div class="alugar_action">        
                        <a class="btn btn-outline-secondary" href="?alugar=<?php echo $carro['id'] ?>">Alugar</a>
                    </div>
                <?php } else if (isset($_SESSION['usuario_nome']) && $_SESSION['usuario_nome'] == nome_cliente($carro['cliente_usuario'])) { ?>
                    <div class="alugar_action">
                        <a href="devolucao.php?devolver=<?php echo $carro['id'] ?>" class="btn btn-outline-danger">Devolver</a>
                    </div>
                <?php } else { ?>
                    <div class="informacao_alugado">
                        <span>Alugado por <?php echo nome_cliente($carro['cliente_usuario']) ?>.</span>
                    </div>
                <?php } ?> 
            </div>
        <?php } else echo "<h4>Não há carros para alugar no momento.</h4>" ?>
    </main>
</body>
</html>