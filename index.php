<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('php/conecta.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['correo'])) {
    header("Location: login.php");
    exit;
}

// Obtener categorías desde la base de datos (tabla 'categorias')
$resultado = $mysqli->query("SELECT id_categoria, nombre FROM categorias");
if (!$resultado) {
    die("Error en la consulta: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Books and Stories - Categorías</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('img/fondo_libros.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }
        header {
            background-color: rgba(75, 0, 130, 0.9);
            padding: 20px;
            text-align: center;
            position: relative;
        }
        header h1 {
            font-size: 28px;
            color: #fff;
            margin: 0;
        }
        .btn-carrito {
            position: absolute;
            right: 20px;
            top: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
        }
        .btn-carrito:hover {
            background-color: #0056b3;
        }
        .contenedor {
            max-width: 900px;
            margin: 40px auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            color: #333;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }
        h2 {
            text-align: center;
            color: #4b0082;
            margin-bottom: 30px;
        }
        .categorias {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }
        .categoria {
            background-color: #6a0dad;
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            width: 80%;
            max-width: 300px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
            text-decoration: none;
        }
        .categoria:hover {
            background-color: #5a0082;
            transform: scale(1.05);
        }
        .logout {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
        .logout a {
            color: #4b0082;
            font-weight: bold;
            text-decoration: none;
        }
        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
    <h1>Bienvenidos a Books and Stories</h1>
    <a class="btn-carrito" href="carrito.php">Ver Carrito</a>
</header>

<div class="contenedor">
    <h2>En donde podrás encontrar gran variedad de libros</h2>

    <div class="categorias">
        <?php while ($cat = $resultado->fetch_assoc()): ?>
            <a class="categoria" href="libros.php?id_categoria=<?= htmlspecialchars($cat['id_categoria']) ?>">
                <?= htmlspecialchars($cat['nombre']) ?>
            </a>
        <?php endwhile; ?>
    </div>

    <div class="logout">
        <a href="logout.php">Cerrar sesión</a>
    </div>
</div>

</body>
</html>

</html>