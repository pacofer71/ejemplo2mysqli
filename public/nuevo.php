<?php
session_start();
require_once __DIR__ . "/../db/conexion.php";
function mostrarError($nombre)
{
    if (isset($_SESSION[$nombre])) {
        echo "<p class='text-danger mt-2'>{$_SESSION[$nombre]}</p>";
        unset($_SESSION[$nombre]);
    }
}

if (isset($_POST['btn'])) {
    $nombre = trim($_POST['nombre']);
    $precio = (float)trim($_POST['precio']);
    $enVenta = (isset($_POST['enVenta'])) ? "SI" : "NO";

    $error = false;

    if (strlen($nombre) < 3) {
        $_SESSION['nombre'] = "*** El campo nombre debe tener al menos 3 caracteres";
        $error = true;
    } else {
        //comprobamos que el nombre existe
        $q = "select id from articulos where nombre = ?";
        $stmt = mysqli_stmt_init($llave);
        if (mysqli_stmt_prepare($stmt, $q)) {
            //emparejamos los parametros
            mysqli_stmt_bind_param($stmt, 's', $nombre);
            mysqli_stmt_execute($stmt);
            //guardamos temporalmente el resultado
            mysqli_stmt_store_result($stmt);
            $filas = mysqli_stmt_num_rows($stmt);
            if ($filas != 0) {
                $_SESSION['nombre'] = "*** El artículo YA está registrado";
                $error = true;
            }
        }
        mysqli_stmt_close($stmt);
    }

    if ($precio <= 0 || $precio > 999.99) {
        $error = true;
        $_SESSION['precio'] = "*** Error el precio debe estar entre 1 y 999.99";
    }
    if ($enVenta != "SI" && $enVenta != "NO") {
        $error = true;
        $_SESSION['enVenta'] = "*** este campo solo admite SI/NO";
    }

    if ($error) {
        header("Location:nuevo.php");
        die();
    }
    //Si hemos llegado aquí todo bien, procesamos la imagen
    // echo "<pre>";
    // var_dump($_FILES['imagen']);
    // echo "</pre>";
    // die();
    $nombreF = "/img/default.png";
    if ($_FILES['imagen']['error'] == 0) {
        //se ha subido un archivo comprobamos que sea una IMAGEN
        $imagenes = [
            'image/gif',
            'image/x-icon',
            'image/jpeg',
            'image/svg+xml',
            'image/tiff',
            'image/webp',
            'image/png',
            'image/bmp'
        ];
        if (!in_array($_FILES['imagen']['type'], $imagenes)) {
            // die("No es Imagen");
            $_SESSION['imagen'] = "*** Error se esparaba una imagen";
            header("Location:nuevo.php");
            die();
        }
        //se subio una imagen
        //vamos a guardarla
        $nombreF = "/img/" . uniqid() . "_" . $_FILES['imagen']['name']; // /img/12345678_nombre.jpg
        //lo movemos de la carpeta tmtp a directorio img
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], ".$nombreF")) {
            //no se pudo guardar la imagen
            $nombreF = "/img/default.png";
        }
    }
    //NOs traemos la conexion

    $q = "insert into articulos(nombre, precio, imagen, enVenta) values(?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($llave);
    if (mysqli_stmt_prepare($stmt, $q)) {
        mysqli_stmt_bind_param($stmt, 'sdss', $nombre, $precio, $nombreF, $enVenta);
        mysqli_stmt_execute($stmt);
    } else {
        die("Error al insertar");
    }
    mysqli_stmt_close($stmt);
    mysqli_close($llave);
    $_SESSION['mensaje'] = "Articulo guardado.";
    header("Location:main.php");
} else {
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

        <title>Nuevo</title>
    </head>

    <body style="background-color: #a2d9ce ">
        <h5 class="text-center mt-4">Crear Artículo</h5>
        <div class="container">
            <form action="nuevo.php" method="POST" enctype="multipart/form-data" class="px-4 py-4 mx-auto bg-dark text-light rounded" style="width:40rem;">
                <div class="mb-3">
                    <label for="n" class="form-label">Nombre Articulo</label>
                    <input type="text" class="form-control" id="n" name="nombre" required />
                    <?php
                    mostrarError("nombre");
                    ?>
                </div>
                <div class="mb-3">
                    <label for="p" class="form-label">Precio Articulo (€)</label>
                    <input type="number" class="form-control" id="p" name="precio" step="0.01" min=0 max='999.99' required />
                    <?php
                    mostrarError("precio");
                    ?>
                </div>
                <div class="mb-3">
                    <label for="i" class="form-label">Imagen</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="i" name="imagen" accept="image/*">

                    </div>
                    <?php
                    mostrarError("imagen");
                    ?>
                </div>
                <div>
                    <label class="form-check-label" for="ev">Artículo en Venta (Si/No)</label>
                </div>
                <div class="form-check form-switch mb-3">

                    <input class="form-check-input" type="checkbox" role="switch" id="ev" name="enVenta">
                    <label class="form-check-label" for="ev">En Venta</label>
                </div>


                <div class="d-flex flex-row-reverse">
                    <button type="submit" name="btn" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>&nbsp;
                    <button type="reset" class="btn btn-warning">
                        <i class="fas fa-paintbrush"></i> Limpiar
                    </button>
                </div>

            </form>

        </div>
    </body>

    </html>
<?php } ?>