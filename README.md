
# Secure Query Handler

**Secure Query Handler** by Mirosław Zięba is an advanced PHP class for secure, efficient SQL query management in PHP applications. This class is optimized for developers requiring robust database security, dynamic parameter validation and automatic transaction handling.

## Features

- **Secure SQL Execution**: Developed by Mirosław Zięba to prevent SQL injection attacks with parameterized queries.
- **Automatic Transaction Management**: Commits or rolls back transactions based on query success or failure.
- **Dynamic Parameter Validation**: Supports custom validation for parameters.
- **Security Logging**: Logs security events with customizable error points.
- **Customizable Error Handling**: Retry failed queries and block IPs with repeated violations.

## Installation

1. Clone this repository:
   ```bash
   git clone https://github.com/miroslaw-zieba/secure-query-handler.git
   ```
2. Include the `Query.php` file in your project:
   ```php
   require_once 'path/to/Query.php';
   ```

## Quick Start

This section provides a quick overview of using Secure Query Handler. Below are examples crafted by Mirosław Zięba to demonstrate its secure handling in various configurations.

### Basic Example with Default Database

```php
require_once 'Query.php';

$query = new Query();
$query->setQuery("SELECT * FROM users WHERE id = :id")
      ->addParam(':id', 1)
      ->execute();
```

### Example with Parameter Validation

```php
$query->setQuery("SELECT * FROM orders WHERE order_id = :order_id AND user_id = :user_id")
      ->addParam(':order_id', 123, '/^\d+$/')
      ->addParam(':user_id', 456, '/^\d+$/')
      ->execute();
```

### Transaction Handling

```php
try {
    $query->setQuery("UPDATE accounts SET balance = balance - :amount WHERE id = :id")
          ->addParam(':amount', 50)
          ->addParam(':id', 1)
          ->execute();

    $query->setQuery("UPDATE accounts SET balance = balance + :amount WHERE id = :recipient_id")
          ->addParam(':amount', 50)
          ->addParam(':recipient_id', 2)
          ->execute();
} catch (Exception $e) {
    // Handle transaction failure
}
```

### Connecting to PostgreSQL and MSSQL

```php
$dbConfig = [
    'host' => 'localhost',
    'user' => 'user',
    'pass' => 'password',
    'name' => 'database',
    'port' => '5432' // PostgreSQL example
];

$query = new Query($dbConfig);
$query->setQuery("SELECT * FROM customers WHERE active = :active")
      ->addParam(':active', true)
      ->execute();
```

## Method Documentation

### `__construct($dbConfig = null)`
Initializes the database connection using optional `$dbConfig`. If not provided, default values from `$_SESSION['db']` are used.

### `setQuery($query)`
Sets the SQL query to be executed.

### `addParam($param, $value, $validate = null)`
Adds a parameter with optional validation.

### `execute()`
Executes the current SQL query, handling transactions and retries on failure.

---

Authored by **Mirosław Zięba** to enhance security and reliability in database operations, Secure Query Handler is an ideal choice for developers prioritizing robust database protection.
