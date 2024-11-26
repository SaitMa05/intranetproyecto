<?php 

require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../core/config.php';


// Conectarnos a la base de datos
$db = conectarDB();

use Model\Model;

Model::setDB($db);