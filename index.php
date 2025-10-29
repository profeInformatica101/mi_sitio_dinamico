<?php
session_start();
require_once __DIR__ . '/config.php'; // <--- ¡IMPORTANTE!



$p = $_GET['p'] ?? 'inicio';

include "layout.php";
