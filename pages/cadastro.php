<?php $s = session_start() ?>
<!DOCTYPE html>
<html lang="pt-BR">
<?php 
include "../db/bd_man.php";
if (isset($_COOKIE['login']))
    header("Location: ../");
if (isset($_POST['nome'], $_POST['sobrenome'], $_POST['email'], $_POST['senha'])) {
    $a = cadastrar_usuario($_POST['nome'], $_POST['sobrenome'], $_POST['email'], $_POST['senha']);
    if ($a) {
        header("Location: ../");
        unset($_SESSION['emailInvalido']);
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Locadora - Cadastro</title>
</head>
<body class="d-flex flex-column vh-100">
    <?php include "../components/navbar.php"; ?>
    <main class="d-flex flex-column align-items-center justify-content-center flex-fill">
        <h4 class="mb-4">Para começar a alugar carros, faça o seu cadastro!</h4>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="border p-3 rounded" style="height: fit-content; min-width: 25%">
            <div class="row mb-3">
                <div class="col">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" required>
                </div>
                <div class="col">
                    <label for="sobrenome" class="form-label">Sobrenome</label>
                    <input type="text" name="sobrenome" id="sobrenome" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" id="email" name="email" 
                class="form-control<?php echo isset($_SESSION['emailInvalido']) ? " is-invalid" : ""?>" aria-describedby="email-feedback" required>
                <div id="email-feedback" class="invalid-feedback">
                    Este e-mail já está cadastrado.
                </div>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" id="senha" name="senha" class="form-control" required>
            </div>
            <input type="submit" class="btn btn-primary" value="Cadastrar">
        </form>
    </main>
    <script>
        // Remover exibição de erro do input quando necessário.

        /** @type { HTMLElement } */
        let emailInput = document.getElementById("email");
        emailInput.addEventListener("change", () => {
            emailInput.classList.remove("is-invalid");
        })
    </script>
</body>
</html>