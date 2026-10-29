# Práctica 7: Hola Mundo con Docker Compose y MySQL

Aplicación web "Hola Mundo" en **PHP** con conexión a una base de datos **MySQL**, orquestada con **Docker Compose**.

---

## 📁 Estructura del Proyecto

```text
Practica7/
├── src/
│   └── index.php          # Código fuente Hola Mundo con conexión a MySQL
├── Dockerfile             # Configuración de PHP 8.2 + Apache con drivers MySQL (PDO)
├── docker-compose.yml     # Orquestador con servicios 'app' y 'db'
├── .gitignore             # Archivos ignorados por Git
└── README.md              # Documentación de la práctica
```

---

## 🛠️ Servicios Configurados en `docker-compose.yml`

1. **`app` (Servidor de Aplicación - PHP 8.2 + Apache)**:
   - Construido a partir del `Dockerfile`.
   - Incluye las extensiones de MySQL (`pdo_mysql`, `mysqli`).
   - Expone el puerto `8080` hacia el host (`http://localhost:8080`).
   - Mapea el volumen `./src:/var/www/html` para reflejar cambios en vivo.
   - Depende del servicio `db`.

2. **`db` (Servidor de Base de Datos - MySQL 8.0)**:
   - Imagen oficial `mysql:8.0`.
   - Inicializa la base de datos `holamundo_db`.
   - Expone el puerto `3307` hacia el host (para evitar conflictos con MySQL local).
   - Persistencia de datos mediante el volumen `db_data`.

---

## 🚀 Instrucciones de Ejecución

1. **Levantar los contenedores:**
   ```bash
   docker-compose up -d --build
   ```

2. **Abrir en el navegador:**
   [http://localhost:8080](http://localhost:8080)

3. **Detener los contenedores:**
   ```bash
   docker-compose down
   ```

