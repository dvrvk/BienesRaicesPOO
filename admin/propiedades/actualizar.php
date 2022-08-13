<?php

    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

    require '../../includes/app.php';

    //Comprobar si esta logeado
    estaAutenticado();

    //validar la URL por id valido
    $id = $_GET['id'];
    $id = filter_var($id,FILTER_VALIDATE_INT); //filtro que el id sea un nº
    if(!$id) {
        header('Location: /admin');
    }

    
    //Consulta de las propiedades
    $propiedad = Propiedad::find($id);
    
    //Consultar los vendedores
    $vendedores = Vendedor::all();

    // Arreglo con mensajes de errores
    $errores = Propiedad::getErrores();

    //Se ejecuta tras dar a enviar
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $args = $_POST['propiedad'];

        $propiedad->sincronizar($args);

        //Validación de errores
        $errores = $propiedad->validar();
        
        /*Subida de archivos*/
        //1. Generar nombre único
        $nombreImagen =md5(uniqid(rand(), true)) . ".jpg";

        //2.Setear la imagen: Realiza un resize a la imagen con intervention/image
        if($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen); 
        }
        
        if(empty($errores)){ 
            if($_FILES['propiedad']['tmp_name']['imagen']) {
                //Almacenar la imagen (si existe una imagen)
                $image->save(CARPETA_IMAGENES . $nombreImagen);
            }

            $propiedad->guardar();

        }   

    }

    //Template
    
    incluirTemplate('header');



?>

<main class="contenedor secction">
    <h1>Actualizar Propiedad</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>
    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_propiedades.php'; ?> 

        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>
</main>

<?php
    incluirTemplate('footer');
?>