<b>Technical Stack & Libraries</b>

For this project, the following stack was used:
PHP 7.4.18
Laravel 8
MySQL 5.7

The following libraries were added via composer:

nztim/mailchimp:
Laravel Wrapper for official PHP SDK of Mailchimp;

sendgrid/sendgrid:
Oficial PHP SDK for Sendgrid;


<b>Project Setup</b>

Clone project from github

Run “composer install” to install dependencies

Edit .env file to reflect database connections and API tokens for Mailchimp (MC_KEY) and Sendgrid (SENDGRID_KEY)

Run “php artisan migrate” to run migrations.


<b>Usage</b>

Use method GET in  “/contacts/sync” endpoint to run synchronization. 

IMPORTANT: An API key is needed for added security, since we do not want to trigger synchronization for random accesses.

API KEY: eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9
