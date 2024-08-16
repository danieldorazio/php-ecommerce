<?php

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
mysqli_set_charset($conn, "utf8");

//logica di login 
$loggedInUser = null;

// verifica se all'interno della variabile $_SESSION esiste uno user
if (isset($_SESSION['user'])) {
    $loggedInUser = $_SESSION['user'];
}
