<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pronóstico por horas</title>
    <link rel="icon" type="image/png" href="../logo_tiempo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white d-flex justify-content-center min-vh-100 py-5">

<div class="text-center" style="width: 600px;">

    <h1 class="fw-bold mb-4">Pronóstico por Horas</h1>

    <form method="GET" action="" class="mb-4">
        <div class="input-group">
            <input
                type="text"
                name="ciudad"
                class="form-control form-control-lg bg-secondary text-white border-0"
                placeholder="Escribe una ciudad..."
                value="<?= isset($_GET['ciudad']) ? htmlspecialchars($_GET['ciudad']) : '' ?>"
            >
            <button type="submit" class="btn btn-info fw-bold">Buscar</button>
        </div>
    </form>

    <?php
    require_once __DIR__ . '/configuracion.php';

    if (isset($_GET['ciudad']) && !empty($_GET['ciudad'])) {

        $ciudad = trim($_GET['ciudad']);
        $query  = urlencode($ciudad);
        $url    = "https://api.openweathermap.org/data/2.5/forecast?q={$query}&appid=" . API_KEY . "&units=metric&lang=es&cnt=8";

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
                echo "<div class='row g-3'>";

                foreach ($data["list"] as $item) {
                    $hora  = date("H:i", $item["dt"]);
                    $dia   = date("d/m", $item["dt"]);
                    $temp  = round($item["main"]["temp"]);
                    $feels = round($item["main"]["feels_like"]);
                    $desc  = ucfirst($item["weather"][0]["description"]);
                    $hum   = $item["main"]["humidity"];
                    $wind  = $item["wind"]["speed"];

                    echo "
                    <div class='col-6'>
                        <div class='card bg-secondary text-white h-100' style='border-radius: 16px;'>
                            <div class='card-body p-3'>
                                <p class='text-info fw-bold mb-1'>{$dia} &mdash; {$hora}h</p>
                                <h3 class='fw-bold mb-1'>{$temp}°C</h3>
                                <p class='small text-capitalize mb-2'>{$desc}</p>
                                <hr class='border-light my-2'>
                                <div class='d-flex justify-content-between small'>
                                    <span>💧 {$hum}%</span>
                                    <span>🌡️ {$feels}°C</span>
                                    <span>💨 {$wind} m/s</span>
                                </div>
                            </div>
                        </div>
                    </div>";
                }

                echo "</div>";

            } else {
                echo "<div class='alert alert-danger'>Ciudad no encontrada. Prueba con otro nombre.</div>";
            }
        }
    }
    ?>

    <div class="mt-4">
        <a href="/../index.php" class="btn btn-outline-light btn-sm">Volver al inicio</a>
    </div>

</div>

</body>
</html>
