# 📡 Documentación API REST

Base URL: `http://127.0.0.1:8000/api`

## 🔧 Headers requeridos

```
Content-Type: application/json
Accept: application/json
```

---

## 📦 Productos

### 1. Listar todos los productos
```http
GET /api/products
```

**Parámetros de consulta (opcionales):**
- `search` - Buscar por nombre
- `per_page` - Número de resultados por página (default: 15)
- `page` - Número de página

**Ejemplo:**
```bash
curl -X GET "http://127.0.0.1:8000/api/products?search=producto&per_page=10" \
  -H "Accept: application/json"
```

**Respuesta exitosa (200):**
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "name": "Producto 1",
      "description": "Descripción del producto",
      "price": "99.99",
      "stock": 50,
      "created_at": "2025-11-26T12:00:00.000000Z",
      "updated_at": "2025-11-26T12:00:00.000000Z",
      "categories": [
        {
          "id": 1,
          "name": "Categoría 1",
          "description": "Descripción"
        }
      ]
    }
  ],
  "per_page": 15,
  "total": 1
}
```

---

### 2. Obtener un producto específico
```http
GET /api/products/{id}
```

**Ejemplo:**
```bash
curl -X GET "http://127.0.0.1:8000/api/products/1" \
  -H "Accept: application/json"
```

**Respuesta exitosa (200):**
```json
{
  "data": {
    "id": 1,
    "name": "Producto 1",
    "description": "Descripción del producto",
    "price": "99.99",
    "stock": 50,
    "categories": [...]
  }
}
```

---

### 3. Crear nuevo producto
```http
POST /api/products
```

**Body (JSON):**
```json
{
  "name": "Nuevo Producto",
  "description": "Descripción opcional",
  "price": 99.99,
  "stock": 100,
  "categories": [1, 2, 3]
}
```

**Ejemplo:**
```bash
curl -X POST "http://127.0.0.1:8000/api/products" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Nuevo Producto",
    "description": "Descripción del producto",
    "price": 99.99,
    "stock": 100,
    "categories": [1, 2]
  }'
```

**Respuesta exitosa (201):**
```json
{
  "message": "Producto creado exitosamente",
  "data": {
    "id": 1,
    "name": "Nuevo Producto",
    "description": "Descripción del producto",
    "price": "99.99",
    "stock": 100,
    "categories": [...]
  }
}
```

**Errores de validación (422):**
```json
{
  "message": "The name field is required.",
  "errors": {
    "name": ["The name field is required."],
    "price": ["The price field is required."]
  }
}
```

---

### 4. Actualizar producto
```http
PUT /api/products/{id}
PATCH /api/products/{id}
```

**Body (JSON):**
```json
{
  "name": "Producto Actualizado",
  "description": "Nueva descripción",
  "price": 149.99,
  "stock": 75,
  "categories": [1, 3]
}
```

**Ejemplo:**
```bash
curl -X PUT "http://127.0.0.1:8000/api/products/1" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Producto Actualizado",
    "price": 149.99,
    "stock": 75,
    "categories": [1, 3]
  }'
```

**Respuesta exitosa (200):**
```json
{
  "message": "Producto actualizado exitosamente",
  "data": {
    "id": 1,
    "name": "Producto Actualizado",
    "price": "149.99",
    "stock": 75,
    "categories": [...]
  }
}
```

---

### 5. Eliminar producto
```http
DELETE /api/products/{id}
```

**Ejemplo:**
```bash
curl -X DELETE "http://127.0.0.1:8000/api/products/1" \
  -H "Accept: application/json"
```

**Respuesta exitosa (200):**
```json
{
  "message": "Producto eliminado exitosamente"
}
```

---

## 🏷️ Categorías

### 1. Listar todas las categorías
```http
GET /api/categories
```

**Parámetros de consulta (opcionales):**
- `search` - Buscar por nombre
- `per_page` - Número de resultados por página
- `page` - Número de página

**Ejemplo:**
```bash
curl -X GET "http://127.0.0.1:8000/api/categories" \
  -H "Accept: application/json"
```

**Respuesta exitosa (200):**
```json
{
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "name": "Categoría 1",
      "description": "Descripción",
      "products_count": 5,
      "created_at": "2025-11-26T12:00:00.000000Z",
      "updated_at": "2025-11-26T12:00:00.000000Z"
    }
  ],
  "per_page": 15,
  "total": 1
}
```

---

### 2. Obtener una categoría específica
```http
GET /api/categories/{id}
```

**Ejemplo:**
```bash
curl -X GET "http://127.0.0.1:8000/api/categories/1" \
  -H "Accept: application/json"
```

**Respuesta exitosa (200):**
```json
{
  "data": {
    "id": 1,
    "name": "Categoría 1",
    "description": "Descripción",
    "products_count": 5,
    "products": [...]
  }
}
```

---

### 3. Crear nueva categoría
```http
POST /api/categories
```

**Body (JSON):**
```json
{
  "name": "Nueva Categoría",
  "description": "Descripción opcional"
}
```

**Ejemplo:**
```bash
curl -X POST "http://127.0.0.1:8000/api/categories" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Nueva Categoría",
    "description": "Descripción de la categoría"
  }'
```

**Respuesta exitosa (201):**
```json
{
  "message": "Categoría creada exitosamente",
  "data": {
    "id": 1,
    "name": "Nueva Categoría",
    "description": "Descripción de la categoría"
  }
}
```

---

### 4. Actualizar categoría
```http
PUT /api/categories/{id}
PATCH /api/categories/{id}
```

**Body (JSON):**
```json
{
  "name": "Categoría Actualizada",
  "description": "Nueva descripción"
}
```

**Ejemplo:**
```bash
curl -X PUT "http://127.0.0.1:8000/api/categories/1" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Categoría Actualizada",
    "description": "Nueva descripción"
  }'
```

**Respuesta exitosa (200):**
```json
{
  "message": "Categoría actualizada exitosamente",
  "data": {
    "id": 1,
    "name": "Categoría Actualizada",
    "description": "Nueva descripción"
  }
}
```

---

### 5. Eliminar categoría
```http
DELETE /api/categories/{id}
```

**Ejemplo:**
```bash
curl -X DELETE "http://127.0.0.1:8000/api/categories/1" \
  -H "Accept: application/json"
```

**Respuesta exitosa (200):**
```json
{
  "message": "Categoría eliminada exitosamente"
}
```

---

## 📝 Códigos de Estado HTTP

| Código | Descripción |
|--------|-------------|
| 200 | OK - Solicitud exitosa |
| 201 | Created - Recurso creado exitosamente |
| 422 | Unprocessable Entity - Error de validación |
| 404 | Not Found - Recurso no encontrado |
| 500 | Internal Server Error - Error del servidor |

---

## 🧪 Probar la API

### Usando Postman
1. Importa la colección de endpoints
2. Configura la URL base: `http://127.0.0.1:8000/api`
3. Añade los headers requeridos

### Usando cURL (desde terminal)
Ver ejemplos en cada endpoint arriba

### Usando JavaScript (fetch)
```javascript
// Listar productos
fetch('http://127.0.0.1:8000/api/products')
  .then(response => response.json())
  .then(data => console.log(data));

// Crear producto
fetch('http://127.0.0.1:8000/api/products', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  body: JSON.stringify({
    name: 'Producto desde JS',
    price: 99.99,
    stock: 50,
    categories: [1, 2]
  })
})
  .then(response => response.json())
  .then(data => console.log(data));
```

### Usando Python (requests)
```python
import requests

# Listar productos
response = requests.get('http://127.0.0.1:8000/api/products')
print(response.json())

# Crear producto
data = {
    'name': 'Producto desde Python',
    'price': 99.99,
    'stock': 50,
    'categories': [1, 2]
}
response = requests.post(
    'http://127.0.0.1:8000/api/products',
    json=data,
    headers={'Accept': 'application/json'}
)
print(response.json())
```

---

## 🔐 Nota sobre autenticación

Actualmente la API es pública. Para producción, considera implementar:
- Laravel Sanctum para autenticación de API
- Tokens de acceso
- Rate limiting
- CORS configurado apropiadamente
