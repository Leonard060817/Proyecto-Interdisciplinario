<?php
include 'conexion.php';
$turnos = $conn->query("
    SELECT t.id_turno, t.fecha, t.hora, t.estado,
           p.nombre AS paciente, m.nombre AS medico
    FROM Turnos t
    JOIN Pacientes p ON t.id_paciente = p.id_paciente
    JOIN Medicos m ON t.id_medico = m.id_medico
    ORDER BY t.fecha, t.hora
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Turnos - Clínica Internacional</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="container">
<header>
<h1>📅 Turnos</h1>
<a href="agregar_turno.php" class="btn">➕ Nuevo Turno</a>
<a href="index.php" class="btn">🏠 Panel</a>
</header>

<table>
<tr>
    <th>ID</th>
    <th>Paciente</th>
    <th>Médico</th>
    <th>Fecha</th>
    <th>Hora</th>
    <th>Estado</th>
    <th>Acciones</th>
</tr>
<?php while($t = $turnos->fetch_assoc()): ?>
<tr>
    <td><?= $t['id_turno'] ?></td>
    <td><?= htmlspecialchars($t['paciente']) ?></td>
    <td><?= htmlspecialchars($t['medico']) ?></td>
    <td><?= $t['fecha'] ?></td>
    <td><?= $t['hora'] ?></td>
    <td><?= $t['estado'] ?></td>
    <td>
        <a href="editar_turno.php?id=<?= $t['id_turno'] ?>" class="btn">✏️ Editar</a>
        <a href="eliminar_turno.php?id=<?= $t['id_turno'] ?>" class="btn" style="background:#dc3545;">🗑️ Eliminar</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
</div>
</body>
</html>
