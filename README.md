# 🍽️ La Buena Mesa — API RESTful de Gestión de Menú

API RESTful desarrollada con **Laravel 12** y **Eloquent ORM** para centralizar la gestión del menú del restaurante "La Buena Mesa". Permite operaciones CRUD completas sobre los platillos, filtrado por categoría, y expone datos listos para ser consumidos por una app de meseros, el sistema de cocina o una plataforma web — todo desde una única fuente de verdad.

Incluye además una **vista de administración** (Blade + JS puro) que consume la propia API, útil como demo funcional y como documentación viva de los endpoints.

---

## 📁 Estructura del proyecto

```
la-buena-mesa-api/
├── app/
│   ├── Enums/
│   │   └── MenuCategory.php          # Categorías válidas del menú
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php
│   │   │   └── Api/
│   │   │       └── MenuItemController.php   # Lógica CRUD del recurso
│   │   ├── Requests/
│   │   │   ├── StoreMenuItemRequest.php     # Validación al crear
│   │   │   └── UpdateMenuItemRequest.php    # Validación al actualizar
│   │   └── Resources/
│   │       └── MenuItemResource.php         # Transformación de la respuesta JSON
│   └── Models/
│       └── MenuItem.php               # Modelo Eloquent + scopes
├── bootstrap/
│   └── app.php                        # Registro de rutas y manejo de excepciones (JSON)
├── database/
│   ├── factories/MenuItemFactory.php
│   ├── migrations/2026_08_14_000000_create_menu_items_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── MenuItemSeeder.php         # 10 platillos reales + 15 aleatorios
├── public/css/app.css
├── resources/views/
│   ├── layouts/app.blade.php
│   └── menu/index.blade.php           # Panel CRUD que consume /api/menu-items
├── routes/
│   ├── api.php
│   ├── console.php
│   └── web.php
├── .env.example
├── composer.json
└── README.md
```

### Arquitectura y decisiones de diseño

| Capa | Responsabilidad |
|---|---|
| **Model** (`MenuItem`) | Reglas de datos, casts, scopes de consulta reutilizables (`available()`, `category()`) |
| **FormRequest** | Toda la validación de entrada, desacoplada del controlador |
| **Controller** | Orquesta la petición → validación → modelo → respuesta. Sin lógica de negocio "hardcodeada" |
| **Resource** | Define el contrato JSON público, independiente del esquema real de la tabla |
| **Enum** (`MenuCategory`) | Única fuente de verdad para las categorías válidas, evita strings mágicos repetidos |

Este enfoque sigue **separación de responsabilidades** y facilita escalar a múltiples sucursales (por ejemplo, agregando un `branch_id` al modelo sin tocar controladores ni vistas).

---

## ⚙️ Instrucciones de instalación

### Requisitos previos
- PHP >= 8.2
- Composer
- MySQL 8+ (o SQLite para pruebas rápidas)
- Extensión `pdo_mysql` o `pdo_sqlite` habilitada

### Pasos

```bash
# 1. Clonar el repositorio
git clone https://github.com/codedarwinflores/api-la-buena-mesa.git
cd la-buena-mesa-api

# 2. Instalar dependencias (crea la carpeta vendor/)
composer install

# 3. Copiar el archivo de entorno y generar la clave de aplicación
cp .env.example .env
php artisan key:generate

# 4. Base de datos: el proyecto usa SQLite por defecto y ya incluye
# database/database.sqlite vacío, así que no necesitas configurar nada más.
# Si prefieres MySQL, edita .env (ver comentarios dentro del archivo).

# 5. Ejecutar migraciones y seeders
php artisan migrate --seed

# 6. Levantar el servidor de desarrollo
php artisan serve
```

La API quedará disponible en `http://localhost:8000/api/menu-items` y el panel de administración en `http://localhost:8000/`.

---

## 📡 Documentación de Endpoints

Base URL: `http://localhost:8000/docs`

Todas las respuestas siguen el formato:
```json
{
  "success": true,
  "data": { ... },
  "message": "..."
}
```

### 1. Listar elementos del menú
```
GET /api/menu-items
```
**Query params opcionales:** `category`, `available` (0|1), `search`, `per_page`

```bash
curl "http://localhost:8000/api/menu-items?category=postre&available=1"
```

**Respuesta 200:**
```json
{
  "success": true,
  "data": [
    {
      "id": 7,
      "name": "Tarta de Chocolate y Maracuyá",
      "description": "Ganache de chocolate 70%, coulis de maracuyá, tierra de cacao.",
      "price": 7.5,
      "category": "postre",
      "category_label": "Postre",
      "image_url": "https://picsum.photos/seed/tarta/640/480",
      "available": true,
      "created_at": "2026-08-14T10:00:00+00:00",
      "updated_at": "2026-08-14T10:00:00+00:00"
    }
  ],
  "meta": { "current_page": 1, "last_page": 1, "per_page": 15, "total": 1 }
}
```

### 2. Obtener un elemento específico
```
GET /api/menu-items/{id}
```
```bash
curl http://localhost:8000/api/menu-items/7
```
`404` con `{"success": false, "message": "Recurso no encontrado."}` si no existe.

### 3. Crear un nuevo elemento
```
POST /api/menu-items
Content-Type: application/json
```
```bash
curl -X POST http://localhost:8000/api/menu-items \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Pastel de Zanahoria",
    "description": "Con frosting de queso crema y nueces.",
    "price": 6.25,
    "category": "postre",
    "image_url": "https://picsum.photos/seed/pastel/640/480",
    "available": true
  }'
```
**Respuesta 201** con el elemento creado. **Respuesta 422** si faltan campos requeridos o la categoría no es válida.

### 4. Actualizar un elemento existente
```
PUT /api/menu-items/{id}     (reemplazo completo)
PATCH /api/menu-items/{id}   (actualización parcial)
```
```bash
curl -X PATCH http://localhost:8000/api/menu-items/7 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{ "price": 8.00, "available": false }'
```

### 5. Eliminar un elemento
```
DELETE /api/menu-items/{id}
```
```bash
curl -X DELETE http://localhost:8000/api/menu-items/7 -H "Accept: application/json"
```

### 6. Filtrar por categoría (ruta dedicada)
```
GET /api/menu-items/category/{category}
```
Valores válidos: `entrada`, `plato_fuerte`, `postre`, `bebida`, `acompanamiento`
```bash
curl http://localhost:8000/api/menu-items/category/bebida
```

---

## 🧪 Panel de administración (vista)

Al visitar `/` se carga un panel Blade con formulario de alta/edición y un listado en tarjetas, todo consumiendo `fetch()` contra `/api/menu-items` — sin dependencias de JS externas. Sirve como cliente de referencia para equipos frontend que integren la API (app móvil, POS, etc.).

---

## ✅ Validaciones implementadas

| Campo | Reglas |
|---|---|
| `name` | requerido, string, 3–150 caracteres |
| `description` | opcional, máx. 1000 caracteres |
| `price` | requerido, numérico, entre 0 y 9999.99 |
| `category` | requerido, debe ser uno de los valores de `MenuCategory` |
| `image_url` | opcional, debe ser una URL válida |
| `available` | booleano |

En `PUT`/`PATCH` las reglas usan `sometimes` para permitir actualizaciones parciales sin exigir todos los campos.

---

## 🚀 Escalabilidad futura

- **Multi-sucursal:** agregar `branch_id` al modelo y un scope `MenuItem::branch($id)`.
- **App móvil / POS:** la API ya devuelve JSON versionable vía `MenuItemResource`, lo que permite cambiar el esquema de BD sin romper contratos externos.
- **Autenticación:** integrar Laravel Sanctum para proteger `store`, `update` y `destroy` con tokens por rol (mesero/cocina/admin).
- **Tiempo real:** exponer eventos con Laravel Broadcasting (WebSockets) cuando cambie disponibilidad/precio, para refrescar apps de meseros al instante.

---

## 🛠️ Stack

- Laravel 12 · PHP 8.2+
- Eloquent ORM
- Blade + JavaScript vanilla (sin frameworks frontend)
- MySQL / SQLite
