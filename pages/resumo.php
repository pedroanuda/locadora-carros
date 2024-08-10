<?php
include "../db/bd_man.php";
if (isset($_GET['devolva']) && isset($_COOKIE['login']) && possui_carro($_GET['devolva'], $_COOKIE['login'])) {
    devolver_carro($_GET['devolva']);
    header("Location: ../index.php");
}
if (!isset($_GET['carro']) || !isset($_COOKIE['login']) || !possui_carro($_GET['carro'], $_COOKIE['login']) || !isset($_GET['km']))
    header("Location: .");

// Calculos
$carro = pegar_carro($_GET['carro']);
$gasolina_preco = 4.89;
$preco_gasolina_usada = round($_GET['km'] / $carro['consumo'] * $gasolina_preco, 2);
$km_perc = round($_GET['km'] * $carro['custo'], 2);
$total = $preco_gasolina_usada + $km_perc;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Locadora - Resumo de Pagamento</title>
    <style>
        body {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        div.caixa-checkout {
            padding: 1rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            min-width: 25%;
        }
        button.sucesso,
        div.caixa-checkout input[type=submit] {
            margin-top: 1rem;
            width: 100%;
        }
        div.carro-info {
            display: flex;
            gap: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        div.carro-info > img {
            width: 200px;
            border-radius: 10px;
        }
        div.pagamento-desc {
            margin-top: 1rem;
        }
        span#total {
            font-size: 1.5rem;
            margin-top: .5rem;
        }
        p.mensagem-sucesso {
            font-family: 1.2rem;
            margin-top: .5rem;
        }
    </style>
</head>
<body>
    <?php include "../components/navbar.php"; ?>
    <main>
        <h4>Resumo: Checkout</h4>
        <div class="caixa-checkout">
            <div class="carro-info">
                <img src="<?php echo "../". $carro['imagem'] ?>" alt="<?php echo $carro['nome'] ?>">
                <span>
                    Consumo: <?php echo $carro['consumo'] ?> km/l<br>
                    Custo p/ Km: <?php echo "R$" . $carro['custo'] ?>
                </span>
            </div>
            <div class="pagamento-desc">
                Preço combustível: <?php echo $_GET['km'] . " / " . $carro['consumo'] . " × " . $gasolina_preco . " = " . "R$$preco_gasolina_usada"?><br>
                Km percorridos: <?php echo $_GET['km'] . " × " . $carro['custo'] . " = " . "R$$km_perc"?>
            </div>
            <span id="total"><strong>Total:</strong> <?php echo "R$$total" ?></span>
            <!-- <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <input type="hidden" name="pagamento" value="true">
                <input type="submit" value="Finalizar o pagamento" class="btn btn-outline-success">
            </form> -->
            <button type="button" class="btn btn-outline-success sucesso">Finalizar o pagamento</button>
        </div>
    </main>
    <script>
        let caixa = document.querySelector(".caixa-checkout");
        let button = document.querySelector("button.sucesso");

        const redirecionar = () => {
            window.location.href = "?devolva=<?php echo $carro['id'] ?>";
        }

        button.addEventListener("click", () => {
            button.style = "display: none";
            caixa.innerHTML += "<p class=\"mensagem-sucesso\">Obrigado por alugar conosco!</p>";
            timer = setTimeout(redirecionar, 1000);
        })
    </script>
</body>
</html>