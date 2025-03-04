# ODS_PROYECT_CUATROVIENTOS 🌍

Esta aplicación está diseñada para gestionar **iniciativas** y sus datos asociados, facilitando la creación, lectura, actualización y eliminación (lógica) de registros. Además, permite gestionar dimensiones relacionadas con las iniciativas. A continuación, se explican en detalle los requisitos, los endpoints disponibles y cómo poner en marcha el proyecto.

---

## 🛠️ Requisitos Previos

- **PHP**: Versión 8.1 o superior.
- **Composer**: Gestor de dependencias para PHP.
- **Symfony CLI**: Facilita el desarrollo y ejecución del servidor.
- **Base de Datos**: MySQL, HeidiSQL u otra compatible con Doctrine.
- **Git**: Para clonar el repositorio.

---

## 🚀 Instalación y Preparación

Sigue estos pasos para poner en marcha el proyecto en tu entorno local:

1. **Clonar el repositorio**

    ```bash
    git clone https://github.com/Foxriel13/ODS_PROYECT_CUATROVIENTOS_BACKEND.git
    cd ruta-del-repositorio
    ```

2. **Instalar dependencias**

    Ejecuta el siguiente comando para instalar todas las dependencias del proyecto:

    ```bash
    composer install
    ```

3. **Iniciar el servidor**

    Para iniciar el servidor de desarrollo, ejecuta:

    ```bash
    symfony server:start
    ```

4. **Configurar la base de datos**

    - **Crear la base de datos**:

    ```bash
    php bin/console doctrine:database:create
    ```

    - **Crear la migración de la base de datos**:

    ```bash
    php bin/console make:migration
    ```

    - **Ejecutar la migración**:

    ```bash
    php bin/console doctrine:migrations:migrate
    ```

---

## 📡 Endpoints

La aplicación expone varios endpoints para gestionar las **iniciativas** y **dimensiones** asociadas. A continuación se detallan los principales endpoints.

### **1. Obtener todas las iniciativas**

- **Método**: `GET`
- **Ruta**: `/iniciativas`
- **Descripción**: Retorna todas las iniciativas, con la opción de filtrarlas por estado (`activas` o `eliminadas`) mediante el parámetro `eliminado` en la query string.

### **2. Crear una nueva iniciativa**

- **Método**: `POST`
- **Ruta**: `/iniciativas`
- **Cuerpo JSON esperado**:

    ```json
    {
        "tipo": "Tipo de iniciativa",
        "horas": 10,
        "nombre": "Nombre de la iniciativa",
        "producto_final": "Descripción o URL del producto final",
        "fecha_registro": "2023-01-01 12:00:00",
        "fecha_inicio": "2023-01-10 08:00:00",
        "fecha_fin": "2023-02-01 18:00:00",
        "innovador": true,
        "anyo_lectivo": "2022-2023",
        "imagen": "ruta_o_url_de_la_imagen"
    }
    ```

### **3. Actualizar una iniciativa existente**

- **Método**: `PUT`
- **Ruta**: `/iniciativas/{id}`
- **Descripción**: Actualiza los campos enviados en el request. Solo se modifican aquellos campos presentes en el cuerpo JSON.

    Ejemplo de cuerpo JSON:

    ```json
    {
        "nombre": "Nuevo nombre de la iniciativa",
        "horas": 15
    }
    ```

### **4. Eliminar (marcar como eliminado) una iniciativa**

- **Método**: `DELETE`
- **Ruta**: `/iniciativas/{id}`
- **Descripción**: No elimina físicamente el registro, sino que marca el campo `eliminado` como `true`.

---

## 🔧 Detalles adicionales sobre las entidades

La aplicación también expone varios **GETs** para consultar las entidades asociadas a las iniciativas. A continuación, se describen las relaciones más importantes.

### **1. Cursos** 🎯

```php
    {
        "nombre": "Nuevo nombre de la iniciativa",
        "horas": 15
    }
```

### **2. Dimensiones** 🎯

```php
    {
        "nombre": "Nuevo nombre de la iniciativa",
        "horas": 15
    }
```

### **3. Entidades Externas** 🎯

```php
    {
        "nombre": "Nuevo nombre de la iniciativa",
        "horas": 15
    }
```

### **4. Metas** 🎯

```php
    {
        "nombre": "Nuevo nombre de la iniciativa",
        "horas": 15
    }
```

### **5. Modulos** 🎯

```php
    {
        "nombre": "Nuevo nombre de la iniciativa",
        "horas": 15
    }
```

### **6. ODSs** 🎯

```php
    {
        "nombre": "Nuevo nombre de la iniciativa",
        "horas": 15
    }
```

### **7. Profesores** 🎯

```php
    {
        "nombre": "Nuevo nombre de la iniciativa",
        "horas": 15
    }
```