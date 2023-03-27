# Apuntes PHP REST API

Proyecto realizado con fines didácticos, con el propósito de comprender la
creación y funcionamiento de una API básica utilizando **Php** y **Apache**.
Además de servir de introducción los mismos.

Las clases, metodos y funciones creadas dentro de este proyecto cumplen este
propósito. No estan diseñadas para correr en un entorno de producción.

### Requerimientos

[MariaDB](https://mariadb.com/docs/), [Apache](https://httpd.apache.org/docs/)
y [PHP](https://www.php.net/docs.php). Opcional
[PhpMyAdmin](https://docs.phpmyadmin.net/en/latest/)

```sh
sudo apt install mariadb-server apache2 php-mysql python3-mysqldb php php-cli \
         php-curl php-gd php-json php-mbstring php-mysql php-zip

# opcional
sudo apt install phpmyadmin
```

```sh
sudo systemctl enable mysql
```

### Configuracion Apache2

#### Agregar user a www-data

```sh
sudo usermod -a -G www-data $USER
```

#### Crear regla

Ejemplo usando symlink `html` a `$HOME/projects/apirest` en vez de usar el
directorio `/var/www/html`.

```sh
cd /var/www/
sudo ln -s $HOME/projects/apirest html
```

Editar archivo de configuración de apache `sudoedit /etc/apache2/apache2.conf`

Agregar:

```apache
<Directory /var/www/>
    Options Indexes FollowSymLinks
    AllowOverride All 
    Require all granted
</Directory>

# Para usar phpmyadmin, agregar al final
Include /etc/phpmyadmin/apache.conf
```

#### Activar modulo rewrite

Para usar `.htaccess` específico del proyecto.

```sh
sudo a2enmod rewrite
sudo systemctl restart apache2
```

> ¿Como mostrar errores en php? [stackoverflow](https://stackoverflow.com/questions/1053424/how-do-i-get-php-errors-to-display).

Agregar la sgte. linea en archivo [.htaccess](./apirest_yt/.htaccess)

```apache
php_flag display_errors 1
```

O modifcar el/los parametro(s) en `/etc/php/8.1/php.ini`

```apache
error_reporting = E_ALL
display_errors = On
```

#### Extension RESTED para Firefox

![img](./imgs/firefox_rested_extension.png)

----

## Inicio del proyecto

Crear y poblar base de datos, según [archivo sql](./original/database/apirest.sql)
en `./original/database/apirest.sql`.

Crear archivo de configuración en la ruta `./<projecto>/clases/conexion/config`.

```json
{
    "conexion":{
        "server" : "127.0.0.1",
        "user" : "<USER>",
        "password" : "<PASWORD>",
        "database" : "apirest",
        "port" : "3306"
    }
}
```

#### Creación de token

Combinación de 2 funciones de *php* para generar un *token* único en [archivo](./apirest_yt/clases/auth.class.php)
`<proyecto>/clases/auth.class.php`.

- Función [bin2hex](https://www.php.net/manual/en/function.bin2hex.php) devuelve
un *string hexadecimal*.
- Función [openssl_random_pseudo_bytes](https://www.php.net/manual/en/function.openssl-random-pseudo-bytes.php).

> [Metodos HTTP](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods)

#### Desactivar tokens

Cron Job para cambiar estado de tokens a ***Inactivo***

Agregar tarea: `crontab -e`

ej. Ejecutar tarea cada 5 minutos.

```sh
# m h  dom mon dow   command
*/5 *   *   *   *    curl localhost/php_apirest/apirest_yt/cron/actualizar_tokens &>/dev/null
```
