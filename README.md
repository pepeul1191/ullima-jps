# Slim PHP Boilerplate

Instalar depdendencias:

    $ composer install

Refrescar composer:

    $ composer dump-autoload -o

Basado en Slim Framework 3 Skeleton Application

### Migraciones

Migraciones con DBMATE - app:

    $ dbmate -d "db/migrations" -e "DB" new <<nombre_de_migracion>>
    $ dbmate -d "db/migrations" -e "DB" up
    $ dbmate -d "db/migrations" -e "DB" new <<nombre_de_migracion>>
    $ dbmate -d "db/migrations" -e "DB" up
    $ dbmate -d "db/migrations" -e "DB" rollback

## Correr test de carga

Cambiar en 'src/configs/settings.php' el valor de llave 'ambiente_csrf' y 'ambiente_session' a 'inactivo' .

---

Fuentes:

+ https://github.com/pepeul1191/coa-slim
+ https://github.com/Kong/unirest-php