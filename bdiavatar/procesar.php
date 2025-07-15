<?php
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$baseDeDatos = "bd2";



if (isset($_FILES["inputImg"])){
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
?>