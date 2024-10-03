<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "sa";
$password = "123";
$dbname = "dnd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $classe = $_POST["classe"];
    $raca = $_POST["raca"];
    $nivel = $_POST["nivel"];
    $forca = $_POST["forca"];
    $destreza = $_POST["destreza"];
    $constituicao = $_POST["constituicao"];
    $inteligencia = $_POST["inteligencia"];
    $sabedoria = $_POST["sabedoria"];
    $carisma = $_POST["carisma"];
    $pontos_vida = $_POST["pontos_vida"];
    $equipamento = $_POST["equipamento"];
    $habilidades = $_POST["habilidades"];

    $sql = "INSERT INTO ficha_personagem (nome, classe, raca, nivel, forca, destreza, constituicao, inteligencia, sabedoria, carisma, pontos_vida, equipamento, habilidades)
            VALUES ('$nome', '$classe', '$raca', '$nivel', '$forca', '$destreza', '$constituicao', '$inteligencia', '$sabedoria', '$carisma', '$pontos_vida', '$equipamento', '$habilidades')";

    if ($conn->query($sql) === TRUE) {
        echo "Ficha salva com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
