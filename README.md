# Contact Book

Table of Contents
- [Overview](#overview)
- [Running with Docker](#running-with-docker)
- [Running Unit Tests](#running-unit-tests)
- [System Design](#system-design)
- [Development Process](#development-process)

## Overview

This project is a contact book application. The main goal is to create a functional address book that allows users to manage their contacts efficiently, featuring essential functionalities such as adding and searching contact information.

This application is designed to showcase skills in back-end development, integration with external APIs, and database management.

## Running with Docker

1. Install `Docker v28+`.

2. Clone the project:
```
git clone https://github.com/jaum1234/contact-book.git
cd contact-book
```

3. Create the .env file from the .env.example file:
```
cp .env.example .env
```

4. Setup the app and database environment variables in the .env file:
  - `APP_DEBUG`: Set to `false` for production.
  - `DB_ROOT_PASSWORD`: The root password for the MySQL database.
  - `DB_DATABASE`: The name of the database to be created.
  - `DB_USERNAME`: The username for accessing the database. Since the root user is used, this can be set to `root`.
  - `DB_PASSWORD`: The password for the database user. Must be the same as `DB_ROOT_PASSWORD`.
  - `DB_HOST`: The hostname of the database service, which is `db` in this case.
  - `DB_PORT`: The port on which the database service is running, typically `3306` for MySQL.
  - `DB_CONNECTION`: The type of database connection, which is `mysql` for this project.

5. Create the .env.testing file from the .env.testing.example file:
```
cp .env.testing.example .env.testing
```

6. Setup the testing database environment variables in the .env.testing file:
  - `DB_DATABASE`: The name of the testing database to be created. Should use the in memory SQLite database for testing.
  - `DB_CONNECTION`: The type of database connection, which is `sqlite` for this project.

7. Build and run the Docker containers:
```
docker compose up -d --build
```

8. Clear the config:
```
docker compose exec app php artisan config:clear
```

9. Run the migrations:
```
docker compose exec app php artisan migrate
```

10. Generate the app key:
```
docker compose exec app php artisan key:generate
```

That's it! The application should now be running. You can access it at `http://localhost:8000`.

## Running Unit Tests

1. Start the containers, if not already running:
```
docker compose up -d
```

2. Run the tests:
```
docker compose exec app php artisan test --testsuite=Feature
```

## System Design

Usually, I would organize the project by bounded contexts, following DDD practices. Each context would encapsulate a specific subdomain. For that project, I would create the `Contact Management` context, which would include the `Contact` aggregate, composed of its attributes and the `Address` value object, the `ContactController`, responsible for handling HTTP requests related to contacts, and the `ContactService`, which would contain the business logic for managing contacts.

If I were to extend the project, I would create the `IAM` context, which would contain the `User` aggregate, responsible for managing the user authentication and authorization.

However, since laravel already has a very opinionated and layered structure, and time is short, I decided to stick to the default structure. Classes like the `ContactController` and `ContactService` are still present, but they are not organized by bounded contexts. Instead, they are placed in the `app/Http/Controllers` and `app/Services` directories, respectively.

## Development Proccess

The development process for this project was as follows:

1. **Task Breakdown**: The project was divided into smaller tasks, such as implementing the contact management features, writing the API documentation, setting up the Docker environment and etc. Each task was represented as a GitHub issue.
2. **Feature Branches**: Each task was developed in a separate feature branch, following the naming convention `feat/<task-name>`. This allowed for easier code reviews and organization.
3. **Unit Tests**: Feature tests were written for each feature, ensuring that the code was tested and working as expected. The tests were placed in the `tests/Feature` directory. Since there ware no complex business logic, I opted for feature tests instead of unit tests.
4. **Pull Requests**: Once a feature was completed, a pull request was created to merge the feature branch into the `master` branch.