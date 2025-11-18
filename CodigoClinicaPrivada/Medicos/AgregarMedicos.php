<?php
include 'conexion.php';

if ($_POST) {
    $nombre = $_POST['nombre'];
    $especialidad = $_POST['especialidad'];
    $matricula = $_POST['matricula'];
    $disponibilidad = $_POST['disponibilidad'];

    $stmt = $conn->prepare("INSERT INTO Medicos (nombre, especialidad, matricula, disponibilidad) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $especialidad, $matricula, $disponibilidad);

    if ($stmt->execute()) {
        header("Location: listar_medicos.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agregar Médico - Clínica Internacional</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="container">
<header>
<h1>➕ Agregar Médico</h1>
<a href="listar_medicos.php" class="btn">⬅️ Volver</a>
</header>

<form method="POST" class="form-section">
<div class="form-group">
<label>Nombre:</label>
<input type="text" name="nombre" required>
</div>
<div class="form-group">
<label>Especialidad:</label>
<input type="text" name="especialidad" required>
</div>
<div class="form-group">
<label>Matrícula:</label>
<input type="text" name="matricula" required>
</div>
<div class="form-group">
<label>Disponibilidad:</label>
<textarea name="disponibilidad" rows="3"></textarea>
</div>

<div class="form-actions">
<button type="submit" class="btn btn-primary">💾 Guardar Médico</button>
<a href="listar_medicos.php" class="btn btn-secondary">❌ Cancelar</a>
</div>
</form>
</div>
</body>
</html>
