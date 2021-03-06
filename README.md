<b>Overview</b>

System that synchronizes contact information (email, first name and last name) from Mailchimp to Sendgrid.


<b>Important links</b>

Technical Design:<br>
https://docs.google.com/document/d/13MlQGukTIWQB6jSHmWITzd_F9qEkJxlcrZt7AdorI4A/edit?usp=sharing
<br><br>
Demo Link: (Use Key below on endpoint)<br>
https://trio-mailchimp-sync.herokuapp.com/
<br><br>
Explanation Video Part 1:<br>
https://docs.google.com/document/d/13MlQGukTIWQB6jSHmWITzd_F9qEkJxlcrZt7AdorI4A/edit
<br><br>
Explanation Video Part 2:<br>
https://drive.google.com/file/d/1DOivFFdfebkr9It3MgBGQHvP0pms881o/view
<br>

<b>Technical Stack & Libraries</b>

For this project, the following stack was used:<br>
PHP 7.4.18<br>
Laravel 8<br>
MySQL 5.7<br>

The following libraries were added via composer:

nztim/mailchimp:
Laravel Wrapper for official PHP SDK of Mailchimp;

sendgrid/sendgrid:
Oficial PHP SDK for Sendgrid;


<b>Project Setup - Deploy locally</b>

Clone project from github

Run “composer install” to install dependencies

Edit .env example to .env only and to reflect database connections and API tokens for Mailchimp (MC_KEY) and Sendgrid (SENDGRID_KEY)

Run “php artisan migrate” to run migrations.


<b>Usage</b>

Use method GET in  “/contacts/sync” endpoint to run synchronization. 

IMPORTANT: An API key is needed for added security, since we do not want to trigger synchronization for random accesses.

API KEY: <b>eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9</b>
