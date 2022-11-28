<?php
//creamos la conexion a la base de datos ejemplo2
try{
    $llave=mysqli_connect("127.0.0.1", "dbuser", "secret0", "ejemplo2");
}catch(Exception $ex){
    $codError=mysqli_connect_errno();
    die("Error 
     codigo =$codError al conectar a la base de datod: ". $ex->getMessage());
}