# Contact Book

This project is a contact book application. The main goal is to create a functional address book that allows users to manage their contacts efficiently, featuring essential functionalities such as adding and searching contact information.

This application is designed to showcase skills in back-end development, integration with external APIs, and database management.

## System Design

Usually, I would organize the project by bounded contexts, following DDD practices. Each context would encapsulate a specific subdomain. So for example, I could have two bounded contexts: the `contact` context and the `address` context. If any authentication functionality was implemented, I could create an `iam` context.

However, since laravel already has a very opinionated and layered structure, and time is short, I decided to stick to the default structure.