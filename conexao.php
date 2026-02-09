<?php

# Database connection
define('HOST', '127.0.0.1');
define('USUARIO', 'root');
define('SENHA', 'root');
define('DB', 'sistemacrud');

try {
    $conexao = mysqli_connect(HOST, USUARIO, SENHA, DB);
} catch (\Throwable $e) {
    die('Erro ao conectar'); 
}
?>