
Para iniciar se debe inicializar con 
```
docker-compose up
```
Instalamos composer en el proyecto

```
docker-compose exec app composer install
```

Se tiene que correr las migraciones y los seeders , como lo tengo inicializado en l maqiona de ubuntu yo pongo el siguiente comando para que docker sepa que estoy en ese imagen

```
docker-compose exec app php artisan migrate
```

```
docker-compose exec app php artisan migrate --database=sqlite
```


inicializamos el server con el siguietne comando

```
docker-compose exec app php artisan serve --host 0.0.0.0 --port 8000
```

Para correr los test 

```
docker-compose exec app php artisan php artisan test
```

Rutas

## Atacar a un jugador

Este endpoint permite a un jugador atacar a otro jugador en el juego PvP.

- URL: `/api/v1/attack`
- Método: POST
- Parámetros de la solicitud:
  - `attackerId` (integer): El ID del jugador atacante.
  - `defenderId` (integer): El ID del jugador defensor.
  - `attackType` (string): El tipo de ataque. Valores posibles: `melee`, `ranged`, `ulti`.

### Ejemplo de solicitud

```http
POST /api/v1/attack
Content-Type: application/json

{
  "attacker_id": 1,
  "defender_id": 2,
  "attack_type": "melee"
}
```

## Equipar Item

Este endpoint permite a un jugador equipar un iteam.

- URL: `/api/v1/items/equip/{player_id}`
- Método: POST
- Parámetros de la solicitud:
  - `itemId` (integer): El ID del Item.

### Ejemplo de solicitud

```http
POST /api/v1/items/equip/1
Content-Type: application/json

{
  "itemId": 1
}
```

## Desequipar Item

Este endpoint permite a un jugador desequipar un iteam.

- URL: `/api/v1/items/unequip/{player_id}`
- Método: POST
- Parámetros de la solicitud:
  - `itemId` (integer): El ID del Item.

### Ejemplo de solicitud

```http
POST /api/v1/items/unequip/1
Content-Type: application/json

{
  "itemId": 1
}
```

## Agregar item al inventario

Este endpoint permite a un jugador agregar un item en el inventario.

- URL: `/api/v1/items/inventory/{player_id}`
- Método: POST
- Parámetros de la solicitud:
  - `itemId` (integer): El ID del Item.

### Ejemplo de solicitud

```http
POST /api/v1/items/inventory/1
Content-Type: application/json

{
  "itemId": 1
}
```

## Agregar nuevo jugador

Este endpoint permite el administrador podra crear un nuevo jugador.

- URL: `/api/v1/admin/players`
- Método: POST
- Parámetros de la solicitud:
  - `name` (string): Nombre del jugador.
  - `email` (string): Email del jugador.
  - `type` (string): El tipo del jugador. Valores posibles: `human`, `zombie`.

### Ejemplo de solicitud

```http
POST /api/v1/admin/players
Content-Type: application/json

{
  "itemId": "player_1",
  "itemId": "player@player.com",
  "itemId": "human"
}
```

## Agregar nuevo item

Este endpoint permite el administrador podra crear un nuevo item.

- URL: `/api/v1/admin/items`
- Método: POST
- Parámetros de la solicitud:
  - `name` (string): Nombre del item.
  - `type` (string): El tipo del item. Valores posibles: `boot`, `armor`, `weapon`.
   - `defense_points` (integer): cantidad de puntos de defensa.
   - `attack_points` (integer): cantidad de puntos de ataque.
### Ejemplo de solicitud

```http
POST /api/v1/admin/items
Content-Type: application/json

{
  "name": "Espada",
  "type": "weapon",
  "defense_points": 1,
  "attack_points": 10,
}
```

## Editar nuevo item

Este endpoint permite el administrador podra editar un item.

- URL: `/api/v1/admin/items/{itemId}`
- Método: PUT
- Parámetros de la solicitud:
  - `name` (string): Nombre del item.
  - `type` (string): El tipo del item. Valores posibles: `boot`, `armor`, `weapon`.
   - `defense_points` (integer): cantidad de puntos de defensa.
   - `attack_points` (integer): cantidad de puntos de ataque.
### Ejemplo de solicitud

```http
POST /api/v1/admin/items
Content-Type: application/json

{
  "name": "Espada",
  "type": "weapon",
  "defense_points": 1,
  "attack_points": 10,
}
```

## Obtener jugadores a que puedan lanzar una ulti

Este endpoint permite el administrador jugadores que pueden lanzar una ulti.

- URL: `/api/v1/admin/items/ultis`
- Método: GET
### Ejemplo de solicitud

```http
POST /api/v1/admin/ultis
Content-Type: application/json

{
}
```
