<header>
    <?php 
    $url = parse_url($_SERVER['REQUEST_URI']);
    if (isset($url['query'])) 
        parse_str($url['query'], $query);
        if (isset($query['logout'])) {
            setcookie("login", "", time() - 60, '/');
            unset($_SESSION['usuario_nome']);
            unset($_SESSION['usuario_sobrenome']);
            header("Location: .");
        }
    ?>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a href="/locadora_carros/index.php" class="navbar-brand">Locadora</a>
            <?php if (!(str_ends_with($_SERVER['REQUEST_URI'], "login.php") | str_ends_with($_SERVER['REQUEST_URI'], "cadastro.php"))) { ?>
            <div class="d-flex">
                <?php if (!isset($_COOKIE['login'])) { ?>
                    <a class="btn btn-outline-primary" href="/locadora_carros/pages/login.php">Log in</a>
                <?php }
                else { ?>
                <div class="dropdown">
                    <img style="user-select: none;" src="/locadora_carros/img/user_icon.jpg" width="32" role="button" data-bs-toggle="dropdown">
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a style="color: red" class="dropdown-item" href="?logout=true">Log out</a>
                        </li>
                    </ul>
                </div> <?php } ?>
            </div>
            <?php } ?>
        </div>
    </nav>
</header>