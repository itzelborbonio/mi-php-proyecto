<?php
include('php/conecta.php');
$result = $mysqli->query("SELECT * FROM categorias");
echo "<h1>Categorías</h1><ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li><a href='categorias.php?id=" . $row['id_categoria'] . "'>" . $row['nombre'] . "</a></li>";
}
echo "</ul>";
?>