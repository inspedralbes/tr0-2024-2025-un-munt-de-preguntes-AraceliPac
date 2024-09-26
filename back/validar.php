<?php
session_start();
//echo '<pre>';
//print_r($_POST['respuesta']);
//echo '</pre>';
// Comprobar si se ha enviado la respuesta

if (isset($_POST['respuesta'])) {
    $respuestaUsuario = $_POST['respuesta'];  // Respuesta del usuario
    $preguntaActual = $_SESSION['resultados'][$_SESSION['preguntaActual']];  // Pregunta actual

    $indicePreguntaActual = $_SESSION['preguntaActual'];

    // Comprobar si la respuesta es correcta
    if ($respuestaUsuario == $_SESSION['resultados'][$indicePreguntaActual]['correctAnswer']) {
        $_SESSION['correctes']++;  // Aumentar contador de respuestas correctas
        $_SESSION['feedback'] = "Resposta correcta!";
    } else {
        $_SESSION['feedback'] = "Resposta incorrecta!";
    }
    // Pasar a la siguiente pregunta
    $_SESSION['preguntaActual']++;
}

// Redirigir a `index.php` para mostrar la siguiente pregunta o el resultado
header('Location: index.php');
exit();
