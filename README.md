
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
  - `attacker_id` (integer): El ID del jugador atacante.
  - `defender_id` (integer): El ID del jugador defensor.
  - `attack_type` (string): El tipo de ataque. Valores posibles: `melee`, `ranged`, `ulti`.

### Ejemplo de solicitud

```http
POST /api/v1/attack
Content-Type: application/json

{
  "attacker_id": 1,
  "defender_id": 2,
  "attack_type": "melee"
}
