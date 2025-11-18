<?php
include 'conexion.php';
$pacientes = $conn->query("SELECT * FROM Pacientes ORDER BY nombre");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pacientes - Clínica Internacional</title>
<link rel="stylesheet" href="estilo.css">
</head>
<body>
<div class="container">
<header>
<h1>👥 Pacientes</h1>
<a href="agregar_paciente.php" class="btn">➕ Nuevo Paciente</a>
<a href="index.php" class="btn">🏠 Panel</a>
</header>

<table>
<tr>
<th>ID</th>
<th>Nombre</th>
<th>DNI</th>
<th>Email</th>
<th>Teléfono</th>
<th>Obra Social</th>
<th>Alergias</th>
<th>Acciones</th>
</tr>
<?php while($p = $pacientes->fetch_assoc()): ?>
<tr>
<td><?= $p['id_paciente'] ?></td>
<td><?= htmlspecialchars($p['nombre']) ?></td>
<td><?= $p['dni'] ?></td>
<td><?= htmlspecialchars($p['email']) ?></td>
<td><?= htmlspecialchars($p['telefono']) ?></td>
<td><?= htmlspecialchars($p['obra_social']) ?></td>
<td><?= htmlspecialchars($p['alergias']) ?></td>
<td>
<a href="editar_paciente.php?id=<?= $p['id_paciente'] ?>" class="btn">✏️ Editar</a>
<a href="eliminar_paciente.php?id=<?= $p['id_paciente'] ?>" class="btn" style="background:#dc3545;">🗑️ Eliminar</a>
</td>
</tr>
<?php endwhile; ?>
</table>
</div>
</body>
</html>
