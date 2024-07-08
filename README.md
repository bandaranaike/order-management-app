
# Laravel Order Processing API

This project demonstrates a simple Laravel application with a REST API endpoint to process new orders, using Laravel Sanctum for authentication.

## Requirements

- PHP ^8.2
- Laravel Framework ^11.9
- Laravel Sanctum ^4.0
- MySQL or any other database supported by Laravel

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/bandaranaike/order-management-app.git
   ```

2. Navigate to the project directory:
   ```bash
   cd order-management-app
   ```

3. Install the dependencies:
   ```bash
   composer install
   ```

4. Create a `.env` file and configure your database connection and other environment variables:
   ```bash
   cp .env.example .env
   ```

5. Generate the application key:
   ```bash
   php artisan key:generate
   ```

6. Run the database migrations:
   ```bash
   php artisan migrate
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

## API Endpoints

- **Create Order**: `POST /api/order`
    - Parameters:
        - `customer_name`: string, required
        - `order_value`: numeric, required
    - Authentication: Bearer Token

## Running Tests

To run the tests, use the following command:
```bash
php artisan test
```


## Home Page Form

The home page contains a simple form to input order details, store them in IndexedDB and showing in a table. Below is the HTML and JavaScript code for the form
