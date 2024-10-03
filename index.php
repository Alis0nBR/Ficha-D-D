<?php

session_start();

// Configurações de conexão
$servername = "localhost";
$username = "sa";
$password = "123";
$dbname = "sistema_login";

try {
    $dsn = "sqlsrv:server=$servername;Database=$dbname";
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Conexão falhou: " . $e->getMessage());
}

// Estabelece a conexão
$conn = sqlsrv_connect($servername, array(
    "UID" => $username,
    "PWD" => $password,
    "Database" => $dbname,
));

if ($conn === false) {
    die("Conexão falhou: " . print_r(sqlsrv_errors(), true));
}

// Registro de Usuário
if (isset($_POST['registro'])) {
    $usuario = $_POST['usuario'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $checkUser = "SELECT * FROM usuarios WHERE usuario = ?";
    $checkStmt = sqlsrv_query($conn, $checkUser, array($usuario));
    
    if ($checkStmt !== false && sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC)) {
        echo "Usuário já existe.";
    } else {
        $sql = "INSERT INTO usuarios (usuario, senha) VALUES (?, ?)";
        $params = array($usuario, $senha);
        
        $stmt = sqlsrv_query($conn, $sql, $params);
        
        if ($stmt === false) {
            echo "Erro ao registrar usuário: " . print_r(sqlsrv_errors(), true);
        } else {
            echo "Usuário registrado com sucesso!";
            header('Location: index.php');
            exit();
        }
    }
}

// Login de Usuário
if (isset($_POST['login'])) {
    $usuario = $_POST['login_usuario'];
    $senha = $_POST['login_senha'];

    $sql = "SELECT * FROM usuarios WHERE usuario = ?";
    $params = array($usuario);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo "Erro: " . print_r(sqlsrv_errors(), true);
    } else {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        if ($row) {
            // Verifica a senha
            if (password_verify($senha, $row['senha'])) {
                $_SESSION['usuario'] = $usuario;
                header('Location: inicial.php');
                exit();
            } else {
                echo "Senha incorreta.";
            }
        } else {
            echo "Usuário não encontrado.";
        }
    }
}

// Fecha a conexão
sqlsrv_close($conn);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="Style/registro.css">
</head>

<script>
    function toggleForms() {
        var loginForm = document.getElementById('login-form');
        var registerForm = document.getElementById('register-form');

        // Alterna a visibilidade dos formulários
        if (loginForm.classList.contains('hidden')) {
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
        } else {
            loginForm.classList.add('hidden');
            registerForm.classList.remove('hidden');
        }
    }
</script>

<body>
    <div class="form-container">
        <!-- Botão para alternar entre login e registro -->
        <button class="toggle-btn" onclick="toggleForms()">Trocar para Registro/Login</button>

        <!-- Formulário de Login -->
        <form id="login-form" method="POST" action="index.php">
            <h2>Login</h2>
            <label for="login_usuario">Usuário:</label>
            <input type="text" name="login_usuario" required>

            <label for="login_senha">Senha:</label>
            <input type="password" name="login_senha" required>

            <input type="submit" name="login" value="Login">
        </form>

        <!-- Formulário de Registro -->
        <form id="register-form" method="POST" action="index.php" class="hidden">
            <h2>Registrar</h2>
            <label for="usuario">Usuário:</label>
            <input type="text" name="usuario" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" required>

            <input type="submit" name="registro" value="Registrar">
        </form>
    </div>
</body>

</html>