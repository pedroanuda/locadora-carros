<?php 
session_start();
include "./db/bd_man.php";

unset($_SESSION['emailInvalido']);
unset($_SESSION['senhaInvalida']);
if (isset($_COOKIE['login']) && !isset($_SESSION['usuario_nome']))
    pegar_dados_usuario($_COOKIE['login']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Locadora de Veículos</title>
    <style>
        body {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main {
            display: flex;
            flex: 1;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .carousel {
            width: 45%;
        }

        .carousel img {
            height: 250px;
            object-fit: cover;
        }

        div.opcoes {
            display: flex;
            gap: 1rem;
            width: 45%;
            margin-top: 1rem;;
        }

        div.opcoes > a {
            padding: 1rem;
            border-radius: 10px;
            background-color: #e6e6e6;
            flex: 1;
            text-decoration: none;
            color: #000;
        }

        div.opcoes > a:hover {
            background-color: #d4d4d4;
        }
    </style>
</head>
<body>
    <?php include "components/navbar.php"; ?>
    <main>
        <?php if (!isset($_SESSION['usuario_nome'])) { ?>
            <h3>Bem vindo(a) à Locadora!</h3>
        <?php } else { ?>
            <h3>Bem vindo(a), <?php echo $_SESSION['usuario_nome']; ?>!</h3>
        <?php } ?>
        <div id="carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="img/corolla-cross.webp" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                <img src="img/creta.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                <img src="img/t-cross.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="opcoes">
            <a href="pages/alugar.php">Alugar</a>
            <a href="pages/devolucao.php">Devolver</a>
        </div>

    </main>
</body>
</html>