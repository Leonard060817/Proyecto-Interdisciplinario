<?php
include 'conexion.php';
$id = intval($_GET['id']);
$conn->query("DELETE FROM Turnos WHERE id_turno = $id");
header("Location: listar_turnos.php");
exit;
?>
