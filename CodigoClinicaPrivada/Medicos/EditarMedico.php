<?php
include 'conexion.php';
$id = intval($_GET['id']);
$medico = $conn->query("SELECT * FROM Medicos WHERE id_medico = $id")->fetch_assoc();

if (!$medico) {
    header("Location: listar_medicos.php");
    exit;
}

if ($_POST) {
    $nombre = $_POST['nombre'];
    $especialidad = $_POST['especialidad'];
    $matricula = $_POST['matricula'];
    $disponibilidad = $_POST['disponibilidad'];

    $stmt = $conn->prepare("UPDATE Medicos SET nombre=?, especialidad=?, matricula=?, disponibilidad=? WHERE id_medico=?");
    $stmt->bind_param("ssssi", $nombre, $especialidad, $matricula, $disponibilidad, $id);

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
<title>Editar Médico - Clínica Internacional</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="container">
<header>
<h1>✏️ Editar Médico</h1>
<a href="listar_medicos.php" class="btn">⬅️ Volver</a>
</header>

<form method="POST" class="form-section">
<div class="form-group">
<label>Nombre:</label>
<input type="text" name="nombre" value="<?= htmlspecialchars($medico['nombre']) ?>" required>
</div>
<div class="form-group">
<label>Especialidad:</label>
<input type="text" name="especialidad" value="<?= htmlspecialchars($medico['especialidad']) ?>" required>
</div>
<div class="form-group">
<label>Matrícula:</label>
<input type="text" name="matricula" value="<?= htmlspecialchars($medico['matricula']) ?>" required>
</div>
<div class="form-group">
<label>Disponibilidad:</label>
<textarea name="disponibilidad" rows="3"><?= htmlspecialchars($medico['disponibilidad']) ?></textarea>
</div>

<div class="form-actions">
<button type="submit" class="btn btn-primary">💾 Actualizar Médico</button>
<a href="listar_medicos.php" class="btn btn-secondary">❌ Cancelar</a>
</div>
</form>
</div>
</body>
</html>
