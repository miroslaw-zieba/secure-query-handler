
# Secure Query Handler by Mirosław Zięba

**Secure Query Handler** is an advanced PHP class by Mirosław Zięba, designed for secure and efficient SQL query management in PHP applications. This class supports multiple databases, parameterized queries, and automatic transaction handling, and is ideal for developers who prioritize robust database security and dynamic query execution.

## Features
- **Secure SQL Execution**: Prevents SQL injection with parameterized queries.
- **Automatic Transaction Management**: Commits or rolls back transactions based on success or failure.
- **Dynamic Parameter Validation**: Supports custom regex validation.
- **Security Logging**: Logs events with error points and customizable alerts.
- **Multi-Database Support**: Easily connects to MySQL (default), PostgreSQL, and MSSQL.

## Installation
1. Clone this repository:
   ```bash
   git clone https://github.com/miroslaw-zieba/secure-query-handler.git
   ```
2. Include the `Query.php` file in your project:
   ```php
   require_once 'path/to/Query.php';
   ```

## Quick Start Examples

### 1. Basic Example with Default Database (MySQL)
```php
require_once 'Query.php';

$query = new Query();  // Uses default session-stored database credentials
$query->setQuery("SELECT * FROM users WHERE id = :id")
      ->addParam(':id', 1, '/^\d+$/')
      ->execute();
```

### 2. Example with Custom Database Configuration and Regex Validation for Parameters
```php
$dbConfig = [
    'host' => 'localhost',
    'user' => 'custom_user',
    'pass' => 'custom_pass',
    'name' => 'custom_database',
    'port' => '3306'
];

$query = new Query($dbConfig);
$query->setQuery("INSERT INTO users (username, email, age, id) VALUES (:username, :email, :age, :id)")
      ->addParam(':username', 'johndoe', '/^[a-zA-Z0-9_]{3,20}$/')
      ->addParam(':email', 'john@example.com', '/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,6}$/')
      ->addParam(':age', 29, '/^\d{1,3}$/')
      ->addParam(':id', 101, '/^\d+$/')
      ->execute();
```

### 3. Transactional Example
```php
$query = new Query();
$query->setQuery("UPDATE accounts SET balance = balance - :amount WHERE id = :id")
      ->addParam(':id', 1, '/^\d+$/')
      ->addParam(':amount', 500, '/^\d+(\.\d{1,2})?$/')
      ->execute();

$query->setQuery("UPDATE accounts SET balance = balance + :amount WHERE id = :recipient_id")
      ->addParam(':recipient_id', 2, '/^\d+$/')
      ->addParam(':amount', 500, '/^\d+(\.\d{1,2})?$/')
      ->execute();
```

### 4. Example with PostgreSQL
```php
$dbConfig = [
    'host' => 'localhost',
    'user' => 'postgres_user',
    'pass' => 'postgres_pass',
    'name' => 'postgres_database',
    'port' => '5432',
    'driver' => 'pgsql'
];

$query = new Query($dbConfig);
$query->setQuery("SELECT * FROM users WHERE id = :id")
      ->addParam(':id', 123, '/^\d+$/')
      ->execute();
```

### 5. Example with MSSQL
```php
$dbConfig = [
    'host' => 'localhost',
    'user' => 'mssql_user',
    'pass' => 'mssql_pass',
    'name' => 'mssql_database',
    'port' => '1433',
    'driver' => 'sqlsrv'
];

$query = new Query($dbConfig);
$query->setQuery("SELECT * FROM employees WHERE employee_id = :employee_id")
      ->addParam(':employee_id', 456, '/^\d+$/')
      ->execute();
```

## Method Documentation

### `__construct($dbConfig = null)`
Initializes the database connection with an optional configuration array. Defaults to session-stored settings if no configuration is provided.

### `setQuery($query)`
Sets the SQL query with placeholders for parameters.

### `addParam($param, $value, $validate = null)`
Adds a parameter with optional regex validation.

### `execute()`
Executes the SQL query, handles transactions, and returns query results or error details.

---

Each example demonstrates Secure Query Handler’s flexibility across databases. Customize by adding or removing parameters, adjusting validation patterns, or modifying database settings for your environment.
