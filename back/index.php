<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>QUIZZ</title>
</head>

<body>
    <header>
        <h1>JOC PREGUNTES</h1>
    </header>
    <main>
        <div class="container">
            <?php
            session_start();
            //session_unset();
            if (!isset($_SESSION['resultados'])) {
                //ara desar aleatoriament 10 preg al array resultados (pregunta,resposta correcta, opcions[]) que luego anira dins session
                $resultados = [];
                $data = @file_get_contents('preg.json');
                $preguntes = json_decode($data, true);
                $totalPreguntes = count($preguntes['questions']); //contar total preguntes 
                $seleccionades = [];  //array per desar index de seleccionades i no repetir-les
                $maxPreguntes = 10;
                while (count($seleccionades) < $maxPreguntes) {
                    $index = rand(0, $totalPreguntes - 1);
                    if (!in_array($index, $seleccionades)) {
                        $seleccionades[] = $index;
                        $resultados[] = [
                            'question' => $preguntes['questions'][$index]['question'],
                            'correctAnswer' => $preguntes['questions'][$index]['answers'][$preguntes['questions'][$index]['correctIndex']],
                            'options' => $preguntes['questions'][$index]['answers']
                        ];
                    }
                }

                //inicialitzar dades variable sessio
                $_SESSION['resultados'] = $resultados;
                if (!isset($_SESSION['preguntaActual'])) {
                    $_SESSION['preguntaActual'] = 0;
                }
                if (!isset($_SESSION['correctes'])) {
                    $_SESSION['correctes'] = 0;
                }
                if (!isset($_SESSION['feedback'])) {
                    $_SESSION['feedback'] = '';
                }
            }
            //print_r($_SESSION);

            //mostrar les preguntes 1 a 1 
            $indicePreguntaActual = $_SESSION['preguntaActual'];
            if ($_SESSION['preguntaActual'] < count($_SESSION['resultados'])) { // 0 <10
                $preguntaActual = $_SESSION['resultados'][$indicePreguntaActual]; //$session['resultados'][0]['question']
            ?>
                <form action="validar.php" method="post">
                    <h2><?= $preguntaActual['question'] ?></h2>
                    <?php foreach ($preguntaActual['options'] as $resp) { ?>
                        <input type="radio" name="respuesta" value="<?= $resp ?>" required> <?= $resp ?><br>
                    <?php } ?>
                    <button type="submit">Enviar resposta</button>
                    <div>
                        <?php
                        // Mostrar feedback, preguntes contestades i correctes
                        echo ("<br>" . $_SESSION['feedback'] . "<br>");
                        echo ("<br>Preguntes contestades " . ($_SESSION['preguntaActual']) . "<br>");
                        echo ("Preguntes encertades " . $_SESSION['correctes']);
                        ?>
                    </div>
                </form>


            <?php
            } else {
                // Cuando ya se han respondido todas las preguntas, mostrar la puntuación final
                echo "<h2>Has completat el qüestionari!</h2>";
                echo "<h3>Puntuació final: {$_SESSION['correctes']} / " . count($_SESSION['resultados']) . "</h3>";
            }
            ?>


            <div id="reset"><a href="reset.php" class="button">Reiniciar</a>
            </div>
        </div>
    </main>
</body>
<footer>
    <h4>2024. By Araceli</h4>
</footer>

</html>