<?php
include 'conexion.php';
$id = intval($_GET['id']);
$conn->query("DELETE FROM Medicos WHERE id_medico = $id");
header("Location: listar_medicos.php");
exit;
?>
