<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//
function esUltimo(string $actual, string $proximo) : bool {
    if ($actual !== $proximo) {
        return true;
    }
    return false;
}

//Funcion que revisa que el usuario este acutenticado
function isAuth() : void {
    if(!isset($_SESSION['login'])) { //Revisa si la variable $_SESSION esta como true o false 
        header('Location: /');
    }
}

//Funcion que revisa que el usuario es administrador y esta autenticado
function isAdmin() : void {
    if (!isset($_SESSION['admin'])) {
        header('Location: /');
    }
}