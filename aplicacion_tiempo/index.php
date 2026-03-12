<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AntonCiclon</title>
    <link rel="icon" type="image/png" href="logo_tiempo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white d-flex align-items-center justify-content-center min-vh-100">
<div class="text-center" style="width: 380px;">
    <h1 class="fw-bold mb-4">ANTONCICLON</h1>
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
    require_once __DIR__ . '/PHP/configuracion.php';
    require_once __DIR__ . '/PHP/Inyeccion.php';
    if (isset($_GET['ciudad']) && !empty($_GET['ciudad'])) {
        $ciudad = trim($_GET['ciudad']);
        $query  = urlencode($ciudad);
        $url    = "https://api.openweathermap.org/data/2.5/weather?q={$query}&appid=" . API_KEY . "&units=metric&lang=es";

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
            if (isset($data["cod"]) && $data["cod"] == 200) {
                $temp     = round($data["main"]["temp"]);
                $feels    = round($data["main"]["feels_like"]);
                $humidity = $data["main"]["humidity"];
                $wind     = $data["wind"]["speed"];
                $desc     = ucfirst($data["weather"][0]["description"]);
                $name     = $data["name"];
                $country  = $data["sys"]["country"];
                echo "
                <div class='card bg-secondary text-white shadow-lg' style='border-radius: 20px;'>
                    <div class='card-body p-4'>
                        <h2 class='card-title fw-bold'>{$name} <small class='fs-5 text-light'>{$country}</small></h2>
                        <p class='text-capitalize text-info mb-1'>{$desc}</p>
                        <h1 class='display-1 fw-bold my-3'>{$temp}°C</h1>
                        <hr class='border-light'>
                        <div class='row text-center mt-3'>
                            <div class='col-4'>
                                <p class='text-uppercase small text-info mb-1'>Sensación</p>
                                <p class='fs-5 fw-semibold'>{$feels}°C</p>
                            </div>
                            <div class='col-4'>
                                <p class='text-uppercase small text-info mb-1'>Humedad</p>
                                <p class='fs-5 fw-semibold'>{$humidity}%</p>
                            </div>
                            <div class='col-4'>
                                <p class='text-uppercase small text-info mb-1'>Viento</p>
                                <p class='fs-5 fw-semibold'>{$wind} m/s</p>
                            </div>
                        </div>
                        <hr class='border-light'>
                        <a href='/PHP/tiempo_horas.php?ciudad=" . urlencode($ciudad) . "' class='btn btn-outline-info mt-2 w-100'>
                            Pronóstico por horas
                        </a>
                        <a href='/PHP/tiempo_diario.php?ciudad=" . urlencode($ciudad) . "' class='btn btn-outline-warning mt-2 w-100'>
                            Pronóstico semanal
                        </a>
                    </div>
                </div>";
            } else {
                echo "<div class='alert alert-danger'>Ciudad no encontrada. Prueba con otro nombre.</div>";
            }
        }
    }
    ?>
</div>
</body>
</html>