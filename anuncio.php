<?php 
require 'includes/app.php';

use App\Propiedad;

// Obtengo el id
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header("location: index.php");
}

$propiedad = Propiedad::find($id);

//Template
incluirTemplate("header");
?>

    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $propiedad->titulo; ?></h1>

        <img lloading="lazy" src="imagenes/<?php echo $propiedad->imagen; ?> " alt="Imagen de la propiedad">

        <div class="resumen-propiedad">
            <p class="precio"><?php echo $propiedad->precio; ?>€</p>

            <ul class="iconos-caracteristicas">
                <li>
                    <img class="iconos" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad->wc; ?></p>
                </li>
                <li>
                    <img class="iconos" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad->estacionamiento; ?></p>
                </li>
                <li>
                    <img class="iconos" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono dormitorio">
                    <p><?php echo $propiedad->habitaciones; ?></p>
                </li>
            </ul>

            <p>
            <?php echo $propiedad->descripcion; ?>
            </p>

        </div>
    </main>

    
    <?php 

    incluirTemplate("footer");

    //cerrar conexión
    mysqli_close($db);

    ?>
    