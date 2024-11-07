
# Secure Query Handler by Mirosław Zięba

![License](https://img.shields.io/badge/license-MIT-blue)
![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%207.4-blue)
![Build Status](https://img.shields.io/badge/build-passing-brightgreen)
![Stars](https://img.shields.io/github/stars/miroslaw-zieba/secure-query-handler)
![Issues](https://img.shields.io/github/issues/miroslaw-zieba/secure-query-handler)
![Last Commit](https://img.shields.io/github/last-commit/miroslaw-zieba/secure-query-handler)
![Contributions Welcome](https://img.shields.io/badge/contributions-welcome-brightgreen)

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


## Complex Query Examples

Here are several advanced examples showcasing the flexibility and capabilities of `SecureQueryHandler`:

### Basic Query with Default Database
A simple `SELECT` query using the default database configuration.

```php
require_once 'Query.php';

$query = new Query();
$query->setQuery("SELECT * FROM users WHERE status = :status")
      ->addParam(':status', 'active', '/^(active|inactive)$/')
      ->execute();
```

### Query with Multiple Parameters and Validations
An example showcasing a query with multiple parameters, each validated with regular expressions.

```php
$query->setQuery("SELECT * FROM orders WHERE customer_id = :customer_id AND status = :status AND created_at > :created_at")
      ->addParam(':customer_id', 123, '/^\d+$/') // Customer ID must be a number
      ->addParam(':status', 'shipped', '/^(pending|shipped|delivered)$/') // Status validation
      ->addParam(':created_at', '2023-01-01', '/^\d{4}-\d{2}-\d{2}$/') // Date format validation
      ->execute();
```

### Insert with Transaction Management
Demonstrating how transactions ensure both inserts complete successfully or roll back if one fails.

```php
try {
    $query->beginTransaction();

    $query->setQuery("INSERT INTO products (name, price, created_at) VALUES (:name, :price, NOW())")
          ->addParam(':name', 'Laptop', '/^[a-zA-Z0-9\s]{3,50}$/')
          ->addParam(':price', 1200.50, '/^\d+(\.\d{1,2})?$/')
          ->execute();

    $query->setQuery("INSERT INTO inventory (product_id, stock) VALUES (:product_id, :stock)")
          ->addParam(':product_id', $query->lastInsertId())
          ->addParam(':stock', 50, '/^\d+$/')
          ->execute();

    $query->commitTransaction();
} catch (Exception $e) {
    $query->rollbackTransaction();
    throw $e;
}
```

### Complex Update within a Transaction
An example where multiple tables are updated conditionally, and changes are rolled back if any update fails.

```php
try {
    $query->beginTransaction();

    $query->setQuery("UPDATE accounts SET balance = balance - :amount WHERE id = :account_id")
          ->addParam(':amount', 100, '/^\d+(\.\d{1,2})?$/')
          ->addParam(':account_id', 1, '/^\d+$/')
          ->execute();

    $query->setQuery("UPDATE accounts SET balance = balance + :amount WHERE id = :recipient_account_id")
          ->addParam(':amount', 100, '/^\d+(\.\d{1,2})?$/')
          ->addParam(':recipient_account_id', 2, '/^\d+$/')
          ->execute();

    $query->commitTransaction();
} catch (Exception $e) {
    $query->rollbackTransaction();
    throw $e;
}
```

### Aggregation with Grouping and Having Clause
Using aggregation functions with grouping to count entries and filter by a minimum count.

```php
$query->setQuery("SELECT department, COUNT(*) as employee_count FROM employees GROUP BY department HAVING employee_count > :min_count")
      ->addParam(':min_count', 10, '/^\d+$/') // Minimum count validation
      ->execute();
```

### Parameterized Nested Subquery
Executing a query with a nested subquery for advanced data selection.

```php
$query->setQuery("SELECT * FROM products WHERE price > (SELECT AVG(price) FROM products WHERE category_id = :category_id)")
      ->addParam(':category_id', 5, '/^\d+$/') // Category ID validation
      ->execute();
```

### Multi-Step Conditional Insert and Update
Inserting data and updating records conditionally using parameters and transactions.

```php
try {
    $query->beginTransaction();

    $query->setQuery("INSERT INTO orders (customer_id, status) VALUES (:customer_id, :status)")
          ->addParam(':customer_id', 456, '/^\d+$/')
          ->addParam(':status', 'processing', '/^(processing|completed|shipped)$/')
          ->execute();

    $orderId = $query->lastInsertId();

    $query->setQuery("UPDATE customers SET last_order_id = :last_order_id WHERE id = :customer_id")
          ->addParam(':last_order_id', $orderId)
          ->addParam(':customer_id', 456, '/^\d+$/')
          ->execute();

    $query->commitTransaction();
} catch (Exception $e) {
    $query->rollbackTransaction();
    throw $e;
}
```

Each example demonstrates how to build and execute secure SQL statements using `SecureQueryHandler`, ensuring both flexibility and security in handling dynamic data.

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
