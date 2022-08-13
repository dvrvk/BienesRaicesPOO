<?php
    require '../../includes/app.php';

    use App\Propiedad;
    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

    //Comprobar si esta logeado
    estaAutenticado();
    
    //Inicializar
    $propiedad  = new Propiedad();

    //Consulta para obtener todos los vendedores
    $vendedores = Vendedor::all();

    // Arreglo con mensajes de errores
    $errores = Propiedad::getErrores();

    //Se ejecuta tras dar a enviar
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        //Crear una nueva instancia
        $propiedad = new Propiedad($_POST['propiedad']);

        /* Subida de archivos*/
            
            //1. Generar nombre único
        $nombreImagen =md5(uniqid(rand(), true)) . ".jpg";

            //2.Setear la imagen: 
            //Realiza un resize a la imagen con intervention/image
        if($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen); 
        }
         
        //Revisar que el arreglo de errores está vacio (isSet o empty)
        $errores = $propiedad->validar();
        
        //Si no hay errores se inserta
        if(empty($errores)){ 
            
            
            //1. Crear carpeta imagenes
            if(!is_dir(CARPETA_IMAGENES)) {
                mkdir(CARPETA_IMAGENES);
            }
            //2. Subir la imagen al servidor
            $image->save(CARPETA_IMAGENES . $nombreImagen);

            //3. Guarda en la base de datos
            $propiedad->guardar();

        }

    }

    //Template
    incluirTemplate('header');

?>

<main class="contenedor secction">
    <h1>Crear</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>
    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    
    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>

<?php
    incluirTemplate('footer');
?>