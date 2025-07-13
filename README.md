# Contact Book

This project is a contact book application. The main goal is to create a functional address book that allows users to manage their contacts efficiently, featuring essential functionalities such as adding and searching contact information.

This application is designed to showcase skills in back-end development, integration with external APIs, and database management.

## Running with Docker

1. Install `Docker v28+`.

2. Clone the project:
```
git clone https://github.com/jaum1234/contact-book.git
```

3. Create the .env file from the .env.example file:
```
cp .env.example .env
```

4. Setup the database environment variables in the .env file:
  - `DB_ROOT_PASSWORD`: The root password for the MySQL database.
  - `DB_DATABASE`: The name of the database to be created.
  - `DB_USERNAME`: The username for accessing the database. Since the root user is used, this can be set to `root`.
  - `DB_PASSWORD`: The password for the database user. Must be the same as `DB_ROOT_PASSWORD`.
  - `DB_HOST`: The hostname of the database service, which is `db` in this case.
  - `DB_PORT`: The port on which the database service is running, typically `3306` for MySQL.
  - `DB_CONNECTION`: The type of database connection, which is `mysql` for this project.

5. Build and run the Docker containers:
```
docker compose up -d --build
```

6. Clear the config:
```
docker compose exec app php artisan config:clear
```

7. Run the migrations:
```
docker compose exec app php artisan migrate
```

8. Generate the app key:
```
docker compose exec app php artisan key:generate
```

## Running Unit Tests

1. Start the containers, if not already running:
```
docker compose up -d
```

2. Run the tests:
```
docker compose exec app php artisan test
```

## System Design

Usually, I would organize the project by bounded contexts, following DDD practices. Each context would encapsulate a specific subdomain. So for example, I could have two bounded contexts: the `contact` context and the `address` context. If any authentication functionality was implemented, I could create an `iam` context.

However, since laravel already has a very opinionated and layered structure, and time is short, I decided to stick to the default structure.