# An Api Backend for a simple Blog App

# Laravel Blog API

This is a simple blogging platform built with Laravel, where users can register, log in, create, edit, and delete blog posts.

I switched Repos Midway through due to a hosting test. Old Repo: https://github.com/highb33kay/blogapi

## Getting Started

Follow the instructions below to set up and run the Laravel Blog API on your local machine.

### Prerequisites

Make sure you have the following installed on your machine:

-   PHP
-   Composer
-   MySQL

### Installation

1. Clone the repository:

    ```bash
    git clone <repository-url>
    ```

2. Navigate into the cloned repository folder and install the application dependencies by running:

    ```bash
    composer install
    ```

3. Create a `.env` file by copying the sample env file `.env.example`:

    ```bash
    cp .env.example .env
    ```

4. In the `.env` file, add your database credentials:

    ```bash
    DB_CONNECTION=mysql
    DB_HOST=your-database-host
    DB_PORT=your-database-port
    DB_DATABASE=your-database-name
    DB_USERNAME=your-database-username
    DB_PASSWORD=your-database-password
    ```

5. Generate a new application key:

    ```bash
    php artisan key:generate
    ```

6. Run the database migrations to create the required tables:

    ```bash
    php artisan migrate
    ```

7. Start the application by running:

    ```bash
       php artisan serve
    ```

8. Access the application at `http://localhost:8000`

## Design Decisions

### API Structure

The Laravel Blog API follows a RESTful architecture to provide a clear and standardized way for clients to interact with the server. The API uses conventional HTTP methods (GET, POST, PUT, DELETE) to perform CRUD operations on resources.

### Authentication

The API uses Laravel Sanctum for authentication. Sanctum provides a simple and convenient way to issue API tokens to users, securing endpoints that require authentication. By using tokens, we ensure secure communication between the client and the server.

### Database Structure

#### Users Table

The 'users' table stores user information, including a unique UUID identifier, name, email, password, role and timestamps. UUIDs are used as primary keys to enhance security and prevent enumeration attacks. All passwords are hashed and protected. Roles include, Admin and User. 

#### Posts Table

The 'posts' table stores blog posts, utilizing a UUID identifier as the primary key. Each post is associated with a user through a foreign key relationship. This ensures that each post is tied to a specific user.

### API Endpoints

#### Registration and Login

The registration and login endpoints follow industry-standard practices. Users register by providing a name, email, password, and an optional role for Admin Signups. Authentication is achieved through the issuance of Bearer tokens, which are included in subsequent requests.

#### Post Creation and Retrieval

Creating a post requires a user to be authenticated. Each post is associated with the authenticated user, ensuring that posts are linked to their respective creators.

#### Post Updating and Deletion

A created post can be deleted or updated by passing the UUID identifier to the controller. A user can only delete or update a post that is linked to them. An Admin can delete or update all posts regardless of ownership.

### Error Handling

The API returns clear and consistent error responses to assist developers in troubleshooting. HTTP status codes and meaningful error messages are provided to indicate the success or failure of a request.

### API Endpoints

| Endpoint | Functionality |

| ----------------------------- | ------------------------ |

| POST /api/register | Register a user |

| POST /api/login | Login a user |

| GET /api/posts | Fetch all posts |

| GET /api/posts/{id} | Fetch a single post |

| POST /api/posts | Create a new post |

| PUT /api/posts/{id} | Update a post |

| DELETE /api/posts/{id} | Delete a post |

## API Documentation

The API documentation is available at `https://documenter.getpostman.com/view/28437007/2s9YkkehxB`

## Built With

-   [Laravel](https://laravel.com/) - The PHP Framework For Web Artisans
-   [MySQL](https://www.mysql.com/) - Open-Source Relational Database Management System

## Authors

-   **Ibukun Alesinloye** - _Initial work_ - [IbukunAlesinloye](http://github.com/highb33kay)
