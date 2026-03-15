# 📚 Biblioteca-php-api-libros

Refactorización experimental del módulo de libros de una API originalmente desarrollada en Java + Spring Boot, reimplementado en PHP vanilla (sin framework).

El objetivo fue explorar cómo se vería la misma lógica de negocio en PHP manteniendo una arquitectura por capas.

---

## 🧠 Contexto

Este proyecto surge como un experimento de fin de semana.

Tengo una API REST para un sistema de gestión de biblioteca construida con:

- Java
- Spring Boot
- MySQL

Para experimentar con PHP decidí aislar el módulo de consultas de libros y reimplementarlo en PHP puro, manteniendo una estructura de backend similar a la utilizada en el proyecto original.

El objetivo no es reemplazar la API original, sino explorar:

- Sintaxis y flujo de trabajo en PHP
- Manejo de requests HTTP sin framework
- Acceso a base de datos con PDO
- Arquitectura backend básica en PHP

---

## 🏗 Arquitectura

El proyecto sigue una estructura simple por capas:

```
config/
controllers/
services/
repositories/
api/
minifront/
```

**Controller** — Gestiona la entrada HTTP y el routing básico.

**Service** — Contiene la lógica de negocio.

**Repository** — Encargado del acceso a base de datos.

**Config** — Conexión a MySQL.

---

## 🔌 Endpoints implementados

**Obtener todos los libros**
```
GET /api/libros.php
```

**Obtener libro por ID**
```
GET /api/libros.php?id=1
```

**Crear libro**
```
POST /api/libros.php
```

Body JSON:
```json
{
  "titulo": "Nuevo libro",
  "paginas": 320,
  "ubicacionId": 1,
  "autoresIds": [1],
  "generosIds": [2],
  "editorialesIds": [1]
}
```

**Eliminar libro**
```
DELETE /api/libros.php?id=1
```

---

## 🗄 Base de datos

El proyecto utiliza MySQL. Para facilitar pruebas se puede utilizar una copia de la base original del sistema de biblioteca.

Las credenciales se configuran en:
```
config/database.php
```

El archivo `config/database.example.php` sirve como plantilla. El archivo real está excluido del repositorio mediante `.gitignore`.

---

## 🖥 Mini frontend de demo

Se incluye un pequeño frontend de prueba en:
```
minifront/
```

Permite probar rápidamente el comportamiento de la API. Funcionalidades:

- Listar libros
- Ver detalle de un libro
- Crear libros
- Eliminar libros

> Este frontend está pensado como herramienta de demostracion.

---

## ▶ Cómo ejecutarlo

1. Clonar el repositorio.
2. Colocar el proyecto dentro de `htdocs` de XAMPP o cualquier servidor Apache con PHP.
3. Configurar credenciales en `config/database.php`.
4. Abrir el mini frontend:

```
http://localhost/Biblioteca-php-api-libros/minifront/index.html
```

---

## 📌 Notas

Este proyecto no busca ser un framework ni una API completa, sino un ejercicio práctico para explorar PHP a partir de un backend ya existente en otro stack.