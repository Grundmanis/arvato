Your task is to create a product detail page for our online product shop based on the provided
design. In addition to showcasing detailed product information, the page must enable users to
switch between table and grid views for certain product information and apply filters to the
product list or reviews.
Design mockups
https://www.figma.com/design/uGSeEMoJWMC3sSQD7ICBce/Interview-Task?node-id=0-
1&p=f
Ensure that the UI closely follows the provided design mockups!
Back-end
1. DONE - Create Symfony application (use LTS version)
2. PARTIALLY DONE - Setup Docker or Lando (as a bonus);
3. DONE - Install SonataAdminBundle with ORM (no admin login required);
4. EXCEPT IMAGE DONE Create “Product” entity with all needed fields for the front-end, plus the following:
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
c. CHECK DONE - POST
d. CHECK DONE - PUT
e. CHECK DONE - PATCH
f. CHECK DONE - DELETE
Front-end
DONE - Use modern front-end technologies (e.g., HTML, CSS, and JavaScript or a framework of your
choice such as React).
DONE - Data should be fetched from back-end API (#10 from Back-end part).
PARTIALLY DONE - For now, as product image use whatever you want. 
DONE - In your task React and Typescript are mandatory requirement.
Some things that we will pay attention:
DONE - ● State management
DONE - ● List rendering
?? ● Form handling
CHECK DONE - ● Linting + formatting
● Bonus (
    PARTIALLY DONE - transitions, 
    NOT DONE - table sorting, 
    DONE - filter sorting,
    DONE - browser history handling, 
    NOT DONE - tests
    )
● NOT DONE - Deliverables
● NOT DONE - Deployed front end project, that can be firstly seen by persons without possibility to run
your code.
● NOT DONE - Access to repository where project is hosted.

Before finishing
NOT DONE - Create a public Git repository, commit your code there and share a link.

TODO left:
2. PARTIALLY DONE - Setup Docker or Lando (as a bonus);
4. EXCEPT IMAGE DONE Create “Product” entity with all needed fields for the front-end, plus the following:
b. CHECK DONE Filters for all relevant fields;
c. NOT_DONE Utilize translations for labels in columns/filters on list view and for field labels
in create/update view
c. CHECK DONE - POST
d. CHECK DONE - PUT
e. CHECK DONE - PATCH
f. CHECK DONE - DELETE
PARTIALLY DONE - For now, as product image use whatever you want. 
?? ● Form handling
CHECK DONE - ● Linting + formatting
    NOT DONE - table sorting, 
NOT DONE - tests
● NOT DONE - Deliverables
● NOT DONE - Deployed front end project, that can be firstly seen by persons without possibility to 
● NOT DONE - Access to repository where project is hosted.
NOT DONE - Create a public Git repository, commit your code there and share a link.
