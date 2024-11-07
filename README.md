
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

### Example 1: Basic Query (Using Default Database)
This example demonstrates a simple `SELECT` query using the default database.

```php
require_once 'Query.php';

$query = new Query();
$query->setQuery("SELECT * FROM users WHERE status = :status")
      ->addParam(':status', 'active', '/^(active|inactive)$/')
      ->execute();
```

### Example 2: Query with Multiple Parameters and Validations
This example showcases a query with multiple parameters, each validated using regular expressions for enhanced security.

```php
$query->setQuery("SELECT * FROM orders WHERE customer_id = :customer_id AND status = :status AND created_at > :created_at")
      ->addParam(':customer_id', 123, '/^\d+$/') // Customer ID must be a number
      ->addParam(':status', 'shipped', '/^(pending|shipped|delivered)$/') // Status validation
      ->addParam(':created_at', '2023-01-01', '/^\d{4}-\d{2}-\d{2}$/') // Date format validation
      ->execute();
```

### Example 3: Inserting Data with Transaction Management
Using transactions to ensure data integrity in case of failures during an `INSERT` operation.

```php
$query->setQuery("INSERT INTO products (name, price, created_at) VALUES (:name, :price, NOW())")
      ->addParam(':name', 'Laptop', '/^[a-zA-Z0-9\s]{3,50}$/') // Product name validation
      ->addParam(':price', 1200.50, '/^\d+(\.\d{1,2})?$/') // Price format validation
      ->execute();
```

### Example 4: Complex Update with Conditional Validation
An example where conditional validations are used to ensure only valid input is processed.

```php
$query->setQuery("UPDATE users SET email = :email, role = :role WHERE id = :id")
      ->addParam(':email', 'user@example.com', '/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,6}$/') // Email format validation
      ->addParam(':role', 'admin', '/^(admin|user|guest)$/') // Role validation
      ->addParam(':id', 789, '/^\d+$/') // ID must be numeric
      ->execute();
```

### Example 5: Deleting Records with Logging
A `DELETE` example where records are deleted based on a specific condition, with logging for auditing.

```php
$query->setQuery("DELETE FROM sessions WHERE user_id = :user_id AND expired_at < NOW()")
      ->addParam(':user_id', 345, '/^\d+$/') // User ID validation
      ->execute();
```

### Example 6: Aggregation with Grouping and Having Clause
Complex query with aggregation, grouping, and a `HAVING` clause for more advanced SQL operations.

```php
$query->setQuery("SELECT department, COUNT(*) as employee_count FROM employees GROUP BY department HAVING employee_count > :min_count")
      ->addParam(':min_count', 10, '/^\d+$/') // Minimum count validation
      ->execute();
```

### Example 7: Parameterized Query with Nested Subqueries
An example of a nested subquery within a parameterized `SELECT` statement.

```php
$query->setQuery("SELECT * FROM products WHERE price > (SELECT AVG(price) FROM products WHERE category_id = :category_id)")
      ->addParam(':category_id', 5, '/^\d+$/') // Category ID validation
      ->execute();
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
