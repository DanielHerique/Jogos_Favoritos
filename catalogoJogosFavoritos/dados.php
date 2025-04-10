<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $imagem = $_FILES['imagem']['name'] ?? '';

    if (!empty($nome) && !empty($descricao) && !empty($imagem)) {
        $uploadDir = 'IMG/';
        $uploadFile = $uploadDir . basename($_FILES['imagem']['name']);

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploadFile)) {
            $_SESSION['jogos'][] = [
                'nome' => $nome,
                'descricao' => $descricao,
                'imagem' => $imagem
            ];
        }
    }
}

header("Location: meus_jogos.php");
exit();
