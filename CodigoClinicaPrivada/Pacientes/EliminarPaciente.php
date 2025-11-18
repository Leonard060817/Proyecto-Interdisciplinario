<?php
include 'conexion.php';
$id = intval($_GET['id']);
$conn->query("DELETE FROM Pacientes WHERE id_paciente = $id");
header("Location: listar_pacientes.php");
exit;
?>
