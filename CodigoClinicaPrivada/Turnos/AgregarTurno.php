<?php
include 'conexion.php';

// Si se envía el formulario
if ($_POST) {
    $id_paciente = $_POST['id_paciente'];
    $id_medico = $_POST['id_medico'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $estado = "Pendiente"; // Estado por defecto

    $stmt = $conn->prepare("INSERT INTO Turnos (id_paciente, id_medico, fecha, hora, estado) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $id_paciente, $id_medico, $fecha, $hora, $estado);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error al guardar el turno";
    }
}

// Obtener pacientes
$pacientes = $conn->query("SELECT id_paciente, nombre, dni FROM Pacientes");

// Obtener médicos
$medicos = $conn->query("SELECT id_medico, nombre, especialidad FROM Medicos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Turno</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

    <div class="container">
        <header>
            <h1>📅 Registrar Turno</h1>
            <nav>
                <a href="index.php" class="btn btn-secondary">⬅️ Volver</a>
            </nav>
        </header>

        <section class="form-section">
            <form method="POST" class="turno-form">

                <div class="form-group">
                    <label for="id_paciente">Paciente:</label>
                    <select name="id_paciente" id="id_paciente" required>
                        <option value="">Seleccione un paciente...</option>
                        <?php while($p = $pacientes->fetch_assoc()): ?>
                            <option value="<?= $p['id_paciente'] ?>">
                                <?= $p['nombre'] ?> (DNI: <?= $p['dni'] ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_medico">Médico:</label>
                    <select name="id_medico" id="id_medico" required>
                        <option value="">Seleccione un médico...</option>
                        <?php while($m = $medicos->fetch_assoc()): ?>
                            <option value="<?= $m['id_medico'] ?>">
                                <?= $m['nombre'] ?> - <?= $m['especialidad'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="fecha">Fecha:</label>
                        <input type="date" name="fecha" id="fecha" required>
                    </div>

                    <div class="form-group">
                        <label for="hora">Hora:</label>
                        <input type="time" name="hora" id="hora" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">💾 Guardar Turno</button>
                    <a href="index.php" class="btn btn-secondary">❌ Cancelar</a>
                </div>

            </form>
        </section>
    </div>

</body>
</html>
