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
            <?php if ($usuario): ?>
                <a href="meus_jogos.php">Meus Jogos</a>
                <a href="cadastro.php">Cadastrar Novo Jogo</a>
            <?php endif; ?>
        </div>
        <?php if ($usuario): ?>
            <a href="logout.php" class="logout">Logout</a>
        <?php else: ?>
            <a href="login.php?origem=index.php" class="logout">Login</a>
        <?php endif; ?>
    </div>
</header>
