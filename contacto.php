<?php
// Conexión a la base de datos usando PDO (si necesitas almacenar el mensaje)
try {
    $pdo = new PDO('mysql:host=localhost:8012;dbname=libreria', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Procesar el formulario cuando se envíe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $nombre = $_POST['nombre'];
    $asunto = $_POST['asunto'];
    $comentario = $_POST['comentario'];

    // Insertar los datos en la tabla contacto (opcional, si deseas almacenar los mensajes)
    $sql = "INSERT INTO contacto (fecha, correo, nombre, asunto, comentario) 
            VALUES (NOW(), :correo, :nombre, :asunto, :comentario)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['correo' => $correo, 'nombre' => $nombre, 'asunto' => $asunto, 'comentario' => $comentario]);

    // Mensaje de confirmación
    echo "Mensaje enviado exitosamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Librería</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Archivo CSS personalizado -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Librería</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="homepage.php">Libros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="autores.php">Autores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contacto.php">Contacto</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Contacto</h1>
        <p>Si tienes alguna pregunta, por favor llena el siguiente formulario.</p>

        <!-- Formulario de contacto -->
        <form action="contacto.php" method="POST">
            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="asunto">Asunto</label>
                <input type="text" class="form-control" id="asunto" name="asunto" required>
            </div>
            <div class="form-group">
                <label for="comentario">Comentario</label>
                <textarea class="form-control" id="comentario" name="comentario" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
