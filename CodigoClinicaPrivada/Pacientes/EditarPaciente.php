<?php
include 'conexion.php';
$id = intval($_GET['id']);
$paciente = $conn->query("SELECT * FROM Pacientes WHERE id_paciente = $id")->fetch_assoc();

if (!$paciente) {
    header("Location: listar_pacientes.php");
    exit;
}

if ($_POST) {
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $obra_social = $_POST['obra_social'];
    $alergias = $_POST['alergias'];

    $stmt = $conn->prepare("UPDATE Pacientes SET nombre=?, dni=?, email=?, telefono=?, obra_social=?, alergias=? WHERE id_paciente=?");
    $stmt->bind_param("ssssssi", $nombre, $dni, $email, $telefono, $obra_social, $alergias, $id);

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
<title>Editar Paciente - Clínica Internacional</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="container">
<header>
<h1>✏️ Editar Paciente</h1>
<a href="listar_pacientes.php" class="btn">⬅️ Volver</a>
</header>

<form method="POST" class="form-section">
<div class="form-group">
<label>Nombre:</label>
<input type="text" name="nombre" value="<?= htmlspecialchars($paciente['nombre']) ?>" required>
</div>
<div class="form-group">
<label>DNI:</label>
<input type="text" name="dni" value="<?= htmlspecialchars($paciente['dni']) ?>" required>
</div>
<div class="form-group">
<label>Email:</label>
<input type="email" name="email" value="<?= htmlspecialchars($paciente['email']) ?>">
</div>
<div class="form-group">
<label>Teléfono:</label>
<input type="text" name="telefono" value="<?= htmlspecialchars($paciente['telefono']) ?>">
</div>
<div class="form-group">
<label>Obra Social:</label>
<input type="text" name="obra_social" value="<?= htmlspecialchars($paciente['obra_social']) ?>">
</div>
<div class="form-group">
<label>Alergias:</label>
<textarea name="alergias" rows="3"><?= htmlspecialchars($paciente['alergias']) ?></textarea>
</div>

<div class="form-actions">
<button type="submit" class="btn btn-primary">💾 Actualizar Paciente</button>
<a href="listar_pacientes.php" class="btn btn-secondary">❌ Cancelar</a>
</div>
</form>
</div>
</body>
</html>
