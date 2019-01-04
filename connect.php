<?php

define('USER','root');  // użytkownik bazy danych
define('PASSWORD','');  // hasło
define('HOST','localhost'); //  serwer
define('DATABASE','skup');  //  baza danych

$pdoOptions = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
];

$pdo = new PDO("mysql:host=". HOST . ";dbname=" . DATABASE, USER, PASSWORD, $pdoOptions);   // łączenie z bazą danych