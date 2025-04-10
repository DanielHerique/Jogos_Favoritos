<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuario = $_SESSION['usuario'] ?? null;
?>

<header>
<div class="menu">
    <div class="nav-links">
        <a href="index.php">Início</a>
        <a href="meus_jogos.php">Meus Jogos</a>
        <a href="cadastro.php">Cadastrar Novo Jogo</a>
    </div>
    <a href="logout.php" class="logout">Logout</a>
</div>
</header>
