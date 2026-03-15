# 📚 Biblioteca-php-api-libros
 
> Refactorización del módulo de consultas de libros: de Java Spring Boot a PHP puro (sin framework).
 
---
 
## 🧠 Contexto
 
Experimento de fin de semana. Tengo una API REST construida con **Java + Spring Boot**, con el objetivo de probar PHP aisle el módulo de libros para reescribirlo en **PHP vanilla**, sin depender de ningún framework.
 
El objetivo no es reemplazar la API original, sino explorar PHP.

### 📃 Notas
#### 1
El archivo `config/database.example.php` tiene los campos vacíos para completar.

`config/database.php` está en el `.gitignore` para no exponer credenciales.

#### 2
Desarrolle un mini frontend demo para mostrar el comportamiento especifico de la API de forma rapida y sencilla.

Permite:
- Listar libros
- Ver detalles de un libro especifico
- Crear libros
- Borrar libros
 