<?php
session_start();
include('php/conecta.php');

// Si no hay sesión iniciada, redirigir
if (!isset($_SESSION['correo'])) {
    header("Location: login.php");
    exit;
}

// Crear carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Eliminar un producto del carrito
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    unset($_SESSION['carrito'][$id]);
    $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar
    header("Location: carrito.php");
    exit;
}

// Limpiar todo el carrito
if (isset($_GET['limpiar'])) {
    unset($_SESSION['carrito']);
    header("Location: carrito.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <style>
        body {
            background-color: #f0f0ff;
            font-family: Arial, sans-serif;
        }
        .contenedor {
            max-width: 800px;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px #aaa;
        }
        h2 {
            text-align: center;
            color: #4b0082;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #4b0082;
            color: white;
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
        .btn-eliminar {
            background-color: crimson;
        }
        .btn-eliminar:hover {
            background-color: darkred;
        }
        .total {
            text-align: right;
            font-size: 18px;
            margin-top: 15px;
            color: #333;
        }
        .acciones {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="contenedor">
    <h2>Tu Carrito</h2>

    <?php if (empty($_SESSION['carrito'])): ?>
        <p>El carrito está vacío.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Título</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Acción</th>
            </tr>
            <?php
            $total = 0;
            foreach ($_SESSION['carrito'] as $id => $item):
                if (!is_array($item) || !isset($item['titulo'], $item['precio'], $item['cantidad'])) continue;
                $subtotal = $item['precio'] * $item['cantidad'];
                $total += $subtotal;
            ?>
            <tr>
                <td><?= htmlspecialchars($item['titulo']) ?></td>
                <td>$<?= number_format($item['precio'], 2) ?></td>
                <td><?= intval($item['cantidad']) ?></td>
                <td>$<?= number_format($subtotal, 2) ?></td>
                <td><a class="btn btn-eliminar" href="carrito.php?eliminar=<?= $id ?>">Eliminar</a></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <div class="total">
            <strong>Total: $<?= number_format($total, 2) ?></strong>
        </div>

        <div class="acciones">
            <form action="finalizar_compra.php" method="post" style="display:inline-block;">
                <button type="submit" class="btn">Finalizar compra</button>
            </form>
            <a class="btn btn-eliminar" href="carrito.php?limpiar=1">Vaciar carrito</a>
        </div>
    <?php endif; ?>

    <div class="acciones">
        <a class="btn" href="index.php">← Seguir comprando</a>
    </div>
</div>
</body>
</html>

