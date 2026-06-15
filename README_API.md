# Miembro B - API REST de equipos

Esta parte agrega una API simple para trabajar con la tabla `equipo`.

## Endpoints

### Listar todos los equipos

`GET /equipos`

Tambien se puede filtrar por pais:

`GET /equipos?pais=Argentina`

### Ver un equipo por ID

`GET /equipos/1`

### Crear un equipo

`POST /equipos`

Ejemplo de JSON:

```json
{
  "nombre": "Boca Juniors",
  "pais": "Argentina",
  "estadio": "La Bombonera",
  "anio_fundacion": 1905,
  "copas_libertadores": 6,
  "director_tecnico": "Miguel Russo",
  "apodo_club": "Xeneize"
}
```

### Editar un equipo

`PUT /equipos/1`

Se envia el mismo formato de JSON que en el alta.

### Eliminar un equipo

`DELETE /equipos/1`

## Respuestas

La API devuelve JSON y usa codigos HTTP simples:

- `200`: todo salio bien.
- `201`: se creo un equipo.
- `400`: faltan datos o el JSON esta mal.
- `404`: no se encontro el recurso.
- `405`: el metodo no esta permitido.
