<?php 
session_start(); 
include "../db/bd_man.php";
if (isset($_COOKIE['login']))
    header("Location: ../");
if (isset($_POST['email'], $_POST['password'])) {
    $b = logar_usuario($_POST['email'], $_POST['password']);
    if ($b) {
        header("Location: ../");
        unset($_SESSION['senhaInvalida']);
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
    <title>Locadora - Login</title>
</head>
<body class="vh-100 d-flex flex-column">
    <?php include "../components/navbar.php"; ?>
    <div class="d-flex justify-content-center align-items-center flex-column flex-fill">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="p-3 mb-3 border rounded" style="min-width: 25%;height: fit-content;">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control<?php echo isset($_SESSION['emailInvalido']) ? " is-invalid" : ""?>" aria-describedby="email-feedback">
                <div id="email-feedback" class="invalid-feedback">
                    E-mail não cadastrado.
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" class="form-control<?php echo isset($_SESSION['senhaInvalida']) ? " is-invalid" : ""?>" name="password" id="password" aria-describedby="senha-feedback">
                <div id="senha-feedback" class="invalid-feedback">
                    Senha incorreta.
                </div>
            </div>
            <input type="submit" value="Entrar" class="btn btn-primary">
        </form>
        <p>Você ainda não possui um login? Cadastre-se <a href="./cadastro.php">aqui</a>.</p>
    </div>
    <script>
        let emailInput = document.getElementById("email");
        let senhaInput = document.getElementById("password");
        emailInput.addEventListener("change", () => emailInput.classList.remove("is-invalid"));
        senhaInput.addEventListener("change", () => senhaInput.classList.remove("is-invalid"));
    </script>
</body>
</html>