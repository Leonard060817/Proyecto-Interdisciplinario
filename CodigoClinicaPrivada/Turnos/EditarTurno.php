<?php
include 'conexion.php';

$id_turno = intval($_GET['id']);
$turno = $conn->query("SELECT * FROM Turnos WHERE id_turno = $id_turno")->fetch_assoc();

if (!$turno) {
    header("Location: index.php");
    exit;
}

// Obtener listas
$pacientes = $conn->query("SELECT id_paciente, nombre, dni FROM Pacientes");
$medicos = $conn->query("SELECT id_medico, nombre, especialidad FROM Medicos");

if ($_POST) {
    $id_paciente = $_POST['id_paciente'];
    $id_medico   = $_POST['id_medico'];
    $fecha       = $_POST['fecha'];
    $hora        = $_POST['hora'];
    $estado      = $_POST['estado'];

    $stmt = $conn->prepare(
        "UPDATE Turnos 
         SET id_paciente = ?, id_medico = ?, fecha = ?, hora = ?, estado = ?
         WHERE id_turno = ?"
    );
    $stmt->bind_param("iisssi", $id_paciente, $id_medico, $fecha, $hora, $estado, $id_turno);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "❌ Error al actualizar turno.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Turno - Clínica Privada</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

<div class="container">
    <header>
        <h1>✏️ Editar Turno</h1>
        <nav>
            <a href="index.php" class="btn btn-secondary">⬅️ Volver</a>
        </nav>
    </header>

    <section class="form-section">
        <form method="POST" class="turno-form">

            <div class="form-group">
                <label>Paciente:</label>
                <select name="id_paciente" required>
                    <?php while($p = $pacientes->fetch_assoc()): ?>
                        <option value="<?= $p['id_paciente'] ?>"
                            <?= $p['id_paciente'] == $turno['id_paciente'] ? 'selected' : '' ?>>
                            <?= $p['nombre'] ?> (DNI: <?= $p['dni'] ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Médico:</label>
                <select name="id_medico" required>
                    <?php while($m = $medicos->fetch_assoc()): ?>
                        <option value="<?= $m['id_medico'] ?>"
                            <?= $m['id_medico'] == $turno['id_medico'] ? 'selected' : '' ?>>
                            <?= $m['nombre'] ?> - <?= $m['especialidad'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Fecha:</label>
                    <input type="date" name="fecha" value="<?= $turno['fecha'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Hora:</label>
                    <input type="time" name="hora" value="<?= $turno['hora'] ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Estado:</label>
                <select name="estado" required>
                    <option <?= $turno['estado'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option <?= $turno['estado'] == 'Confirmado' ? 'selected' : '' ?>>Confirmado</option>
                    <option <?= $turno['estado'] == 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                </select>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary" type="submit">💾 Actualizar Turno</button>
                <a href="index.php" class="btn btn-secondary">❌ Cancelar</a>
            </div>

        </form>
    </section>
</div>

</body>
</html>
