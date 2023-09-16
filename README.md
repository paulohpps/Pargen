# Comandos 

### Criar um usuario
```
php artisan usuario:create
```
### Criar um usuario como administrador 
```
php artisan usuario:create --admin
```
### Tornar um usuario administrador
```
php artisan usuario:admin
```
### Para deploy
```
composer install && npm i && npm run build && php artisan migrate
```
### Sincronizar OnTrace
```
php artisan update:database
```
### Atualizar Status Fatura
```
php artisan atualizar:faturas
```
