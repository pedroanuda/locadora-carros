<?php
include "./db/bd_man.php";

echo $_GET['carro'];

if (isset($_GET['carro']) && isset($_COOKIE['login']) && possui_carro($_GET['carro'], $_COOKIE['login'])) {
    header("Location: pages/resumo.php?carro=" . $_GET['carro'] . "&km=" . $_GET['km']);
}

//header("Location: devolucao.php");