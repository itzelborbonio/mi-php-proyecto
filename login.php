?php
session_start();
include('php/conecta.php');

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'] ?? '';
    $contraseña = $_POST['contraseña'] ?? '';

    $stmt = $mysqli->prepare("SELECT id_usuario, password, nombre FROM usuarios WHERE correo = ?");
    if (!$stmt) {
        die("Error en la consulta preparada: " . $mysqli->error);
    }

    $stmt->bind_param("s", $correo);
    $stmt->execute();

    $resultado = $stmt->get_result();
    if ($resultado->num_rows === 1) {
        $row = $resultado->fetch_assoc();
        if (password_verify($contraseña, $row['password'])) {
            $_SESSION['correo'] = $correo;
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['id_usuario'] = $row['id_usuario'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Correo no registrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Iniciar sesión</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; }
        .container { max-width: 400px; margin: 100px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
        h2 { text-align: center; color: #4b0082; }
        form { display: flex; flex-direction: column; }
        label { margin: 10px 0 5px; }
        input { padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        button { margin-top: 20px; padding: 10px; background-color: #6a0dad; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #5a0082; }
        .error { color: red; margin-top: 10px; text-align: center; }
        .link { margin-top: 15px; text-align: center; }
        .link a { color: #4b0082; text-decoration: none; }
        .link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Iniciar sesión</h2>
        <form method="post" action="">
            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required />
            
            <label for="contraseña">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" required />
            
            <button type="submit">Entrar</button>
        </form>
        <?php if($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <div class="link">
            ¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a>
        </div>
    </div>
</body>
</html>
