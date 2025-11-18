<?php
require_once _DIR_ . "/../bd/MySQL.php";

if (!isset($_POST["idDocumento"])) {
    die("Documento inválido.");
}

$idDocumento = (int) $_POST["idDocumento"];
$comentario = trim($_POST["comentario"]);

$conn = new MySQL();

$sql = "
    INSERT INTO comentario_documento (idDocumento, idProfessor, comentario, dataHora)
    VALUES ('{$idDocumento}', '{$idProfessor}', '{$comentario}', NOW())
";

$conn->executa($sql);

header("Location: visualisarDoc.php?idDocumento=" . $idDocumento);
exit;