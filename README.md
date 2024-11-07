
# SecureQueryHandler
A secure and efficient SQL query handling class for PHP applications, designed to protect against SQL injection and manage SQL queries with built-in parameter validation, transaction handling, and security logging.

## Features
- **Secure SQL Execution**: Prevents SQL injection attacks with parameterized queries.
- **Automatic Transaction Management**: Commits or rolls back transactions depending on query success or failure.
- **Dynamic Parameter Validation**: Supports custom validation for parameters.
- **Security Logging**: Logs security events with custom error points.
- **Customizable Error Handling**: Retry failed queries and block IPs with repeated violations.

## Installation
1. Clone this repository:
   ```bash
   git clone https://github.com/miroslaw-zieba/SecureQueryHandler.git
   ```
2. Include the `Query.php` file in your project:
   ```php
   require_once 'path/to/Query.php';
   ```

## Quick Start
```php
require_once 'Query.php';

$dbConfig = [
    'host' => 'localhost',
    'user' => 'your_username',
    'pass' => 'your_password',
    'name' => 'database_name'
];

$query = new Query($dbConfig);
$query->setQuery("SELECT * FROM users WHERE id = :id")
      ->addParam(':id', 1, '/^\d+$/')
      ->execute();
```

## Method Documentation

### `__construct($dbConfig = null)`
Initializes the database connection with an optional configuration array. The default database settings are sourced from session variables (`$_SESSION['db']`). This setup is used unless a custom database configuration is provided in `$dbConfig`, allowing queries to be directed to a different database.

- **Parameters**:
  - **`$dbConfig`** (array, optional): Database configuration details. Fields:
    - **`host`** (string): Host for the database connection (default from session if not specified).
    - **`user`** (string): Username for database access (default from session if not specified).
    - **`pass`** (string): Password for the database (default from session if not specified).
    - **`name`** (string): Database name (default from session if not specified).
    - **`port`** (string): Port number for the database (default from session if not specified).
  
- **Behavior**:
  If `$dbConfig` is omitted or partially filled, the class will automatically fall back to session-stored database credentials (`$_SESSION['db']`) for the missing details.

---

### `setQuery($query)`
Sets the SQL query to be executed.

- **Parameters**:
  - **`$query`** (string): SQL query string with placeholders for parameters.
- **Returns**: Instance of `SecureQueryHandler` for chaining.

---

### `addParam($param, $value, $validate = null)`
Adds a parameter to the query, with optional validation.

- **Parameters**:
  - **`$param`** (string): Named placeholder in the query (e.g., `:id`).
  - **`$value`** (mixed): Value to be bound to the placeholder.
  - **`$validate`** (string, optional): Regular expression pattern to validate the format of `$value`.
- **Throws**: Exception if validation fails.
- **Returns**: Instance of `SecureQueryHandler` for chaining.

---

### `execute()`
Executes the current SQL query, binding parameters, and managing transactions. 

- **Returns**: Associative array containing:
  - **`success`** (bool): `true` if the query executed successfully.
  - **`executionTime`** (float): Time taken to execute the query.
  - **`query`** (string): Executed SQL query.
  - Additional fields for specific query types (e.g., `lastInsertId` for `INSERT` queries).

---

### `enableDebugMode($logTo = [])`
Enables debug mode and configures logging options.

- **Parameters**:
  - **`$logTo`** (array): Specifies where logs should be stored, such as `"database"` or `"email"`.

---

### Usage Notes
The class `SecureQueryHandler` offers the flexibility to switch between different databases dynamically. If additional database credentials (including port) are needed, these can be specified in the `$dbConfig` array when initializing the class.

```php
// Example of connecting to a specific database with a different port
$dbConfig = [
    'host' => 'localhost',
    'user' => 'custom_user',
    'pass' => 'custom_pass',
    'name' => 'custom_database',
    'port' => '3308'
];

$query = new Query($dbConfig);
$query->setQuery("SELECT * FROM example_table WHERE id = :id")
      ->addParam(':id', 123)
      ->execute();
```

### `retryOnFailure()`
Attempts to re-execute the query if it initially fails.

- **Behavior**: 
  Implements retry logic on query failure to avoid transient database issues. This method manages re-execution until success or a maximum retry limit.

---

### `logSecurityEvent($eventCode, $param = null, $value = null)`
Logs security-related events with a custom points system.

- **Parameters**:
  - **`$eventCode`** (string): Code representing the type of security event.
  - **`$param`** (string, optional): Parameter related to the event.
  - **`$value`** (mixed, optional): Value that triggered the event.

- **Behavior**: 
  Assigns and logs security points for specific events. If cumulative points for a user reach the threshold, the user is blocked.
