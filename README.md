To samo, a nawet więcej: https://github.com/mieszkou/docker-lamp


# docker-lamp z MSSQL

Apache + PHP + MSSQL

Przygotowane w oparciu o:

- https://www.bornfight.com/blog/blog-lamp-docker-setup-with-php-8-and-mariadb-for-symfony-projects/
- https://mariadb.com/kb/en/setting-up-a-lamp-stack-with-docker-compose/
- https://www.section.io/engineering-education/dockerized-php-apache-and-mysql-container-development-environment/
- https://citizix.com/how-to-run-mssql-server-2019-with-docker-and-docker-compose/
- https://stackoverflow.com/questions/51933001/install-configure-sql-server-pdo-driver-for-php-docker-image
- https://stackoverflow.com/questions/68824347/unable-to-get-php-working-with-sql-server-in-docker-container (xdebug ??)
- moje poprawki

## Założenia

- Konfiguracja w pliki `.env`
- Kod w folderze `www`
- W oparciu o numer portu applikacji `APP_PORT=5000` są generowane porty (przekierowania) dla phpMyAdmin (`APP_DB_ADMIN_PORT=15000`) i MariaDB (`DB_PORT=35000`). Dlatego port aplikacji nie może przekraczać 9999.

## Uruchamianie

```
docker compose build
docker compose up
```
