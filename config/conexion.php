<?php
#propiedades de host
$pass='';
$user = 'root';
$namedb = 'crud';

try {
    $db = new PDO(
        'mysql:host=localhost;dbname='.$namedb, $user, $pass
    );
} catch (Execpion $error) {
    echo 'error conexion'.$error->getMessage();
    die();
}