<?php
require_once __DIR__ . '/configuracion.php';

function guardarConsulta($ciudad, $pais) {
    try {
        $pdo  = getDB();
        $stmt = $pdo->prepare("INSERT INTO consultas (CIUDAD, PAIS) VALUES (:ciudad, :pais)");
        $stmt->execute([
            ':ciudad' => $ciudad,
            ':pais'   => $pais
        ]);
    } catch (PDOException $e) {
        echo "<div class='alert alert-warning'>Error al guardar en BD: " . $e->getMessage() . "</div>";
    }
}

