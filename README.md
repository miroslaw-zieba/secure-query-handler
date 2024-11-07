
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
Initializes the database connection using the provided configuration, including `host`, `user`, `pass`, and `name`. It also verifies if the IP is blocked based on prior security violations.

### `setQuery($query)`
Sets the SQL query to be executed. Returns `$this` for method chaining.

### `addParam($param, $value, $validate = null)`
Adds a parameter with an optional validation pattern (e.g., regex). Logs security events if validation fails.

### `execute()`
Executes the SQL query with bound parameters. Handles transaction management, retries on failure, and returns result details like last insert ID, row count, and query results.

### `enableDebugMode($logTo = [])`
Enables debug mode and sets output destinations for error and query logs (e.g., `database`, `email`).
