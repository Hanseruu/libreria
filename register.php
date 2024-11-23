<?php
// Conexión a la base de datos usando PDO
try {
    $pdo = new PDO('mysql:host=localhost:8012;dbname=libreria', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Registro de usuario
if (isset($_POST['signUp'])) {
    // Obtener los valores del formulario y eliminar espacios extra
    $firstName = trim($_POST['fName']);
    $lastName = trim($_POST['lName']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validar que los campos no estén vacíos
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        echo "Todos los campos son obligatorios.";
    } else {
        // Cifrar la contraseña
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Verificar si el correo ya existe
            $checkEmail = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $pdo->prepare($checkEmail);
            $stmt->execute(['email' => $email]);

            if ($stmt->rowCount() > 0) {
                echo "El Email que ha introducido ya existe!";
            } else {
                // Insertar el nuevo usuario
                $insertQuery = "INSERT INTO usuarios (firstName, lastName, email, password) VALUES (:firstName, :lastName, :email, :password)";
                $stmt = $pdo->prepare($insertQuery);
                
                if ($stmt->execute(['firstName' => $firstName, 'lastName' => $lastName, 'email' => $email, 'password' => $passwordHash])) {
                    echo "Usuario registrado con éxito.";
                    header("Location: login.php"); // Redirigir a la página de login
                    exit();
                } else {
                    echo "Error: No se pudo registrar el usuario.";
                }
            }
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
    }
}

// Inicio de sesión
if (isset($_POST['signIn'])) {
    // Obtener los valores del formulario y eliminar espacios extra
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validar que los campos no estén vacíos
    if (empty($email) || empty($password)) {
        echo "Por favor ingrese su email y contraseña.";
    } else {
        try {
            // Consulta para obtener los datos del usuario
            $sql = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar si el usuario existe y si la contraseña es correcta
            if ($user && password_verify($password, $user['password'])) {
                // Iniciar sesión y redirigir a la página principal
                session_start();
                $_SESSION['email'] = $user['email'];
                header("Location: homepage.php"); // Redirigir a la página principal
                exit(); // Asegúrate de salir después de la redirección
            } else {
                echo "Email o contraseña incorrectos.";
            }
        } catch (PDOException $e) {
            echo "Error en la consulta: " . $e->getMessage();
        }
    }
}
?>
