## Challenge two:

### Summary:

Help! a bunch of customers can't log in to our site! We need you to figure out why and fix it ASAP!

These customers also need a bunch of univeristy data from an API.

### Task:

For this task, you will need to look beyond the code and see what is stopping people from logging in to the site. Fix it so that everyone is able to log in with the same email and password they are currently using and, if you have time, suggest some improvements to the code logic. 

Secondly, can you consume an API and commit data to the database?
Using an Object Oriented approach, return and parse the list of all universities in Canada and the US.
Store the information in a MySQL database using best practice for table normalization. Please include the schema.

Present the list of universities and highlight the one that have more multiple domains.
Make the presentation of this data to be clean and have some styling.

### Requirements:

- PHP 7+
- Mysql 8+
- The API: `http://universities.hipolabs.com/`
- The API Docs: `https://github.com/Hipo/university-domains-list-api`

### Setup:

- Ensure all dependencies are installed. E.g: `php-mysql`.
- import the provided SQL dump file located in the `database` directory.
- Setup PDO data for mysql host, username and password in `actions/login.php` script.
- Use credentials to attempt to login: `ahuillet@hotmail.com , Blackburn`.
- Start debugging!
