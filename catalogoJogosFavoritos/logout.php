<?php
session_start();
unset($_SESSION["usuario"]);

$_SESSION['logout_message'] = 'Você foi desconectado com sucesso!';

header("Location: index.php");
exit();
?>
