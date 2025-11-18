<?php
include 'conexion.php';

if ($_POST) {
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $obra_social = $_POST['obra_social'];
    $alergias = $_POST['alergias'];

    $stmt = $conn->prepare("INSERT INTO Pacientes (nombre, dni, email, telefono, obra_social, alergias) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $dni, $email, $telefono, $obra_social, $alergias);

    if ($stmt->execute()) {
        header("Location: listar_pacientes.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agregar Paciente - Clínica Internacional</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="container">
<header>
<h1>➕ Agregar Paciente</h1>
<a href="listar_pacientes.php" class="btn">⬅️ Volver</a>
</header>

<form method="POST" class="form-section">
<div class="form-group">
<label>Nombre:</label>
<input type="text" name="nombre" required>
</div>
<div class="form-group">
<label>DNI:</label>
<input type="text" name="dni" required>
</div>
<div class="form-group">
<label>Email:</label>
<input type="email" name="email">
</div>
<div class="form-group">
<label>Teléfono:</label>
<input type="text" name="telefono">
</div>
<div class="form-group">
<label>Obra Social:</label>
<input type="text" name="obra_social">
</div>
<div class="form-group">
<label>Alergias:</label>
<textarea name="alergias" rows="3"></textarea>
</div>

<div class="form-actions">
<button type="submit" class="btn btn-primary">💾 Guardar Paciente</button>
<a href="listar_pacientes.php" class="btn btn-secondary">❌ Cancelar</a>
</div>
</form>
</div>
</body>
</html>
