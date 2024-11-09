
# Secure Query Handler by Mirosław Zięba

![License](https://img.shields.io/badge/license-MIT-blue)
![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%207.4-blue)
![Build Status](https://img.shields.io/badge/build-passing-brightgreen)
![Stars](https://img.shields.io/github/stars/miroslaw-zieba/secure-query-handler)
![Issues](https://img.shields.io/github/issues/miroslaw-zieba/secure-query-handler)
![Last Commit](https://img.shields.io/github/last-commit/miroslaw-zieba/secure-query-handler)
![Contributions Welcome](https://img.shields.io/badge/contributions-welcome-brightgreen)

**Secure Query Handler** is an advanced PHP class by Mirosław Zięba, designed for secure and efficient SQL query management in PHP applications. This class was developed as part of a comprehensive update to my dedicated PHP framework, StarFrame, to ensure modern standards of security and performance. With support for multiple databases, parameterized queries, and automatic transaction handling, this tool is ideal for developers who prioritize robust database security and dynamic query execution.

## Features

The `SecureQueryHandler` class provides a wide range of functionalities aimed at delivering secure, efficient, and flexible SQL query handling in PHP applications.

### 1. Secure SQL Execution
   - **Parameterized Queries**: Prevents SQL injection attacks by using prepared statements with parameterized queries.
   - **Input Validation**: Ensures input values meet specified formats using regular expressions, reducing injection risks.

### 2. Automatic Transaction Management
   - **Commit & Rollback**: Automatically commits or rolls back transactions based on query success or failure.
   - **Nested Transactions**: Handles multiple levels of transactions within a single request, ensuring data integrity.

### 3. Dynamic Parameter Validation
   - **Regular Expressions**: Validates each parameter using customizable regex patterns for data integrity and security.
   - **Predefined Validators**: Includes built-in validators for common data types like integers, emails, dates, and alphanumeric strings.

### 4. Security Event Logging
   - **Comprehensive Logging**: Tracks all executed queries, errors, and validation failures, creating a detailed log.
   - **Security Event Scoring**: Assigns error points for failed queries and unauthorized actions; blocks IPs with repeated violations.
   - **Detailed Audit Trails**: Provides a full history of all interactions for audit purposes.

### 5. Customizable Error Handling
   - **Retry Mechanism**: Attempts to re-execute failed queries based on a defined number of retry attempts.
   - **Dynamic IP Blocking**: Blocks IP addresses with multiple failed attempts or security violations based on a points system.
   - **Error Notifications**: Configurable to send email notifications on critical errors, aiding rapid response.

### 6. Real-Time Query Caching
   - **Query Results Caching**: Caches frequently executed queries to improve performance on repeated queries.
   - **Cache Expiry Control**: Allows setting custom cache expiration times for different query types.

### 7. Flexible Debugging Options
   - **Debug Mode**: Enables verbose logging and stack traces for easier debugging during development.
   - **Customizable Log Output**: Allows configuration to save logs in files, database entries, or send them via email.

### 8. Transaction Safety
   - **Automatic Rollback**: Automatically rolls back open transactions upon encountering an exception.
   - **Multiple Savepoints**: Supports savepoints within transactions, enabling partial rollbacks if necessary.

### 9. Multi-Database Compatibility
   - **MySQL, PostgreSQL, MSSQL Support**: Built with the flexibility to connect and operate with MySQL, PostgreSQL, or MSSQL.
   - **Dynamic Configuration**: Database credentials and configurations can be set per query or inherited from default session settings.

### 10. Customizable Query Execution Context
   - **Module and Class Tracking**: Tracks the module and class where each query originates, useful for complex applications.
   - **Execution Timing**: Measures and logs execution time for each query, helping identify slow operations.
   
### 11. Real-Time Query Performance Monitoring
   - **Execution Time Logging**: Measures the time taken for each query, allowing real-time performance tracking.
   - **Optimized Execution**: Identifies and logs slow queries for further optimization.

### 12. Data Integrity with Conditional Constraints
   - **Conditional Parameters**: Ensures that data constraints are met before query execution.
   - **Dynamic Constraints**: Adjusts constraints dynamically based on the query context, maintaining data integrity.

### 13. IP and User-Based Security Filtering
   - **IP Whitelisting and Blacklisting**: Filters IPs based on user-defined security policies.
   - **Role-Based Access Control**: Manages permissions based on user roles, restricting query execution to authorized users.

### 14. Robust Audit Trails
   - **Action-Specific Logging**: Logs specific user actions within queries for compliance and auditing.
   - **Historical Data Review**: Retains query histories for forensic analysis and historical review.

### 15. Comprehensive Error Scoring
   - **Customizable Points System**: Tracks and assigns error points for security violations, aiding in automated IP blocking.
   - **Progressive Penalties**: Implements escalating penalties for repeat offenders, helping to prevent brute-force attacks.

### 16. Intelligent Query Analysis
   - **Error Analysis**: Automatically categorizes errors by type, frequency, and query source.
   - **Automated Optimization Suggestions**: Provides suggestions for optimization based on query patterns and performance data.

### 17. Advanced Query Debugging
   - **Query Execution Profiling**: Profiles each query’s execution to help with debugging and optimization.
   - **Developer Mode**: When enabled, provides developers with detailed query statistics and error traces.

### 18. Integration with External Tools
   - **External Notification Hooks**: Allows integration with external logging or notification tools for real-time alerting.
   - **Flexible Configuration**: Configurable for integration with third-party performance and security monitoring tools.

This expanded `SecureQueryHandler` class by Mirosław Zięba ensures secure, flexible, and highly customizable SQL query handling, making it ideal for PHP applications requiring robust data management and security.

## Installation
1. Clone this repository:
   ```bash
   git clone https://github.com/miroslaw-zieba/secure-query-handler.git
   ```
2. Include the `Query.php` file in your project:
   ```php
   require_once 'path/to/Query.php';
   ```


## Query Examples

Here are several examples showcasing the flexibility and capabilities of `SecureQueryHandler`:

### 1. Example: Basic Select Query
```php
$query = new Query();
$query->setQuery("SELECT * FROM users")->execute();
```

### 2. Example: Select with a Single Parameter
```php
$query->setQuery("SELECT * FROM users WHERE id = :id")
      ->addParam(':id', 1, '/^\d+$/') // ID must be numeric
      ->execute();
```

### 3. Example: Simple Insert Statement
```php
$query->setQuery("INSERT INTO products (name, price) VALUES (:name, :price)")
      ->addParam(':name', 'Keyboard', '/^[\w\s]{3,50}$/')
      ->addParam(':price', 49.99, '/^\d+(\.\d{1,2})?$/')
      ->execute();
```

### 4. Example: Basic Update Statement
```php
$query->setQuery("UPDATE users SET email = :email WHERE id = :id")
      ->addParam(':email', 'newemail@example.com', '/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,6}$/')
      ->addParam(':id', 1, '/^\d+$/')
      ->execute();
```

### 5. Example: Deleting a Record
```php
$query->setQuery("DELETE FROM sessions WHERE user_id = :user_id")
      ->addParam(':user_id', 345, '/^\d+$/')
      ->execute();
```

### 6. Example: Select with Multiple Parameters
```php
$query->setQuery("SELECT * FROM orders WHERE customer_id = :customer_id AND status = :status")
      ->addParam(':customer_id', 123, '/^\d+$/')
      ->addParam(':status', 'shipped', '/^(pending|shipped|delivered)$/')
      ->execute();
```

### 7. Example: Inserting with Dynamic Date
```php
$query->setQuery("INSERT INTO orders (customer_id, order_date) VALUES (:customer_id, NOW())")
      ->addParam(':customer_id', 789, '/^\d+$/')
      ->execute();
```

### 8. Example: Updating with Conditional Logic
```php
$query->setQuery("UPDATE products SET stock = stock - :quantity WHERE id = :product_id")
      ->addParam(':quantity', 5, '/^\d+$/')
      ->addParam(':product_id', 102, '/^\d+$/')
      ->execute();
```

### 9. Example: Simple Aggregate Query
```php
$query->setQuery("SELECT COUNT(*) as user_count FROM users WHERE status = :status")
      ->addParam(':status', 'active', '/^(active|inactive)$/')
      ->execute();
```

### 10. Example: Grouping and Ordering Results
```php
$query->setQuery("SELECT department, COUNT(*) as count FROM employees GROUP BY department ORDER BY count DESC")
      ->execute();
```

### 11. Example: Fetching Specific Columns
```php
$query->setQuery("SELECT name, email FROM users WHERE role = :role")
      ->addParam(':role', 'admin', '/^(admin|user)$/')
      ->execute();
```

### 12. Example: Checking for Existence
```php
$query->setQuery("SELECT EXISTS(SELECT 1 FROM users WHERE email = :email) AS email_exists")
      ->addParam(':email', 'test@example.com', '/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,6}$/')
      ->execute();
```

### 13. Example: Using a Date Range
```php
$query->setQuery("SELECT * FROM events WHERE event_date BETWEEN :start_date AND :end_date")
      ->addParam(':start_date', '2023-01-01', '/^\d{4}-\d{2}-\d{2}$/')
      ->addParam(':end_date', '2023-12-31', '/^\d{4}-\d{2}-\d{2}$/')
      ->execute();
```

### 14. Example: Insert with Generated UUID
```php
$query->setQuery("INSERT INTO sessions (user_id, session_id) VALUES (:user_id, UUID())")
      ->addParam(':user_id', 333, '/^\d+$/')
      ->execute();
```

### 15. Example: Advanced String Pattern Matching
```php
$query->setQuery("SELECT * FROM products WHERE name LIKE :pattern")
      ->addParam(':pattern', '%Laptop%', '/^%[\w\s]+%$/')
      ->execute();
```

### 16. Example: Using a Limit and Offset
```php
$query->setQuery("SELECT * FROM orders WHERE status = :status LIMIT 10 OFFSET 20")
      ->addParam(':status', 'pending', '/^(pending|shipped|delivered)$/')
      ->execute();
```

### 17. Example: Multi-Column Sorting
```php
$query->setQuery("SELECT * FROM employees ORDER BY department ASC, last_name DESC")
      ->execute();
```

### 18. Example: Conditional Update with Multiple Parameters
```php
$query->setQuery("UPDATE accounts SET balance = balance + :amount WHERE id = :account_id AND status = :status")
      ->addParam(':amount', 100.00, '/^\d+(\.\d{1,2})?$/')
      ->addParam(':account_id', 888, '/^\d+$/')
      ->addParam(':status', 'active', '/^(active|inactive)$/')
      ->execute();
```

### 19. Example: Simple Join Query
```php
$query->setQuery("SELECT u.name, o.order_date FROM users u JOIN orders o ON u.id = o.user_id WHERE u.id = :user_id")
      ->addParam(':user_id', 555, '/^\d+$/')
      ->execute();
```

### 20. Example: Insert with Current Timestamp
```php
$query->setQuery("INSERT INTO logs (event_type, event_timestamp) VALUES (:event_type, CURRENT_TIMESTAMP)")
      ->addParam(':event_type', 'login', '/^(login|logout|error)$/')
      ->execute();
```

### 21. Example: Basic Query with Default Database
A simple `SELECT` query using the default database configuration.

```php
require_once 'Query.php';

$query = new Query();
$query->setQuery("SELECT * FROM users WHERE status = :status")
      ->addParam(':status', 'active', '/^(active|inactive)$/')
      ->execute();
```

### 22. Example: Query with Multiple Parameters and Validations
An example showcasing a query with multiple parameters, each validated with regular expressions.

```php
$query->setQuery("SELECT * FROM orders WHERE customer_id = :customer_id AND status = :status AND created_at > :created_at")
      ->addParam(':customer_id', 123, '/^\d+$/') // Customer ID must be a number
      ->addParam(':status', 'shipped', '/^(pending|shipped|delivered)$/') // Status validation
      ->addParam(':created_at', '2023-01-01', '/^\d{4}-\d{2}-\d{2}$/') // Date format validation
      ->execute();
```

### 23. Example: Insert with Transaction Management
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

### 24. Example: Complex Update within a Transaction
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

### 25. Example: Aggregation with Grouping and Having Clause
Using aggregation functions with grouping to count entries and filter by a minimum count.

```php
$query->setQuery("SELECT department, COUNT(*) as employee_count FROM employees GROUP BY department HAVING employee_count > :min_count")
      ->addParam(':min_count', 10, '/^\d+$/') // Minimum count validation
      ->execute();
```

### 26. Example: Parameterized Nested Subquery
Executing a query with a nested subquery for advanced data selection.

```php
$query->setQuery("SELECT * FROM products WHERE price > (SELECT AVG(price) FROM products WHERE category_id = :category_id)")
      ->addParam(':category_id', 5, '/^\d+$/') // Category ID validation
      ->execute();
```

### 27. Example: Multi-Step Conditional Insert and Update
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

### 28. Example: Multi-Step Transaction with Conditional Rollback
This example demonstrates a transaction across multiple tables, with conditional validation and rollback in case of validation failures.

```php
require_once 'Query.php';

$dbConfig = [
    'host' => 'localhost',
    'user' => 'user',
    'pass' => 'pass',
    'name' => 'database',
    'port' => '3306'
];

$query = new Query($dbConfig);

try {
    // Begin transaction
    $query->setQuery("START TRANSACTION")->execute();

    // Step 1: Insert into orders table
    $query->setQuery("INSERT INTO orders (customer_id, total_amount) VALUES (:customer_id, :total_amount)")
          ->addParam(':customer_id', 123, '/^\d+$/')
          ->addParam(':total_amount', 250.75, '/^\d+(\.\d{1,2})?$/')
          ->execute();

    $orderId = $query->getLastInsertId();

    // Step 2: Insert into order_items table
    $query->setQuery("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)")
          ->addParam(':order_id', $orderId, '/^\d+$/')
          ->addParam(':product_id', 456, '/^\d+$/')
          ->addParam(':quantity', 2, '/^\d+$/')
          ->addParam(':price', 125.38, '/^\d+(\.\d{1,2})?$/')
          ->execute();

    // Conditional check
    if ($query->affectedRows() < 1) {
        throw new Exception("No items inserted; rolling back.");
    }

    // Commit transaction
    $query->setQuery("COMMIT")->execute();

} catch (Exception $e) {
    $query->setQuery("ROLLBACK")->execute();
    echo "Transaction failed: " . $e->getMessage();
}
```

### 29. Example: Dynamic SQL with Nested Subqueries and Custom Validation
Using nested subqueries and custom validations for parameterized queries with complex conditions.

```php
$query->setQuery("SELECT id, name FROM users WHERE role = :role AND id IN (SELECT user_id FROM permissions WHERE level = :level)")
      ->addParam(':role', 'admin', '/^(admin|user|guest)$/')
      ->addParam(':level', 5, '/^\d+$/')
      ->execute();
```

### 30. Example: Bulk Insert with Data Validation and Logging
Inserts multiple records in one go, validating each entry and logging unsuccessful insertions.

```php
$users = [
    ['name' => 'John Doe', 'email' => 'john.doe@example.com', 'age' => 30],
    ['name' => 'Jane Smith', 'email' => 'jane.smith@example.com', 'age' => 25],
    // More users...
];

try {
    $query->setQuery("START TRANSACTION")->execute();
    
    foreach ($users as $user) {
        $query->setQuery("INSERT INTO users (name, email, age) VALUES (:name, :email, :age)")
              ->addParam(':name', $user['name'], '/^[a-zA-Z\s]{3,50}$/')
              ->addParam(':email', $user['email'], '/^[\w\.\-]+@[\w\.\-]+\.[a-zA-Z]{2,6}$/')
              ->addParam(':age', $user['age'], '/^\d{1,2}$/')
              ->execute();

        if ($query->affectedRows() < 1) {
            $query->logSecurityEvent("INSERT_FAILED", 'user', json_encode($user));
        }
    }

    $query->setQuery("COMMIT")->execute();

} catch (Exception $e) {
    $query->setQuery("ROLLBACK")->execute();
    echo "Bulk insert failed: " . $e->getMessage();
}
```

### 31. Example: Complex Join with Real-Time Condition Checks
Query involving multiple joins and real-time data filtering.

```php
$query->setQuery("
    SELECT u.id, u.name, SUM(o.total) as total_spent 
    FROM users u
    JOIN orders o ON u.id = o.user_id
    JOIN payments p ON o.id = p.order_id
    WHERE u.status = :status AND p.status = :payment_status
    GROUP BY u.id
    HAVING total_spent > :min_spent
")
->addParam(':status', 'active', '/^(active|inactive)$/')
->addParam(':payment_status', 'completed', '/^(completed|pending)$/')
->addParam(':min_spent', 1000, '/^\d+$/')
->execute();
```

### 32. Example: Conditional Updates with Multiple Table Interactions
Example of conditional updates across multiple tables with real-time logging of affected rows.

```php
try {
    $query->setQuery("START TRANSACTION")->execute();

    // Update user status
    $query->setQuery("UPDATE users SET status = 'inactive' WHERE last_login < NOW() - INTERVAL 1 YEAR")
          ->execute();

    $inactiveCount = $query->affectedRows();

    // Update orders linked to inactive users
    $query->setQuery("UPDATE orders SET status = 'cancelled' WHERE user_id IN (SELECT id FROM users WHERE status = 'inactive')")
          ->execute();

    $cancelledOrders = $query->affectedRows();

    $query->logSecurityEvent("USER_INACTIVITY_UPDATE", 'inactive_users', $inactiveCount);
    $query->logSecurityEvent("ORDER_CANCELLATION", 'cancelled_orders', $cancelledOrders);

    $query->setQuery("COMMIT")->execute();

} catch (Exception $e) {
    $query->setQuery("ROLLBACK")->execute();
    echo "Conditional update failed: " . $e->getMessage();
}
```

Each example demonstrates how to build and execute secure SQL statements using `SecureQueryHandler`, ensuring both flexibility and security in handling dynamic data.

## Method Documentation for Secure Query Handler Class

### `__construct($dbConfig = null)`
Initializes a new instance of the Secure Query Handler with an optional database configuration array. 
If no custom configuration is provided, the class defaults to settings stored in the session (`$_SESSION['db']`).

- **Parameters**:
  - **`$dbConfig`** (array, optional): Configuration array with the following fields:
    - **`host`** (string): Database server hostname.
    - **`user`** (string): Database username.
    - **`pass`** (string): Database password.
    - **`name`** (string): Database name.
    - **`port`** (string, optional): Port number (defaults to the standard database port if not provided).

- **Example**:
```php
// Using default database configuration from session
$query = new Query();

// Custom database configuration
$dbConfig = [
    'host' => 'localhost',
    'user' => 'custom_user',
    'pass' => 'custom_pass',
    'name' => 'custom_database',
    'port' => '3308'
];
$query = new Query($dbConfig);
```

---

### `setQuery($query)`
Sets the SQL query to be executed, allowing placeholders for parameters to be bound later.

- **Parameters**:
  - **`$query`** (string): SQL query string with placeholders (e.g., `:id`, `:email`).

- **Returns**: 
  - Instance of `Secure Query Handler` for chaining methods.

- **Example**:
```php
$query->setQuery("SELECT * FROM users WHERE id = :id")
      ->addParam(':id', 1)
      ->execute();
```

---

### `addParam($param, $value, $validate = null)`
Adds a parameter to the query, with optional validation through regular expressions. This feature ensures only valid data is injected into queries.

- **Parameters**:
  - **`$param`** (string): Named placeholder in the query (e.g., `:id`).
  - **`$value`** (mixed): Value to be bound to the placeholder.
  - **`$validate`** (string, optional): Regular expression pattern to validate the format of `$value`.

- **Throws**: 
  - Exception if validation fails.

- **Returns**: 
  - Instance of `Secure Query Handler` for chaining.

- **Example**:
```php
$query->setQuery("SELECT * FROM orders WHERE order_id = :order_id")
      ->addParam(':order_id', 123, '/^\d+$/') // Order ID must be a number
      ->execute();
```

---

### `execute()`
Executes the current SQL query, binding parameters and handling transactions.

- **Returns**: 
  - Associative array containing:
    - **`success`** (bool): `true` if the query executed successfully.
    - **`executionTime`** (float): Time taken to execute the query.
    - **`query`** (string): Executed SQL query.
    - Additional fields for specific query types (e.g., `lastInsertId` for `INSERT` queries).

- **Example**:
```php
$query->setQuery("INSERT INTO products (name, price) VALUES (:name, :price)")
      ->addParam(':name', 'Laptop')
      ->addParam(':price', 1500.99)
      ->execute();
```

---

### `enableDebugMode($logTo = [])`
Activates debug mode, providing more detailed error logging and configuration options for where logs are stored.

- **Parameters**:
  - **`$logTo`** (array): Specifies output destinations for logs, such as `"database"`, `"email"`, etc.

- **Example**:
```php
$query->enableDebugMode(['database', 'email']);
```

---

### `validateParam($value, $validate)`
Validates a parameter based on a specified regular expression pattern.

- **Parameters**:
  - **`$value`** (mixed): The value to validate.
  - **`$validate`** (string): Regular expression for validation.

- **Returns**:
  - **`true`** if validation passes, otherwise **`false`**.

- **Example**:
```php
// This will only proceed if ':email' matches the email format
$query->addParam(':email', 'user@example.com', '/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$/');
```

---

### `logSecurityEvent($eventCode, $param = null, $value = null)`
Logs a security event, adding an entry to the security log for monitoring purposes.

- **Parameters**:
  - **`$eventCode`** (string): Code identifying the type of event (e.g., SQL injection attempt).
  - **`$param`** (string, optional): Name of the parameter involved.
  - **`$value`** (mixed, optional): Value that triggered the event.

- **Example**:
```php
// Manually logging a security event
$query->logSecurityEvent("INVALID_PARAMETER_FORMAT", "age", "invalid_age");
```

---

## About Mirosław Zięba

With a strong foundation in software development, Mirosław Zięba is an experienced IT professional specializing in building robust, secure systems and complex web applications. With over 19 years of expertise spanning full-stack development, database management, and system architecture, Mirosław leads custom software projects for businesses, creates secure data-handling systems, and offers mentorship for young people interested in the IT field, providing guidance to support career changers in transitioning smoothly into IT roles. Mirosław is passionate about exploring new technologies and developing solutions that enhance efficiency, security, and scalability in applications.
