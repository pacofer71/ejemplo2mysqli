<?php
session_start();
if(!isset($_POST['id'])){
    header("Location:main.php");
    die();
}
$id=$_POST['id'];

require_once __DIR__."/../db/conexion.php";

$q1 = "delete from articulos where id= ?";

$q2="select imagen from articulos where id=?";

$stmt = mysqli_stmt_init($llave);
//recupero en nombre de la imagen del articulo que quiero borrar
if (mysqli_stmt_prepare($stmt, $q2)) {
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt); 
    mysqli_stmt_bind_result($stmt, $nombreImagen);
    mysqli_stmt_fetch($stmt);
}
//borro el articulo
if(mysqli_stmt_prepare($stmt, $q1)){
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    //ahora sí, borraremos la imagen del articulo borrado 
    //si no es default.png
    if(basename($nombreImagen)!="default.png"){
        unlink(".$nombreImagen");  // ./img/nombre.jpg;
    }
}
mysqli_stmt_close($stmt);
mysqli_close($llave);
$_SESSION['mensaje']="Artículo Borrado";
header("Location:main.php");
