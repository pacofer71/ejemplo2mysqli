<?php
    if(!isset($_GET['id'])){
        header("Location:main.php");
        die();
    }
    $id=$_GET['id'];
    $q="select * from articulos where id=?";
    require_once __DIR__."/../db/conexion.php";
    $stmt=mysqli_stmt_init($llave);
    if(mysqli_stmt_prepare($stmt, $q)){
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $nombre, $precio, $imagen, $enVenta);
        mysqli_stmt_fetch($stmt);
        
    }
    mysqli_stmt_close($stmt);
    mysqli_close($llave);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- cdn fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- cdn sweetalert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Detalle Articulo</title>
</head>

<body style="background-color: #a2d9ce ">
    <h5 class="text-center mt-4">Detalle Artículo</h5>
    <div class="container">
        <div class="card mx-auto" style="width: 32rem;">
            <img src="<?php echo ".$imagen" ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo $nombre ?></h5>
                <p class="card-text"><b>Precio: </b> <?php  echo $precio ?> €</p>
                <p class="card-text"><b>En Venta: </b> <?php  echo $enVenta ?></p>
                <a href="main.php" class="btn btn-primary">
                    <i class="fas fa-backward"></i> Volver</a>
            </div>
        </div>
    </div>
</body>

</html>