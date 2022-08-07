# A Maker-Checker API for Glover

## Project Overview
This project was written using PHP (Laravel).

## Project setup
The project follows the regular Laravel pattern in its setup. 

Run `composer install` to install dependencies. 

This uses Sanctum for authentication. 

### Seeding the database
 To run tests simply run the command `php artisan db:seed`.

 This will create two admin accounts for you to test with. Their login details are written below

 - email: ``admin_one@mail.com``, password: ``password``

- email: ``admin_two@mail.com``, password: ``password``


10 dummy users will be created which can be used to test the ``update`` and ``delete`` endpoints.

 ### Running Tests
 To run tests simply run the command `composer test`


## Constraints
This code did not take into consideration the size of the DB. As a result, no pagination was done in the responses. 

No admin middleware was set up because this code as built be used only by admins.

Queues were not used in order to prevent issues that might arise as a result of setting up queues and running jobs on queues. 

It also uses soft deletes for deleting data.
