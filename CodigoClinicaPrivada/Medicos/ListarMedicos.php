<?php
include 'conexion.php';
$medicos = $conn->query("SELECT * FROM Medicos ORDER BY nombre");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Médicos - Clínica Internacional</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="container">
<header>
<h1>🩺 Médicos</h1>
<a href="agregar_medico.php" class="btn">➕ Nuevo Médico</a>
<a href="index.php" class="btn">🏠 Panel</a>
</header>

<table>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Especialidad</th>
<th>Matrícula</th>
<th>Disponibilidad</th>
<th>Acciones</th>
</tr>
<?php while($m = $medicos->fetch_assoc()): ?>
<tr>
<td><?= $m['id_medico'] ?></td>
<td><?= htmlspecialchars($m['nombre']) ?></td>
<td><?= htmlspecialchars($m['especialidad']) ?></td>
<td><?= htmlspecialchars($m['matricula']) ?></td>
<td><?= htmlspecialchars($m['disponibilidad']) ?></td>
<td>
<a href="editar_medico.php?id=<?= $m['id_medico'] ?>" class="btn">✏️ Editar</a>
<a href="eliminar_medico.php?id=<?= $m['id_medico'] ?>" class="btn" style="background:#dc3545;">🗑️ Eliminar</a>
</td>
</tr>
<?php endwhile; ?>
</table>
</div>
</body>
</html>
