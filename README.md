# API de Manejo de Ventas

Este proyecto es una API RESTful desarrollada con Laravel que permite gestionar ventas, clientes, productos y generar reportes. También incluye funcionalidades como caché con Redis, colas para envío de correos y autenticación basada en roles.

---

## Requisitos del Sistema

Asegúrate de tener instalado lo siguiente antes de comenzar:

- Docker (para usar Laravel Sail)
- PHP 8.2 o superior (opcional si usas Sail)
- Composer

---

## Instalación

1. **Clona el repositorio:**
   ```bash
   git clone https://github.com/tu-usuario/api-ventas.git
   cd api-ventas
   ```
   
2. **Instala las dependencias:**
   ```bash
   composer install
    ```
3. **Copia el archivo `.env.example` a `.env`:**
    ```bash
    cp .env.example .env
    ```
4. **Levanta los servicios con Laravel Sail:**
    ```bash
    vendor/bin/sail up -d
    ```
5. **Ejecuta las migraciones y seeders:**
    ```bash
    vendor/bin/sail artisan migrate --seed
    ```
6. **Accede a Mailpit:**
   Abre Mailpit en tu navegador:
    ```
    http://localhost:8025
    ```

## Configuración
### Roles y Permisos
- **Administrador**: Acceso total al sistema.
- **Vendedor**: Solo puede crear, listar y actualizar productos, y registrar/consultar ventas.

## Autenticación
La API utiliza tokens de autenticación (Sanctum). Para obtener un token:

### Registra un usuario:
```bash
POST /api/register
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "role": "admin" // o "seller"
}
```

### Inicia sesión para obtener el token:
```bash
POST /api/login
{
    "email": "john@example.com",
    "password": "password"
}
```

## Uso de la API
### Registro de una Venta
```bash
POST /api/sales
Authorization: Bearer <tu_token>
Content-Type: application/json

{
    "customer_id": 1,
    "details": [
        {
            "product_id": 1,
            "quantity": 2
        },
        {
            "product_id": 2,
            "quantity": 1
        }
    ]
}
```

### Generar Reporte de Productos Más Vendidos
```bash
GET /api/reports/top-selling-products?start_date=2023-01-01&end_date=2023-12-31&limit=10
Authorization: Bearer <tu_token>
```

## Endpoints Disponibles
| Método | Endpoint                                    | Descripción                            |
|---------|-------------------------------------------|----------------------------------------|
| POST    | `/api/register`                           | Registrar un nuevo usuario           |
| POST    | `/api/login`                              | Iniciar sesión y obtener un token    |
| POST    | `/api/sales`                              | Registrar una nueva venta            |
| GET     | `/api/reports/top-selling-products`      | Obtener productos más vendidos       |
| GET     | `/api/reports/sales-by-time-range`      | Obtener ventas agrupadas por tiempo  |

## Colas y Correos
### Procesar colas:
Inicia un worker para procesar las colas:
```bash
vendor/bin/sail artisan queue:work
```

### Ver correos enviados:
Abre Mailpit en tu navegador:
```
http://localhost:8025
```

## Caché con Redis
Los reportes utilizan Redis para almacenar datos en caché. Por ejemplo, el endpoint `/api/reports/top-selling-products` almacena los resultados durante 1 hora para mejorar el rendimiento.

Para limpiar la caché:
```bash
vendor/bin/sail artisan cache:clear
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
