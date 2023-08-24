# Online Shop with Backend and Frontend

This guide will walk you through setting up the  project on your local development environment.

## Prerequisites

Before you start, make sure you have the following installed:

- PHP
- Composer
- MySQL
- Laravel CLI
- Laravel Valet (optional for easy setup)

## Step 1: Clone the repository

Clone the project repository to your local machine:

```bash
git clone https://github.com/chrisdeuda/sevron-online-shop-exam.git
```
or using ssh

```bash
git clone git@github.com:chrisdeuda/sevron-online-shop-exam.git
```

## Step 2: Install dependencies

cd sevron-online-shop-exam
composer install


Step 3: Configure environment variables
Duplicate the .env.example file and rename it to .env:


Then, open the .env file and update the database connection settings:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 4: Generate application key

`php artisan key:generate`

## Setting up the Database


Before you can run the migrations and seeders, you will need to create a new MySQL database for the project.

Here's how you can do this:

1. Open your terminal.

2. Log in to the MySQL shell with the following command:

   ```bash
   mysql -u root -p
   ```

You'll be prompted to enter the password for the root user. If your MySQL server has a different setup, replace root with your MySQL username.

#### 1. At the MySQL prompt, create a new database with the following command:


```CREATE DATABASE zap_map;```

This command creates a new database named zap_map. You can replace zap_map with the name you want to use for your database.

#### 2. To confirm that the database was created successfully, use the following command:


```SHOW DATABASES;```

You should see zap_map (or the name you chose for your database) in the list of databases.

Remember to update the .env file in your Laravel project with the name of your new database, as well as the username and password for your MySQL server.



### Step 5: Run the migrations and seeders

```
php artisan migrate --seed
```

### Step 6: Start the server

You should now be able to access the API at http://localhost:8000/api/

```
php artisan serve
```

Step 4: Compile Front-end Assets

```
npm install
npm run dev
```
# API Documentations

// Insert documentations


Extra features
## For the SPA with Vue.JS
I like using the Laravel-Inertia.js-Vue.js stack because it makes building web apps easier and faster. With this setup, I can make single-page apps without having to make separate APIs. This is a big help, especially when I'm short on time for tasks like take-home tests.

Inertia.js makes the hard parts of building single-page apps much simpler. Vue.js helps me organize my frontend code, making it easier to manage and grow. Laravel takes care of the backend stuff like linking pages and getting data, so everything works together smoothly.

Using all these tools together speeds up my work, makes it easier to keep things running well, and helps create a better experience for users. Overall, it gives me a single, easy-to-use way to build modern web apps.

But it might not be 100% suitable if the projects get's bigger.

Quick demo of the functionality:
* https://www.loom.com/share/d080ae17fde4459ba53df38a17be7ec5

## Didn't be able to do this following

* Use Laravel's queue system to handle background processing tasks, such as sending confirmation emails to customers.
* Implement a search feature that allows users to search for products by name or description.
* Implement pagination for product and order listings.
* Use Laravel's caching system to improve performance.

Because I mostly implemented the backend functionality on the SPA and got only limited time to do some of this. But I make sure that all of the basic functionality was well integrated on the frontend.



## Future Backlogs 
- [] Fix the csrf for the api request currently every url 
- [ ]Add restriction to guest and admin
- [ ] API
  - Complete the order list
  - Add CRUD to Order List in the admin
