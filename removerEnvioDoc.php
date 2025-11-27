<?php

session_start();
require_once __DIR__ . "/classes/Documento.php";

if(!isset($_SESSION['idUsuario'])){
    header('Location: cadastro.php');
    exit;
}

if(!isset($_GET['idDocumento']) || !isset($_GET['idEstagio'])){
    header('Location: listagemDoc.php');
    exit;
}

$idDocumento = intval($_GET['idDocumento']);
$idEstagio = intval($_GET['idEstagio']);

// Buscar o documento
$documento = Documento::find($idDocumento);

if($documento){
    // Se existe arquivo, remover do servidor
    if(!empty($documento->getArquivo())){
        $caminhoArquivo = __DIR__ . '/uploads/' . $documento->getArquivo();
        if(file_exists($caminhoArquivo)){
            unlink($caminhoArquivo);
        }
    }
    
    // Atualizar o documento:
    // - Remover o arquivo
    // - Resetar status para Pendente (não enviado)
    // - Limpar data de envio
    $documento->setArquivo('');
    $documento->setStatus(Documento::STATUS_PENDENTE);
    $documento->setDataEnvio(null);
    $documento->update();
}

// Redirecionar de volta para a listagem
header('Location: listagemDoc.php?idEstagio=' . $idEstagio);
exit;

?>
