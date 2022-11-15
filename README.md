# Categories Rest API documentation
Descripción de una API REST basica para manejar el CRUD de categorias de productos.

> Antes de comenzar, se debe importar la base de datos sobre la que se estará trabajando, así como tambien tener instalado y configurado XAMPP para usar el servidor sobre el que se montará este proyecto.

---
## Get all categories

> `GET` /api/categories

**Query Parameters**

| Parametro                    | Tipo          | Requerido | Descripción                                         |
|:-----------------------------|:--------------|:---------|:----------------------------------------------------|
| `sortBy`                      | string        | No      | Campo seleccionado para ordenar los resultados, default `name` .                                 |
| `order`                      | string        | No      | Orden aplicado, `asc`(default) o `desc`.                                 |
| `page`                      | int        | No      | Pagina actual, default 1.                                 |
| `limit`                      | int        | No      | Cantidad de campos por pagina, default 10.                                 |
| `filterBy` / `value`                      | string        | No      | Campo por el que filtrar y su valor.                                 |                              |


### **Ejemplos de request:**

#### `GET` /api/categories
> Response:

    Status: 200 
    Body:
    [
        {
            "id": 7,
            "name": "Aromatica",
            "description": "Su nombre lo dice todo, más allá de ser un elemento decorativo son un gran aporte al aroma y sabor de tu plato."
        },
        {
            "id": 19,
            "name": "dummy category",
            "description": "descripción de relleno para la categoria dummy."
        },
        {
            "id": 8,
            "name": "Flor comestible",
            "description": "Si bien algunas tienen sabor, el fuerte indebatible es la estética que aportan a los platos o postres."
        },
        {
            "id": 6,
            "name": "Microgreen",
            "description": "Son plántulas jóvenes, con los mismos sabores y nutrientes que sus versiones adultas pero en una mayor concentración."
        }
    ] 


#### `GET`/api/categories?page=1&limit=2&filterBy=name&value=ro&order=asc
> Response:

    Status: 200 
    Body:
    [
        {
            "id": 7,
            "name": "Aromatica",
            "description": "Su nombre lo dice todo, más allá de ser un elemento decorativo son un gran aporte al aroma y sabor de tu plato."
        },
        {
            "id": 6,
            "name": "Microgreen",
            "description": "Son plántulas jóvenes, con los mismos sabores y nutrientes que sus versiones adultas pero en una mayor concentración."
        }
    ]


#### `GET` /api/categories?page=1&limit=2&filterBy=name&value=ro&order=asc&sortBy=id

> Response:

    Status: 200 
    Body:
    [
        {
            "id": 6,
            "name": "Microgreen",
            "description": "Son plántulas jóvenes, con los mismos sabores y nutrientes que sus versiones adultas pero en una mayor concentración."
        },
        {
            "id": 7,
            "name": "Aromatica",
            "description": "Su nombre lo dice todo, más allá de ser un elemento decorativo son un gran aporte al aroma y sabor de tu plato."
        }
    ]

---

## Get category by id

> `GET` /api/categories/:id

**Path Parameters**

| Parametro                    | Tipo          | Requerido | Descripción                                         |
|:-----------------------------|:--------------|:---------|:----------------------------------------------------|
| `id`                      | int        | Si      | Id de la categoria a buscar                                 |

### **Ejemplos de request:**

#### `GET` /api/categories/7
> Response:

    Status: 200 
    Body:
    {
        "id": 7,
        "name": "Aromatica",
        "description": "Su nombre lo dice todo, más allá de ser un elemento decorativo son un gran aporte al aroma y sabor de tu plato."
    }

#### `GET` /api/categories/999

>Response:

    Status: 404 
    Body:
        "La categoria con el id=999 no existe"

---

## Autenticación para obtener Bearer token

>`GET` /api/auth/token

**Basic auth parameters**

| Parametro                    | Tipo          | Requerido | Descripción                                         |
|:-----------------------------|:--------------|:---------|:----------------------------------------------------|
| `username`                      | string        | Si      | Nombre de usuario registrado                                 |
| `password`                      | string        | Si      | Clave de acceso                                 |

### **Ejemplos de request:**

#### `GET` /api/auth/token

    Username: admin@admin.com
    password: asd

>Response:

    Status: 200 
    Body:
        "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwibmFtZSI6ImFkbWluQGFkbWluLmNvbSIsImV4cCI6MTY2ODU1NjQ0OX0.gfzdvp6mH0kFgkB3lq56KSxl0bo_i2I0QzNZ5SIg_pE"

--- 

## Create category

> `POST` /api/categories/

**Headers**

| Parametro                    | Tipo          | Requerido | Descripción                                         |
|:-----------------------------|:--------------|:---------|:----------------------------------------------------|
| `Authorization`                      | string        | Si      | Bearer token                                 |

**Body**

| Parametro                    | Tipo          | Requerido | Descripción                                         |
|:-----------------------------|:--------------|:---------|:----------------------------------------------------|
| `name`                      | string        | Si      | Nombre de la categoria                                 |
| `description`                      | string        | Si      | Descripción de la categoria                                 |

### **Ejemplos de request:**

#### `POST` /api/categories/

>Header:

    Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwibmFtZSI6ImFkbWluQGFkbWluLmNvbSIsImV4cCI6MTY2ODU1NjQ0OX0.gfzdvp6mH0kFgkB3lq56KSxl0bo_i2I0QzNZ5SIg_pE

>Body:

    {
        "name":"Nueva Categoria",
        "description":"Descripcion de la categoria nueva" 
    }

> Response:

    Status: 201
    Body:
    {
        "id": 21,
        "name": "Nueva Categoria",
        "description": "Descripcion de la categoria nueva"
    }

--- 

## Update category

> `PUT` /api/categories/

**Parametros**
| Parametro                    | Tipo          | Requerido | Descripción                                         |
|:-----------------------------|:--------------|:---------|:----------------------------------------------------|
| `id`                      | int        | Si      | Id de la categoria a actualizar                                 |

**Headers**

| Parametro                    | Tipo          | Requerido | Descripción                                         |
|:-----------------------------|:--------------|:---------|:----------------------------------------------------|
| `Authorization`                      | string        | Si      | Bearer token                                 |

**Body**

| Parametro                    | Tipo          | Requerido | Descripción                                         |
|:-----------------------------|:--------------|:---------|:----------------------------------------------------|
| `name`                      | string        | Si      | Nombre de la categoria                                 |
| `description`                      | string        | Si      | Descripción de la categoria                                 |

### **Ejemplos de request:**

#### `PUT` /api/categories/

>Header:

    Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwibmFtZSI6ImFkbWluQGFkbWluLmNvbSIsImV4cCI6MTY2ODU1NjQ0OX0.gfzdvp6mH0kFgkB3lq56KSxl0bo_i2I0QzNZ5SIg_pE

>Body:

    {
        "name":"Nueva Categoria",
        "description":"Descripción de la categoria nueva con acento" 
    }

> Response:

    Status: 200
    Body:
    {
        "id": 21,
        "name": "Nueva Categoria",
        "description": "Descripción de la categoria nueva con acento"
    }

--- 

## Delete category

> `DELETE` /api/categories/

**Parametros**
| Parametro                    | Tipo          | Requerido | Descripción                                         |
|:-----------------------------|:--------------|:---------|:----------------------------------------------------|
| `id`                      | int        | Si      | Id de la categoria a eliminar                                 |


**Headers**

| Parametro                    | Tipo          | Requerido | Descripción                                         |
|:-----------------------------|:--------------|:---------|:----------------------------------------------------|
| `Authorization`                      | string        | Si      | Bearer token                                 |


### **Ejemplos de request:**

#### `DELETE` /api/categories/

>Header:

    Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwibmFtZSI6ImFkbWluQGFkbWluLmNvbSIsImV4cCI6MTY2ODU1NjQ0OX0.gfzdvp6mH0kFgkB3lq56KSxl0bo_i2I0QzNZ5SIg_pE


> Response:

    Status: 200
    Body:
    {
        "id": 22,
        "name": "Nueva Categoria - duplicado para borrar",
        "description": "Descripcion de la categoria nueva"
    }

> NOTA: Si se intenta borrar una categoria con productos asociados, se obtendrá el siguiente response

> Response:

    Status: 409
    Body:
    "La categoria seleccionada tiene productos asociados y no puede ser borrada"