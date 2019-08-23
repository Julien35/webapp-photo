# WebAppPhoto

#### Vuejs / Symfony 4

### Prerequisites
* composer
* nodejs
* yarn

### Installation
* ```$ yarn``` for js dependency
* ```$ composer install``` for php dependency
* ```$ or php -d memory_limit=-1 composer.phar install, if memory problem```


### Development
Launch javascript server, symfony server
* ```$ yarn dev or dev-server-hot for HMR```
* ```$ bin/console server:run```
* ``` Add to .env : DATABASE_URL=sqlite:///%kernel.project_dir%/var/webphoto.db``` 
