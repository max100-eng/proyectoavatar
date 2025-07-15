<?php
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$baseDeDatos = "bd2";

// Procesar subida de imagen
if (isset($_FILES["inputImg"])) {
    $nombre = $_FILES["inputImg"]["name"];
    $extension = pathinfo($nombre, PATHINFO_EXTENSION);
    
    $nombre = "imagen_".date("Y_m_d_His").".".$extension;

    $temporal = $_FILES["inputImg"]["tmp_name"];
    move_uploaded_file($temporal, "imagenes/$nombre");

    $conn = new mysqli($servidor, $usuario, $contraseña, $baseDeDatos); 

    // Guardamos la imagen en la BD
    $sql = "INSERT INTO imagenes(imagen) VALUES ('$nombre')";
    $conn->query($sql); 
    $conn->close();
}

// Obtener imágenes para la galería
$conn = new mysqli($servidor, $usuario, $contraseña, $baseDeDatos);
$resultado = $conn->query("SELECT imagen FROM imagenes");
?>
<!DOCTYPE html>
<html>
<head>
   <style>
    .galeria {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin: 20px 0;
    }
    .imagen-container {
        width: calc(25% - 10px);
        box-sizing: border-box;
    }
    .imagen-miniatura {
        width: 100%;
        height: auto;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        background: white;
    }
    .imagen-miniatura:hover {
        box-shadow: 0 0 5px rgba(0,0,0,0.3);
    }
</style>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="inputImg" accept="image/*">
        <button type="submit">Subir Imagen</button>
    </form>

    <div class="galeria">
        <?php 
        if ($resultado->num_rows > 0) {
            $contador = 0;
            while($fila = $resultado->fetch_assoc()) {
                echo '<div class="imagen-container">';
                echo '<img src="imagenes/' .$fila['imagen']. '" class="imagen-miniatura">';
                echo '</div>';
                $contador++;
            }
        } else {
            echo "<p>No hay imágenes para mostrar.</p>";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>