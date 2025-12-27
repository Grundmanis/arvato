This project is fully wrapped in Lando, so you only need Docker and Lando installed.

Prerequisites

Docker
https://www.docker.com/get-started

Lando
https://docs.lando.dev/getting-started/installation.html


Start the project:
1. `lando start`

2. `cd backend`

3. Install packages
`lando composer install`

4. Run migration
`lando php bin/console doctrine:migrations:migrate`

5. Run the fixtures to seed the datbase with test data:
(It will create products with image, product reviews, api user for requests)
`lando php bin/console doctrine:fixtures:load`


Run backend test:
`lando php bin/phpunit`


Api docs:
Open: http://arvato.lndo.site/api/docs 

Use login_check request:
```
username: api@local.test
password: secret
```

PHP CS FIXER:
To check the code:
`lando php ./vendor/bin/php-cs-fixer check`

To fix the code:
`lando php ./vendor/bin/php-cs-fixer fix`

Static analysis / type checking:
`lando php vendor/bin/phpstan analyse src --level 5`

Frontend (cd frontend)
To lint:
`lando npm run lint`

To fix linting:
`lando npm run lint:fix`

To check formatting:
`lando npm run format`

To fix formatting:
`lando npm run format:fix`