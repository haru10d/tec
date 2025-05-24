<?php
include 'conexion.php';

// Recolectar y limpiar entradas
$fecha = $_POST['fecha'];
$cliente = $_POST['cliente'];
$direccion = $_POST['direccion'];
$marca = $_POST['marca'];
$cont_bn = $_POST['cont_bn'];
$modelo = $_POST['modelo'];
$cont_color = $_POST['cont_color'];
$serie = $_POST['serie'];
$cont_escaner = $_POST['cont_escaner'];
$ubicacion = $_POST['ubicacion'];
$hora_inicio = $_POST['hora_inicio'];
$hora_salida = $_POST['hora_salida'];
$tipo_servicio = isset($_POST['tipo_servicio']) ? implode(", ", $_POST['tipo_servicio']) : '';
$problema_reportado = $_POST['problema_reportado'];
$tipo_mantenimiento = isset($_POST['tipo_mantenimiento']) ? implode(", ", $_POST['tipo_mantenimiento']) : '';
$mantenimiento = isset($_POST['mantenimiento']) ? implode(", ", $_POST['mantenimiento']) : '';
$observacion = $_POST['observacion'];
$firma_tecnico = $_POST['firma_tecnico'];
$firma_cliente = $_POST['firma_cliente'];

// Partes (combinamos cantidad + descripción)
$partes = "";
for ($i = 1; $i <= 7; $i++) {
    $cant = $_POST["cantidad$i"];
    $desc = $_POST["descripcion$i"];
    if (!empty($cant) || !empty($desc)) {
        $partes .= "[$cant x $desc]\n";
    }
}

// Insertar en la base de datos
$sql = "INSERT INTO informes (
    fecha, cliente, direccion, marca, cont_bn, modelo, cont_color,
    serie, cont_escaner, ubicacion, hora_inicio, hora_salida,
    tipo_servicio, problema_reportado, tipo_mantenimiento, mantenimiento,
    observacion, partes, firma_tecnico, firma_cliente
) VALUES (
    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
)";

$stmt = $conexion->prepare($sql);
$stmt->bind_param(
    "ssssssssssssssssssss",
    $fecha, $cliente, $direccion, $marca, $cont_bn, $modelo, $cont_color,
    $serie, $cont_escaner, $ubicacion, $hora_inicio, $hora_salida,
    $tipo_servicio, $problema_reportado, $tipo_mantenimiento, $mantenimiento,
    $observacion, $partes, $firma_tecnico, $firma_cliente
);

if ($stmt->execute()) {
    echo "<script>alert('Informe guardado correctamente.'); window.location.href='index.html';</script>";
} else {
    echo "Error al guardar: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
