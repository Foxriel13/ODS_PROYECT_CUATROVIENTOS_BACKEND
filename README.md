<a id="readme-top"></a>

<!-- Variables definidas al final de la página -->
[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]

<!-- Logo del proyecto -->
<br />
<div align="center">
  <a href="https://github.com/othneildrew/Best-README-Template">
    <img src="https://www.cuatrovientos.org/wp-content/uploads/2019/07/logo-cuatrovientos-2.png" alt="Logo" width="300" height="80">
  </a>
  <h3 align="center">ODS_PROYECT_CUATROVIENTOS_BACKEND</h3>
  <p align="center"> 
    ODS_PROYECT_CUATROVIENTOS es una aplicación desarrollada para gestionar iniciativas vinculadas a los Objetivos de Desarrollo Sostenible (ODS), permitiendo su creación, consulta, actualización y eliminación lógica. También ofrece gestión de dimensiones, metas, profesores, entidades externas, módulos, cursos, y más.
    <br />
    <a href="https://github.com/Foxriel13/ODS_PROYECT_CUATROVIENTOS_BACKEND"><strong>Explorar la documentación»</strong></a>
    <br />
    <br />
    <a href="https://github.com/Foxriel13/ODS_PROYECT_CUATROVIENTOS_BACKEND/issues/new?labels=bug&template=bug-report---.md">Reportar Bug</a>
    &middot;
    <a href="https://github.com/Foxriel13/ODS_PROYECT_CUATROVIENTOS_BACKEND/issues/new?labels=enhancement&template=feature-request---.md">Solicitar Funcionalidad</a>
  </p>
</div>

<!-- Sobre el proyecto -->
# 🌍 Sobre el Proyecto
**ODS_PROYECT_CUATROVIENTOS** es una aplicación desarrollada para gestionar **iniciativas** vinculadas a los Objetivos de Desarrollo Sostenible (ODS), permitiendo su creación, consulta, actualización y eliminación lógica. También ofrece gestión de dimensiones, metas, profesores, entidades externas, módulos, cursos, y más.

<p align="right">(<a href="#readme-top">vuelta arriba</a>)</p>

<!-- Requisitos Previos -->
## 🧰 Requisitos Previos
Asegúrate de tener instaladas las siguientes herramientas:
- **PHP** ≥ 8.1  
- **Composer**  
- **Symfony CLI**  
- **Base de datos**: MySQL, HeidiSQL u otra compatible con Doctrine  
- **Git**

<p align="right">(<a href="#readme-top">vuelta arriba</a>)</p>

<!-- Instalación -->
## 🚀 Instalación
Sigue los pasos a continuación para levantar el proyecto en tu entorno local:

### 1. Clonar el repositorio
Puedes trabajar sobre la rama que necesites:
```bash
# Clonar desde Entrega 1
git clone --branch Entrega1 --single-branch https://github.com/Foxriel13/ODS_PROYECT_CUATROVIENTOS_BACKEND.git
cd ODS_PROYECT_CUATROVIENTOS_BACKEND

# O desde Entrega 2
git clone --branch Entrega2 --single-branch https://github.com/Foxriel13/ODS_PROYECT_CUATROVIENTOS_BACKEND.git
cd ODS_PROYECT_CUATROVIENTOS_BACKEND
```

### 2. Instalar dependencias
```bash
composer install
```

### 3. Configurar la base de datos
```bash
# Crear la base de datos
php bin/console doctrine:database:create

# Generar migraciones
php bin/console make:migration

# Ejecutar las migraciones
php bin/console doctrine:migrations:migrate
```

### 4. Iniciar el servidor
```bash
symfony server:start
```

### 5. Meter datos en la Base de Datos
```bash
Introducir INSERTS en el motor de Base de Datos del archivo
https://github.com/Foxriel13/ODS_PROYECT_CUATROVIENTOS_BACKEND/blob/main/INSERTS%20BACKEND.txt
```

<p align="right">(<a href="#readme-top">vuelta arriba</a>)</p>

## 📡 Endpoints Disponibles

### 🔍 Obtener todas las iniciativas

- **Método**: `GET`  
- **Ruta**: `/iniciativas`  
- **Descripción**: Retorna todas las iniciativas. Puedes filtrar por estado con el parámetro `eliminado`.

### ➕ Crear una nueva iniciativa

- **Método**: `POST`  
- **Ruta**: `/iniciativas`  
- **Body JSON**:

```json
{
  "tipo": "Tipo de iniciativa",
  "horas": 10,
  "nombre": "Nombre de la iniciativa",
  "producto_final": "URL o descripción del producto final",
  "fecha_registro": "2023-01-01 12:00:00",
  "fecha_inicio": "2023-01-10 08:00:00",
  "fecha_fin": "2023-02-01 18:00:00",
  "innovador": true,
  "anyo_lectivo": "2022-2023",
  "imagen": "ruta_o_url_imagen",
  "metas": [1],
  "profesores": [1],
  "entidades_externas": [1],
  "modulos": [
    {
      "id": 1,
      "clases": [1]
    }
  ],
  "redes_sociales": [1],
  "actividades": [1]
}
```
### ✏️ Actualizar una iniciativa

- **Método**: `PUT`  
- **Ruta**: `/iniciativas/{id}`  
- **Descripción**: Actualiza los campos presentes en el cuerpo JSON.

<p align="right">(<a href="#readme-top">vuelta arriba</a>)</p>

### ❌ Eliminar (marcado lógico)

- **Método**: `DELETE`  
- **Ruta**: `/iniciativas/{id}`  
- **Descripción**: Marca la iniciativa como eliminada (`eliminado: true`), sin borrarla físicamente.

<p align="right">(<a href="#readme-top">vuelta arriba</a>)</p>

## 📘 Entidades Asociadas

Estas entidades están relacionadas con las iniciativas:

### 🎯 Metas

```json
{
  "idMeta": 1,
  "descripcion": "Fomentar la educación digital",
  "ods": [
    {
      "idOds": 1,
      "nombre": "Fin de la pobreza",
      "dimension": {
        "idDimension": 1,
        "nombre": "Social"
      }
    }
  ]
}
```

### 🌱 ODS

```json
  {
    "idOds": 1,
    "nombre": "Fin de la Pobreza",
    "dimension": "Social"
  }
```

### 🧩 Módulos

```json
{
  "idModulo": 1,
  "nombre": "Programación",
  "curso": {
    "idCurso": 1,
    "nombre": "DAM"
  }
}
```

### 🎓 Cursos

```json
{
  "idCurso": 1,
  "nombre": "DAM"
}
```

### 🏛️ Entidades Externas

```json
{
  "idEntidadExterna": 1,
  "nombre": "Universidad Nacional"
}
```

### 👨‍🏫 Profesores

```json
{
  "idProfesor": 1,
  "nombre": "Markos Perez"
}
```

### 🗂️ Actividades

```json
{
  "idActividad": 1,
  "nombre": "Actividad1"
}
```

<p align="right">(<a href="#readme-top">vuelta arriba</a>)</p>

## 🗺️ Oja de Ruta

- [x] BBDD: Implantar el esquema SQL del proyecto 1 DAM
- [x] REST API: GET/POST/PUT/DELETE Iniciativas
- [x] REST API: GET de Entidades
- [x] REST API: GET Indicadores
- [x] REST API: POST/PUT/DELETE Entidades Auxiliares
- [ ] Securizar API y gestión de roles (Usuario y Administrador)


## 📅 Estado del Proyecto

🚧 **En desarrollo activo**  
Actualmente el proyecto se encuentra en constante evolución. Se están implementando nuevas funcionalidades, corrigiendo errores y optimizando el rendimiento para su uso en producción.

> Si encuentras un bug o tienes sugerencias, ¡no dudes en abrir un issue o una pull request!

<p align="right">(<a href="#readme-top">vuelta arriba</a>)</p>

## 👥 Autores

Proyecto desarrollado por:

- [@Danel](https://www.github.com/danel-rico)  
- [@Aitor](https://www.github.com/AitorLopez057)


<!-- MARKDOWN LINKS -->
[contributors-shield]: https://img.shields.io/github/contributors/Foxriel13/ODS_PROYECT_CUATROVIENTOS_BACKEND.svg?style=for-the-badge
[contributors-url]: https://github.com/Foxriel13/ODS_PROYECT_CUATROVIENTOS_BACKEND/graphs/contributors

[forks-shield]: https://img.shields.io/github/forks/Foxriel13/ODS_PROYECT_CUATROVIENTOS_BACKEND.svg?style=for-the-badge
[forks-url]: https://github.com/Foxriel13/ODS_PROYECT_CUATROVIENTOS_BACKEND/network/members

[stars-shield]: https://img.shields.io/github/stars/Foxriel13/ODS_PROYECT_CUATROVIENTOS_BACKEND.svg?style=for-the-badge
[stars-url]: https://github.com/Foxriel13/ODS_PROYECT_CUATROVIENTOS_BACKEND/stargazers

[issues-shield]: https://img.shields.io/github/issues/Foxriel13/ODS_PROYECT_CUATROVIENTOS_BACKEND.svg?style=for-the-badge
[issues-url]: https://github.com/Foxriel13/ODS_PROYECT_CUATROVIENTOS_BACKEND/issues
