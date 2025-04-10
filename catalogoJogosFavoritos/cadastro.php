<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    $_SESSION["origem"] = "cadastro.php";
    header("Location: login.php");
    exit();
}

$mensagem = "";
$nome = $_POST["nome"] ?? "";
$descricao = $_POST["descricao"] ?? "";
$imagem = $_FILES["imagem"] ?? null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($nome) || empty($descricao)) {
        $mensagem = "Preencha todos os campos corretamente!";
    } elseif (!isset($imagem) || $imagem["error"] !== 0) {
        $mensagem = "Por favor, adicione uma imagem para o jogo!";
    } else {
        $uploadDir = "IMG/";
        $uploadFile = $uploadDir . basename($imagem["name"]);

        if (move_uploaded_file($imagem["tmp_name"], $uploadFile)) {
            $_SESSION["jogos"][] = [
                "nome" => $nome,
                "descricao" => $descricao,
                "imagem" => $uploadFile
            ];
            $mensagem = "Jogo cadastrado com sucesso!";
            
            // Se cadastrar o jogo corretamente, limpa os formularios, se não mantem o que foi preenchido
            $nome = "";
            $descricao = "";
        } else {
            $mensagem = "Erro ao fazer upload da imagem.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Jogos</title>
    <link rel="stylesheet" href="estilos.css">
    <script>
        function exibirMensagem() {
            var mensagem = "<?php echo htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?>";
            if (mensagem) {
                alert(mensagem);
            }
        }
        window.onload = exibirMensagem;
    </script>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h2>Cadastrar Novo Jogo</h2>
        <form action="cadastro.php" method="post" enctype="multipart/form-data" class="form-container">
            <label for="nome">Nome do Jogo:</label>
            <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($nome) ?>" required>
            
            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" required><?= htmlspecialchars($descricao) ?></textarea>
            
            <label for="imagem">Imagem:</label>
            <div class="upload-container">
                <input type="file" name="imagem" id="imagem" accept="image/*">
                <label for="imagem" class="botao-upload">Escolher Arquivo</label>
                <span id="nome-arquivo">Nenhum arquivo selecionado</span>
            </div>
            
            <button type="submit" class="botao">Cadastrar</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
