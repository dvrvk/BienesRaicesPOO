<?php
    require '../../includes/app.php';
    use App\Vendedor;
    estaAutenticado();

    //Validar que sea un ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('location: /admin');
    }

    $vendedor = Vendedor::find($id);
    

    // Arreglo con mensajes de errores
    $errores = Vendedor::getErrores();

    //Se ejecuta tras dar a enviar
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        //asignar los valores
        $args = $_POST['vendedor'];

        //Sincronizar objeto en memoria
        $vendedor->sincronizar($args);

        //Validación
        $errores = $vendedor->validar();

        //Actualizar si no hay errores
        if(empty($errores)){
            $vendedor->guardar();
        }

        
    }

    //Template
    incluirTemplate('header');

    ?>

<main class="contenedor secction">
    <h1>Actualizar Vendedor(a)</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>
    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <input type="submit" value="Guardar" class="boton boton-verde">
    </form>
</main>

<?php
    incluirTemplate('footer');
?>