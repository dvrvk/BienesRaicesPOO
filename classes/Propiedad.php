<?php

namespace App;

class Propiedad extends ActiveRecord {
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo','precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    public function __construct($args = [])
    {
        //AQUI ME QUEDO
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    public function validar() {

        //Validación del formulario
        if(!$this->titulo) {
            self::$errores[] ="Debes añadir un título";
        }
        if (!$this->precio) {
            self::$errores[] ="El precio es obligatorio";
        }
        if (strlen($this->descripcion) < 50) { //long descripción < 50
            self::$errores[] ="La descripción tiene que tener al menos 50 caracteres";
        }
        if (!$this->habitaciones) {
            self::$errores[] ="El nº de habitaciones es obligatorio";
        }
        if (!$this->wc) {
            self::$errores[] ="El nº de wc es obligatorio";
        }
        if (!$this->estacionamiento) {
            self::$errores[] ="El nº de estacionamientos es obligatorio";
        }
        if (!$this->vendedorId) {
            self::$errores[] ="Selecciona un vendedor";
        }
        if(!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        }
        
        return self::$errores;
    }

}