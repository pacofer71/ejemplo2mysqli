<?php
    session_start();
    require_once __DIR__."/../db/conexion.php";
    $q="select id, nombre, precio, enVenta from articulos order by nombre";
    $resultado=mysqli_query($llave, $q);
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

    <title>Ver Articulos</title>
</head>

<body style="background-color: #a2d9ce ">
    <h5 class="text-center mt-4">Listado de Artículos</h5>
    <div class="container">
        <a href="nuevo.php" class="btn btn-success my-2">
            <i class="fas fa-add"></i> Nuevo
        </a>
        <table class="table table-striped">
            <thead>
               
                <tr>
                    <th scope="col">Detalle</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Precio</th>
                    <th scope="col">En Venta</th>
                    <th scope="col">Acciones</th>
                </tr>
            
            </thead>
            <tbody>
            <?php
                while($fila=mysqli_fetch_assoc($resultado)){
                    $color=($fila['enVenta']=='SI') ? "text-primary" : "text-danger";
                echo <<<TXT
                <tr>
                    <th scope="row">
                    <a href="detalle.php?id={$fila['id']}" class="btn btn-sm btn-info">
                    <i class="fas fa-info"></i>
                    </a>
                    </th>
                    <td>{$fila['nombre']}</td>
                    <td>{$fila['precio']} €</td>
                    <td class="$color"><b>{$fila['enVenta']}</b></td>
                    <td>Acciones</td>
                </tr>
                TXT;
                }
                ?>
                
            </tbody>
        </table>
    </div>
</body>

</html>