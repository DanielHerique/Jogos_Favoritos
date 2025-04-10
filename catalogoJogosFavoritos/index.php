<?php
session_start();
$usuario = $_SESSION["usuario"] ?? null;

include 'dados_fixos.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Jogos</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <?php if ($usuario): ?>
            <h2 class="bem-vindo">Bem-vindo, <?php echo htmlspecialchars($usuario); ?>!</h2>
        <?php endif; ?>
    </div>

    <h3 class="titulo">Catálogo de Jogos</h3>

    <div class="jogos-container">
        <?php

        foreach ($jogos_fixos as $index => $jogo) {
            echo "<div class='jogo-card'>";
            echo "<img src='" . htmlspecialchars($jogo['imagem']) . "' alt='Imagem do jogo' class='jogo-imagem'>";
            echo "<p class='jogo-nome'>" . htmlspecialchars($jogo['nome']) . "</p>";
            echo "<button class='botao' onclick='abrirModalFixos($index)'>Ver Mais</button>";
            echo "</div>";
        }

        if (isset($_SESSION['jogos']) && !empty($_SESSION['jogos'])) {
            foreach ($_SESSION['jogos'] as $index => $jogo) {
                echo "<div class='jogo-card'>";
                echo "<img src='" . htmlspecialchars($jogo['imagem']) . "' alt='Imagem do jogo' class='jogo-imagem'>";
                echo "<p class='jogo-nome'>" . htmlspecialchars($jogo['nome']) . "</p>";
                echo "<button class='botao' onclick='abrirModalUsuario($index)'>Ver Mais</button>";
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
        let jogosFixos = <?php echo json_encode($jogos_fixos); ?>;
        let jogosUsuario = <?php echo json_encode($_SESSION['jogos'] ?? []); ?>;

        function abrirModalFixos(index) {
            abrirModalGeral(jogosFixos[index]);
        }

        function abrirModalUsuario(index) {
            abrirModalGeral(jogosUsuario[index]);
        }

        function abrirModalGeral(jogo) {
            let modal = document.getElementById('modal');
            let modalTitulo = document.getElementById('modal-titulo');
            let modalImagem = document.getElementById('modal-imagem');
            let modalDescricao = document.getElementById('modal-descricao');

            modalTitulo.innerText = jogo.nome;
            modalImagem.src = jogo.imagem;
            modalDescricao.innerText = jogo.descricao;

            modal.style.display = 'flex';
        }

        function fecharModal() {
            document.getElementById('modal').style.display = 'none';
        }

        function verificarLogin() {
            let usuarioLogado = <?php echo isset($_SESSION["usuario"]) ? 'true' : 'false'; ?>;
            if (usuarioLogado) {
                window.location.href = 'meus_jogos.php';
            } else {
                window.location.href = 'login.php';
            }
        }
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>
