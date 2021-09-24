# Pontue-challenge

## Comandos pra projeto funcionar

### Copiar .env.example para .env

```sh
$ cp .env.example .env
```

### Se for preciso fazer configurações de permissões do diretório storage/bootsrap

```sh
$ sudo chown -R root:www-data /diretório_do_projeto
$ sudo find /diretório_do_projeto -type f -exec chmod 664 {} \;
$ sudo find /diretório_do_projeto -type d -exec chmod 775 {} \;
$ sudo chgrp -R www-data storage bootstrap/cache
$ sudo chmod -R ug+rwx storage bootstrap/cache
```

### Coloca pra buildar e rodar o docker

```sh
$ docker-compose up -d --build
```

### É preciso gerar a key do projeto

```sh
$ docker-compose exec app php artisan key:generate
```

### Popular o db com alguns dados

```sh
$ docker-compose exec app php artisan db:seed
```

### Gera a chave secreta do jwt

```sh
$ docker-compose exec app php artisan jwt:secret
```
