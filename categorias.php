<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
session_start();

include('php/conecta.php');

$id_categoria = $_GET['id'];

$stmt = $mysqli->prepare("SELECT * FROM libros WHERE id_categoria = ? LIMIT 5");
$stmt->bind_param("i", $id_categoria);
$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<div>
        <img src='img/" . $row['imagen'] . "' width='100'>
        <h3>" . $row['titulo'] . "</h3>
        <p>" . $row['descripcion'] . "</p>
        <form method='post' action='carrito.php'>
            <input type='hidden' name='id_libro' value='" . $row['id_libro'] . "'>
            <button type='submit'>Agregar al carrito</button>
        </form>
    </div>";
}
?>