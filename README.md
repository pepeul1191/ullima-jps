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

## Dump de datos de una tabla sqlite3

sqlite> .mode insert new_table
sqlite> select * from tbl1;

---

Fuentes:

+ https://github.com/pepeul1191/coa-slim
+ https://github.com/Kong/unirest-php
+ https://stackoverflow.com/questions/41232178/is-the-output-of-sqlite-in-mode-insert-correct
+ https://github.com/pepeul1191/cipher-php
