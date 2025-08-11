<?php
session_start();
include('php/conecta.php');

if (!isset($_SESSION['correo'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id_categoria'])) {
    echo "Categoría no especificada.";
    exit;
}

$id_categoria = intval($_GET['id_categoria']);
$stmt = $mysqli->prepare("SELECT id_libro, titulo, autor, precio, imagen FROM libros WHERE id_categoria = ?");
$stmt->bind_param("i", $id_categoria);
$stmt->execute();
$resultado = $stmt->get_result();

$mensaje = "";

// Procesar formulario de agregar al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_libro'])) {
    $id_libro = intval($_POST['id_libro']);
    $titulo = $_POST['titulo'];
    $precio = floatval($_POST['precio']);

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Revisar si ya existe en el carrito
    $existe = false;
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['titulo'] === $titulo) {
            $item['cantidad'] += 1;
            $existe = true;
            break;
        }
    }

    // Si no existe, lo agregamos
    if (!$existe) {
        $_SESSION['carrito'][] = [
            'id' => $id_libro,
            'titulo' => $titulo,
            'precio' => $precio,
            'cantidad' => 1
        ];
    }

    // Guardar mensaje en sesión para mostrarlo después del reload
    $_SESSION['mensaje'] = "📚 Libro agregado correctamente al carrito.";
    header("Location: libros.php?id_categoria=" . $id_categoria);
    exit;
}

// Mostrar mensaje si existe
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libros por Categoría</title>
    <style>
        body {
            background-color: #f0f0ff;
            font-family: Arial, sans-serif;
            color: #333;
        }
        .contenedor {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 0 10px #aaa;
        }
        h2 {
            text-align: center;
            color: #4b0082;
        }
        .mensaje {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 10px 20px;
            border-radius: 6px;
            margin: 20px auto;
            max-width: 600px;
            text-align: center;
            font-weight: bold;
        }
        .libro {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 10px;
            margin: 15px;
            display: inline-block;
            width: 200px;
            vertical-align: top;
            background-color: #eee;
        }
        .libro img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .libro h3 {
            font-size: 18px;
            color: #4b0082;
        }
        .libro p {
            margin: 5px 0;
        }
        .libro form {
            margin-top: 10px;
        }
        .btn {
            padding: 8px 12px;
            background-color: #4b0082;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #360065;
        }
        .volver {
            display: block;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="contenedor">
    <h2>Libros de la Categoría</h2>

    <?php if ($mensaje): ?>
        <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <?php while ($libro = $resultado->fetch_assoc()): ?>
        <div class="libro">
            <img src="img/<?= htmlspecialchars($libro['imagen']) ?>" alt="Libro">
            <h3><?= htmlspecialchars($libro['titulo']) ?></h3>
            <p><strong>Autor:</strong> <?= htmlspecialchars($libro['autor']) ?></p>
            <p><strong>Precio:</strong> $<?= number_format($libro['precio'], 2) ?></p>

            <form method="POST">
                <input type="hidden" name="id_libro" value="<?= $libro['id_libro'] ?>">
                <input type="hidden" name="titulo" value="<?= htmlspecialchars($libro['titulo']) ?>">
                <input type="hidden" name="precio" value="<?= $libro['precio'] ?>">
                <button type="submit" class="btn">Agregar al carrito</button>
            </form>
        </div>
    <?php endwhile; ?>

    <div class="volver">
        <a href="index.php" class="btn">← Volver a la página principal</a>
    </div>
</div>
</body>
</html>



