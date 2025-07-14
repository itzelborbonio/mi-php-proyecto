<?php
include('../php/conecta.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $pass = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $stmt = $mysqli->prepare("INSERT INTO usuarios (nombre, correo, contraseña, direccion, telefono) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nombre, $correo, $pass, $direccion, $telefono);
    if ($stmt->execute()) {
        echo "Usuario registrado.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<form method="post">
    Nombre: <input type="text" name="nombre"><br>
    Correo: <input type="email" name="correo"><br>
    Contraseña: <input type="password" name="contraseña"><br>
    Dirección: <input type="text" name="direccion"><br>
    Teléfono: <input type="text" name="telefono"><br>
    <button type="submit">Registrarse</button>
</form>