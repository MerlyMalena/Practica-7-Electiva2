<?php
// Mostrar todos los errores para diagnóstico en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hola Mundo - Docker Compose & MySQL</title>
    <!-- Estilos con Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: sans-serif; }
        .card-container { max-width: 650px; margin: 60px auto; border-radius: 12px; }
    </style>
</head>
<body>

<div class="container">
    <div class="card card-container shadow">
        <div class="card-header bg-primary text-white text-center py-4">
            <h1 class="h2 mb-1">👋 ¡Hola Mundo!</h1>
            <p class="mb-0">Aplicación Web con Docker Compose y MySQL</p>
        </div>
        <div class="card-body p-4">
            <?php
            // 1. Obtenemos las credenciales desde las variables de entorno de Docker
            $host     = getenv('DB_HOST') ?: 'db';
            $db_name  = getenv('DB_NAME') ?: 'holamundo_db';
            $user     = getenv('DB_USER') ?: 'root';
            $password = getenv('DB_PASSWORD') ?: 'rootpassword';

            $conectado = false;
            $mensaje_error = '';
            $mysql_version = '';

            // 2. Intentamos conectar a MySQL asegurando que el driver exista
            try {
                if (!extension_loaded('pdo_mysql')) {
                    throw new Exception("La extensión 'pdo_mysql' no está instalada en el contenedor PHP.");
                }

                $dsn = "mysql:host={$host};dbname={$db_name};charset=utf8mb4";
                $pdo = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_TIMEOUT => 5
                ]);
                $conectado = true;

                // Consultamos la versión de MySQL para comprobar respuesta
                $stmt = $pdo->query("SELECT VERSION() as version");
                $mysql_version = $stmt->fetch(PDO::FETCH_ASSOC)['version'];

            } catch (Throwable $e) {
                // Captura tanto PDOException como Exception genéricas o errores de PHP
                $conectado = false;
                $mensaje_error = $e->getMessage();
            }
            ?>

            <!-- 3. Mostramos el resultado visualmente -->
            <div class="text-center mb-4">
                <h5 class="text-secondary">Estado de la Base de Datos:</h5>
                <?php if ($conectado): ?>
                    <span class="badge bg-success fs-6 p-2">✅ Conexión Exitosa a MySQL</span>
                <?php else: ?>
                    <span class="badge bg-danger fs-6 p-2">❌ No se pudo conectar a MySQL</span>
                <?php endif; ?>
            </div>

            <?php if ($conectado): ?>
                <table class="table table-bordered">
                    <tr>
                        <th>Host de BD</th>
                        <td><code><?= htmlspecialchars($host) ?></code></td>
                    </tr>
                    <tr>
                        <th>Nombre de BD</th>
                        <td><code><?= htmlspecialchars($db_name) ?></code></td>
                    </tr>
                    <tr>
                        <th>Versión de MySQL</th>
                        <td><span class="badge bg-info text-dark"><?= htmlspecialchars($mysql_version) ?></span></td>
                    </tr>
                    <tr>
                        <th>Versión de PHP</th>
                        <td><span class="badge bg-secondary"><?= phpversion() ?></span></td>
                    </tr>
                </table>
            <?php else: ?>
                <div class="alert alert-warning">
                    <strong>Aviso:</strong> Si acabas de encender los contenedores, MySQL tarda unos segundos en inicializar.<br>
                    <small><strong>Detalle:</strong> <?= htmlspecialchars($mensaje_error) ?></small>
                </div>
            <?php endif; ?>

            <div class="text-center mt-3">
                <a href="" class="btn btn-outline-primary btn-sm">🔄 Recargar Página</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>