## Webservice
### Iniciando servidor
instalar pacotes
```bash
composer install && php artisan key:generate
```

- configurar banco de dados no arquivo [.env](.env)
```bash
...
DB_DATABASE=before
DB_USERNAME=root
DB_PASSWORD=root
...
```

- criar servidor local
``´bash
pgp artisan serve
```

- criar tabelas e adcinar dados ao banco
```bash
php artisan migrate --seed
``` 
#### Configurações
- duração de token de autenticação = 1 dia  
- banco de dados 
  - uso de softdeletes  
  - versinaomaneto usando migrations
    
