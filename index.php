<?php
$titulo = "Mi primer sitio modular con PHP";

$p = $_GET['p'] ?? 'inicio';
$menu = [
  'inicio' => 'Inicio',
  'contenido' => 'Productos',
  'contacto' => 'Contacto'
];

include "layout.php";
