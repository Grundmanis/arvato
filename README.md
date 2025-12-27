This project is fully wrapped in Lando, so you only need Docker and Lando installed.

Prerequisites

Docker
https://www.docker.com/get-started

Lando
https://docs.lando.dev/getting-started/installation.html


Start the project:
1. lando start

2. cd backend

3. Install packages

lando composer install
4. Run migration
lando php bin/console doctrine:migrations:migrate

5. Run the fixtures to seed the datbase with test data:
(It will create products with image, product reviews, api user for requests)
lando php bin/console doctrine:fixtures:load


Run backend test:
lando php bin/phpunit


Api docs:
Open: http://arvato.lndo.site/api/docs 

Use login_check request:
username: api@local.test
password: secret

PHP CS FIXER:
To check the code:
lando php ./vendor/bin/php-cs-fixer check

To fix the code:
lando php ./vendor/bin/php-cs-fixer fix

Static analysis / type checking:
lando php vendor/bin/phpstan analyse src --level 5

Frontend (cd frontend)
To lint:
lando npm run lint

To fix linting:
lando npm run lint:fix

To check formatting:
lando npm run format

To fix formatting:
lando npm run format:fix
 

Back-end
1. DONE - Create Symfony application (use LTS version)
2. DONE - Setup Docker or Lando (as a bonus);
3. DONE - Install SonataAdminBundle with ORM (no admin login required);
4. DONE - Create “Product” entity with all needed fields for the front-end, plus the following:
a. DONE - createdAt (datetime)
b. DONE - updatedAt (datetime)
5. DONE - Implement Doctrine lifecycle callbacks for the “Product” entity to populate createdAt
and updatedAt fields;
6. DONE - Create Sonata admin section to manage “Product” entity (CRUD):
a. DONE - List with all relevant fields;
b. CHECK DONE Filters for all relevant fields;
c. NOT_DONE Utilize translations for labels in columns/filters on list view and for field labels
in create/update view
7. DONE - Create “ProductReview” entity with all needed fields for the front-end, plus the
following:
a. DONE - product (ManyToOne relation);
8. DONE - Same as #6, but for “ProductReview” entity:
a. DONE - Product field should be read-only.
9. DONE - Install API Platform;
10. DONE - Create API endpoints for “Product” and “ProductReview” entities:
a. DONE - GET collection
b. DONE - GET single
c. DONE - POST
d. DONE - PUT
e. DONE - PATCH
f. DONE - DELETE
DONE - Use modern front-end technologies (e.g., HTML, CSS, and JavaScript or a framework of your
choice such as React).
DONE - Data should be fetched from back-end API (#10 from Back-end part).
DONE - For now, as product image use whatever you want. 
DONE - In your task React and Typescript are mandatory requirement.
Some things that we will pay attention:
DONE - ● State management
DONE - ● List rendering
CHECK -  Form handling
DONE - ● Linting + formatting
    PARTIALLY DONE - transitions, 
    DONE - table sorting (without URLS), 
    DONE - filter sorting,
    DONE - browser history handling, 
    NOT DONE - tests
● NOT DONE - Deliverables
● NOT DONE - Deployed front end project, that can be firstly seen by persons without possibility to run
your code.
● DONE - Access to repository where project is hosted.

Before finishing
DONE - Create a public Git repository, commit your code there and share a link.




TODO left:
b. CHECK DONE Filters for all relevant fields;
c. NOT_DONE Utilize translations for labels in columns/filters on list view and for field labels
in create/update view
NOT DONE Form handling
NOT DONE - tests
● NOT DONE - Deliverables
● NOT DONE - Deployed front end project, that can be firstly seen by persons without possibility to 
NOT DONE - add redis on lando config
pagination URL
perPage URL
error handling in api requests
price as string should be passed 
no products found FLASH OF CONTENT

        image upload in admin
        show image in product show
        sort and filters to next URL 
        login check 