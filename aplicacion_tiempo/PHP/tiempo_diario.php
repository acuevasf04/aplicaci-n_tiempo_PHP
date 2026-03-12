<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pronóstico Semanal</title>
    <link rel="icon" type="image/png" href="/../logo_tiempo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white d-flex justify-content-center min-vh-100 py-5">

<div class="text-center" style="width: 700px;">

    <h1 class="fw-bold mb-4">Pronóstico Semanal</h1>

    <?php
    require_once __DIR__ . '/configuracion.php';

    $ciudad = isset($_GET['ciudad']) ? trim($_GET['ciudad']) : '';

    if (!empty($ciudad)) {
        $query = urlencode($ciudad);
        $url = "https://api.openweathermap.org/data/2.5/forecast?q={$query}&appid=" . API_KEY . "&units=metric&lang=es&cnt=40";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        if ($response === false) {
            echo '<div class="alert alert-danger">Error de conexión: ' . curl_error($ch) . '</div>';
        } else {
            $data = json_decode($response, true);

            if (isset($data["cod"]) && $data["cod"] == "200") {
                $nombreCiudad = $data["city"]["name"];
                $pais         = $data["city"]["country"];

                echo "<h4 class='mb-4 text-info'>{$nombreCiudad}, {$pais}</h4>";

                // Agrupar por día
                $dias = [];
                foreach ($data["list"] as $item) {
                    $dia = date("Y-m-d", $item["dt"]);
                    $dias[$dia][] = $item;
                }

                echo "<div class='row g-3'>";
                foreach ($dias as $fecha => $registros) {
                    // Calcular temp max, min y descripción del día
                    $temps   = array_column(array_column($registros, 'main'), 'temp');
                    $tempMax = round(max($temps));
                    $tempMin = round(min($temps));
                    $desc    = ucfirst($registros[0]["weather"][0]["description"]);
                    $hum     = round(array_sum(array_column(array_column($registros, 'main'), 'humidity')) / count($registros));
                    $wind    = round(array_sum(array_column(array_column($registros, 'wind'), 'speed')) / count($registros), 1);

                    // Nombre del día en español
                    $timestamp  = strtotime($fecha);
                    $diasSemana = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
                    $meses      = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
                    $nombreDia  = $diasSemana[date('w', $timestamp)];
                    $numDia     = date('d', $timestamp);
                    $mes        = $meses[date('n', $timestamp) - 1];

                    echo "
                    <div class='col-12'>
                        <div class='card bg-secondary text-white' style='border-radius: 16px;'>
                            <div class='card-body p-3'>
                                <div class='row align-items-center text-center'>
                                    <div class='col-3'>
                                        <p class='text-info fw-bold mb-0'>{$nombreDia}</p>
                                        <p class='small mb-0'>{$numDia} {$mes}</p>
                                    </div>
                                    <div class='col-3'>
                                        <p class='small text-capitalize text-white-50 mb-0'>{$desc}</p>
                                    </div>
                                    <div class='col-2'>
                                        <p class='fw-bold mb-0'>{$tempMax}°</p>
                                        <p class='small text-white-50 mb-0'>{$tempMin}°</p>
                                    </div>
                                    <div class='col-2'>
                                        <p class='small mb-0'>💧 {$hum}%</p>
                                    </div>
                                    <div class='col-2'>
                                        <p class='small mb-0'>💨 {$wind} m/s</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>";
                }
                echo "</div>";

            } else {
                echo "<div class='alert alert-danger'>Ciudad no encontrada.</div>";
            }
        }
    } else {
        echo "<div class='alert alert-warning'>No se ha especificado ninguna ciudad. <a href='index.php' class='alert-link'>Volver al inicio</a></div>";
    }
    ?>

    <div class="mt-4">
       <a href="/../index.php" class="btn btn-outline-light btn-sm">Volver al inicio</a>
    </div>

</div>

</body>
</html>