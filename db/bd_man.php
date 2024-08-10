<?php
if (session_status() != PHP_SESSION_ACTIVE) session_start();

$dbInfos = json_decode(file_get_contents("./config.json"), true);

function conectar_db(): mysqli {
    $conn = mysqli_connect(
        $GLOBALS['dbInfos']['hostname'],
        $GLOBALS['dbInfos']['username'],
        $GLOBALS["dbInfos"]['password'],
        $GLOBALS["dbInfos"]['database'],
        $GLOBALS["dbInfos"]['porta']
    );
    if (!$conn) die("Conexão falha com banco de dados.");

    return $conn;
}

function checar_usuario_na_db(mysqli $mysqli, string $email): bool {
    $email_check = mysqli_query($mysqli, "SELECT email from Usuario WHERE email = \"$email\";");
    if (mysqli_num_rows($email_check) > 0) return true;
    
    return false;
}

function cadastrar_usuario(string $nome, string $sobrenome, string $email, string $senha) {
    $conn = conectar_db();

    if (checar_usuario_na_db($conn, $email)) {
        $_SESSION['emailInvalido'] = true;
        return false;
    }

    $senha_cripto = md5($senha);
    $token = sha1($senha_cripto);
    $query = "INSERT INTO Usuario (email, nome, sobrenome, senha, token) VALUES (\"$email\", \"$nome\", \"$sobrenome\", \"$senha_cripto\", \"$token\");";
    mysqli_query($conn, $query);
    mysqli_close($conn);
    setcookie("login", $token, time() + 60 * 60 * 24, "/");
    return true;
}

function logar_usuario(string $email, string $senha) {
    unset($_SESSION['emailInvalido']);
    unset($_SESSION['senhaInvalida']);
    $conn = conectar_db();

    if (!checar_usuario_na_db($conn, $email)) {
        $_SESSION['emailInvalido'] = true;
        return false;
    }

    $senha_cripto = md5($senha);
    $query = "SELECT senha, token FROM Usuario WHERE senha = \"$senha_cripto\" AND email = \"$email\"";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 0) {
        $_SESSION['senhaInvalida'] = true;
        return false;
    }

    $assoc = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    setcookie("login", $assoc['token'], time() + 60 * 60 * 24, "/");
    return true;
}

function pegar_dados_usuario(string $token) {
    $conn = conectar_db();
    $result = mysqli_query($conn, "SELECT * FROM Usuario WHERE token = \"$token\"");
    if (mysqli_num_rows($result) == 0) return;

    $fetched_res = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    $_SESSION['usuario_nome'] = $fetched_res['nome'];
    $_SESSION['usuario_sobrenome'] = $fetched_res['sobrenome'];
}

function pegar_carro(string $carro_id) {
    $conn = conectar_db();

    $query = "SELECT * FROM Carros WHERE id = \"$carro_id\"";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    return $result;
}

function pegar_carros() {
    $conn = conectar_db();

    $query = "SELECT * FROM carros;";
    $result = mysqli_query($conn, $query);
    $fetched_res = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $fetched_res;
}

function alugar_carro(string $carro_id, string $token_usuario) {
    $conn = conectar_db();
    $email = mysqli_fetch_assoc(mysqli_query($conn, "SELECT email FROM Usuario WHERE token = \"$token_usuario\""))['email'];

    $data_aluguel = date("Y-m-d");
    $query = "UPDATE carros SET cliente_usuario = \"$email\", data_alugado = \"$data_aluguel\" WHERE id = \"$carro_id\" ";
    mysqli_query($conn, $query);
    mysqli_close($conn);
}

function nome_cliente(string $email): string {
    $conn = conectar_db();
    $query = "SELECT nome FROM usuario WHERE email = \"$email\";";
    $result = mysqli_query($conn, $query);
    $fetched_res = mysqli_fetch_assoc($result);
    mysqli_close($conn);

    return $fetched_res['nome'];
}

function email_cliente(string $token): string {
    $conn = conectar_db();
    $query = "SELECT email FROM Usuario WHERE token = \"$token\";";
    $result = mysqli_query($conn, $query);
    $fetched_res = mysqli_fetch_assoc($result);
    mysqli_close($conn);

    return $fetched_res["email"];
}

function possui_carro(string $carro, string $token_usuario): bool {
    $conn = conectar_db();
    $query = "SELECT * FROM Carros WHERE cliente_usuario = \"" . email_cliente($token_usuario) . "\";";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows( $result ) > 0) 
        $answer = true;
    else $answer = false;
    mysqli_close( $conn );
    return $answer;
}

function devolver_carro(string $carro) {
    $conn = conectar_db();
    $query = "UPDATE Carros SET cliente_usuario = NULL, data_alugado = NULL WHERE id = \"$carro\";";
    mysqli_query($conn, $query);
    mysqli_close($conn);
}

function carros_possuidos(string $token_usuario) {
    $conn = conectar_db();
    $email = email_cliente($token_usuario);
    $query = "SELECT * FROM Carros WHERE cliente_usuario = \"$email\";";
    $carros = mysqli_fetch_all(mysqli_query($conn, $query), MYSQLI_ASSOC);
    mysqli_close($conn);
    return $carros;
}
