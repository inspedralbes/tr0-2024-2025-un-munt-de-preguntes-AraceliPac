<?php
session_start();
session_destroy();  // Destruir la sesión para reiniciar el cuestionario
header('Location: index.php');  // Redirigir a index.php
exit();
