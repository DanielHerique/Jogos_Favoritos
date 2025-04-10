<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    $_SESSION["origem"] = "meus_jogos.php";
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Jogos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <h3 class="titulo">Meus Jogos</h3>

    <div class="jogos-container">
        <?php
        if (!isset($_SESSION['jogos']) || empty($_SESSION['jogos'])) {
            echo "<p class='mensagem'>Nenhum jogo cadastrado.</p>";
        } else {
            foreach ($_SESSION['jogos'] as $index => $jogo) {
                echo "<div class='jogo-card'>";
                echo "<img src='" . htmlspecialchars($jogo['imagem']) . "' alt='Imagem do jogo' class='jogo-imagem'>";
                echo "<p class='jogo-nome'>" . htmlspecialchars($jogo['nome']) . "</p>";
                echo "<button class='botao' onclick='abrirModal($index)'>Ver Mais</button>";
                echo "</div>";
            }
        }
        ?>
    </div>

    <div id="modal" class="modal">
        <div class="modal-conteudo">
            <span class="fechar" onclick="fecharModal()">&times;</span>
            <h2 id="modal-titulo"></h2>
            <img id="modal-imagem" src="" alt="Imagem do jogo" class="modal-imagem">
            <p id="modal-descricao"></p>
        </div>
    </div>

    <script>
        function abrirModal(index) {
            let modal = document.getElementById('modal');
            let modalTitulo = document.getElementById('modal-titulo');
            let modalImagem = document.getElementById('modal-imagem');
            let modalDescricao = document.getElementById('modal-descricao');

            let jogos = <?php echo json_encode($_SESSION['jogos'] ?? []); ?>;

            if (jogos[index]) {
                modalTitulo.innerText = jogos[index].nome;
                modalImagem.src = jogos[index].imagem;
                modalDescricao.innerText = jogos[index].descricao;

                modal.style.display = 'flex';
            }
        }

        function fecharModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
