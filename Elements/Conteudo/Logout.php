<?php

include '../../index.php';


session_start();
session_unset(); // Limpa as variáveis de sessão
session_destroy(); // Destrói a sessão

header("Location: index.php"); // Redireciona para a página de login
exit();

?>