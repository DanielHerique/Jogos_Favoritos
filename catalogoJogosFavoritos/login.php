<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"] ?? "";
    $senha = $_POST["senha"] ?? "";

    if ($usuario === "admin" && $senha === "up@2025") {
        $_SESSION["usuario"] = $usuario;

        if (!isset($_SESSION["jogos"])) {
            $_SESSION["jogos"] = [];
        }

        $destino = $_SESSION["origem"] ?? "meus_jogos.php";
        unset($_SESSION["origem"]);

        header("Location: $destino");
        exit();
    } else {
        $erro = "Usuário ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container login-container">
        <h2>Meu catálogo</h2>
        <br><br><br>
        <?php if (isset($erro)) { echo "<p class='erro'>" . htmlspecialchars($erro) . "</p>"; } ?>
        <form action="login.php" method="post" class="form-container" onsubmit="salvarJogos()">
            <label>Usuário:</label>
            <input type="text" name="usuario" required><br>
            <label>Senha:</label>
            <input type="password" name="senha" required><br>
            <input type="hidden" name="jogosSalvos" id="jogosSalvos">
            <input type="submit" value="Entrar" class="botao">
        </form>
    </div>

    <script>
        function salvarJogos() {
            let jogos = sessionStorage.getItem("jogos") || "[]";
            document.getElementById("jogosSalvos").value = jogos;
        }
    </script>
</body>
</html>
