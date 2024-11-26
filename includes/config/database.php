<?php 

function conectarDB() : mysqli {
    $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    } 

    return $db;
    
}