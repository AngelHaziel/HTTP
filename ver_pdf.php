<?php
$userId = 1; 
$remoteUrl = 'http://10.0.0.7/recibir_usuario.php'; 
$response = file_get_contents($remoteUrl . '?id=' . $userId);
if ($response === false) {
    echo 'Error al enviar el ID de usuario.';
} else {
    header('Location: recibir_usuario.php');
    exit;
}
?>