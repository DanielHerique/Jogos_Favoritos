<?php
session_start();
$usuario = $_SESSION["usuario"] ?? null;

include 'dados_fixos.php';

if (isset($_SESSION['logout_message'])) {
    $alerta = $_SESSION['logout_message'];
    unset($_SESSION['logout_message']);  // Remove a mensagem após usá-la
}
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
    <?php if (isset($alerta)): ?>
        <div class="alerta"><?php echo htmlspecialchars($alerta); ?></div>
    <?php endif; ?>

    <?php include 'header.php'; ?>



    <div class="container">
        <?php if ($usuario && isset($_SESSION["boas_vindas"])): ?>
            <h2 class="bem-vindo">Bem-vindo, <?php echo htmlspecialchars($usuario); ?>!</h2>
            <?php unset($_SESSION["boas_vindas"]);
            ?>
        <?php endif; ?>

        <h3 class="titulo">Catálogo de Jogos</h3>
        <div style="text-align: right; margin-bottom: 10px;">
            <input type="text" id="campo-pesquisa" placeholder="Pesquisar jogo..." style="padding: 8px; width: 250px; border-radius: 8px;">
        </div>
    </div>

    <div class="jogos-container" id="catalogo-jogos">
        <?php
        if (isset($_SESSION['jogos']) && !empty($_SESSION['jogos'])) {
            foreach ($_SESSION['jogos'] as $index => $jogo) {
                $id = "usuario-" . $index;
                echo "<div class='jogo-card' data-nome='" . strtolower($jogo['nome']) . "' id='{$id}'>";
                echo "<img src='" . htmlspecialchars($jogo['imagem']) . "' alt='Imagem do jogo' class='jogo-imagem'>";
                echo "<p class='jogo-nome'>" . htmlspecialchars($jogo['nome']) . "</p>";
                echo "<button class='botao' onclick='abrirModalUsuario($index)'>Ver Mais</button>";
                echo "</div>";
            }
        }
        foreach ($jogos_fixos as $index => $jogo) {
            $id = "fixo-" . $index;
            echo "<div class='jogo-card' data-nome='" . strtolower($jogo['nome']) . "' id='{$id}'>";
            echo "<img src='" . htmlspecialchars($jogo['imagem']) . "' alt='Imagem do jogo' class='jogo-imagem'>";
            echo "<p class='jogo-nome'>" . htmlspecialchars($jogo['nome']) . "</p>";
            echo "<button class='botao' onclick='abrirModalFixos($index)'>Ver Mais</button>";
            echo "</div>";
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
            document.getElementById('modal-titulo').innerText = jogo.nome;
            document.getElementById('modal-imagem').src = jogo.imagem;
            document.getElementById('modal-descricao').innerText = jogo.descricao;
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

        document.getElementById('campo-pesquisa').addEventListener('input', function() {
            let termo = this.value.toLowerCase();
            let cards = document.querySelectorAll('.jogo-card');

            cards.forEach(card => {
                let nome = card.getAttribute('data-nome');
                if (nome.includes(termo)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>
